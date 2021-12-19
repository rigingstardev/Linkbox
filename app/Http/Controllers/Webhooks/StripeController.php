<?php
namespace App\Http\Controllers\Webhooks;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Laravel\Cashier\Http\Controllers\WebhookController; 

use Illuminate\Notifications\Notifiable;
use App\Notifications\NewSubscription;
use App\Notifications\StripePaymentSuccess;
use App\Notifications\StripeCardUpdated;

class StripeController extends WebhookController {   
    /**
     * Occurs whenever a customer with no subscription is signed up for a plan.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionCreated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);           
        if ($user) {
            $data['name'] = $user->name;
            $data['plan'] = $payload['data']['object']['plan']['name'];
            $data['amount'] = strtoupper($payload['data']['object']['plan']['currency']).' '.($payload['data']['object']['plan']['amount']/100);
            $data['end_date'] = date("m/d/Y",$payload['data']['object']['current_period_end']);
            $data['start_date'] = date("m/d/Y",$payload['data']['object']['current_period_start']);            
            $user->notify(new NewSubscription($data));
        }       
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a customer ends their subscription.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $user->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function ($subscription) {
                $subscription->markAsCancelled();
            });
        }
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a subscription changes. Examples would include switching from one plan to another, or switching status from trial to active..
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);        
        //update status and subscription end time
        if ($user) {
            $user->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function ($subscription) {
                $subscription->status = $payload['data']['object']['status'];
                $subscription->save();
                if('active' == $payload['data']['object']['status']) {
                     $user->subscription_ends_at = date('Y-m-d H:i:s', $payload['data']['object']['current_period_end']);
                     $user->save();
                }
            });
            // Send mail to Customer with the Updated Plan if plan changed.
        }
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a plan is created.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
    */
    protected function handlePlanCreated(array $payload)
    {
        $plan = $payload['data']['object'];
        $lastSortOrder = \App\Models\Plan::max('sortorder');       

        $planTypeArray = ['month' => 'monthly','year'=>'yearly','custom'=>'custom'];
       
        if ( $plan ) {

            $planObj = \App\Models\Plan::where('plan_id',$plan['id'])->first();            
           
            if( !empty($planObj) ) {
               
                $planObj->name = $plan['name'];
                $planObj->amount = $plan['amount'];
                $planObj->currency = $plan['currency'];
                $planObj->period = $plan['interval_count'].' '.$plan['interval'];
                $planObj->plan_type = $planTypeArray[$plan['interval']];  

            } else {  

                $planObj = new \App\Models\Plan;
                $planObj->plan_id = $plan['id'];
                $planObj->name = $plan['name'];
                $planObj->amount = $plan['amount'];
                $planObj->currency = $plan['currency'];
                $planObj->period = $plan['interval_count'].' '.$plan['interval'];
                $planObj->plan_type = $planTypeArray[$plan['interval']];
                $planObj->sortorder = $lastSortOrder+1;  
            }
            $planObj->save();
        }      
        return new Response('Webhook Handled', 200);
    }
    /**
     * Handle When a Plan Deleted.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
    */
    protected function handlePlanDeleted(array $payload)
    {
        $plan = $payload['data']['object'];
        
        $planObj = \App\Models\Plan::where('plan_id',$plan['id'])->first();
        if ($planObj) {
            $planObj->delete();
        }
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a new charge is created and is successful.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleChargeSucceeded(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        //$user = $this->getUserByStripeId('cus_AHPYul7GiYU4Np');    
        if ($user) {
            $activePlan = $user->activeSubscription;  
            $data['name'] = $user->name;
            $data['plan'] = $activePlan->name;
            $data['amount'] = strtoupper($payload['data']['object']['currency']).' '.($payload['data']['object']['amount']/100);
            $data['end_date'] = date("m/d/Y",strtotime($user->subscription_ends_at));
            $data['start_date'] = date("m/d/Y",strtotime($activePlan->created_at));            
            $user->notify(new StripePaymentSuccess($data));
        }       
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a new charge is Failed
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleChargeFailed(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        //$user = $this->getUserByStripeId('cus_AHPYul7GiYU4Np');    
        if ($user) {
            // $activePlan = $user->activeSubscription;  
            // $data['name'] = $user->name;
            // $data['plan'] = $activePlan->name;
            // $data['amount'] = strtoupper($payload['data']['object']['currency']).' '.($payload['data']['object']['amount']/100);
            // $data['end_date'] = date("m/d/Y",strtotime($user->subscription_ends_at));
            // $data['start_date'] = date("m/d/Y",strtotime($activePlan->created_at));            
            // $user->notify(new StripePaymentSuccess($data));
        }       
        return new Response('Webhook Handled', 200);
    }
    /**
     * Handle When Customer Subscribes.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerUpdated(array $payload)
    { 
        $user = $this->getUserByStripeId($payload['data']['object']['id']);
        // $user = $this->getUserByStripeId('cus_AHPYul7GiYU4Np');    
        if ($user) {            
            $data['name'] = $user->name;                      
            $user->notify(new StripeCardUpdated($data));
        }       
        return new Response('Webhook Handled', 200);
    }
    /**
     * Occurs whenever a new invoice is created.
     *
     * @param  array  $payload
     * @return Response
     */
    public function handleInvoiceCreated($payload) {
        
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);        
        if ($user) {   
            // To Manage Invoices Success       
        }        
        http_response_code(200);       
    }
    /**
     * Handle a payment succeeded Stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */
    public function handleInvoicePaymentSucceeded($payload) {
        
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);        
        if ($user) {   
            // To Manage Invoices Success       
        }        
        http_response_code(200);       
    }
    /**
     * Handle a payment failed Stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */
    public function handleInvoicePaymentFailed($payload) {       

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        if ($user) {
            // To Manage Invoices Failues    
        }        
        http_response_code(200);        
    }
}