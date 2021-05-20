<?php

namespace App\Http\Controllers;


use App\RegistrationRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('filterGuest');
        //$this->middleware('auth');
    }
    public function index()
    {

        return view('index'


        );
    }
    public function search(){

         //dd(RegistrationRequest::findOrFail($request));
        $requests=DB::select('select * from registration_requests');
        //dohvatanje svih
        User::all();

        //dohvatanje nekog
        $registrations=RegistrationRequest::where('username','=','pera')->get();

        //kreiranje novog
        //User::create(["username"=> $request->input('username')]);

        //ako ne prodje, baca ValidationException i vraca na prethodnu stranicu
        // u html kodu bi trebalo:
        //@if( $errors->any() )
        //@foreach($errors->all() as $error)


        //{{$error}}
        //@endif
        request()->validate([]);

        //pravljenje Rule:
        //php artisan make:rule Uppercase
        // sam rule :  05:24:00 radi lik

        //pravljenje Request:
        //php artisan make:request CreateValidationRequest
        //sam request:  05:38:00

        dd($registrations);


        //dd($request);

         //return view('vrati',compact('request'));
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
