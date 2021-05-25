<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\HasAppointment;
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

        //prikaz svih labova za predmet sa datom sifrom

        $code=$request->code; //dohvatamo parametar


        $subject=Subject::where('code','=',$code)->first();
        //$labExercises=[];
        $labExercises=LabExercise::where('idSubject','=',$subject->idSubject)->get();
        //dd($labExercises);
        //return view('/student/test');
        return view('student/lab_exercices_index',['labExercises'=>$labExercises, 'code'=>$code]);

    }
    public function showAppointments(Request $request){
        //prikazi termine za ovaj lab
        $code=$request->code;
        $idLab=$request->idLab;

        $lab=LabExercise::where('idLabExercise','=',$idLab)->first();
        //svi termini ovog laba
        $appointments=Appointment::where('idLabExercise','=',$idLab)->get();


        $arrayForView=[];// niz koji sadrzi: ImeStudenta,PrezimeStudenta,Index,idTermina
                         // (Potrebno za tabelu da znamo koji su studenti u kom terminu)
        foreach($appointments as $appointment) {
           $temp=$appointment->students;

            foreach ($temp as $t)

                    $arrayForView[] = $t->user->forename . "," . $t->user->surname . "," . $t->index . "," . $appointment->idAppointment.",".$t->idStudent;
        }
        $redniBrojevi=[];
        //dd($arrayForView);
        foreach($appointments as $appointment) {
            $redniBrojevi[]=1;
        }
        $num=0;
        foreach($arrayForView as $ar)
            $num++;
        $empty=false;
        if($num==0) $empty=true;

        //pronadjem u kom se terminu trenutno nalazim
        $IAmInThisOne=null;


        foreach($appointments as $appointment) {
            $temp=$appointment->students;
            foreach ($temp as $t){
                if($t->user->idUser==$request->session()->get('user')['userObject']->idUser)
                    $IAmInThisOne=$appointment;

            }

        }
        return view('student/show_appointments',['appointments'=>$appointments,'array'=>$arrayForView
                            , 'lab'=>$lab ,'redniBrojevi'=>$redniBrojevi, 'code'=>$code,'empty'=>$empty
                            , 'IAmInThisOne'=>$IAmInThisOne] );
        //preko view koji ima FORMU koja ima HIDDEN polje koje je idTermina
    }

    public function joinAppointment(Request $request){
        //prijavi se za termin , tako sto uzmes hidden polje idTermina iz forme

        $termin=$request->get('idAppointment');
        $user=$request->session()->get('user')['userObject'];

        //obrisem ako sam vec prijavljen na nekom terminu ovog laba
        $idLab=$request->idLab;
        $terminiLaba=Appointment::where('idLabExercise','=',$idLab)->get();
        foreach($terminiLaba as $terminLab){
            $matchThese=['idAppointment'=>$terminLab->idAppointment,'idStudent'=>$user->idUser];
            HasAppointment::where($matchThese)->delete();
        }


        $dodat=new HasAppointment;
        $dodat->idAppointment=$termin;
        $dodat->idStudent=$user->idUser;

        $dodat->save();
        //dd($request->code." , ".$request->idLab);
        //redirect()->route('student.subject.lab.idlab.join.get',['code'=>$request->code,'idLab'=>$request->idLab]);
        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);
    }
    public function leaveAppointment(Request $request){
        //ukloni studenta sa termina
        $termin=$request->get('idAppointment');
        $user=$request->session()->get('user')['userObject'];


        $matchThese=['idAppointment'=>$termin,'idStudent'=>$user->idUser];
        $dodat=HasAppointment::where($matchThese)->delete();


        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);
    }
}
