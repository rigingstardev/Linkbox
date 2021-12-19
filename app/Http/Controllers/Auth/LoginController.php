<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Sessions;
use App\User;
use Illuminate\Support\Facades\Session;

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

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public $maxAttempts = 5; // change to the max attemp you want.
    public $decayMinutes = 1440; // change to the minutes you want.
    protected $redirectTo = '/physician/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        Auth::loginUsingId(19);
        $this->middleware('guest', ['except' => 'logout']);
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
            
            if(Auth::user()->practice_id > 0)
            {
                $this->clear_active_sessions();
                $this->updateLastLogin($request);
                session(['session_identifier' => Hash::make(time() . rand(10, 9999))]);
                if(Auth::user()->user_role == 'D')
                {
                    \Session::put('physician_id',Auth::user()->id);
                }
                else
                {
                    if(\Session::has('physician_id'))
                    {
                        \Session::forget('physician_id');   
                    }
                }
                return $this->sendLoginResponse($request);
            }
            else
            {
                $previous_session = $this->guard()->User()->session_id;
                $current_session = session()->getId();
                $this->guard()->logout();
                $request->session()->flush();
                if ($current_session) {
                    \Session::getHandler()->destroy($current_session);
                }
                $request->session()->regenerate();
                return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember', 'user_type1', 'user_type2'))
                        ->withErrors([
                            $this->username() => 'You are not authorized to login due to invalid practice.Please contact administrator.', ]);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Handle a update db .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function updateLastLogin(Request $request) {
        Auth::user()->update(array('last_logged_in' => date('Y-m-d H:i:s')));
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
        if (Auth::user()->is_subscribed == 'N' && Auth::user()->user_role == 'D') {
            $this->redirectTo = 'physician/subscription';
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/physician/home';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        if (Auth::guard()->check()) {
            if(\Session::has('physician_id'))
            {
                \Session::forget('physician_id');   
            }
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
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $previous_session = $this->guard()->User()->session_id;
        $current_session = session()->getId();
        if(\Session::has('physician_id'))
        {
            \Session::forget('physician_id');   
        }
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
//        Sessions::where('user_id', $user_id)->delete();
        Sessions::where(['user_id' => $user_id, 'user_type' => 'D'])->delete();
    }

    public function lockUser(Request $request) {
        $email = $request->email;
        User::where('email', $email)->update(array('isLocked' => 1));
    }

    /**
     * To find the user exist already
     *
     * @return \Illuminate\Http\Response
     */
    public function checkUserExist(Request $request) {
        $inputPost  = $request->all();   
        $result     = User::checkExistUser($inputPost);
    }

    /**
     * To store the user details
     *
     * @return \Illuminate\Http\Response
     */
    public function loginRedirectUser(Request $request) {
        $request  = $request->all();   
        Session::forget('registerDetails');
        Session::push('registerDetails', [
                            'formRole'  => $request['data']['formRole'], 
                            'existRole' => $request['data']['existRole'], 
                            'roleType'  => $request['data']['roleType'], 
                            'email'   => $request['email']
                        ]);
        echo 'saved';
    }

    /**
     * Redirect to Login for register
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectLoginRegister(Request $request) {
        if ($request->all()) {
            $usercheck = User::validateUserAndRegister($request->all());
            if ($usercheck) {
                switch ($usercheck['message']) {
                    case 'Patient-Success':
                        return redirect()->route('patient-login')->with('success', trans('Patient::messages.link_patient_registration_success'));
                        break;
                    case 'Physician-Success':
                            return redirect()->route('physician-login')->with('success', trans('Physician::messages.link_physician_registration_success'));
                        break;
                    case 'Staff-Success':
                        return redirect()->route('physician-login')->with('success', trans('Physician::messages.link_staff_registration_success'));
                        break;
                    case 'Admin-Success':
                        return redirect()->route('physician-login')->with('success', trans('Admin::messages.link_admin_registration_success'));
                        break;
                    case 'Patient-Failed':
                        return redirect('patient/register')->with('error', trans('auth.registration_failed'));
                        break;
                    case 'Physician-Failed':
                        return redirect('physician/register')->with('error', trans('auth.registration_failed'));
                        break;
                    case 'AdminStaff-Failed':
                        return redirect('administrator-staff/register')->with('error', trans('auth.registration_failed'));
                        break;
                    case 'Admin-Failed':
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        return view('auth.register_login');
    }

    /**
     * Redirect to Physician Login Page
     *
     * @return \Illuminate\Http\Response
     */
    public function physicianLogin()
    {
        return view('pages.office_login');
    }

    /**
     * Redirect to Patient Login Page
     *
     * @return \Illuminate\Http\Response
     */
    public function patientLogin()
    {
        return view('pages.patient_login');
    }
  
}
