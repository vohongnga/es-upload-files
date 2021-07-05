<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       if (!$request->session()->has('user') && !isset($_COOKIE['remember_token'])) {
           return redirect()->route('login1')->with(['msgF'=>'You must have to login before']);
       }
       return $next($request);
    }
}
