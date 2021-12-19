<?php

namespace App\Http\Controllers\Auth;
use App\Models\PasswordResets;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Patient;

class ResetPasswordController extends Controller {
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    // protected function resetPassword($user, $password) {
    //     $user->forceFill([
    //         'password' => bcrypt($password),
    //         'remember_token' => Str::random(60),
    //     ])->save();
    // }

    protected function resetPassword($user, $password) {
        if ($user) {
            
            // To check whether the emailId exist if exist replace the password & remember Token
            $patient  = Patient::where('email', $user->email)->get()->first();
            
            if ($patient) {
                $patient->forceFill([
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
    protected function sendResetResponse($response) {
        \Session::flash('custom_message', trans('custom.password_reset_success'));
        return redirect('/login');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null) {
        $emailId = PasswordResets::select('email')->where('token', '=', $token)->get()->first();
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
        return view('auth.passwords.reset')->with(
                        ['token' => $token, 'email' => $emails, 'params' =>$params, 'action' => url('/password/reset')]
        );
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
            'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*?[0-9])(?=.*[A-Z])(?=.*[@!#$%]).*$/|confirmed',
        ];
    }
}
