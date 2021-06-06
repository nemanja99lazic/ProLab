<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Http\Controllers;

use App\Appointment;
use App\Attends;
use App\FreeAgent;
use App\HasAppointment;
use App\LabExercise;
use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\Project;
use App\RegistrationRequest;
use App\Subject;
use App\SubjectJoinRequest;
use App\Teaches;
use App\Team;
use App\TeamMember;
use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Teacher;
use App\Administrator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * AdminController - klasa koja implemenitra logiku funckionalnosti za tip korisnika admin.
 *
 * @version 1.0
 */
class AdminController extends Controller {
    /**
     * Kreiranje nove instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('adminMiddleware');
    }

    /**
     * Fukcija koja dohvata iz baze sve zahteve za registracijom koji nisu jos uvek obradjeni i poziva
     * pogled koji te zahteve prikazuje adminu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerRequests() {
        $requests = RegistrationRequest::all();
        return view('admin/admin_register_requests', ['regRequests' => $requests]);
    }

    /**
     * Funckija koja dohvata iz baze sve zahteve za kreiranje novih predmeta koji jos uvek nisu obradjeni
     * i poziva pogled koji te zahteve prikazuje adminu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function newSubjectRequests() {
        $requests = NewSubjectRequest::all();
        return view('admin/admin_subject_requests', ['newSubjectRequests' => $requests]);
    }

    /**
     * Funkcija koja odjavljuje prijavljenog korisnika sa sistema i redirektuje ga na login stranicu.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    /**
     * Funkcija koja dodaje u bazu novog korisnika, ciji zahtev za registraciju je prihvacen od strane
     * admina.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addUser(Request $request) {
        $regReq = RegistrationRequest::where('email', '=', $request->get('email'))->first();

        $user = new User;
        $user->forename = explode(',', $regReq->username)[1];
        $user->surname = explode(',', $regReq->username)[2];
        $user->email = $regReq->email;
        $user->username = explode(',', $regReq->username)[0];
        $user->password = $regReq->password;
        $user->save();

        $user = User::where('username', '=', explode(',', $regReq->username)[0])->first();
        $newUser = null;

        if ($regReq->userType == 's') {
            $newUser = new Student;
            $newUser->idStudent = $user->idUser;
            $newUser->index = $this->getIndexFromEmail($user->email);
        } elseif ($regReq->userType == 't') {
            $newUser = new Teacher;
            $newUser->idTeacher = $user->idUser;
        } else {
            $newUser = new Administrator;
            $newUser->idAdministrator = $user->idUser;
        }
        $newUser->save();

        $regReq->delete();
        // RegistrationRequest::truncate();

        return redirect()->to(url('admin'));
    }

    /**
     * Funkcija koja brise iz baze zahtev za registracijom.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRegisterRequest(Request $request) {
        $regReq = RegistrationRequest::where('email', '=', $request['email']);
        $regReq->delete();
        // RegistrationRequest::truncate();
        return redirect()->to(url('admin'));
    }

    /**
     * Funkcija koja dodaje novi predmet u bazu, nakon prihvatanja zahteva za kreiranje
     * predmeta od strane admina.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSubject(Request $request) {
        $idRequest = $request->get('idRequest');
        $subjectRequest = NewSubjectRequest::where('idRequest', '=', $idRequest)->first();

        $subject = new Subject;
        $subject->name = explode('_', $subjectRequest->subjectName)[0];
        $subject->idTeacher = $subjectRequest->idTeacher;
        $subject->code = explode('_', $subjectRequest->subjectName)[1];;
        $subject->save();

        $teachers = $subjectRequest->teachers;

        foreach ($teachers as $teacher) {
            $teach = new Teaches;
            $teach->idTeacher = $teacher->idTeacher;
            $teach->idSubject = $subject->idSubject;
            $teach->save();
        }

        NewSubjectRequestTeaches::where('idRequest', '=', $idRequest)->delete();
        $subjectRequest->delete();

        return redirect()->to(url('admin/requests/newSubjects'));
    }

    /**
     * Funkcija koja brise iz baze zahtev za kreiranje novog predmeta.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSubjectRequest(Request $request) {
        $idRequest = $request->get('idRequest');

        NewSubjectRequestTeaches::where('idRequest', '=', $idRequest)->delete();
        NewSubjectRequest::where('idRequest', '=', $idRequest)->delete();

        return redirect()->to(url('admin/requests/newSubjects'));
    }


    /**
     * Funkcija koja poziva pogled za prikaz svih predmeta koji postoje u sistemu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function subjectList() {
        $subjects = Subject::all();
        return view('/admin/admin_subjects_list', ['subjects' => $subjects]);
    }

    /**
     * Funkcija koja brise odredjeni predmet (ukljucujuci i sve entitete sa kojima je u vezi dati predmet).
     *
     * @param Request $request
     * @return void
     */
    public function deleteSubject(Request $request) {
        $subjectCode = $request->subjectCode;
        $this->deleteSubjectHelper($subjectCode);
        return redirect()->to(url('admin/subjects/list'));
    }

    /**
     * Funkcija koja poziva pogled za prikaz pocetne stranice predmeta.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function subjectIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        } else {
            return view('admin/admin_subject_index', ['subject' => $subject]);
        }
    }

    /**
     * Funkcija koja brise datog profesora sa datog predmeta i ukoliko je on jedini ostao na predmetu
     * od profesora u tom slucaju ce biti i ceo predmet obrisan iz sistema, a ako to nije slucaj, ali je dati
     * profesor kreirao dati predmet onda ce se neki drugi profesor od preostalih proglasiti za kreatora.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTeacherFromSubject(Request $request) {
        $idTeacher = $request->idT;
        $subjectCode = $request->subjectCode;

        $subjectDeleted = $this->deleteTeacherFromSubjectHelper($idTeacher, $subjectCode);

        if ($subjectDeleted) {
            return redirect()->to(url('admin/subjects/list'));
        } else {
            return redirect()->route('admin.subject.index', [$subjectCode]);
        }
    }

    /**
     * Funkcija koja brise datog studenta sa datog predmeta, ukljucujuci i izbacivanje sa svih aktivnosti
     * na kojima je bio.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function deleteStudentFromSubject(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;
        $idStudent = $request->idSt;

        Attends::where('idStudent', '=', $idStudent)->where('idSubject', '=', $idSubject)->delete();

        // $subject = Subject::where('idSubject', '=', $idSubject)->first();

        $labs = $subject->labExercises;

        if (count($labs) == 0) {
            return redirect()->route('admin.subject.index', [$subjectCode]);
        }

        foreach ($labs as $lab) {
            $appointments = $lab->appointments;
            if (count($appointments) == 0) {
                continue;
            }
            foreach ($appointments as $appointment) {
                $hasApp = HasAppointment::where('idStudent', '=', $idStudent)->where('idAppointment', '=', $appointment->idAppointment)->first();
                if ($hasApp != null) {
                    FreeAgent::where('idHasAppointment', '=', $hasApp->idHasAppointment)->delete();
                    $hasApp->delete();
                    $this->swapStudents($appointment->idAppointment);
                    break;
                }
            }
        }

        $projects = $subject->projects;
        if (count($projects) == 0) {
            return redirect()->route('admin.subject.index', [$subjectCode]);
        }

        $project = $projects[0];
        $teams = $project->teams;
        foreach ($teams as $team) {
            $teamMember = TeamMember::where('idStudent', '=', $idStudent)->where('idTeam', '=', $team->idTeam)->first();
            if ($teamMember != null) {
                if ($team->idLeader == $idStudent || count($team->students) == 1) {
                    TeamMember::where('idTeam', '=', $team->idTeam)->delete();
                    $team->delete();
                } else {
                    $teamMember->delete();
                }
                break;
            }
        }

        return redirect()->route('admin.subject.index', [$subjectCode]);
    }

    /**
     * Funkcija koja dodeljuje slobodan termin nekom od studenata koji zele kao zamenu dati termin ciji
     * id je prosledjen kao parametar.
     *
     * @param int $idFreeAppointment
     * @return void
     */
    protected function swapStudents($idFreeAppointment) {
        $app = Appointment::where('idAppointment', '=', $idFreeAppointment)->first();
        $deadline = Carbon::parse($app->datetime);
        if ($deadline->isPast()) {
            return;
        }

        $freeAgent = FreeAgent::where('idDesiredAppointment', '=', $idFreeAppointment)->first();
        if ($freeAgent == null) {
            return;
        }
        $idHasApp = $freeAgent->idHasAppointment;
        FreeAgent::where('idHasAppointment', '=', $idHasApp)->delete();

        $hasApp = HasAppointment::where('idHasAppointment', '=', $idHasApp)->first();
        $newFreeAppointment = $hasApp->idAppointment;
        $hasApp->idAppointment = $idFreeAppointment;
        $hasApp->save();

        $this->swapStudents($newFreeAppointment);
    }

    /**
     * Funkcija koja poziva progled za prikaz pocetne stranice datog projekta na odredjenom predmetu.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function projectIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $project = Subject::where('code', '=', $subjectCode)->first()->projects;
        if (count($project) == 0) {
            return view('admin/admin_project_index');
        }
        return view('admin/admin_project_index', ['project' => $project[0], 'teams' => $project[0]->teams]);
    }

    /**
     * Funckija koja brise odredjeni tim sa odredjenog projekta.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTeam(Request $request) {
        $idTeam = $request->idTeam;
        $this->deleteTeamHelper($request, $idTeam);
        return redirect()->route('admin.subject.project.index', $request->subjectCode);
    }

    /**
     * Funcija koja brise projekat sa datog predmeta.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function deleteProject(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $project = $subject->projects;
        $teams = $project[0]->teams;
        foreach ($teams as $team) {
            $this->deleteTeamHelper($request, $team->idTeam);
        }
        $project[0]->delete();
        return redirect()->route('admin.subject.project.index', $request->subjectCode);
    }

    /**
     * Funkcija koja prikazuje pocetnu stranicu za prikaz laboratorijskih vezbi.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function labExercisesIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;

        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['labs' => $labs]);
    }

    /**
     * Funckija koja prikazuje pocetnu stranicu odredjne laboratorijske vezbe na nekom predmetu.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function labExerciseIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;
        $idLab = $request->input('labs_list');
        $lab = LabExercise::where('idLabExercise', '=', $idLab)->where('idSubject', '=', $idSubject)->first();
        if ($lab == null) {
            return abort(404);
        }

        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['idLab' => $idLab,'labs' => $labs, 'lab' => $lab]);
    }

    /**
     * Funkcija koja brise odredjeni termin sa odredjene laboratorijske vezbe na nekom predmetu.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleteAppointment(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;
        $idLab = $request->input('labs_list');

        $idAppointment = $request->idApp;

        $this->deleteAppointmentHelper($request, $idAppointment);

        $lab = LabExercise::where('idLabExercise', '=', $idLab)->where('idSubject', '=', $idSubject)->first();
        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['idLab' => $idLab, 'labs' => $labs, 'lab' => $lab]);
    }

    /**
     * Funckcija koja brise odredjenu laboratorijsku vezbu sa nekog predmeta.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function labExerciseDelete(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;

        $idLab = $request->input('labs_list');

        $lab = LabExercise::where('idLabExercise', '=', $idLab)->first();
        if ($lab == null) {
            return abort(404);
        }
        $apps = $lab->appointments;

        foreach ($apps as $app) {
            $this->deleteAppointmentHelper($request, $app->idAppointment);
        }

        $lab->delete();

        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['labs' => $labs]);
    }

    protected function deleteTeamHelper(Request $request, $idTeam) {
        TeamMember::where('idTeam', '=', $idTeam)->delete();
        Team::where('idTeam', '=', $idTeam)->delete();
    }

    /**
     * Pomocna funkcija koja brise odredjeni termin na nekoj laboratorijskoj vezbi odredjenog predmeta.
     *
     * @param Request $request
     * @param int $idAppointment
     * @return void
     */
    protected function deleteAppointmentHelper(Request $request, $idAppointment) {
        $app = Appointment::where('idAppointment', '=', $idAppointment)->first();
        if ($app == null) {
            return;
        }
        $hasApps = $app->hasAppointments;

        foreach ($hasApps as $hasApp) {
            FreeAgent::where('idHasAppointment', '=', $hasApp->idHasAppointment)->delete();
            $hasApp->delete();
        }
        FreeAgent::where('idDesiredAppointment', '=', $idAppointment)->delete();
        return $app->delete();
    }

    /**
     * Funkcija koja poziva pogled za prikaz stranice za pretragu korisnika.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchUsers(Request $request) {
        $request->session()->forget('searchInput');
        return view('admin/admin_users_search');
    }

    /**
     * Funckija koja nalazi sve korisnike cije ime i prezime se uparuje sa unetim
     * tekstom za pretragu i nakon toga poziva pogled za prikaz nadjenih korisnika.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchUsersResults(Request $request) {
        $searchInput = $request->get('search-input');
        $request->session()->put('searchInput', $searchInput);
        $userType = $request->input('search');

        $users = [];

        $usersResult = User::where('forename', 'LIKE', '%'.$searchInput.'%')
            ->orWhere('surname', 'LIKE', '%'.$searchInput.'%')
            ->orWhere('username', 'LIKE', '%'.$searchInput.'%')->get();

        foreach ($usersResult as $user) {
            if ($userType == 'teacher' && !is_null($user->teacher)) {
                $users[] = $user->teacher;
            } else if ($userType == 'student' && !is_null($user->student)) {
                $users[] = $user->student;
            } else if($userType == 'admin' && !is_null($user->administrator) && $request->session()->get('user')['userObject']->idUser != $user->idUser) {
                $users[] = $user->administrator;
            }
        }

        if ($userType == 'teacher') {
            return view('admin/admin_users_search',
                ['teachers' => $users]);
        } else if ($userType == 'student') {
            return view('admin/admin_users_search',
                ['students' => $users]);
        } else {
            return view('admin/admin_users_search',
                ['admins' => $users]);
        }
    }

    /**
     * Funckija koja brise datog studenta iz sistema (ukljucujuci i sve entitete sa kojima je bio u vezi
     * dati student).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteStudentFromSystem(Request $request) {
        $idStudent = $request->idS;

        SubjectJoinRequest::where('idStudent', '=', $idStudent)->delete();

        $hasApps = HasAppointment::where('idStudent', '=', $idStudent)->get();
        if ($hasApps == null) {
            return abort(404);
        }
        foreach ($hasApps as $hasApp) {
            $idAppointment = $hasApp->idAppointment;
            if ($hasApp != null) {
                FreeAgent::where('idHasAppointment', '=', $hasApp->idHasAppointment)->delete();
                $hasApp->delete();
                $this->swapStudents($idAppointment);
                break;
            }
        }

        Attends::where('idStudent', '=', $idStudent)->delete();

        $teamMembers = TeamMember::where('idStudent', '=', $idStudent)->get();
        if ($teamMembers == null) {
            return abort(404);
        }
        foreach ($teamMembers as $teamMember) {
            $team = $teamMember->team;
            if ($team->idLeader == $idStudent || count($team->students) == 1) {
                TeamMember::where('idTeam', '=', $team->idTeam)->delete();
                $team->delete();
            } else {
                $teamMember->delete();
            }
        }

        Student::where('idStudent', '=', $idStudent)->delete();
        User::where('idUser', '=', $idStudent)->delete();

        return response()->json(array('message' => 'ok'));
    }

    /**
     * Funckija koja brise datog profesora iz sistema (ukljucujuci i sve entitete sa kojima je bio u vezi
     * dati profesor).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTeacherFromSystem(Request $request) {
        $idTeacher = $request->idT;
        NewSubjectRequestTeaches::where('idTeacher', '=', $idTeacher)->delete();
        $requests = NewSubjectRequest::where('idTeacher', '=', $idTeacher)->get();

        foreach ($requests as $req) {
            NewSubjectRequestTeaches::where('idRequest', '=', $req->idRequest)->delete();
            $req->delete();
        }

        $subjectTeaches = Teaches::where('idTeacher', '=', $idTeacher)->get();
        foreach ($subjectTeaches as $subjectTeach) {
            $this->deleteTeacherFromSubjectHelper($idTeacher, $subjectTeach->subject->code);
        }

        Teacher::where('idTeacher', '=', $idTeacher)->delete();
        User::where('idUser', '=', $idTeacher)->delete();

        return response()->json(array('message' => 'ok'));
    }

    /**
     * Pomocna funkcija koja brise profesora sa datog predmeta (ukljucjuci i sve entitete za koje je
     * vezan dati profesora).
     *
     * @param int $idTeacher
     * @param string $subjectCode
     * @return bool
     */
    protected function deleteTeacherFromSubjectHelper($idTeacher, $subjectCode) {
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;

        Teaches::where('idTeacher', '=', $idTeacher)->where('idSubject', $idSubject)->delete();

        if ($subject->idTeacher == $idTeacher) {
            $teaches = Teaches::where('idSubject', $idSubject)->first();
            if ($teaches != null) {
                $subject->idTeacher = $teaches->teacher->idTeacher;
                $subject->save();
                return False;
            } else {
                //return redirect()->route('admin.delete.subject', [$idSubject]);
                // return $this->deleteSubject($request);
                $this->deleteSubjectHelper($subjectCode);
                return True;
            }
        }

        return False;

        // return redirect()->route('admin.subject.index', [$subjectCode]);
    }

    /**
     * Pomocna funckija koja brise dati predmet iz sistema (ukljucjuci i sve entitete vezane za dati
     * predmet).
     *
     * @param string $subjectCode
     * @return mixed
     */
    protected function deleteSubjectHelper($subjectCode) {
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        }
        $idSubject = $subject->idSubject;

        Attends::where('idSubject', '=', $idSubject)->delete();
        SubjectJoinRequest::where('idSubject', '=', $idSubject)->delete();
        Teaches::where('idSubject', '=', $idSubject)->delete();

        $projects = Project::where('idSubject', '=', $idSubject)->get();
        if ($projects == null) {
            return abort(404);
        }
        foreach ($projects as $project) {
            $teams = Team::where('idProject', '=', $project->idProject)->get();
            if ($projects == null) {
                continue;
            }
            foreach ($teams as $team) {
                TeamMember::where('idTeam', '=', $team->idTeam)->delete();
                $team->delete();
            }
            $project->delete();
        }

        $labExercises = LabExercise::where('idSubject', '=', $idSubject)->get();

        if ($labExercises == null) {
            return abort(404);
        }

        foreach ($labExercises as $labExercise) {
            $appointments = Appointment::where('idLabExercise', '=', $labExercise->idLabExercise)->get();
            if ($appointments == null) {
                continue;
            }
            foreach ($appointments as $appointment) {
                $hasAppointments = HasAppointment::where('idAppointment', '=', $appointment->idAppointment)->get();
                if ($hasAppointments == null) {
                    continue;
                }
                foreach ($hasAppointments as $hasAppointment) {
                    FreeAgent::where('idHasAppointment', '=', $hasAppointment->idHasAppointment)->delete();
                    $hasAppointment->delete();
                }

                FreeAgent::where('idDesiredAppointment', '=', $appointment->idAppointment)->delete();

                $appointment->delete();
            }

            $labExercise->delete();
        }

        // Subject::where('idSubject', '=', $idSubject)->delete();
        return $subject->delete();

        // return redirect()->to(url('admin/subjects/list'));
    }

    /**
     * Funkcija koja trajno brise iz sistema korisnika tipa admin.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAdminFromSystem(Request $request) {
        $idAdministrator = $request->idA;

        Administrator::where('idAdministrator', '=', $idAdministrator)->delete();
        User::where('idUser', '=', $idAdministrator)->delete();

        return response()->json(array('message' => 'ok'));
    }

    /**
     * Pomocna funkcija koja na osnovu email adrese
     * studenta vraca string reprezentaciju indeksa studenta (gggg/bbbb).
     *
     * @param string $email
     * @return string
     */
    protected function getIndexFromEmail($email) {
        $year = "20".substr($email, 2, 2);
        $number = substr($email, 4, 4);
        return $year."/".$number;
    }
}

