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

        $code = '';
        foreach (explode(' ', $subjectRequest->subjectName) as $part) {
            if (is_numeric($part)) {
                $code .= $part;
            } else if (strlen($part) > 1) {
                $code .= $part[0];
            }
        }

        $subject = new Subject;
        $subject->name = $subjectRequest->subjectName;
        $subject->idTeacher = $subjectRequest->idTeacher;
        $subject->code = strtoupper($code);
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
        $idSubject = $request->idS;

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

        Subject::where('idSubject', '=', $idSubject)->delete();

        return redirect()->to(url('admin/subjects/list'));
    }

    public function subjectIndex(Request $request) {
        $idSubject = $request->idS;
        $subject = Subject::where('idSubject', '=', $idSubject)->first();
        if ($subject == null) {
            return abort(404);
        } else {
            return view('admin/admin_subject_index', ['subject' => $subject]);
        }
    }

    public function deleteTeacher(Request $request) {
        $idSubject = $request->idS;
        $idTeacher = $request->idT;

        Teaches::where('idTeacher', '=', $idTeacher)->where('idSubject', $idSubject)->delete();

        $subject = Subject::where('idSubject', '=', $idSubject)->first();
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

        return redirect()->route('admin.subject.index', [$idSubject]);
    }

    public function deleteStudent(Request $request) {
        $idSubject = $request->idS;
        $idStudent = $request->idSt;

        Attends::where('idStudent', '=', $idStudent)->where('idSubject', '=', $idSubject)->delete();

        $subject = Subject::where('idSubject', '=', $idSubject)->first();

        $labs = $subject->labExercises;

        if ($labs == null) {
            return redirect()->route('admin.subject.index', [$idSubject]);
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
            return redirect()->route('admin.subject.index', [$idSubject]);
        }

        $project = $projects[0];
        $teams = $project->teams;
        foreach ($teams as $team) {
            $teamMember = TeamMember::where('idStudent', '=', $idStudent)->where('idTeam', '=', $team->idTeam)->first();
            if ($teamMember != null) {
                $teamMember->delete();
                // provera za datum, ako je ok onda idi dalje
                // ako je ovaj student bio tim lider - proglasi drugog studenta za lidera
                // ako je ovaj student jedini u timu - izbrisi tim
                break;
            }
        }

        return redirect()->route('admin.subject.index', [$idSubject]);
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

    /**
     * Funkcija koja prikazuje pocetnu stranicu za prikaz laboratorijskih vezbi.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function labExercisesIndex(Request $request) {
        $idSubject = $request->idS;
        $labs = LabExercise::where('idSubject', '=', $idSubject)->get();
        return view('admin/admin_lab_list', ['labs' => $labs]);
    }

    public function showLabExercise(Request $request) {
        $idSubject = $request->idS;
        $idLab = $request->idL;

        $lab = LabExercise::where('idLabExercise', '=', $idLab)->where('idSubject', '=', $idSubject)->first();
        if ($lab == null) {
            return abort(404);
        }

        return view('admin/admin_lab_list', ['lab' => $lab]);
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

