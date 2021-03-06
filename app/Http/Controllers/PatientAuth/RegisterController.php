<?php namespace App\Http\Controllers\PatientAuth;

use App\User;
use App\Patient;
use Validator;
use App\Models\PatientPractice;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailVerify;
use App\Modules\Physician\Repositories\QuestionReceipientsRepository;

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
protected $guard = 'patient';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/patient/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('patient.guest');
        $this->questionReceipientsRepo = new QuestionReceipientsRepository();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'first_name' => 'bail|required|max:255',
                'last_name' => 'bail|required|max:255',
                'email' => 'bail|required|email|max:255|unique:patients,email,P,is_account_active',
                'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*[@!#$%]).*$/|confirmed',
                'gender' => 'required',
                'dob' => 'bail|required|max:255',
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
        $data['dob'] = Carbon::createFromFormat('d/m/Y', $data['dob']);
        $data['dob'] = trim($data['dob'], '"');
        return Patient::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'contact_number' => '+' . $data['country_code'] . '-' . $data['contact_number'],
                'password' => bcrypt($data['password']),
                'gender' => $data['gender'],
                'dob' => Carbon::parse($data['dob'])->format('Y-m-d'),
                'activation_code' => str_random(10),
        ]);
    }

    /**
     * update user instance after a valid registration.
     *
     * @param  array  $data
     * @return Patient
     */
    protected function update($data, $patientID)
    {
        $data['dob'] = Carbon::createFromFormat('d/m/Y', $data['dob']);
        $data['dob'] = trim($data['dob'], '"');
        return Patient::where('id', $patientID)->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
//                'name' => $data['patient_name'],
//                'name' => $data['patient_name'],
                'email' => $data['email'],
                'contact_number' => '+' . $data['country_code'] . '-' . $data['contact_number'],
                'password' => bcrypt($data['password']),
                'gender' => $data['gender'],
                'dob' => Carbon::parse($data['dob'])->format('Y-m-d'),
                'activation_code' => str_random(10),
                'is_account_active' => 'Y'
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('patient.auth.register');
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
        // dd($inputData);
        if (isset($inputData['uuid'])) {
            $patientID = $this->questionReceipientsRepo->getPatientIdFromUUid($inputData['uuid']);
            if ($patientID)
                $patientID = $patientID->patient_id;

            event(new Registered($user = $this->update($request->all(), $patientID)));
        } elseif (array_key_exists('email', $inputData)) {
            
            $patientDetails = $this->questionReceipientsRepo->getIdFromEmailIdForActiveP($inputData['email']);
            if (!$patientDetails) {
                $patientDetails = $this->questionReceipientsRepo->getIdFromContactNoForActiveP($inputData['contact_number']);
                
            }
            
            if ($patientDetails) {
                $patientID      = $patientDetails->id;
                $this->update($request->all(), $patientID);
                $patientDetails = $this->questionReceipientsRepo->getPatientDetails($patientID);
                $user           = $patientDetails;
                event(new Registered($patientDetails));
            } else {
                event(new Registered($user = $this->create($request->all())));
            }
        }
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
    protected function registered(Request $request, $user)
    {
        $inputData = $request->all();
        

        // To save the Patient Practice details 
        // $practice = new PatientPractice();
        // $practice->patient_id = $user->id; 
        // $practice->practice_id = $inputData['practice']; 
        // $practice->save();

        if (isset($inputData['uuid'])) {

            $patientID = $this->questionReceipientsRepo->getPatientIdFromUUid($inputData['uuid']);
            if ($patientID)
                $patientID = $patientID->patient_id;
            $user      = Patient::find($patientID);
            if ($user)
                $this->questionReceipientsRepo->updatePatientId($inputData['uuid'], $user->id);
        } if ($user) {
            $user->type = 'Patient';
            $user->name = $inputData['first_name'] . " " . $inputData['last_name'];
            $user->notify(new EmailVerify($user));
            return redirect('patient/register')->with('success', trans('Physician::messages.registration_success'));
        } else
            return redirect('patient/register')->with('error', trans('Physician::messages.dnInsertFailed'));
    }

// Get the user who has the same token and change his/her status to verified i.e. 1
    public function verify($token)
    {
// The verified method has been added to the user model and chained here
// for better readability
        $obj = Patient::where('activation_code', $token)->first();
        if ($obj) {
            $obj->verified();
        }
        \Session::flash('custom_message', trans('custom.email_verified'));
        return redirect('login');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('patient');
    }
}
