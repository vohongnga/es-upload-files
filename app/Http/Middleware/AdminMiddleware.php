<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class AdminMiddleware
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
        if ($request->session()->has('user')) {
           $role_id = $request->session()->get('user')['role_id'];
           if($role_id !=1) {
               return redirect()->route('login1')->with(['msgF'=>'You do not have permission for that']);
           }
        }
        if (isset($_COOKIE['remember_token'])) {
            $result = DB::table('users')->where('remember_token','=',$_COOKIE['remember_token'])->first();
            if($result->role_id != 1) {
                return redirect()->route('login1')->with(['msgF'=>'You do not have permission for that']);
            }
        }
        return $next($request);
    }
}
