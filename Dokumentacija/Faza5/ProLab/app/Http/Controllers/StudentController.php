<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Subject;
use App\Attends;
use App\SubjectJoinRequest;

class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('studentMiddleware');
    }

    public function index() {
        return view('index');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    public function showAllSubjectsList()
    {
        $subjects = Subject::all();
        $filteredSubjects = array();
        foreach($subjects as $subject)
        {
            if(Attends::studentAttendsSubjectTest(Session::get("user")["userObject"]->idUser, $subject->idSubject) == false &&
                SubjectJoinRequest::studentRequestedToJoinTest(Session::get("user")["userObject"]->idUser, $subject->idSubject) == false)
                $filteredSubjects[] = $subject;
        }
        //dd($subjects);
        return view('student.show_all_subjects', ['subjects' => $filteredSubjects]);
    }

    /*
    Funkcija za testiranje - TREBA DA SE IZBRISE
     */
    public function test(Request $request)
    {
        //dd($request->session()->all());
        //dd(Session::get("user")["userObject"]->idUser);
        dd($request);
    }

    public function sendJoinRequest(Request $request)
    {
        $idStudent = Session::get("user")["userObject"]->idUser;
        $idSubject = $request->get('idSubject');

        $joinRequest = new SubjectJoinRequest;
        $joinRequest->idSubject = $idSubject;
        $joinRequest->idStudent = $idStudent;
        
        $joinRequest->save();

        return redirect()->route('student.showAllSubjectsList');
    }
}
