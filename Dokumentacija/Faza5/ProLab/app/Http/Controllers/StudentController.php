<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Subject;
use App\Attends;
use App\SubjectJoinRequest;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * Prikaz svih predmeta koji mogu da se prijave. Poziva se za rutu '/student/subject/enroll'
     * 
     * @return view
     * 
     * - Nemanja Lazic 2018/0004
    */
    public function showAllSubjectsList()
    {
        $subjects = Subject::orderBy('code')->get();
        $filteredSubjects = array();
        foreach($subjects as $subject)
        {
            if(Attends::studentAttendsSubjectTest(Session::get("user")["userObject"]->idUser, $subject->idSubject) == false &&
                SubjectJoinRequest::studentRequestedToJoinTest(Session::get("user")["userObject"]->idUser, $subject->idSubject) == false)
                $filteredSubjects[] = $subject;
        }
        $maxItemsPerPage = 2;
        $paginatorSubjects = new LengthAwarePaginator(array_slice($filteredSubjects, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
                                                        ,count($filteredSubjects), $maxItemsPerPage, null, []);
        $paginatorSubjects->withPath('/student/subject/enroll');
        
        return view('student.show_all_subjects', ['subjects' => $paginatorSubjects]);
    }

    /*
    Funkcija za testiranje - TREBA DA SE IZBRISE
     */
    public function test(Request $request)
    {
        //dd($request->session()->all());
        //dd(Session::get("user")["userObject"]->idUser);
        //dd($request);
        $results = Subject::paginate(2);
        dd($results);

    }

    /**
     * Slanje zahteva za pracenje predmeta. Poziva se za rutu '/student/subject/enroll' (POST)
     * 
     * @param Request $request Request
     * @return redirect
     * 
     * - Nemanja Lazic 2018/0004
     */
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
