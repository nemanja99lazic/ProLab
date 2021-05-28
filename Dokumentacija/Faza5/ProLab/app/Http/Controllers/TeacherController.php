<?php
/**
 * Autor: Slobodan Katanic 2018/0133
 */
namespace App\Http\Controllers;

use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\User;
use Illuminate\Http\Request;
use App\Teacher;
use MongoDB\Driver\Session;
use App\SubjectJoinRequest;
use App\Attends;
use App\Project;

/**
 * TeacherController - klasa koja implemenitra logiku funckionalnosti za tip korisnika profesor.
 *
 * @version 1.0
 */
class TeacherController extends Controller {
    /**
     * Kreiranje nove instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('teacherMiddleware');
    }

    /**
     * Funkcija koja prikazuje pocetni stranicu profesora.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\
     */
    public function index() {
        return view('teacher/teacher_index');
    }

    /**
     * Funcikcija koja sluzi za logout profesora.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    /**
     * Funcija za prikaz forme za dodavanje novog predmeta.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addSubjectGet(Request $request) {
        $teachers = Teacher::where('idTeacher', '!=', $request->session()->get('user')['userObject']->idUser)->get();
        return view('teacher/teacher_create_subject', ['teachers' => $teachers, 'success' => $request->get('success')]);
    }

    /**
     * Funkcija predstavlja obradu POST zahteva poslatog za kreiranje novog predmeta
     * od strane profesora.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSubjectPost(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);
        $teachers = $request->get('teachers_select');
        $teacher = $request->session()->get('user')['userObject'];

        $newSubjectRequest = new NewSubjectRequest;
        $newSubjectRequest->idTeacher = $teacher->idUser;
        $newSubjectRequest->subjectName = $request->get('name');
        $newSubjectRequest->save();
        $requestId = $newSubjectRequest->idRequest;

        if ($teachers != null) {
            foreach ($teachers as $teacher) {
                $newSubjectRequestTeaches = new NewSubjectRequestTeaches;
                preg_match('/\((.+)\)/', $teacher, $email);
                $user = User::where('email', '=', $email[1])->first();
                $newSubjectRequestTeaches->idTeacher = $user->idUser;
                $newSubjectRequestTeaches->idRequest = $requestId;
                $newSubjectRequestTeaches->save();
            }
        }

        $newSubjectRequestTeaches = new NewSubjectRequestTeaches;
        $newSubjectRequestTeaches->idTeacher = $request->session()->get('user')['userObject']->idUser;
        $newSubjectRequestTeaches->idRequest = $requestId;
        $newSubjectRequestTeaches->save();

        //return redirect()->to(url('teacher/addSubject/info'));
        $request->session()->put('success', 'yes');
        return redirect()->route('teacher.addsubject.get');
    }

    /**
     * Fukcija koja prikazuje profesoru informaije od odredjenom predmetu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function addSubjectInfo() {
        return view('teacher/teacher_create_subject_info');
    }
    /**
     * Prikaz svih zahteva za upis na kurs koji su stigli profesoru
     *
     * - Nemanja Lazic 2018/0004
     */
    public function showRequestsList(Request $request)
    {
        $myId = $request->session()->get('user')['userObject']->idUser;
        $myRequests = SubjectJoinRequest::whereIn('subject_join_requests.idSubject', function($query) use ($myId) {
            $query  ->select('idSubject')
                    ->from('teaches')
                    ->where('teaches.idTeacher', $myId);
        })->join('users', 'users.idUser', '=', 'subject_join_requests.idStudent')
        ->join('subjects', 'subjects.idSubject', '=', 'subject_join_requests.idSubject')
        ->paginate(2);

        //dd($myRequests);

        return view('teacher.requests_list', ['requests' => $myRequests]);
    }

    /**
     * Privatanje zahteva - POST
     *
     * - Nemanja Lazic 2018/0004
     */
    public function acceptRequest(Request $request)
    {
        $idRequest = $request->get('idRequest');
        $acceptingRequest = SubjectJoinRequest::where('idRequest', '=', $idRequest)->first();

        $attendsEntity = new Attends;
        $attendsEntity->idStudent = $acceptingRequest->idStudent;
        $attendsEntity->idSubject = $acceptingRequest->idSubject;
        $attendsEntity->save();

        $acceptingRequest->delete();

        return redirect()->route('teacher.showRequestsList');
    }

    public function rejectRequest(Request $request)
    {
        $idRequest = $request->get('idRequest');
        SubjectJoinRequest::destroy($idRequest);

        return redirect()->route('teacher.showRequestsList');
    }

    /**
     * Prikaz svih definisanih projekata za odredjeni predmet
     *
     * - Nemanja Lazic 2018/0004
     */
    public function showProjects(Request $request)
    {
        $code = $request->code;

        $myProjects = Project::where('projects.idSubject', '=', function($query) use ($code){
            $query  -> select('idSubject')
                    -> from('subjects')
                    -> where('subjects.code', '=', $code);
        })->get();

        return view('teacher.show_projects', ['projects' => $myProjects, 'code' => $code]);
    }

    /**
     * Prikaz forme za definisanje projekta
     *
     * - Nemanja Lazic 2018/0004
     */
    public function showProjectForm(Request $request)
    {

    }

    /**
     * Uklanjanje projekta - POST zahtev
     *
     * - Nemanja Lazic 2018/0004
     */
    public function removeProject(Request $request)
    {
        $idProject = $request->get('idProject');
        Project::destroy($idProject);
        $message = "Uspesno uklonjen projekat";

        return response()->json(array('message' => $message, 'idProject' => $idProject), 200);
    }


    /**
     *
     * @note Funkcija prikazuje sve predmete na kojima profesor predaje.
     *
     * @return \Illuminate\Contracts\View\View
     * @author zvk17
     */
    public function getSubjects(Request $request){
        $userData = $request->session()->get("user");
        $user = $userData["userObject"];
        $teacher = $user->teacher()->sole();
        $subjects = $teacher->subjects()->getResults();
        $list = [];
        foreach ($subjects as $subject)
            $list[] = $subject;

        $teaches = $teacher->teachesSubjects()->getResults();
        foreach ($teaches as $teach) {
            //$sub = $teaches->subject()->sole();
            $list[] = $teach;
        }
        return view("teacher/subject_list", ["subjectList" => $list]);



    }
}
