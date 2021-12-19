<?php

namespace App\Http\Middleware;

use Closure;
use App\Sessions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class SessionCheck extends \Illuminate\Auth\Middleware\Authenticate {

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards) {
//        $this->authenticate($guards);
        if (!$request->ajax()) {
            $user_id = NULL;
            if ($request->user()) {
                $user_id = $request->user()->id;
            }
            if ($request->user('patient')) {
                $user_id = $request->user('patient')->id;
            }
//            echo session()->getId() . '===' .$user_id. '====' . session('session_identifier');
//            die;
            $validSession = Sessions::where('id', session()->getId())
                    ->where('user_id', $user_id)
                    ->where('session_identifier', session('session_identifier'))
                    ->first();
//            echo $validSession->session_identifier .'====='.session('session_identifier');
//            die;
            if (!$validSession) {
                return response()->view('errors.401', [], 401);
            }
        }

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards) {
        if (empty($guards)) {
            return $this->auth->authenticate();
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        throw new AuthenticationException('Unauthenticated.', $guards);
    }

}
