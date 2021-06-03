<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
            $userType = $request->session()->get("user")["userType"];
            return redirect()->to(url("/". $userType));
        }
        if (!$request->session()->has('register_request') && $request->route()->getName() == 'guest.registerinfo') {
            return redirect()->to(url('/'));
        }
        return $next($request);
    }
}
