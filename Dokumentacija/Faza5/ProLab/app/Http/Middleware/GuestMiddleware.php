<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;


/**
 * GuestMiddleware - klasa koja upravlja zahtevima koji su pristgli GuestCotroller-u.
 *
 * @package App\Http\Middleware
 * @version 1.0
 */
class GuestMiddleware
{
    /**
     * Funkcija koja upravlja zahtevom koji je pristigao GuestCotroller-u.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if ($request->session()->has("user")) {
            $user = User::where('idUser', '=', $request->session()->get("user")['userObject']->idUser)->first();
            if ($user == null) {
                $request->session()->forget('user');
                return $next($request);
            } else {
                $userType = request()->session()->get("user")["userType"];
                return redirect()->to(url("/". $userType));
            }
        }
        if (!$request->session()->has('register_request') && $request->route()->getName() == 'guest.registerinfo') {
            return redirect()->to(url('/'));
        }

        return $next($request);
    }
}
