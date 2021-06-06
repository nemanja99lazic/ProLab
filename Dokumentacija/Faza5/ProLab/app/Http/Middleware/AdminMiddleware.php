<?php

/**
 *
 * Autor: Slobodan Katanic 2018/0133
 *
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\User;

/**
 * AdminMiddleware - klasa za upravljanje zahtevima upucenim AdminConroller-u.
 *
 * @package App\Http\Middleware
 * @version 1.0
 */
class AdminMiddleware
{
    /**
     * Funkcija koja upravlja zahtevom koji je pristigao AdminController-u.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (!$request->session()->has("user")) {
            return redirect()->route('guest.login.get');
        } else {
            $user = User::where('idUser', '=', $request->session()->get("user")['userObject']->idUser)->first();
            if ($user == null) {
                $request->session()->forget('user');
                return redirect()->route('guest.login.get');
            } else if ($request->session()->get("user")['userType'] != "admin") {
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
