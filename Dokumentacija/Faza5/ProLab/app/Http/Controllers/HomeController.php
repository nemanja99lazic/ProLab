<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
class HomeController extends Controller
{

    public function index(){
        return view('login');
    }
    public function testAdmin() {
        return view("admin_header");
    }

    public function getSubject($idSubject) {
        $subject = Subject::find($idSubject);
        return dd($subject);
    }


}
