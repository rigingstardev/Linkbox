<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
// use Illuminate\Contracts\Auth\Factory as Auth;
// use App\Sessions;
// use App\Admin;


class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */
    // protected $guard = 'admin';
use AuthenticatesUsers,
    LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $maxAttempts = 5; // change to the max attemp you want.
    public $decayMinutes = 1; // change to the minutes you want.
    public $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin.guest', ['except' => 'logout']);
        // $this->middleware('changeauth');
        // Auth::guard('admin');
        // Auth::shouldUse('admin');
        // $this->auth->shouldUse($this->guard());
        // dd(Auth::check());

    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        return view('Admin::login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('admin');
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $previous_session = $this->guard()->User()->session_id;
        $current_session = session()->getId();

        $this->guard()->logout();

        $request->session()->flush();

        if ($current_session) {
            \Session::getHandler()->destroy($current_session);
        }

        $request->session()->regenerate();

        return redirect('/admin/login');
    }

}
