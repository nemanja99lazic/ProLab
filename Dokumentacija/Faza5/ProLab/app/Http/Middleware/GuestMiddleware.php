<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     * @note ako je korisnik ulogovan, korisnik se šalje na njegovu početnu stranu
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
                return redirect()->to(url("/". $userType));
            }
        }
        if (!$request->session()->has('register_request') && $request->route()->getName() == 'guest.registerinfo') {
            return redirect()->to(url('/'));
        }

        return $next($request);
    }
}
