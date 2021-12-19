<?php

namespace App\Modules\Physician\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Plan;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
//use Illuminate\Support\Facades\DB;
// Repository
use App\Modules\Physician\Repositories\SubscriptionRepository;

// Requests 
use App\Modules\Physician\Requests\SubscriptionCreateRequest;
use Yajra\DataTables\Facades\DataTables;
// Mail Sending
//use Mail;
//use App\Mail\AdminStaff;
//use Illuminate\Notifications\Notifiable;
//use App\Notifications\StaffNotify;

class SubscriptionController extends Controller {

    //use Notifiable;

    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        
    }
    /**
     * Listing of Subscriptions 
     * @param none
     * @return HTML
     */
    public function index(SubscriptionRepository $subRepo) {   
           
        $userPlans = Auth::user()->activeSubscription;  
        $sortOrder = ($userPlans)?$userPlans->plan->sortorder:0;
        $plans = Plan::where('sortorder','>', $sortOrder)->get();           
        return view("Physician::subscription.details",compact('plans','userPlans'));
    }
    /**
     * Ajax method for Payment Subscription 
     * @param request SubscriptionCreateRequest
     * @param String $name, $email, $password 
     * @param Array $menu
     * @param Repository AdminStaffRepository
     * @return Response
     */
    public function postCreate(SubscriptionCreateRequest $request, SubscriptionRepository $subRepo) {   

        $userObj = Auth::user();
        $data = $request->all();   
        $subscribed = $subRepo->create($data);  
        if ($subscribed['exception'] == 1) {                    
            return $subscribed['result'];
        }        
        \Session::flash('success', trans('Physician::messages.subscribed_successfully'));
        return json_encode(array('success' => true, 'message' => trans('Physician::messages.subscribed_successfully'), 'redirectUrl' => route('physician.subscription.index')));
    }
    /**
     * To cancel Subscription
     * @param request SubscriptionCreateRequest
     * @param String $plan_id    
     * @return Response
     */
    public function getCancel($plan, Request $request, SubscriptionRepository $subRepo) {      
           
        $response =  $subRepo->cancel($plan);           
        if($response['success']) 
            return redirect()->back()->with('success', trans('Physician::messages.subscription_canceled')); 
        else
           return redirect()->back()->with('error', $response['message']);

    }

    /**
     * To Update Administrator Staff   
     * @param request AdminStaffUpdateRequest
     * @param String $name, $email, $password 
     * @param Array $menu
     * @param Repository AdminStaffRepository       
     * @return Response
     */
    public function postUpgrade(SubscriptionCreateRequest $request,SubscriptionRepository $subRepo) {
        $upgraded = $subRepo->upgrade($request->all());
        if ($upgraded['exception'] == 1) {                   
            return $upgraded['result'];
        }  
        \Session::flash('success', trans('Physician::messages.subscription_upgraded'));       
        return json_encode(array('success' => true, 'message' => trans('Physician::messages.subscription_upgraded'), 'redirectUrl' => route('physician.subscription.index')));
    }
}