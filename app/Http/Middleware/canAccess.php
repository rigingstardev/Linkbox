<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class canAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {  
        $user = \App\User::find($request->user()->id);        
        if ('D' == $user->user_role) {
            return $next($request);
        }
        if (('S' == $user->user_role) && ($user->hasPermission($permission))) {
            return $next($request);
        }
        return response()->view('errors.404',[],404);          
    }
}
