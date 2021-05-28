<?php

/**
 * Autor: Slobodan Katanic 2018/0133
 */

namespace App\Http\Controllers;

use App\Attends;
use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\RegistrationRequest;
use App\Subject;
use App\SubjectJoinRequest;
use App\Teaches;
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
        $idSubject = $request->id;

        Attends::where('idSubject', '=', $idSubject)->delete();
        SubjectJoinRequest::where('idSubject', '=', $idSubject)->delete();

        Subject::where('idSubject', '=', $idSubject)->delete();

        return redirect()->to(url('admin/subjects/list'));
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
