<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\LabExercise;
use App\Subject;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Session;
use App\Subject;
use App\Attends;
use App\SubjectJoinRequest;
use Illuminate\Pagination\LengthAwarePaginator;

=======
use App\Attends;
>>>>>>> mojBranch
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

<<<<<<< HEAD
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
=======
    public function chosen(Request $request){


        $podaci=$request->session()->get('user');

        $user=$podaci['userObject'];

        $attends=Attends::where('idStudent','=',$user->idUser)->get();
        $subjectIds=[];
        foreach($attends as $attend)
            $subjectIds[]=$attend->idSubject;
        $subjects=[];
        foreach($subjectIds as $subjectId)
            $subjects[]=Subject::find($subjectId);

        return view('student/chosen_subjects',['subjects'=>$subjects]);
    }

    public function lab(Request $request){

        $code=$request->code; //dohvatamo parametar


        $subject=Subject::where('code','=',$code)->first();
        $labExercises=[];
        $labExercises[]=LabExercise::where('idSubject','=',$subject->idSubject)->first();
        //return view('/student/test');
        return view('student/lab_exercices_index',['labExercises'=>$labExercises, 'code'=>$code]);

    }
    public function showAppointments(Request $request){
        //prikazi termine za ovaj lab
        //$code=$request->code;
        $idLab=$request->idLab;


        $appointments=Appointment::where('idLabExercise','=',$idLab)->get();


        $arrayForView=[];
        foreach($appointments as $appointment) {
           $temp=$appointment->students;

            foreach ($temp as $t)
                $arrayForView[] = $t->user->forename . "," . $t->user->surname . "," . $t->index . "," . $appointment->idAppointment;
        }



        return view('student/show_appointments',['appointments'=>$appointments,'array'=>$arrayForView]);
        //preko view koji ima FORMU koja ima HIDDEN polje koje je idTermina
    }

    public function joinAppointment(Request $request){
        //prijavi se za termin , tako sto uzmes hidden polje idTermina iz forme
>>>>>>> mojBranch
    }
}
