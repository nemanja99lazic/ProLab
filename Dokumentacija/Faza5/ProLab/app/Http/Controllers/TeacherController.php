<?php
/**
 * Autor: Slobodan Katanic 2018/0133
 */
namespace App\Http\Controllers;

use App\Rules\SubjectNameCheck;
use App\Rules\SubjectCodeCheck;
use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\User;
use Illuminate\Http\Request;
use App\Teacher;
use App\SubjectJoinRequest;
use App\Attends;
use App\Project;
use App\Subject;

/**
 * TeacherController - klasa koja implemenitra logiku funckionalnosti za tip korisnika profesor.
 *
 * @version 1.0
 */
class TeacherController extends Controller
{

    // Potrebno u odgovorima za ajax zahteve
    public const HTTP_STATUS_OK = 200;
    public const HTTP_STATUS_NOT_FOUND = 404;
    public const HTTP_STATUS_ERROR_ALREADY_EXISTS = 409;

    /**
     * Kreiranje nove instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            'name' => ['required', new SubjectNameCheck()],
            'code' => ['required', 'alpha_num', new SubjectCodeCheck()]
        ],
        [
            'required' => 'Obavezno polje',
            'alpha_num' => 'Sifra se mora sastojati samo od slova i cifara'
        ]);
        $teachers = $request->get('teachers_select');
        $teacher = $request->session()->get('user')['userObject'];

        $newSubjectRequest = new NewSubjectRequest;
        $newSubjectRequest->idTeacher = $teacher->idUser;
        $newSubjectRequest->subjectName = $request->get('name').'_'.$request->get('code');
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
     * @param Request $request Request
     * 
     * @return view
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
     * @param Request $request Request
     * 
     * @return redirect
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
     * @param Request $request Request
     * 
     * @return view
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
     * @param Request $request Request
     * 
     * @return view
     * 
     * - Nemanja Lazic 2018/0004
     */
    public function showProjectForm(Request $request)
    {
        $myCode = $request->code;
        $mySubject = Subject::where('code', '=', $myCode)->first();
        return view('teacher.define_project', ['idSubject' => $mySubject->idSubject, 'code' => $myCode]);
    }

    /**
     * Uklanjanje projekta - POST zahtev
     * 
     * @param Request $request Request
     * 
     * @return response
     * 
     * - Nemanja Lazic 2018/0004
     */
    public function removeProject(Request $request)
    {
        $idProject = $request->get('idProject');
        $success = Project::destroy($idProject);
        
        if($success != 0){
            $message = "Uspesno uklonjen projekat";
            return response()->json(array('message' => $message, 'idProject' => $idProject), TeacherController::HTTP_STATUS_OK);
        }
        else
        {
            $message = "Brisanje nije uspelo.";
            return response()->json(array('message' => $message), TeacherController::HTTP_STATUS_ERROR_NOT_FOUND);
        }
    }

    /**
     * Definisanje projekta - POST zahtev
     * 
     * @param Request $request Request
     * 
     * @return response
     * 
     * - Nemanja Lazic 2018/0004
     */
    public function defineProject(Request $request){

        $name = $request->get('nazivProjekta');
        $minMemberNumber = $request->get('minBrojClanova');
        $maxMemberNumber = $request->get('maxBrojClanova');
        $expirationDate = $request->get('rok');
        $subjectCode = $request->get('code');
        $idSubject = Subject::where('code', '=', $subjectCode)->first()->idSubject;

        if(Project::where('idSubject', '=', $idSubject)->exists())
        {
            $message = "Jedan projekat za predmet već postoji.";
            return response()->json(array('message' => $message), TeacherController::HTTP_STATUS_ERROR_ALREADY_EXISTS);            
        }

        $newProject = new Project;
        $newProject->name = $name;
        $newProject->minMemberNumber = $minMemberNumber;
        $newProject->maxMemberNumber = $maxMemberNumber;
        $newProject->expirationDate = $expirationDate;
        $newProject->idSubject = $idSubject;
        $newProject->save();

        $message = "Projekat uspešno definisan";

        return response()->json(array('message' => $message), TeacherController::HTTP_STATUS_OK);
    }
}
