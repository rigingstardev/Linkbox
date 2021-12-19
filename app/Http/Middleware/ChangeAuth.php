<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Auth;


class ChangeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard) Auth::shouldUse($guard);

        // dd(Auth::getDefaultDriver());  //as expected, outputs $guard if set, 'web' otherwise

        return $next($request);
    }

}
