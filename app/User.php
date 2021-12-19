<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;
use Laravel\Cashier\Billable;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Hash;
use App\Modules\Physician\Models\PermissionUser;


class User extends Authenticatable implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    use Billable;
    
    protected $dates = ['trial_ends_at','subscription_ends_at'];
    //MODEL LEVEL CONSTANT
    const ADMIN_STAFF_YES = 'Y';
    const ADMIN_STAFF_NO = 'N';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password', 'speciality', 'hospital_name', 'npi_number', 'city', 'contact_number', 'user_role',
//    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Set the verified status to true and make the email token null
    public function verified() 
    {
        $this->is_account_active = 'Y';
        $this->activation_code = null;
        $this->save();
    }

    /**
     * Check if the User Is Admin Staff
     *
     * @var array
     */
    public function scopeAdminStaff($query) 
    {

        return $query->whereuser_role('S');
    }

    /**
     * Check If the User Have the Permission 
     *
     * @var array
     */
    public function hasPermission($permission) 
    {
        return $this->permissions()->where('permission', $permission)->first();
    }

    /**
     * The permission that belong to the user.
     */
    public function permissions() {
        return $this->belongsToMany('App\Modules\Physician\Models\Permissions', 'permission_user', 'user_id', 'permission_id');
    }
    /**
     * Check if the User Is Patient
     *
     * @var array
     */    
    public function scopePhysician($query)
    {
        return $query->whereuser_role('D');
    }
    /**
     * Relation with Question
     *
     * @var array
     */    
    public function questions()
    {
        return $this->hasMany('App\Models\Questions','user_id');
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new MyResetPassword($token));
    }    
    /**
     * Get the currently active subscription.
     *
     * @param  string  $token
     * @return void
     */
    public function activeSubscription() 
    {
        return $this->hasOne('App\Models\Subscription', 'user_id')->where('status', 'active');
    }
    /**
     * To check whether the user is subscripbed for any plan.
     *
     * @param  string  $token
     * @return void
     */
    public function isSubscribed() 
    {
        $subscription = $this->subscriptions->sortByDesc(function ($value) {
            return $value->created_at->getTimestamp();
        })
        ->first(function ($value) {
             return $value->status === 'active'; 
            
        });      
        if (is_null($subscription)) {
            
            return false;
        }
        return $subscription;
        // return $subscription->valid();
    }
    /**
     * To check whether the user is Staff.
     *
     * @param  string  $token
     * @return void
     */
    public function isAuthorizedStaff($permission) 
    {    
        
        if ('S' == $this->user_role && !($this->hasPermission($permission))) {            
            return false;
        }
        else {            
            return true;
        }
    }
    /**
     * To get the user id if the user is admin Staff
     *
     * @param  string  $token
     * @return void
     */
    public function getUserId() 
    {   $id = \Session::get('physician_id'); 
        // dd($id,'.',$this->id,$this->parent_id);
        return ('S' == $this->user_role) ? $id : $this->id;
        // return ('S' == $this->user_role) ? $this->parent_id : $this->id;
        // dd(\Session::get('physician_id'));
        
    }
    /**
     * To get the user id if the user is admin Staff
     *
     * @param  string  $token
     * @return void
     */
    public function isParentIsSubscribed() 
    {   $id = \Session::get('physician_id');     
        $subscribed = false;
        if($this->user_role == 'S') {
            $activeSubscription = \App\Models\Subscription::where('user_id',$id)->where('status','active')->first();
            // $activeSubscription = \App\Models\Subscription::where('user_id',$this->parent_id)->where('status','active')->first();
            if($activeSubscription)
                $subscribed = true;                     
        }   
        return $subscribed;   
    }

    /**
     * To check the emailId exist for users table
     * @param string $emailId 
     * @return array
     */
    public static function checkExistUser($input){
        $result = $adminTable = $userDetails = $patientTable = [];
        if ($input['emailId']) {
            try {
                // Check User Table
                $userTable = User::where(['email' => $input['emailId']])->get()->first();
                // $userTable = User::where(['email' => $input['emailId'], 'is_account_active' => 'Y'])->get()->first();
                // Check user Role
                if ($userTable) {
                    $userRoleType = $userTable->user_role;
                    switch($userRoleType) {
                        case 'D':
                            $exist = 'user-doctor-exist';
                        break;
                        case 'A':
                            $exist = 'user-admin-exist';
                        break;
                        case 'P';
                            $exist = 'user-patient-exist';
                        break;
                        case 'S';
                            $exist = 'user-staff-exist';
                        break;
                        default:
                            $exist = 'user-doctor-exist';
                    }
                }
                // Check Admin Table
                $adminTable = Admin::where('email', $input['emailId'])->get()->first();
                if ($adminTable) {
                    $adminExist = 'admin-exist';
                }
                // Check Patient Table 
                $patientTable = Patient::where(['email' => $input['emailId']])->get()->first();
                // $patientTable = Patient::where(['email' => $input['emailId'], 'is_account_active' => 'Y'])->get()->first();
                if ($patientTable) {
                    $patientExist = 'patient-exist';
                }
                // To check to tables
                if ($userTable && empty($adminTable) && empty($patientTable)) {
                    // dd($userTable);
                    $result['formRole']     = $input['role'];
                    $result['existRole']    = $exist;
                    if ($userTable->user_role == 'D' ) {
                        $result['roleType'] = 'Physician';
                    } else if ($userTable->user_role == 'S') {
                        $result['roleType'] = 'AdminStaff';
                    } else if ($userTable->user_role == 'P') {
                        $result['roleType'] = 'User-Patient';
                    } else {
                        $result['roleType'] = 'User-Admin';
                    }
                } else if (empty($userTable) && empty($adminTable) && $patientTable) {
                    $result['formRole']     = $input['role'];
                    $result['existRole']    = $patientExist;
                    $result['roleType']     = 'Patient';
                } else if ($userTable && empty($adminTable) && $patientTable) {
                    $result['formRole']     = $input['role'];
                    $existTable             = [ $exist, $patientExist ];
                    $result['existRole']    = $existTable;
                    $result['roleType']     = 'Physician & Patient';
                } else if (empty($userTable) && $adminTable && empty($patientTable))  {
                    $result['formRole']     = $input['role'];
                    $result['existRole']    = $adminExist;
                    $result['roleType']     = 'Admin';
                }
                // send the request as a json format
                echo json_encode($result);
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * To check the valid user to register
     * @param string $request 
     * @return array
     */
    public static function validateUserAndRegister($request){
        // Assign values to variable
        $email      = $request['email'];
        $password   = $request['password'];
        $existRole  = $request['exist_role'];
        $formRole   = $request['form_role'];
        $roleType   = $request['role_type'];
        $result     = [];
        if ($existRole) {
            if (($existRole == 'user-doctor-exist') || ($existRole == 'user-admin-exist') || ($existRole == 'user-patient-exist') || ($existRole == 'user-staff-exist')) {
                $user = User::where(['email' => $email, 'is_account_active' => 'Y'])->get()->first();
                $existPassword                              = $user->password;
                if (Hash::check($password, $existPassword)) {
                    
                    if ($formRole == 'Patient') {

                        // Assign the values to Admin Staff Account
                        $patient                            = new Patient();
                        $patient->first_name                = $user->name;
                        $patient->last_name                 = '';
                        $patient->email                     = $email;
                        $patient->password                  = $existPassword;
                        $patient->gender                    = ($user->gender) ? $user->gender : '';
                        $patient->dob                       = $user->dob;
                        $patient->is_account_active         = 'Y';
                        $patient->activation_code           = $user->activation_code;
                        $patient->contact_number            = $user->contact_number;
                        $patient->left_menu_display_type    = $user->left_menu_display_type;
                        $patient->remember_token            = $user->remember_token;
                        $patient->isLocked                  = 0;
                        $patient->entry_type                = 'R';

                        // Save 
                        if ($patient->save()) {
                            $result                         = $patient;
                            $result['message']              = 'Patient-Success';
                        } 
                    } 

                } else {
                    // Failed Messages
                    if ($formRole == 'Patient') {
                        $result['message'] = 'Patient-Failed';
                    }
                }
            } else if ($existRole == 'admin-exist') {
                $user = Admin::where('email', $email)->get()->first();

            } else {
                $user                                       = Patient::where(['email'=>$email, 'is_account_active' => 'Y'])->get()->first();
                $existPassword                              = $user->password;
                
                // Check the comparison for valid password
                if (Hash::check($password, $existPassword)) {
                    
                    if ($formRole == 'Physician') {

                        // Assign the values to Physician Account
                        $physician                          = new User();
                        $physician->name                    = $user->first_name . ' '. $user->last_name;
                        $physician->email                   = $email;
                        $physician->password                = $existPassword;
                        $physician->gender                  = $user->gender;
                        $physician->dob                     = $user->dob;
                        $physician->user_role               = 'D';
                        $physician->is_account_active       = 'Y';
                        $physician->activation_code         = $user->activation_code;
                        $physician->contact_number          = $user->contact_number;
                        $physician->left_menu_display_type  = $user->left_menu_display_type;
                        $physician->remember_token          = $user->remember_token;
                        // $physician->speciality_id           = '';
                        $physician->practice_id             = 1;

                        // Save 
                        if ($physician->save()) {
                            $result                         = $physician;
                            $result['message']              = 'Physician-Success';
                        } 

                    } else if ($formRole == 'AdminStaff') {

                        // Assign the values to Admin Staff Account
                        $staff                          = new User();
                        $staff->name                    = $user->first_name . ' '. $user->last_name;
                        $staff->email                   = $email;
                        $staff->password                = $existPassword;
                        $staff->gender                  = $user->gender;
                        $staff->dob                     = $user->dob;
                        $staff->user_role               = 'S';
                        $staff->is_account_active       = 'Y';
                        $staff->activation_code         = $user->activation_code;
                        $staff->contact_number          = $user->contact_number;
                        $staff->left_menu_display_type  = $user->left_menu_display_type;
                        $staff->remember_token          = $user->remember_token;
                        // $staff->speciality_id           = '';
                        $staff->practice_id             = 1;

                        // Save 
                        if ($staff->save()) {
                            $result                         = $staff;
                            $result['message']              = 'Staff-Success';
                        } 
                    }
                } else {
                    // Failed Messages
                    if ($formRole == 'Physician') {
                        $result['message'] = 'Physician-Failed';
                    } else if ($formRole == 'AdminStaff') {
                        $result['message'] = 'AdminStaff-Failed';
                    }
                }
            }

            return $result;
        }
    }
}