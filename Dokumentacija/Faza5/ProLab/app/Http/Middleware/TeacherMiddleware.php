<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (!$request->session()->has("user") || $request->session()->get("user")['userType'] != "teacher") {
            return redirect()->back();
        }
        return $next($request);
    }
}
