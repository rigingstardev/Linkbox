<?php namespace App\Http\Controllers\PatientAuth;

use App\Http\Controllers\Controller;
use App\Models\PatientPasswordResets;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

class ResetPasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;
protected $guard = 'patient';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/patient/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('patient.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        $emailId = PatientPasswordResets::select('email')->where('token', '=', $token)->get()->first();
        $params = [];
        $params['class'] = 'form-control mrgn-btm-25';
        $params['placeholder'] = 'E-Mail Address';
          if(count((array)$emailId)>0){
            $emails = $emailId->email;
            $params['readonly'] = 'readonly';
          }
        else {
            $emails = '';
        }
         return view('patient.auth.passwords.reset')->with(
                ['token' => $token, 'email' =>$emails, 'params' =>$params, 'action' => url('/patient/password/reset')]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    // protected function resetPassword($user, $password)
    // {
    //     $user->forceFill([
    //         'password' => bcrypt($password),
    //         'remember_token' => Str::random(60),
    //     ])->save();
    // }

    protected function resetPassword($user, $password){
        if ($user) {
    
            // To check whether the emailId exist if exist replace the password & remember Token
            $users  = User::where('email', $user->email)->get()->first();
            
            if ($users) {
                $users->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();    
            }
    
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($response)
    {
        \Session::flash('custom_message', trans('custom.password_reset_success'));
        return redirect('/login');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('patients');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('patient');
    }
    
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'bail|required|email|max:255',
            'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*[@!#$%]).*$/|confirmed',
        ];
    }
}
