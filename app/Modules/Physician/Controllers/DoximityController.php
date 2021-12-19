<?php
namespace App\Modules\Physician\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
// use Auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Libraries\Doximity;
use Socialite;

use App\Helpers\ImageResizeHelper;
use Illuminate\Support\Facades\Config;

use App\Modules\Physician\Models\Speciality;

class DoximityController extends Controller {

    use AuthenticatesUsers;
    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct() {        
        $this->middleware('guest', ['except' => 'logout']);
    }
    /**
     * Redirect the user to the Doximity authentication page.
     *
     * @return Response
     */
    public function authentication()
    {
        
        return Socialite::driver('doximity')
                ->with(['type' => 'login'])
                ->redirect();
        //return Socialite::driver('facebook')->redirect();
    } 
    /**
     * Obtain the user information from Doximity.
     *
     * @return Response
     */
   /* public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('doximity')->stateless()->user();
        } catch (Exception $e) {
            return redirect('doximity');
        }   
 
        $authUser = $this->findOrCreateUser($user);
 
        Auth::login($authUser, true);
 
        return redirect()->route('home');
    } */
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $doximityUser
     * @return User
     */
    private function findOrCreateUser($doximityUser)
    {
        $authUser = User::where('email',$doximityUser->email)->first();
        if ($authUser){
            $authUser->last_logged_in = date('Y-m-d H:i:s');
            if(empty($authUser->doximity_id) || ($authUser->doximity_id != $doximityUser->id)) {
                $authUser->doximity_id = $doximityUser->id;
            }   
                $authUser->save();
            return $authUser;
        }  
        $speciality = Speciality::where('name',$doximityUser->speciality)->first(['id']);
        $specialityId = ($speciality)?$speciality->id:Null;           
        $doximityArr = [
            'doximity_id'           => $doximityUser->id,           
            'name'                  => $doximityUser->name,           
            'email'                 => $doximityUser->email,                    
            'contact_number'        =>  $doximityUser->contact_number,
            'profile_description'   =>  $doximityUser->profile_description,
            'gender'                =>  $doximityUser->gender,
            'npi_number'            =>  $doximityUser->npi_number,
            //'dob'                   =>  $user['birthday'],
            'city'                  =>  $doximityUser->city, 
            'speciality_id'         => $specialityId,
            'is_account_active'     => 'Y',
            'last_logged_in' => date('Y-m-d H:i:s'),
            'user_role'             => 'D'
        ];
        $User = User::create($doximityArr);
        if($doximityUser->has_uploaded_profile_photo) {
            // upload image to the path
            $imageName                 = $User->id . '_' . time() . Config::get('settings.phy_profile_img_prefix') . '.png';
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );  
            $image = file_get_contents($doximityUser->profile_image,false,stream_context_create($arrContextOptions));            
            ImageResizeHelper::resizeImage($image, $imageName, 'thumb', Config::get('settings.phy_profile_img_path'));
            ImageResizeHelper::resizeImage($image, $imageName, 'icon', Config::get('settings.phy_profile_img_path'));
            //$doximityUser->profile_image->copy(public_path('uploads/physician/'), $imageName);
            file_put_contents((public_path('uploads/physician/').$imageName), $image);
            $User->profile_image = $imageName;
            $User->save();       
        }
        return $User;
    }
    /**
     * To Authorize From Doximity
     * @param none
     * @return HTML
     */
    public function getAuthorization() {  
        try {
            $user = Socialite::driver('doximity')->stateless()->user();
            //$user = Socialite::driver('doximity')->user();
        } catch (\Exception $e) {
            return redirect('physician/dashboard');
        } 

        $authUser = $this->findOrCreateUser($user);
        
        Auth::login($authUser, true);

        if(!($authUser->isSubscribed()) && $authUser->user_role == 'D'){
            return redirect('physician/subscription');
        } 
        \Session::put('physician_id',Auth::user()->id);
        return redirect('physician/dashboard');
    }
}