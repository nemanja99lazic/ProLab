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
use function PHPUnit\Framework\isNull;

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
    public function createTeam($code, Request $request) {
        $post = $request->post();

        $validator = Validator::make($post, [
            'teamname' => 'required|min:4|max:60|alpha_dash'
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

    private function alreadyInTeam($code, $idUser):bool {
        $teamsTable = $this->getTeamsTable()
            ->where("team_members.idStudent", "=", $idUser)
            ->where("subjects.code", "=", $code);
        $results = $teamsTable->get();
        return $results->count() > 0;
    }



}
