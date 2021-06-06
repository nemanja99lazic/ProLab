<?php
/**
 * Autori: Nemanja Lazic 2018/0004
 *         Slobodan Katanic 2018/0133
 *         Zivkovic Sreten 2018/0008
 *
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

use App\LabExercise;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Appointment;
use App\HasAppointment;
use App\Teaches;
use Illuminate\Support\Facades\Session;

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
    public const HTTP_STATUS_ERROR_SERVER_ERROR = 500;

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
     * Funkcija koja poziva pogeld za prikaz pocetne stranice profesora.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\
     */
    public function index() {
        $myId = Session::get("user")["userObject"]->idUser;
        $userInfo = User::find($myId);
        return view('teacher/teacher_index', ['forename' => $userInfo->forename, 'surname' => $userInfo->surname, 'email' => $userInfo->email, 'username' => $userInfo->username]);
    }

    /**
     * Funcikcija koja sluzi za odjavu profesora sa sistema.
     *
     * @param Request $request Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    /**
     * Funcija koja poziva pogled za prikaz forme za dodavanje novog predmeta.
     *
     * @param Request $request Request
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
     * Fukcija koja prikazuje profesoru informaije o odredjenom predmetu.
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

        $maxItemsPerPage = 10;

        $myRequests = SubjectJoinRequest::whereIn('subject_join_requests.idSubject', function($query) use ($myId) {
            $query  ->select('idSubject')
                    ->from('teaches')
                    ->where('teaches.idTeacher', $myId);
        })->join('users', 'users.idUser', '=', 'subject_join_requests.idStudent')
        ->join('subjects', 'subjects.idSubject', '=', 'subject_join_requests.idSubject')
        ->paginate($maxItemsPerPage);

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
        $myId = $request->session()->get('user')['userObject']->idUser;
        $idRequest = $request->get('idRequest');
        $acceptingRequest = SubjectJoinRequest::where('idRequest', '=', $idRequest)->first();

        if(Teaches::teachesCheck($myId, $acceptingRequest->idSubject)) // samo ako profesor predaje predmet moze da prihvati zahtev
        {
            $attendsEntity = new Attends;
            $attendsEntity->idStudent = $acceptingRequest->idStudent;
            $attendsEntity->idSubject = $acceptingRequest->idSubject;
            $attendsEntity->save();

            $acceptingRequest->delete();
        }
        return redirect()->route('teacher.showRequestsList');
    }

    public function rejectRequest(Request $request)
    {
        $myId = $request->session()->get('user')['userObject']->idUser;
        $idRequest = $request->get('idRequest');
        $rejectingRequest = SubjectJoinRequest::where('idRequest', '=', $idRequest)->first();
        
        if(Teaches::teachesCheck($myId, $rejectingRequest->idSubject)) // samo ako profesor predaje predmet moze da prihvati zahtev
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
        $myId = $request->session()->get('user')['userObject']->idUser;
        $subjectCode = $request->code;
        $idSubject = Subject::where('code', '=', $subjectCode)->first()->idSubject;
        if(!Teaches::teachesCheck($myId, $idSubject))
        {
            $message = "Ne možete da izbrišete projekat za predmet na kom ne predajete.";
            return response()->json(array('message' => $message), TeacherController::HTTP_STATUS_ERROR_SERVER_ERROR);
        }

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

        $myId = $request->session()->get('user')['userObject']->idUser;
        $name = $request->get('nazivProjekta');
        $minMemberNumber = $request->get('minBrojClanova');
        $maxMemberNumber = $request->get('maxBrojClanova');
        $expirationDate = $request->get('rok');
        $subjectCode = $request->get('code');
        $idSubject = Subject::where('code', '=', $subjectCode)->first()->idSubject;

        if(!Teaches::teachesCheck($myId, $idSubject))
        {
            $message = "Ne možete da definišete projekat za predmet na kom ne predajete.";
            return response()->json(array('message' => $message), TeacherController::HTTP_STATUS_ERROR_SERVER_ERROR);
        }

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

    /**
     * Prikaz svih labova za dati predmet
     *
     * @param Request $request Request
     *
     * @return view
     *
     * - Valerijan Matvejev 2018/0257,
     *  prilagodio Nemanja Lazic 2018/0004
     */
    public function showLabs(Request $request){

        $code=$request->code;
        $subject=Subject::where('code','=',$code)->first();

        $arrayLabExcercises = array();
        $labExercises=LabExercise::where('idSubject','=',$subject->idSubject)->get();
        foreach($labExercises as $labExercise){
            $arrayLabExcercises[]=$labExercise;
        }

        $maxItemsPerPage=10;
        $paginatorLabExercises = new LengthAwarePaginator
        (array_slice($arrayLabExcercises, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($arrayLabExcercises), $maxItemsPerPage, null, []);

        $paginatorLabExercises->withPath("/student/subject/".$code."/lab");

        return view('teacher.show_labs',['labExercises'=>$paginatorLabExercises, 'code'=>$code]);
    }

    /**
     * Prikaz informacija o labu sa svim terminima za dati lab
     *
     * @param Request $request Request
     *
     * @return view
     *
     * - Nemanja Lazic 2018/0004
     */
    public function showLabAppointments(Request $request)
    {
        $subjectCode = $request -> code;
        $idLab = $request->idLab;

        $myLab = LabExercise::find($idLab); // nasao Lab
        $myAppointmentsWithStudents = Appointment::where('idLabExercise', '=', $idLab)->get(); // Nasao termina, vraca collection
        foreach($myAppointmentsWithStudents as $appointment) // Nadji studente koji su u odgovarajucim terminima
        {
            $studentsRows = HasAppointment::where('idAppointment', '=', $appointment->idAppointment)
                            ->join('students', 'students.idStudent', '=', 'has_appointment.idStudent')
                            ->join('users', 'users.idUser', '=', 'has_appointment.idStudent')
                            ->select('forename', 'surname', 'index')
                            ->get()->toArray();
            $appointment['students'] = $studentsRows; // prosiri kolekciju termina nizom studenata za taj termin 'students'
        }

        $maxItemsPerPage=4;
        $myAppointmentsWithStudents = $myAppointmentsWithStudents->toArray();
        $paginatorAppointments = new LengthAwarePaginator
        (array_slice($myAppointmentsWithStudents, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($myAppointmentsWithStudents), $maxItemsPerPage, null, [

            ]);

        $paginatorAppointments->withPath("/teacher/subject/". $subjectCode ."/lab/". $idLab ."/appointments");

        return view('teacher.show_lab_appointments', ['lab' => $myLab, 'appointments' => $paginatorAppointments, 'code' => $subjectCode]);
    }

    /**
     * Prikaz forme za definisanje laboratorijske vezbe
     *
     * @param Request $request Request
     *
     * @return view
     *
     * - Nemanja Lazic 2018/0004
     */
    public function showAddLabForm(Request $request)
    {
        $code = $request->code;
        return view('teacher.add_lab', ['code' => $code]);
    }

    /**
     * Definisanje laboratorijske vezbe - upis laboratorijske vezbe u bazu i odgovarajucih termina
     *
     * @param Request $request Request
     *
     * @return view
     *
     * - Nemanja Lazic 2018/0004
     */
    public function defineLab(Request $request)
    {

        $myId = $request->session()->get('user')['userObject']->idUser;

        $subjectCode = $request->code;
        $labExerciseName = $request->get('name');
        $labExerciseDescription = $request->get('description');
        $labExerciseExpiration = $request->get('expiration');
        $labExerciseAppointmentsArray = $request->get('appointments');
        $idSubject = Subject::where('code', '=', $subjectCode)->first()->idSubject;

        if(!Teaches::teachesCheck($myId, $idSubject)) // provera da li predaje predmet
            return response()->json(array('message' => 'Ne možete da kreirate laboratorijsku vežbu na predmetu koji ne predajete.'), TeacherController::HTTP_STATUS_ERROR_SERVER_ERROR);

        $savedLabId = LabExercise::create(array('name' => $labExerciseName, 
                                                    'description' => $labExerciseDescription, 
                                                    'expiration' => $labExerciseExpiration,
                                                    'idSubject' => $idSubject)) -> idLabExercise;

        if($savedLabId == null)
            return response()->json(array('message' => 'Nije uspelo da sačuva laboratorijsku vežbu.'), TeacherController::HTTP_STATUS_ERROR_SERVER_ERROR);

        foreach($labExerciseAppointmentsArray as $appointmentObject)
        {
            $newAppointment = new Appointment;
            $newAppointment->name = $labExerciseName;
            $newAppointment->classroom = $appointmentObject["classroom"];
            $newAppointment->capacity = $appointmentObject["capacity"];
            $newAppointment->location = $appointmentObject["location"];
            $newAppointment->datetime = $appointmentObject["datetime"];
            $newAppointment->idLabExercise = $savedLabId;

            $savedIndicator = $newAppointment->save();
            if(!$savedIndicator)
                return response()->json(array('message' => 'Nije uspelo da sačuva laboratorijsku vežbu.'), TeacherController::HTTP_STATUS_ERROR_SERVER_ERROR);
        }

        return response()->json(array('message' => "Uspesnooo"), TeacherController::HTTP_STATUS_OK);
    }


    /**
     *
     * Prikazuje spisak svih predmeta na kojima profesor predaje.
     * GET metoda
     * @return \Illuminate\Contracts\View\View
     * @author Sreten Živković 0008/2018
     */
    public function getSubjects(Request $request) {

        $userData = $request->session()->get("user");
        $user = $userData["userObject"];
        $teacher = $user->teacher()->first();

        $list = [];

        $subjects = $teacher->teachesSubjects()->getResults();
        foreach ($subjects as $subject) {
            $list[] = $subject;
        }
        return view("teacher.subject_list", ["subjectList" => $list]);

    }
    /**
     *
     * Prikazuje predmet iz pogleda profesora
     * GET metoda
     * @return \Illuminate\Contracts\View\View
     * @author Sreten Živković 0008/2018
     */
    public function subjectIndexPage($code) {
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return redirect()->route('teacher.index');
        }
        $teacherList = [];
        $otherTeachers = $subject->teachers()->getResults();

        foreach ($otherTeachers as $otherTeacher) {
            $teacherList[] = $otherTeacher->user()->first();
        }
        return view("teacher/subject_index", ["subjectTitle"=> $subject->name, "teacherList"=> $teacherList, "code" => $code]);
    }



}
