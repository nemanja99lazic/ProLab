<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\FreeAgent;
use App\HasAppointment;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\LabExercise;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Attends;
use App\SubjectJoinRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('studentMiddleware');
    }

    /**
     * @note Indeksna strana predmeta iz pogleda studenta
     * @author zvk17
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function subjectIndex($code, Request $request) {
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return redirect()->to(route('student.index'));
        }
        $subjectTitle = $subject->name;
        $teacherList = [];

        return view("student/subject_index", ["subjectTitle"=> $subjectTitle, "teacherList"=> $teacherList]);
    }
    public function index(Request $request) {

        return view('student/index');
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
        $paginatorSubjects = new LengthAwarePaginator
            (array_slice($filteredSubjects, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
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
       // $results = Subject::paginate(2);
        //dd($results);
        $agent=FreeAgent::where('idStudent','=',2)->
                            where('idAppointment','=',2)->
                            where('idDesiredAppointment','=',1)->first();
       // $agent->idStudent=2;
        //$agent->idAppointment=2;
       // $agent->idDesiredAppointment=1;
       // $agent->save();
        dd($agent->DesiredAppointment);

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

    /**
     * Prikaz svih izabranih predmeta.
     *
     * Poziva se za rutu '/student/chosen'
     * @param Request $request Request
     * @return view
     *
     * - Valerijan Matvejev 2018/0257
     */
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

    /**
     * Prikaz svih laboratorijskih vežbi za dati predmet.
     *
     * Poziva se za rutu '/student/subject/{code}/lab'
     *
     * @param Request $request Request
     * @return view
     *
     * - Valerijan Matvejev 2018/0257
     */
    public function lab(Request $request){

        //prikaz svih labova za predmet sa datom sifrom

        $code=$request->code; //dohvatamo parametar


        $subject=Subject::where('code','=',$code)->first();
        //$labExercises=[];
        $labExercises=LabExercise::where('idSubject','=',$subject->idSubject)->get();
        foreach($labExercises as $labExercise){
            $arrayLabExcercises[]=$labExercise;
        }
        //dd($labExercises);
        //return view('/student/test');
        $maxItemsPerPage=10;
        $paginatorLabExercises = new LengthAwarePaginator
        (array_slice($arrayLabExcercises, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($arrayLabExcercises), $maxItemsPerPage, null, [

            ]);

        $paginatorLabExercises->withPath("/student/subject/".$request->code."/lab");


        return view('student/lab_exercices_index',['labExercises'=>$paginatorLabExercises, 'code'=>$code]);

    }

    /**
     * Prikaz svih termina za datu laboratorijsku vežbu i za dati predmet.
     *
     * Poziva se za rutu '/student/subject/{code}/lab/{idLab}/join'
     *
     * @param Request $request Request
     * @return view
     *
     * - Valerijan Matvejev 2018/0257
     */

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
            //za paginaciju je potreban niz appointment-a, a ne kolekcija, zato pravim ovo
            $appointmentsArray[]=$appointment;
        }



        $maxItemsPerPage=4;
        $paginatorAppointments = new LengthAwarePaginator
        (array_slice($appointmentsArray, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($appointmentsArray), $maxItemsPerPage, null, [

            ]);

        $paginatorAppointments->withPath("/student/subject/".$request->code."/lab/".$request->idLab."/join");


        return view('student/show_appointments',['appointments'=>$paginatorAppointments,'array'=>$arrayForView
                            , 'lab'=>$lab ,'redniBrojevi'=>$redniBrojevi, 'code'=>$code,'empty'=>$empty
                            , 'IAmInThisOne'=>$IAmInThisOne] );
        //preko view koji ima FORMU koja ima HIDDEN polje koje je idTermina
    }

    /**
     * POST zahtev koji prijavljuje studenta na odabrani termin na odabranom predmetu i na odabranom labu.
     *
     * Poziva se za rutu '/student/subject/{code}/lab/{idLab}/join'
     *
     * @param Request $request Request
     * POST zahtev
     * @return redirect
     *
     * - Valerijan Matvejev 2018/0257
     */
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

        //koliko ima ljudi vec na ovom terminu; ako je > dozvoljeno, ne moze da se prijavi
        $objekatTermina=Appointment::find($termin);
        $studentiNaTerminu=HasAppointment::where('idAppointment','=',$termin)->get();
        $trenutno=count($studentiNaTerminu);
        Session::put('greska', 0);

        if(($trenutno+1)>$objekatTermina->capacity){
            Session::put('greska', 1);
            return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

        }

        $dodat=new HasAppointment;
        $dodat->idAppointment=$termin;
        $dodat->idStudent=$user->idUser;

        $dodat->save();
        //dd($request->code." , ".$request->idLab);
        //redirect()->route('student.subject.lab.idlab.join.get',['code'=>$request->code,'idLab'=>$request->idLab]);
        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);
    }

    /**
     * POST zahtev koji odjavljuje studenta sa odabranog termina na odabranom predmetu i na odabranom labu .
     *
     * Poziva se za rutu '/student/subject/{code}/lab/{idLab}/leave'
     *
     * @param Request $request Request
     * POST zahtev
     * @return redirect
     *
     * - Valerijan Matvejev 2018/0257
     */
    public function leaveAppointment(Request $request){
        //ukloni studenta sa termina
        $termin=$request->get('idAppointment');
        $user=$request->session()->get('user')['userObject'];


        $matchThese=['idAppointment'=>$termin,'idStudent'=>$user->idUser];
        $dodat=HasAppointment::where($matchThese)->delete();


        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);
    }

    /**
     * Prikaz svih studenata koji su spremni za zamenu (FreeAgents), a odgovara im termin ovog studenta.
     *
     * Poziva se za rutu '/student/subject/{code}/lab/idLab/swap'
     *
     * @param Request $request Request
     * @return view
     *
     * - Valerijan Matvejev 2018/0257
     */

    public function showPossibleSwaps(Request $request){
        //svi termini za ovaj lab
        $appointments=Appointment::where('idLabExercise','=',$request->idLab)->get();

        //PREDUSLOV: student mora da ima termin u tabeli HasAppointment da bi radio zamenu
        $myAppointmentArray=[];

        $appointment=$appointments[0];
        foreach($appointments as $appointment){
            $temp=HasAppointment::where('idStudent','=',$request->session()->get('user')['userObject']->idUser)
                ->where('idAppointment','=',$appointment->idAppointment)->first();
            if($temp!=null) $myAppointmentArray[]=$temp;
        }

        if(sizeof($myAppointmentArray)!=1) dd("greska");
        $myAppointment=$myAppointmentArray[0];

        //nadjem sve studente kojima je DesiredAppointment == mojAppointment
        $freeAgents=FreeAgent::where('idDesiredAppointment','=',$myAppointment->idAppointment)->get();
        $formatForView=[];
        foreach($freeAgents as $freeAgent){
            $student=Student::where('idStudent','=',$freeAgent->idStudent)->first();
            $appointment=Appointment::where('idAppointment','=',$freeAgent->idAppointment)->first();
            $formatForView[]=$student->user->forename." ".$student->user->surname." ".$student->index
                        .",".$appointment->datetime->format('d.m.Y').",".$appointment->datetime->format('H:i').",".
                        $appointment->classroom.",".$appointment->idAppointment.",".$student->idStudent;
        }
        $code=$request->code;
        $lab=$request->idLab;
        $maxItemsPerPage=5;
        $paginatorFormatForView = new LengthAwarePaginator
        (array_slice($formatForView, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($formatForView), $maxItemsPerPage, null, [

            ]);

        $paginatorFormatForView->withPath("/student/subject/".$request->code."/lab/".$request->idLab."/swap");

        return view('student/show_possible_swaps',['datas'=>$paginatorFormatForView,
            'code'=>$code, 'lab'=>$lab,'myAppointment'=>$myAppointment->idAppointment]);

    }

    /**
     * POST zahtev koji vrši zamenu termina dvojici studenata.
     *
     * Poziva se za rutu '/student/subject/{code}/lab/{idLab}/swap'
     *
     * @param Request $request Request
     * POST zahtev
     * @return redirect
     *
     * - Valerijan Matvejev 2018/0257
     */
    public function performSwap(Request $request){
        //dohvatimo iz forme potrebne podatke, i uradimo zamenu

        $data=$request->get('odabrani');
        //dd($data);
        $myAppointment=explode(',',$data)[0];
        $myId=explode(',',$data)[1];
        $swapAppointment=explode(',',$data)[2];
        $swapId=explode(',',$data)[3];

        //obrises iz FreeAgents drugog studenta
        FreeAgent::where('idStudent','=',$swapId)->where('idAppointment','=',$swapAppointment)->delete();

        //obrises iz HasAppointment drugog studenta


        //NE RADI OVA LINIJA KODA
        HasAppointment::where('idStudent','=',$swapId)->where('idAppointment','=',$swapAppointment)->delete();

        //obrises iz HasAppointment mene
        dd("bunike");
        HasAppointment::where('idStudent','=',$myId)->where('idAppointment','=',$myAppointment)->delete();
        //dodam u HasAppointment mene sa swapAppointment
        $t1=new HasAppointment();
        $t1->idAppointment = $swapAppointment;
        $t1->idStudent = $myId;
        $t1->save();
        //dodam u HasAppointment drugog studenta sa myAppointment
        $t2=new HasAppointment();
        $t2->idAppointment=$myAppointment;
        $t2->idStudent=$swapId;
        $t2->save();

        //obavestenje AJAX o izvrsenoj promeni

        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

    }

}
