<?php namespace App\Modules\Physician\Repositories;

use App\User;
use App\Models\Subscription;
use App\Models\Plan;
use Stripe\Error\Card;

class SubscriptionRepository extends BaseRepository
{

    protected $model;
    protected $user;
    /**
     * Stripe Initialization
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {   

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->model = new Subscription();
        $this->user = \Auth::user();
    }
    /**
     * Create Subscription
     * @param integer $cardnumber, $cvc , $month, $year
     * @param boolean $saveforfuture
     *    
     * @return \Illuminate\Support\Collection
     */
    public function create($data)
    {          
        $subscribed = ['exception'=>1,'result'=>[]];       
        $plan = Plan::where('plan_id',$data['plan'])->first();
        try{            
            if ($this->user->onPlan($data['plan']) && !($this->user->subscription($data['plan'])->onGracePeriod())) {
                return; 
            }                
            if(0 == $data['token']) {
                if($data['stripeToken'])
                    $tokenId = $data['stripeToken'];
                else{
                    $token = $this->generateToken($data); 
                    $tokenId =  $token->id;
                } 
            }     
            // if stripe customer and need to pay using the previous card dont pass the token
            if( 1 == $data['token']) {
                if($this->user->asStripeCustomer()) {
                    $subscribed['result'] = $this->user->newSubscription($data['plan'], $data['plan'])->add(['email' => $this->user->email]);                   
                }
            }
            else {  
                $subscribed['result'] =  $this->user->newSubscription($data['plan'], $data['plan'])->create($tokenId,['email' => $this->user->email]);                
            
                if(isset($data['savedetails']) && 1 == $data['savedetails'])
                    $this->user->default_card = $data['stripeCard'];
                else   
                    $this->user->default_card = '';

            }
            $this->user->subscription_ends_at = date('Y-m-d H:i:s',strtotime("$plan->period"));  
            $this->user->is_subscribed = 'Y';  
            $this->user->save();  
                               
            $subscribed['exception'] = 0;                  
            return $subscribed;
        }catch (\Stripe\Error\Card $e) { 
            $body = $e->getJsonBody();
            $err  = $body['error'];  
            //$message = $err['message'];
            $message = trans('Physician::messages.subscription_error');           
            return $upgraded = ['exception'=>1,'result'=>response()->json([$err['param'] => $err['message']], $e->getHttpStatus())]; 
        } catch (\Stripe\Error\InvalidRequest $e) {  
           $message = trans('Physician::messages.subscription_error');         
           return $subscribed = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
           
        } catch (\Stripe\Error\Authentication $e) {  
            $message = trans('Physician::messages.subscription_error');           
            return $subscribed = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
          
        } catch (\Stripe\Error\ApiConnection $e) {  
            $message = trans('Physician::messages.subscription_error');          
            return $subscribed = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
            
        } catch (\Stripe\Error\Base $e) {
            $message = trans('Physician::messages.subscription_error');             
            return $subscribed = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
            
        } catch (Exception $e) {
            $message = trans('Physician::messages.subscription_error');             
            return $subscribed = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())];             
        }
    }
    /**
     * Cancel Subsription.
     * @param string Plan_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function cancel($plan, $user = null)
    {  
        $canceled = false;         
        if($user)
            $this->user = $user;
        try{          
            $subscription =  $this->user->subscription($plan); 
            // dd('IR',$subscription);
            if ($this->user->subscription($plan)->cancelNow()) {
                $canceled = true;
                $this->user->subscription($plan)->status = 'canceled';
                $this->user->subscription($plan)->save();
                $this->user->subscription_ends_at = date('Y-m-d H:i:s');
                $this->user->is_subscribed = 'N';
                $this->user->save();  
            }
            $returnArr['success'] = $canceled; 
            return $returnArr;
        }catch (\Stripe\Error\Card $e) { 
            $body = $e->getJsonBody();
            $err  = $body['error'];             
            //array_push($returnArr, var)
            $message = trans('Physician::messages.subscription_error');    
            $returnArr['success'] = $canceled;
            $returnArr['message'] = $message;         
            return $returnArr; //redirect()->back()->with('error', $message);
        } catch (\Stripe\Error\InvalidRequest $e) { 
           $message = trans('Physician::messages.subscription_error');
           $returnArr['success'] = $canceled;
           $returnArr['message'] = $message;         
           return $returnArr; //return redirect()->back()->with('error', $message);              
        } catch (\Stripe\Error\Authentication $e) { 
            $message = trans('Physician::messages.subscription_error');           
            $returnArr['success'] = $canceled;
            $returnArr['message'] = $message;         
            return $returnArr;  //return redirect()->back()->with('error', $message);           
        } catch (\Stripe\Error\ApiConnection $e) {
            $message = trans('Physician::messages.subscription_error');           
            $returnArr['success'] = $canceled;
            $returnArr['message'] = $message;         
            return $returnArr;  //return redirect()->back()->with('error', $message);             
        } catch (\Stripe\Error\Base $e) {
            $message = trans('Physician::messages.subscription_error');            
            $returnArr['success'] = $canceled;
            $returnArr['message'] = $message;         
            return $returnArr; //return redirect()->back()->with('error', $message);             
        } catch (Exception $e) {
            $message = trans('Physician::messages.subscription_error');            
            $returnArr['success'] = $canceled;
            $returnArr['message'] = $message;         
            return $returnArr;  //return redirect()->back()->with('error', $message);           
        }
    }
    /**
     * Upgrade Subscription.
     * @param integer $cardnumber, $cvc , $month, $year
     * @param string Plan_id
     * @return \Illuminate\Support\Collection
     */
    public function upgrade($data)
    {       
        $upgraded = ['exception'=>1,'result'=>[]];  
        $plan = Plan::where('plan_id',$data['plan'])->first(); 
        try{
            if(0 == $data['token']) {
                if($data['stripeToken'])
                    $tokenId = $data['stripeToken'];
                else{
                    $token = $this->generateToken($data); 
                    $tokenId =  $token->id;
                } 
                $this->user->updateCard($tokenId);
            } 
            $activePlan = $this->user->activeSubscription;    
            $subscription =  $this->user->subscription($activePlan->name);         
            $upgrade = $subscription->swap($data['plan']);   
            $subscription->name = $data['plan'];
            $subscription->save(); 
            $this->user->subscription_ends_at = date('Y-m-d H:i:s',strtotime("$plan->period"));             
            if(0 == $data['token']) {
                if(isset($data['savedetails']) &&  $data['savedetails'] == '1') {
                    $this->user->default_card = $data['stripeCard']; 
                }else
                    $this->user->default_card = "";
            }
            $this->user->save(); 
            $upgraded['exception'] = 0;    
            return $upgraded;
        }catch (\Stripe\Error\Card $e) { 
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $message = trans('Physician::messages.subscription_error');  
            return $upgraded = ['exception'=>1,'result'=>response()->json([$err['param'] => $message], $e->getHttpStatus())]; 
        } catch (\Stripe\Error\InvalidRequest $e) { 
            $message = trans('Physician::messages.subscription_error');          
           return $upgraded = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
           
        } catch (\Stripe\Error\Authentication $e) {
            $message = trans('Physician::messages.subscription_error');            
            return $upgraded = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
          
        } catch (\Stripe\Error\ApiConnection $e) {
            $message = trans('Physician::messages.subscription_error');           
            return $upgraded = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
            
        } catch (\Stripe\Error\Base $e) {
            $message = trans('Physician::messages.subscription_error');            
            return $upgraded = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())]; 
            
        } catch (Exception $e) {
            $message = trans('Physician::messages.subscription_error');            
            return $upgraded = ['exception'=>1,'result'=>response()->json(["" => $message ], $e->getHttpStatus())];            
        }
    }  
    /**
     * To Create Token From Server side, Now token is genarating from client side
     *
     * @return \Illuminate\Support\Collection
     */
    public function generateToken($data)
    {                             
        return \Stripe\Token::create(
                array("card" => array(
                    "number" => $data['number'],
                    "exp_month" => $data['exp_month'],
                    "exp_year" => $data['exp_year'],
                    "cvc" => $data['cvc']
                ))
        ); 
    }     
}