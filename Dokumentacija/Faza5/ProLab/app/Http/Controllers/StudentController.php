<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\FreeAgent;
use App\HasAppointment;
use App\LabExercise;
use App\Student;
use App\Subject;
use App\Project;
use App\Team;
use App\TeamMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Attends;
use Illuminate\Support\Facades\DB;
use App\SubjectJoinRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('studentMiddleware');
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
     * Privatna funkcija za proveru da li je rok prosao
     *
     *
     *
     * @param int $idLab
     * @return boolean
     *
     * - Valerijan Matvejev 2018/0257
     */
    private function prosaoRok($idLab){
        $lab=LabExercise::where('idLabExercise','=',$idLab)->first();

        $rokZaPrijavu=$lab->expiration;

        $sada = Carbon::now();


        $sada->addHours(2); //za lokalno vreme


        if($sada->gt($rokZaPrijavu)){

            return true;
        }
        return false;
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



        $labExercises=LabExercise::where('idSubject','=',$subject->idSubject)->get();
        $arrayActiveLabExercises=[];
        $arrayInactiveLabExcercises=[];
        foreach($labExercises as $labExercise){
            if($this->prosaoRok($labExercise->idLabExercise)){
                $arrayInactiveLabExcercises[]=$labExercise;
            }
            else{
                $arrayActiveLabExercises[]=$labExercise;
            }

        }

        $maxItemsPerPage=10;
        $paginatorActiveLabExercises = new LengthAwarePaginator
        (array_slice($arrayActiveLabExercises, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($arrayActiveLabExercises), $maxItemsPerPage, null, [

            ]);

        $paginatorActiveLabExercises->withPath("/student/subject/".$request->code."/lab");

        $paginatorInactiveLabExercises = new LengthAwarePaginator
        (array_slice($arrayInactiveLabExcercises, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($arrayInactiveLabExcercises), $maxItemsPerPage, null, [

            ]);

        $paginatorInactiveLabExercises->withPath("/student/subject/".$request->code."/lab");

        return view('student/lab_exercices_index',['activeLabExercises'=>$paginatorActiveLabExercises,
            'inactiveLabExercises'=>$paginatorInactiveLabExercises,'code'=>$code]);

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
        //ako ne postoji nijedan termin
        if(count($appointments)==0)
            Session::put('nemaTermina',1);

        $arrayForView=[];// niz koji sadrzi: ImeStudenta,PrezimeStudenta,Index,idTermina
                         // (Potrebno za tabelu da znamo koji su studenti u kom terminu)
        foreach($appointments as $appointment) {
            $temp=[];
           //$temp=$appointment->students;
            $hasAppointments=HasAppointment::where('idAppointment','=',$appointment->idAppointment)->get();
            foreach($hasAppointments as $hasAppointment){
                $temp[]=Student::where('idStudent','=',$hasAppointment->idStudent)->first();
            }

            //nadji sve studente koji imaju ovaj termin
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
        $appointmentsArray=[];

        foreach($appointments as $appointment) {
            //$hasAppointments=HasAppointment::where('idAppointment','=',$appointment->idAppointment)->get();

            $temp=[];

            $hasAppointments=HasAppointment::where('idAppointment','=',$appointment->idAppointment)->get();
            foreach($hasAppointments as $hasAppointment){
                $temp[]=Student::where('idStudent','=',$hasAppointment->idStudent)->first();
            }
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
     * Privatna funkcija za proveru da li je rok prosao, uz dodatno postaljanje
     * odgovarajućeg parametra Sesije, kako bi se naznačilo probijanje roka.
     *
     *
     * @param int $idLab
     * @return boolean
     *
     * - Valerijan Matvejev 2018/0257
     */
    private function prosaoRokSaPostavljanjemSesije($idLab){
        $lab=LabExercise::where('idLabExercise','=',$idLab)->first();

        $rokZaPrijavu=$lab->expiration;

        $sada = Carbon::now();
        $sada->addHours(2); //za lokalno vreme


        if($sada->gt($rokZaPrijavu)){
            Session::put('prosao',$idLab);
            return true;
        }
        return false;
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

        //ukoliko je rok za termin prosao, ne moze da se prijavi na termin
        if($this->prosaoRokSaPostavljanjemSesije($request->idLab)){
            return redirect()->route('student.subject.lab', [$request->code]);
        }



        //koliko ima ljudi vec na ovom terminu; ako je > dozvoljeno, ne moze da se prijavi
        $objekatTermina=Appointment::find($termin);
        $studentiNaTerminu=HasAppointment::where('idAppointment','=',$termin)->get();
        $trenutno=count($studentiNaTerminu);


        if(($trenutno+1)>$objekatTermina->capacity){
            //ispis greske o prepunjenosti termina
            Session::put('kapacitet', $request->get('iteracija')+1);
            return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

        }

        //obrisem ako sam vec prijavljen na nekom terminu ovog laba
        $idLab=$request->idLab;
        $terminiLaba=Appointment::where('idLabExercise','=',$idLab)->get();
        foreach($terminiLaba as $terminLab){
            $matchThese=['idAppointment'=>$terminLab->idAppointment,'idStudent'=>$user->idUser];
            $dodat=HasAppointment::where($matchThese)->first();
            if($dodat!=null) {
                $relatedFreeAgents = FreeAgent::where('idHasAppointment', '=', $dodat->idHasAppointment)->delete();
                $dodat->delete();
            }
        }


        //ubacim ga na novi termin
        $dodat=new HasAppointment;
        //$dodat->idHasAppointment=(HasAppointment::max('idHasAppointment')+1);
        $dodat->idAppointment=$termin;
        $dodat->idStudent=$user->idUser;

        $dodat->save();
        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);
    }

    /**
     * Privatna funkcija za rekurentno brisanje iz termina
     *
     *
     *
     * @param int $idAppointment, int $idStudent
     * @return void
     *
     * - Valerijan Matvejev 2018/0257
     */
    private function recurrentDeleteFromAppointment($idAppointment, $idStudent){
        $matchThese=['idAppointment'=>$idAppointment,'idStudent'=>$idStudent];
        $dodat=HasAppointment::where($matchThese)->first();
        //kaskadno brisanje povezanih free agenata
        $relatedFreeAgents=FreeAgent::where('idHasAppointment','=',$dodat->idHasAppointment)->delete();
        //brisanje prvog iz HasAppointment
        $dodat->delete();

        while(true){

            $tren=FreeAgent::where('idDesiredAppointment','=',$idAppointment)->first();
            if($tren==null){
                //kraj rekurzije
                break;
            }
            //premesti prethodnog na trenutno mesto
            $temp=HasAppointment::where('idHasAppointment','=',$tren->idHasAppointment)->first();
            $oldIdAppointment=$temp->idAppointment;

            $temp->update(['idAppointment'=>$idAppointment]);
            //brisanje povezanih freeAgents
            FreeAgent::where('idHasAppointment','=',$temp->idHasAppointment)->delete();

            $idAppointment=$oldIdAppointment;

        }


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
        $user=$request->session()->get('user')['userObject']->idUser;

        $this->recurrentDeleteFromAppointment($termin,$user);



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


        $myAppointmentArray=[];
        //trazim svoj termin
        $appointment=$appointments[0];
        foreach($appointments as $appointment){
            $temp=HasAppointment::where('idStudent','=',$request->session()->get('user')['userObject']->idUser)
                ->where('idAppointment','=',$appointment->idAppointment)->first();
            if($temp!=null) $myAppointmentArray[]=$temp;
        }


        if(sizeof($myAppointmentArray)==0) {
            // ako nemam termin, vratim ga na stranicu svih termina, sa ispisom greske
            Session::put('nePosedujemTermin',1);
            return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

        }
        $myAppointment=$myAppointmentArray[0];

        //nadjem sve studente kojima je DesiredAppointment == mojAppointment
        $freeAgents=FreeAgent::where('idDesiredAppointment','=',$myAppointment->idAppointment)->get();

        $formatForView=[];
        foreach($freeAgents as $freeAgent){
            $hasAppStudent=HasAppointment::where('idHasAppointment','=',$freeAgent->idHasAppointment)->first();
            $student=Student::where('idStudent','=',$hasAppStudent->idStudent)->first();
            $appointment=Appointment::where('idAppointment','=',$hasAppStudent->idAppointment)->first();
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
     * Privatna funkcija koja radi swap termina dvojici studenata.
     *
     *
     *
     * @param int $myAppointment, int $myId, int $swapAppointment, int $swapId
     * @return void
     *
     * - Valerijan Matvejev 2018/0257
     */
    private function swapStudents($myAppointment, $myId, $swapAppointment, $swapId){
        //obrises iz FreeAgents drugog studenta
        $hasApp=HasAppointment::where('idStudent','=',$swapId)->where('idAppointment','=',$swapAppointment)->first();
        FreeAgent::where('idHasAppointment','=',$hasApp->idHasAppointment)->delete();

        //stavim drugom studentu moj Appointment
        $hasApp->update(['idAppointment'=>$myAppointment]);


        $ja=HasAppointment::where('idStudent','=',$myId)->where('idAppointment','=',$myAppointment)->first();
        //obrisem iz free Agents mene
        FreeAgent::where('idHasAppointment','=',$ja->idHasAppointment)->delete();
        //stavim sebi swapAppointment
        $ja->update(['idAppointment'=>$swapAppointment]);
        Session::put('swapZavrsen',1);
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

        $data=$request->get('odabrani'); //koji je radio button odabran
        if($data==null) return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);


        $myAppointment=explode(',',$data)[0];
        $myId=explode(',',$data)[1];
        $swapAppointment=explode(',',$data)[2];
        $swapId=explode(',',$data)[3];

        $this->swapStudents($myAppointment,$myId,$swapAppointment,$swapId);

        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

    }

    /**
     * Prikaz pogleda za unos zahteva za zamenu termina.
     *
     * Poziva se za rutu '/student/subject/{code}/lab/idLab/request'
     *
     * @param Request $request Request
     * @return view
     *
     * - Valerijan Matvejev 2018/0257
     */
    public function enterRequest(Request $request){
        //svi PUNI termini, jer nema svrhe menjati se za slobodan termin
        $allAppointments=Appointment::where('idLabExercise','=',$request->idLab)->get();
        $fullAppointments=[];
        $myAppointment=HasAppointment::where('idStudent','=',$request->session()->get('user')['userObject']->idUser)
            ->first();

        if($myAppointment==null) {
            // ako nemam termin, vratim ga na stranicu svih termina, sa ispisom greske
            Session::put('nePosedujemTermin',1);
            return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

        }

        foreach($allAppointments as $allAppointment){
            $temp=HasAppointment::where('idAppointment','=',$allAppointment->idAppointment)->get();
            $currentNumberOfStudents=count($temp);
            if($currentNumberOfStudents==$allAppointment->capacity and ($myAppointment->idAppointment)!=$allAppointment->idAppointment)
                $fullAppointments[]=$allAppointment;
        }
        //niz za VIEW
        $arrayForView=[];
        foreach($fullAppointments as $fullAppointment){
            $arrayForView[]=$fullAppointment->datetime->format('d.m.Y').",".
                            $fullAppointment->datetime->format('H:i').",".
                            $fullAppointment->classroom.",".$fullAppointment->idAppointment;

        }
        $maxItemsPerPage=5;
        $paginatorArrayForView = new LengthAwarePaginator
        (array_slice($arrayForView, (LengthAwarePaginator::resolveCurrentPage() - 1) * $maxItemsPerPage, $maxItemsPerPage)
            ,count($arrayForView), $maxItemsPerPage, null, [

            ]);
        //PREDUSLOV: kao i kod swapa obicnog, mora student da ima svoj termin
        //treba mi i podatak u kom se ja trenutno terminu nalazim

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




        if($myAppointment==null) {
            //TODO: ako nemam termin, vratim ga na stranicu sa ispisom greske
            Session::put('nePosedujemTermin',1);
            return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

        }

        $paginatorArrayForView->withPath("/student/subject/".$request->code."/lab/".$request->idLab."/request");


        return view('student/swap_request',['appointments'=>$paginatorArrayForView,
            'code'=>$request->code, 'lab'=>$request->idLab,'myAppointment'=>$myAppointment->idAppointment
        ]);
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
        $otherTeachers = $subject->teachers()->getResults();

        foreach ($otherTeachers as $otherTeacher) {
            $teacherList[] = $otherTeacher->user()->sole();
        }

        return view("student/subject_index", ["subjectTitle"=> $subjectTitle, "teacherList"=> $teacherList]);
    }

    /**
     * @note Prikaz stranice za upravljanje projektima iz uloge studenta
     * @param $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @author zvk17
     */
    public function projectIndexPage($code) {
        return view("student/project");
    }

    /**
     * @note JSON lista dostupnih timova za dati predmet (GET)
     * @param $code
     * @author zvk17
     */
    public function availableTeams($code) {
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return response()->json(["message"=> "subject not exist"], 400);
        }
        $project = $subject->projects()->sole();
        if (is_null($project)) {
            return response()->json(["message"=> "project not exist"], 400);
        }
        if ($project->hasExpired()) {
            return response()->json(["message"=> "project expired"], 400);
        }

        $teams = $project->teams()->getResults();
        $teamList = [];
        foreach($teams as $team) {
            $teamList[] = $team;
        }

        return response()->json(['teams' => $teamList], 200);
    }

    /***
     * @note dodaje studenta u tim
     * @param String $code sifra predmeta
     * @param int $teamId id tima
     * @author zvk17
     */
    public function joinTeam($code, $teamId) {
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return response()->json(["message"=> "subject not exist"], 400);
        }
        $project = $subject->projects()->sole();
        if (is_null($project)) {
            return response()->json(["message"=> "project not exist"], 400);
        }
        if ($project->hasExpired()) {
            return response()->json(["message"=> "project expired"], 400);
        }

        $user = request()->session()->get("user")["userObject"];
        $team = Team::find($teamId);
        if (is_null($team)) {
            return response()->json(["message"=>"team doesnt exist"], 409);
        }


        $mmn = (int)$project->maxMemberNumber;
        $tmc = $team->members()->count();
        if ($mmn <= $tmc) {
            return response()->json(["message"=>"max member count exceeded"], 409);
        }


        if ($this->alreadyInTeam($code, $user->idUser)) {
            return response()->json(["message"=>"already in team"], 409);
        }

        $teamMember = new TeamMember();
        $teamMember->idStudent = $user->idUser;
        $teamMember->idTeam = $teamId;
        $teamMember->save();
        return response()->json(["message"=> "ok"], 200);
    }

    /**
     * @note izlazak iz tima
     * @param $subjectId
     * @param $teamId
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function exitTeam($code, $teamId) {
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return response()->json(["message"=> "subject not exist"], 400);
        }
        $project = $subject->projects()->sole();
        if (is_null($project)) {
            return response()->json(["message"=> "project not exist"], 400);
        }
        if ($project->hasExpired()) {
            return response()->json(["message"=> "project expired"], 400);
        }

        $user = request()->session()->get("user")["userObject"];
        $team = Team::find($teamId);

        if (is_null($team)) {
            return response()->json(["message"=> "team doesnt exist"], 409);
        }
        $idLeader = (int)$team->idLeader;
        if ($idLeader == $user->idUser) {
            Team::destroy($teamId);
            return response()->json(["message"=>"team deleted"], 200);
        }
        $mmn = (int)$team->project()->sole()->minMemberNumber;
        $members = $team->members();
        //TODO da li da brišemo kad je minMember veci od broja clanova
        // treba dogovoriti na sastanku
        if ($members->count() <= $mmn) {
            return response()->json(["message"=>"cannot exit"], 409);
        }
        $result = TeamMember::where("team_members.idStudent", "=", $user->idUser)
                ->where("team_members.idTeam", "=", $teamId)
                ->delete();
        if ($result) {
            return response()->json(["message"=>"ok"], 200);
        }
        return response()->json(["message"=>"not deleted"], 400);
    }

    /**
     * @note vraća query nekoliko spojenih tabela na koje mogu da se primene filteri
     * @return \Illuminate\Database\Query\Builder
     */
    private function getTeamsTable() {
        return DB::table('subjects')
            ->join('projects', 'subjects.idSubject', '=', 'projects.idSubject')
            ->join('teams', 'projects.idProject', '=', 'teams.idProject')
            ->join("team_members", "teams.idTeam", "=", "team_members.idTeam")
            ->select("*",
                'projects.name as projectName',
                'subjects.name as subjectName',
                'teams.name as teamName'
            );
    }
    ///student/subject/{code}/team/create
    /// /**
    /**
     * @note kreiranje tima restful POST
     * @param $code
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTeam($code, Request $request) {
        $post = $request->post();
        //TODO testirati regex
        $validator = Validator::make($post, [
            'teamname' => 'required|min:4|max:60|regex:/^[a-zA-Z0-9\s_\-]+$/'
        ]);
        if ($validator->fails()) {
            return response()->json(["message"=> "bad_input"], 400);
        }
        $subject = Subject::where("code", "=", $code)->first();
        if (is_null($subject)) {
            return response()->json(["message"=> "subject not exist"], 400);
        }
        $project = $subject->projects()->sole();
        if (is_null($project)) {
            return response()->json(["message"=> "project not exist"], 400);
        }
        if ($project->hasExpired()) {
            return response()->json(["message"=> "project expired"], 400);
        }
        $user = request()->session()->get("user")["userObject"];
        if ($this->alreadyInTeam($code, $user->idUser)) {
            return response()->json(["message"=>"already in team"], 409);
        }

        $user = request()->session()->get("user")["userObject"];
        $newTeam = new Team();
        $newTeam->name = $post["teamname"];
        $newTeam->idProject = $project->idProject;
        $newTeam->idLeader = $user->idUser;
        $newTeam->locked = false;
        $newTeam->save();
        $teamMember = new TeamMember();
        $teamMember->idStudent = $user->idUser;
        $teamMember->idTeam = $newTeam->idTeam;
        $teamMember->save();

        return response()->json(["message"=> "ok"], 200);
    }

    /**
     * @note da li je student vec u nekom timu na datom projektu
     * @param $code
     * @param $idUser
     * @return bool
     * @author zvk17
     */
    private function alreadyInTeam($code, $idUser):bool {
        $teamsTable = $this->getTeamsTable()
            ->where("team_members.idStudent", "=", $idUser)
            ->where("subjects.code", "=", $code);
        $results = $teamsTable->get();
        return $results->count() > 0;
    }



    /**
     * POST zahtev koji unosi zahtev za zamenu u bazu podataka
     * ILI radi automatsku zamenu termina (slučaj da je student odmah otišao na kreiranje zahteva,
     * preskočivši mogućnost zamene)
     *
     * Poziva se za rutu '/student/subject/{code}/lab/{idLab}/request'
     *
     * @param Request $request Request
     * POST zahtev
     * @return redirect
     *
     * - Valerijan Matvejev 2018/0257
     */
    public function submitRequest(Request $request){
        //dohvatim iz forme sve checkbox koji su checked
        $nizOdabranih=$request->get('zahtevi');

        foreach($nizOdabranih as $odabraniData){
            $myidAppointment=explode(',',$odabraniData)[0];
            $myId=explode(',',$odabraniData)[1];
            $desiredIdAppointment=explode(',',$odabraniData)[2];

            //ako vec postojim u FreeAgents, nista ne radi . Na kraju ispis ako je uspesno dodat u FreeAgent
            $myAppointment=HasAppointment::where('idStudent','=',$myId)->where('idAppointment','=',$myidAppointment)->first();

            $shouldNotExist=FreeAgent::where('idHasAppointment','=',$myAppointment->idHasAppointment)->
                    where('idDesiredAppointment','=',$desiredIdAppointment)->first();
            if($shouldNotExist!=null){
                continue;
            }

            //provera da mozda odmah uradimo swap, bez ubacivanja u FreeAgents
            //nadjemo prvog (tj najranije dodatog) Free agenta, koji zeli nas termin,

            $FGwants=FreeAgent::where('idDesiredAppointment','=',$myidAppointment)->first();

            if($FGwants!=null){
                // ALI MORA DA VAZI i da ja zelim njegov termin
                $temp=HasAppointment::where('idHasAppointment','=',$FGwants->idHasAppointment)->first();
                $takodje= ($temp->idAppointment==$desiredIdAppointment);
                if($takodje){

                    $HAwants=HasAppointment::where('idHasAppointment','=',$FGwants->idHasAppointment)->first();
                    $this->swapStudents($myidAppointment,$myId,$HAwants->idAppointment,$HAwants->idStudent);

                    return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);

                }

            }
            //samo dodamo u free agents tabelu
            $novi=new FreeAgent();
            $novi->idHasAppointment=$myAppointment->idHasAppointment;
            $novi->idDesiredAppointment=$desiredIdAppointment;
            $novi->save();
        }
        Session::put('zahtevEvidentiran',1);
        return redirect()->route('student.subject.lab.idlab.join.get', [$request->code,$request->idLab]);


    }
}
