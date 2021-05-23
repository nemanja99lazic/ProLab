<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\LabExercise;
use App\Subject;
use Illuminate\Http\Request;
use App\Attends;
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
    }
}
