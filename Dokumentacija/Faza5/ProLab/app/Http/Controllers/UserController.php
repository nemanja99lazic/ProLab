<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*
 *  svi korisnici se izvode iz UserControlera
 * svi imaju isti logout
 *
 * */
class UserController extends Controller {
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    public function index() {
        return view('index');
    }
}
