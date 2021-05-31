<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

use App\SubjectJoinRequest;
use App\Attends;
use App\Project;
use App\Subject;

class TeacherController extends Controller
{

    // Potrebno u odgovorima za ajax zahteve
    public const HTTP_STATUS_OK = 200;
    public const HTTP_STATUS_NOT_FOUND = 404;
    public const HTTP_STATUS_ERROR_ALREADY_EXISTS = 409;

    public function __construct()
    {
        $this->middleware('teacherMiddleware');
    }

    public function index() {
        return view('teacher/teacher_index');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    public function addSubjectGet(Request $request) {
        $teachers = Teacher::where('idTeacher', '!=', $request->session()->get('user')['userObject']->idUser)->get();
        return view('teacher/teacher_create_subject', ['teachers' => $teachers]);
    }

    public function addSubjectPost() {

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
