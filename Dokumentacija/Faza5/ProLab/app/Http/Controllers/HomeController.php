<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Teacher;
use Illuminate\View\View;
class HomeController extends Controller
{

    public function index(){
        return view('login');
    }
    public function testAdmin() {
        return view("admin_header");
    }
    public function getSubjects(Request $request){
        $userData = $request->session()->get("user");
        if (is_array($userData)) {
            $userType = $userData["userType"];
            $user = $userData["userObject"];
            $teacher = $user->teacher()->sole();
            $subjects = $teacher->subjects()->getResults();
            $list = [];
            foreach ($subjects as $subject)
                $list[] = $subject;

            $teaches = $teacher->teachesSubjects()->getResults();
            foreach ($teaches as $teach) {
                //$sub = $teaches->subject()->sole();
                $list[] = $teach;
            }
            return view("teacher_subject_list", ["subjectList" => $list]);

            return dd($list);
        } else {
            return redirect()->to(url("/"));
        }
        /*foreach ($user as $key => $value)
            $str .= $key;
        }*/

        return strval($u);
    }
    public function getSubject($idSubject) {
        $subject = Subject::find($idSubject);
        return dd($subject);
    }


}
