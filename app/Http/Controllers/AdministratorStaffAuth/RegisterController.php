<?php namespace App\Http\Controllers\AdministratorStaffAuth;

use App\User;
use App\Patient;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailVerify;
use App\Modules\Physician\Repositories\QuestionReceipientsRepository;
use App\Models\Practice;


class RegisterController extends Controller
{
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'name' => 'bail|required|max:255',
                'practice' => 'required',
                'city' => 'required',
                'email' => 'bail|required|email|max:255|unique:users,email,P,is_account_active',
                'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*[@!#$%]).*$/|confirmed',
                // 'gender' => 'required',
                // 'dob' => 'bail|required|max:255',
                'country_code' => 'bail|required|max:5|regex:/^\+?[^a-zA-Z]{1,}$/',
                'contact_number' => 'bail|min:10|max:15|regex:/^\+?[^a-zA-Z]{5,}$/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Patient
     */
    protected function create(array $data)
    {
        return User::create([
                'name' => $data['name'],
                'practice_id' => $data['practice'],
                'email' => $data['email'],
                'city' => $data['city'],
                'contact_number' => '+' . $data['country_code'] . '-' . $data['contact_number'],
                'password' => bcrypt($data['password']),
                // 'gender' => $data['gender'],
                // 'dob' => Carbon::parse($data['dob'])->format('Y-m-d'),
                'activation_code' => str_random(10),
                'is_admin_staff' =>User::ADMIN_STAFF_YES,
                'parent_id' => 0,
                'is_account_active' =>'Y',
                'user_role' => 'S',
        ]);
    }

   

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $data['practice_list'] = Practice::orderBy('name', 'asc')->pluck('name', 'id');
        
        return view('administrator_staff.auth.register')->with(['data' => $data]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $inputData = $request->all();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect('administrator-staff/register')->with('success', trans('Physician::messages.registration_success'));
    }

// Get the user who has the same token and change his/her status to verified i.e. 1
    public function verify($token)
    {
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
