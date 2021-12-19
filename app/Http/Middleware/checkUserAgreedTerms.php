<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkUserAgreedTerms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->agreed === 'Y') {
            return $next($request);
        } else {
            if (Auth::guard('patient'))
                return redirect('/patient/profile');
            else 
                return redirect('/physician/subscription');
        }
    }
}
