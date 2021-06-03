<?php

/**
 * Autor: Slobodan Katanic 2018/0133
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
use GuzzleHttp\HandlerStack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Teacher;
use App\Administrator;

/**
 * AdminController - klasa koja implemenitra logiku funckionalnosti za tip korisnika admin.
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
     * Fukcija koja dohvata iz baze sve zahteve za registracijom koji nisu jos uvek obadjeni i poziva
     * pogled koji te zahteve prikazuje adminu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerRequests() {
        $requests = RegistrationRequest::all();
        return view('admin/admin_register_requests', ['regRequests' => $requests]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function newSubjectRequests() {
        $requests = NewSubjectRequest::all();
        return view('admin/admin_subject_requests', ['newSubjectRequests' => $requests]);
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

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

    public function deleteRegisterRequest(Request $request) {
        $regReq = RegistrationRequest::where('email', '=', $request['email']);
        $regReq->delete();
        // RegistrationRequest::truncate();
        return redirect()->to(url('admin'));
    }

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

    public function deleteSubjectRequest(Request $request) {
        $idRequest = $request->get('idRequest');

        NewSubjectRequestTeaches::where('idRequest', '=', $idRequest)->delete();
        NewSubjectRequest::where('idRequest', '=', $idRequest)->delete();

        return redirect()->to(url('admin/requests/newSubjects'));
    }

    public function subjectList() {
        $subjects = Subject::all();
        return view('/admin/admin_subjects_list', ['subjects' => $subjects]);
    }

    /**
     * Funkcija koja brise odredjeni predmet (ukljucujuci i sve entiteta sa kojima je u vezi dati predmet).
     *
     * @param Request $request
     *
     * @return void
     */
    public function deleteSubject(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;

        Attends::where('idSubject', '=', $idSubject)->delete();
        SubjectJoinRequest::where('idSubject', '=', $idSubject)->delete();
        Teaches::where('idSubject', '=', $idSubject)->delete();

        $projects = Project::where('idSubject', '=', $idSubject)->get();

        foreach ($projects as $project) {
            $teams = Team::where('idProject', '=', $project->idProject)->get();

            foreach ($teams as $team) {
                TeamMember::where('idTeam', '=', $team->idTeam)->delete();
                $team->delete();
            }

            $project->delete();
        }

        $labExercises = LabExercise::where('idSubject', '=', $idSubject)->get();

        foreach ($labExercises as $labExercise) {
            $appointments = Appointment::where('idLabExercise', '=', $labExercise->idLabExercise)->get();

            foreach ($appointments as $appointment) {
                $hasAppointments = HasAppointment::where('idAppointment', '=', $appointment->idAppointment)->get();

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
        $subject->delete();

        return redirect()->to(url('admin/subjects/list'));
    }

    public function subjectIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        if ($subject == null) {
            return abort(404);
        } else {
            return view('admin/admin_subject_index', ['subject' => $subject]);
        }
    }

    public function deleteTeacherFromSubject(Request $request) {
        $idTeacher = $request->idT;
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;

        Teaches::where('idTeacher', '=', $idTeacher)->where('idSubject', $idSubject)->delete();

        if ($subject->idTeacher == $idTeacher) {
            $teaches = Teaches::where('idSubject', $idSubject)->first();
            if ($teaches != null) {
                $subject->idTeacher = $teaches->teacher->idTeacher;
                $subject->save();
            } else {
                //return redirect()->route('admin.delete.subject', [$idSubject]);
                return $this->deleteSubject($request);
            }
        }

        return redirect()->route('admin.subject.index', [$subjectCode]);
    }

    public function deleteStudentFromSubject(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;
        $idStudent = $request->idSt;

        Attends::where('idStudent', '=', $idStudent)->where('idSubject', '=', $idSubject)->delete();

        // $subject = Subject::where('idSubject', '=', $idSubject)->first();

        $labs = $subject->labExercises;

        if ($labs == null) {
            return redirect()->route('admin.subject.index', [$subjectCode]);
        }

        foreach ($labs as $lab) {
            $appointments = $lab->appointments;
            if ($appointments == null) {
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
        if ($projects == null) {
            return redirect()->route('admin.subject.index', [$subjectCode]);
        }

        $project = $projects[0];
        $teams = $project->teams;
        foreach ($teams as $team) {
            $teamMember = TeamMember::where('idStudent', '=', $idStudent)->where('idTeam', '=', $team->idTeam)->first();
            if ($teamMember != null) {
                // provera za datum, ako je ok onda idi dalje
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

    protected function swapStudents($idFreeAppointment) {
        // dodaj if za datum

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

    public function projectIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $project = Subject::where('code', '=', $subjectCode)->first()->projects;
        if (count($project) == 0) {
            return view('admin/admin_project_index');
        }
        return view('admin/admin_project_index', ['project' => $project[0], 'teams' => $project[0]->teams]);
    }

    public function deleteTeam(Request $request) {
        $idTeam = $request->idTeam;
        $this->deleteTeamHelper($request, $idTeam);
        return redirect()->route('admin.subject.project.index', $request->subjectCode);
    }

    public  function deleteProject(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', $subjectCode)->first();
        $project = $subject->projects;
        $teams = $project[0]->teams;
        foreach ($teams as $team) {
            $this->deleteTeamHelper($request, $team->idTeam);
        }
        return redirect()->route('admin.subject.project.index', $request->subjectCode);
    }

    /**
     * Funkcija koja prikazuje pocetnu stranicu za prikaz laboratorijskih vezbi.
     *
     * @param Request $request
     *
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

    public function labExerciseIndex(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;
        // $idLab = $request->idL;
        $idLab = $request->input('labs_list');
        $lab = LabExercise::where('idLabExercise', '=', $idLab)->where('idSubject', '=', $idSubject)->first();
        if ($lab == null) {
            return abort(404);
        }

        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['idLab' => $idLab,'labs' => $labs, 'lab' => $lab]);
    }

    public function deleteAppointment(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;
        $idLab = $request->input('labs_list');

        $idAppointment = $request->idApp;

        $this->deleteAppointmentHelper($request, $idAppointment);

        $lab = LabExercise::where('idLabExercise', '=', $idLab)->where('idSubject', '=', $idSubject)->first();
        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['idLab' => $idLab,'labs' => $labs, 'lab' => $lab]);
    }

    public function labExerciseDelete(Request $request) {
        $subjectCode = $request->subjectCode;
        $subject = Subject::where('code', '=', $subjectCode)->first();
        $idSubject = $subject->idSubject;

        $idLab = $request->input('labs_list');

        $lab = LabExercise::where('idLabExercise', '=', $idLab)->first();
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

    public function searchUsers() {
        return view('admin/admin_users_search');
    }

    public function searchUsersResults(Request $request) {
        $searchInput = $request->get('search-input');
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
            } else if($userType == 'admin' && !is_null($user->admin) && $request->session()->get('user')['userObject']->idUser != $user->idUser) {
                $users[] = $user->admin;
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

    public function deleteStudentFromSystem(Request $request) {
        $idStudent = $request->idS;

        Student::where('idStudent', '=', $idStudent)->delete();
        User::where('idUser', '=', $idStudent)->delete();

        return response()->json(array('message' => 'ok'));
    }

    /**
     * Pomocna funkcija koja na osnovu email adrese
     * studenta vraca string reprezentaciju indeksa studenta (gggg/bbbb).
     *
     * @param string $email
     *
     * @return string
     */
    protected function getIndexFromEmail($email) {
        $year = "20".substr($email, 2, 2);
        $number = substr($email, 4, 4);
        return $year."/".$number;
    }
}

