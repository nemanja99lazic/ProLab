<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

use App\SubjectJoinRequest;
use App\Attends;

class TeacherController extends Controller
{
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
}
