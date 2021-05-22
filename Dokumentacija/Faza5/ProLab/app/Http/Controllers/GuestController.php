<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\RegistrationRequest;
use App\Rules\EmailCheck;
use App\Rules\PasswordCheck;
use App\Rules\UsernameCheck;
use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('guestMiddleware');
        //$this->middleware('auth');
    }

    protected function getUserType($email) {
        if (preg_match("/@student/", $email)) {
            return 'student';
        } else if (preg_match("/@admin/", $email)) {
            return 'admin';
        } else {
            return 'profesor';
        }
    }

    public function loginGet(Request &$request) {
        return view('login');
    }

    public function loginPost(Request &$request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', '=', $request->get('username'))->first();
        if ($user == null) {
            return redirect()->to(url('/'))->withInput()->with('errorUsername', 'Wrong username');
        }

        $user = User::where('password', '=', $request->get('password'))->first();
        if ($user == null) {
            return redirect()->to(url('/'))->withInput()->with('errorPassword', 'Wrong password');
        }

        $userType = $this->getUserType($user->email);
        $request->session()->put('user', ['userObject' => $user, 'userType' => $userType]);

        return redirect()->to(url("$userType"));
    }

    public function registerGet() {
        return view('register');
    }

    public function registerPost(Request $request) {
        $userType = $request->get('usertype');

        $request->validate([
            'firstname' => 'alpha',
            'lastname' => 'alpha',
            'username' => [new UsernameCheck()],
            'password' => [new PasswordCheck()],
            'email' => [new EmailCheck($userType)]
        ]);

        $user = User::where('username', '=', $request->get('username'))->first();
        $regUser = RegistrationRequest::where('username', 'like', $request->get('username').",%")->first();
        if ($user != null || $regUser != null) {
            return redirect()->to(url('register'))->withInput()->with('errorUsername', 'Username already exists.');
        }

        $user = User::where('email', '=', $request->get('email'))->first();
        $regUser = RegistrationRequest::where('email', '=', $request->get('email'))->first();
        if ($user != null || $regUser != null) {
            return redirect()->to(url('register'))->withInput()->with('errorEmail', 'Email address has already been taken.');
        }

        $reqistrationRequest = new RegistrationRequest;
        $reqistrationRequest->userType = substr($userType, 0, 1);
        $reqistrationRequest->email = $request->get('email');
        $reqistrationRequest->password = $request->get('password');
        $reqistrationRequest->username = $request->get('username').",".$request->get('firstname').",".$request->get('lastname');

        $reqistrationRequest->save();

        $request->session()->put('register_request', 'ok');
        return redirect()->to(url("register_info"));
    }

    public function registerInfo(Request $request) {
        $request->session()->forget('register_request');
        return view('register_info');
    }

//    public function index()
//    {
//
//        return view('index'
//
//
//        );
//    }
//    public function search(){
//
//         //dd(RegistrationRequest::findOrFail($request));
//        $requests=DB::select('select * from registration_requests');
//        //dohvatanje svih
//        User::all();
//
//        //dohvatanje nekog
//        $registrations=RegistrationRequest::where('username','=','pera')->get();
//
//        //kreiranje novog
//        //User::create(["username"=> $request->input('username')]);
//
//        //ako ne prodje, baca ValidationException i vraca na prethodnu stranicu
//        // u html kodu bi trebalo:
//        //@if( $errors->any() )
//        //@foreach($errors->all() as $error)
//
//
//        //{{$error}}
//        //@endif
//        request()->validate([]);
//
//        //pravljenje Rule:
//        //php artisan make:rule Uppercase
//        // sam rule :  05:24:00 radi lik
//
//        //pravljenje Request:
//        //php artisan make:request CreateValidationRequest
//        //sam request:  05:38:00
//
//        dd($registrations);
//
//
//        //dd($request);
//
//         //return view('vrati',compact('request'));
//    }
//    public function asd(){
//
//
//        $this->validate(request(), [
//
//            'username'=>'required',
//            'password'=>'required',
//
//        ]);
//        $data=request()->all();
//
//        return request()->get('username');
//    }
}
