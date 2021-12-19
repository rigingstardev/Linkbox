<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailVerify;
use App\Models\Practice;
class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

use Notifiable;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'physician/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this->middleware('guest');
//        Redirect::to('physician/register')->send();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'physician_name' => 'required|max:255',
                     'practice' => 'required',
                    'email' => 'bail|required|email|max:255|unique:users',
                    'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*[@!#$%]).*$/|confirmed',
                    'speciality' => 'required',
                    'hospital_name' => 'bail|required|max:255',
                    'npi_number' => 'bail|required|max:255',
                    'city' => 'required|max:255',
                    'country_code' => 'bail|required|max:5|regex:/^\+?[^a-zA-Z]{1,}$/',
                    'contact_number' => 'bail|required|regex:/^\+?[^a-zA-Z]{5,}$/|min:10|max:15',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['physician_name'],
                    'practice_id' => $data['practice'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'speciality_id' => $data['speciality'],
                    'hospital_name' => $data['hospital_name'],
                    'npi_number' => $data['npi_number'],
                    'city' => $data['city'],
                    'contact_number' => '+'.$data['country_code'].'-'.$data['contact_number'],
                    'user_role' => 'D',
                    'activation_code' => str_random(10),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        $data['practice_list'] = Practice::orderBy('name', 'asc')->pluck('name', 'id');
        return view('physician/register')->with(['data' => $data]);
        //return view('physician/register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

//        $this->guard()->login($user);
//        return $this->registered($request, $user)
//                ? : redirect($this->redirectPath());
        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user) {
    //    $email = new EmailVerification(new User(['activation_code' => $user->activation_code, 'name' => $user->name]));
    //    $mailSent = EmailHelper::sendEmail($user, $email);
        
        $user->type = 'Physician';
        $user->notify(new EmailVerify($user));
        return redirect('physician/register')->with('success', trans('Physician::messages.registration_success'));
    }

// Get the user who has the same token and change his/her status to verified i.e. 1
    public function verify($token) {
        // The verified method has been added to the user model and chained here
        // for better readability
        $obj = User::where('activation_code', $token)->first();
        if ($obj) {
            $obj->verified();
        }
        \Session::flash('custom_message', trans('custom.email_verified'));
        return redirect('login');
    }
}
