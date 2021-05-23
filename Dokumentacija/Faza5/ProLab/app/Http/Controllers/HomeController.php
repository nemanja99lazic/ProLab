<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
        return view('login');
    }
    public function testAdmin() {
        return view("admin_header");
    }

}
