<?php

namespace App\Http\Controllers;

use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\RegistrationRequest;
use App\Subject;
use App\Teaches;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Teacher;
use App\Administrator;

class AdminController extends Controller {
    public function __construct() {
        $this->middleware('adminMiddleware');
    }

    public function registerRequests() {
        $requests = RegistrationRequest::all();
        return view('admin/admin_register_requests', ['regRequests' => $requests]);
    }

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

    protected function getIndexFromEmail($email) {
        $year = "20".substr($email, 2, 2);
        $number = substr($email, 4, 4);
        return $year."/".$number;
    }
}
