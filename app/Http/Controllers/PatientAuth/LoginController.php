<?php

namespace App\Http\Controllers\PatientAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Sessions;
// use App\Patient;

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

use AuthenticatesUsers,
    LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }
    // protected $guard = 'patient';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $maxAttempts = 5; // change to the max attemp you want.
    public $decayMinutes = 1440; // change to the minutes you want.
    public $redirectTo = '/patient';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        Auth::loginUsingId(38);

        $this->middleware('patient.guest', ['except' => 'logout']);
        // $this->middleware('changeauth');
        // Auth::shouldUse('patient');
        // dd($request);
        
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->lockUser($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->clear_active_sessions();
            session(['session_identifier' => Hash::make(time() . rand(10, 9999))]);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ? : redirect()->intended($this->redirectPath());
    }

    public function redirectPath() {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/patient';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        if (Auth::guard()->check()) {
            return redirect('physician/home');
        } else if (Auth::guard('patient')->check()) {
            return redirect('patient/home');
        } else {
            return view('pages.landing');
        }
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function credentials(Request $request) {
        $request_data = $request->all();
        return [
            'email' => $request->email,
            'password' => $request->password,
            'is_account_active' => 'Y'
        ];
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request) {
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember', 'user_type1', 'user_type2'))
                        ->withErrors([
                            $this->username() => trans('auth.failed'),
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('patient');
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

        return redirect('/');
    }

    /**
     * Log the user sessions out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear_active_sessions() {
        $user_id = $this->guard()->User()->id;
        Sessions::where(['user_id' => $user_id, 'user_type' => 'P'])->delete();
    }

    public function lockUser(Request $request) {
        $email = $request->email;
        Patient::where('email', $email)->update(array('isLocked' => 1));
        }

}
