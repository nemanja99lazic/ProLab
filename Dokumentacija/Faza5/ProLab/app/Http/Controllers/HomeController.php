<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
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

            //$subjects = $user->teacher()->subjectss();
            return view("teacher_subject_list");
        } else {
            return redirect()->to(url("/"));
        }
        /*foreach ($user as $key => $value)
            $str .= $key;
        }*/

        return strval($u);
    }


}
