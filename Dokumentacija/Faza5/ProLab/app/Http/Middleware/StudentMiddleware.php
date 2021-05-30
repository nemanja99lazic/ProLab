<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
//        if (!$request->session()->has("user") || $request->session()->get("user")['userType'] != "student") {
//            return redirect()->back();
//        }
//        return $next($request);
        if (!$request->session()->has("user")) {
            return redirect()->route('guest.login.get');
        } else if ($request->session()->get("user")['userType'] != "teacher") {
            return redirect()->back();
        }
        return $next($request);
    }
}
