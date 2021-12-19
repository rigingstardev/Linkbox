<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Repositories\AdminsRepository;
use Illuminate\Support\Facades\Session;
//Models
use App\Modules\Physician\Models\Physician;
use App\Modules\Physician\Models\Speciality;
use App\Modules\Physician\Models\Patient;
use App\User;

// Repository
use App\Modules\Physician\Repositories\SubscriptionRepository;


// Mail Sending
use Mail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminToUserCancelSubscription;

class AdminController extends Controller
{
    protected $guard;

    public function __construct()
    {
        $this->guard = 'admin';
        Auth::shouldUse('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function login()
    {
        return view("Admin::login");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listPhysicians()
    {
        return view("Admin::list_physicians");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listPatients()
    {
        return view("Admin::list_patients");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function manageLibrary()
    {
        return view("Admin::manage_library");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function patientProfileView($id)
    {
        $id = Hashids::decode($id);
        $patientId                     = $id;
        $patientDetails                = Patient::where('id', $id)->first();
        $patientDetails->profile_image = ($patientDetails->profile_image != '') ? asset('uploads/patient/' . config('settings.thumb_prefix') . $patientDetails->profile_image) : asset('assets/dummy-profile-pic.png');
        if (count((array)$patientDetails) <= 0)
            return redirect('admin/home');
        else
            return view("Admin::patient_profile_view", compact('patientDetails'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function physicianProfileView($id)
    { $id = Hashids::decode($id);
        $data['physician']                = Physician::where('id', $id )->where('user_role', 'D')->first();
        $data['speciality_list']          = Speciality::pluck('name', 'id');
        $data['physician']->profile_image = ($data['physician']->profile_image != '') ? asset('uploads/physician/' . config('settings.thumb_prefix') . $data['physician']->profile_image) : asset('assets/dummy-profile-pic.png');
        
        // To list the active plan

        $physician = User::Physician()->where('id',$id)->first();
        $userActivePlan = $physician->activeSubscription;        
        
        if (count((array)$data['physician']) <= 0)
            return redirect('admin/home');
        else
            return view("Admin::physician_profile_view", compact('data','userActivePlan'));
    }
    /**
     * To cancel Subscription of Physicians
     * @param request SubscriptionCreateRequest
     * @param Integer $user_id  
     * @param String $plan  
     * @return Response
     */
    public function cancelSubscription($id,$plan,SubscriptionRepository $subRepo)
    {
        $physician = User::Physician()->where('id',$id)->first();
        $activePlan = $physician->subscription($plan);        

        if (empty($physician) || empty($activePlan))           
            return redirect()->back()->with('error', trans('Physician::messages.admin_subscription_canceled')); 

        $response = $subRepo->cancel($plan,$physician);  

        // Send mail to user about Email subscription Cancelled By admin 
        if ($response) {
             $physician->notify(new AdminToUserCancelSubscription($physician));
        }  
        return redirect()->back()->with('success', trans('Physician::messages.admin_subscription_canceled')); 
    }
    

    public function updateMenuSettings(Request $req, AdminsRepository $adminsRepo)
    {
        $adminData = Auth::guard('admin')->user();
        $menuType  = $adminData->left_menu_display_type;

        if ($menuType == 1)
            $inputData['left_menu_display_type'] = 0;
        else
            $inputData['left_menu_display_type'] = 1;

        $return = $adminsRepo->updateUserProfile(1, $inputData);
    }
}
