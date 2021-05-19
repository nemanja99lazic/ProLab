<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {

        return view('index'


        );
    }
    public function asd(){

        $this->validate(request(), [

            'username'=>'required',
            'password'=>'required',

        ]);
        $data=request()->all();

        return request()->get('username');
    }
}
