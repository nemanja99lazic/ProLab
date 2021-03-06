<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Http\Controllers;

use App\Administrator;
use App\RegistrationRequest;
use App\Rules\EmailCheck;
use App\Rules\PasswordCheck;
use App\Rules\UsernameCheck;
use App\Student;
use App\Subject;
use App\Teacher;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * session()->get("user") vraća asocijativni niz
 * userType čuva tip korisnika
 * userObject čuva objekat korisnika
 **/

/**
 * GuestController - klasa koja implementira funckcionalnosti za goste sistema (logovanje i registracija).
 *
 * @version 1.0
 */
class GuestController extends Controller
{
    /**
     * Kreiranje nove instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guestMiddleware');
        //$this->middleware('auth');
    }

    /**
     * Pomocna funkcija koja odredjuje tip korsinika na osnovu objekta tipa User.
     *
     * @param User $user
     * @return string
     */
    protected function getUserType($user) {
        if (!is_null($user->student()->getResults())) {
            return "student";
        }
        if (!is_null($user->administrator()->getResults())) {
            return "admin";
        }
        return "teacher";
       }

    /**
     * Funkcija koja poziva pogled za prikaz forme za login korisnika.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginGet(Request &$request) {
        return view('login');
    }

    /**
     * Funckija koja obradjuje POST zahtev za logovanje korisnika (vodi korinika na njegovu pocetnu
     * stranicu ili javlja gresku da uneti podaci nisu ispravni).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost(Request &$request) {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $customMessages = [
            'required' => 'Polje je obavezno'
        ];

        $this->validate($request, $rules, $customMessages);

//        $request->validate([
//            'username' => 'required',
//            'password' => 'required'
//        ]);

        $user = User::where('username', '=', $request->get('username'))->first();

        if ($user == null) {
            return redirect()->to(url('/'))->withInput()->with('errorUsername', 'Pogrešno korisničko ime');
        } else {
            if ($user->password != $request->get('password')) {
                return redirect()->to(url('/'))->withInput()->with('errorPassword', 'Pogrešna lozinka');
            }
        }

//        $user = User::where('password', '=', $request->get('password'))->first();
//        if ($user == null) {
//            return redirect()->to(url('/'))->withInput()->with('errorPassword', 'Wrong password');
//        }

        $userType = $this->getUserType($user);

        // $userType = $this->getUserType($user->email);

        $request->session()->put('user', ['userObject' => $user, 'userType' => $userType]);

        return redirect()->to(url("$userType"));
    }

    /**
     * Funckija koja poziva pogled za prikaz forme za registraciju korisnika.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerGet() {
        return view('register');
    }

    /**
     * Funckija koja obradjuje POST zahtev za registraciju korisnika (kreira nov zahtev za registraciju
     * ili javlja gresku da uneti podaci nisu ispravni).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerPost(Request $request) {
        $userType = $request->get('usertype');

        $rules = [
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'username' => ['required', new UsernameCheck()],
            'password' => ['min:8', new PasswordCheck()],
            'email' => [new EmailCheck($userType)]
        ];

        $customMessages = [
            //'required' => 'Polje za :attribute je obavezno.'
            'required' => 'Polje je obavezno',
            'min' => 'Šifra mora sadržati najmanje 8 karaktera',
            'alpha' => 'Polje mora sadržati samo slova'
        ];

        $this->validate($request, $rules, $customMessages);

//        $userType = $request->get('usertype');
//
//        $request->validate([
//            'firstname' => 'required|alpha',
//            'lastname' => 'required|alpha',
//            'username' => ['required', [new UsernameCheck()]],
//            'password' => ['min:8', new PasswordCheck()],
//            'email' => [new EmailCheck($userType)]
//        ]);

        $user = User::where('username', '=', $request->get('username'))->first();
        $regUser = RegistrationRequest::where('username', 'like', $request->get('username').",%")->first();
        if ($user != null || $regUser != null) {
            return redirect()->to(url('register'))->withInput()->with('errorUsername', 'Korisničko ime već postoji.');
        }

        $user = User::where('email', '=', $request->get('email'))->first();
        $regUser = RegistrationRequest::where('email', '=', $request->get('email'))->first();
        if ($user != null || $regUser != null) {
            return redirect()->to(url('register'))->withInput()->with('errorEmail', 'Email adresa je već u upotrebi.');
        }

        $reqistrationRequest = new RegistrationRequest;
        $reqistrationRequest->userType = substr($userType, 0, 1);
        $reqistrationRequest->email = $request->get('email');
        $reqistrationRequest->password = $request->get('password');
        $reqistrationRequest->username = $request->get('username').",".$request->get('firstname').",".$request->get('lastname');

        $reqistrationRequest->save();

        $request->session()->put('success', 'ok');
        return redirect()->route('guest.register.get');
        // return response()->json(array('message' => 'Zahtev za registraciju je uspesno poslat.'), 200); // ADDED
    }

//    public function registerInfo(Request $request) {
//        $request->session()->forget('register_request');
//        return view('register_info');
//    }
}
