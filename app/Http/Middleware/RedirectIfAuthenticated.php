<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
//        echo 'Hello';
       //var_dump(Auth::user());
        if (Auth::guard($guard)->check()) {
//            dd(Auth::user()->user_role);
            //dd(Auth::user());
            return redirect('physician/home');
        }
        return $next($request);
    }
}
