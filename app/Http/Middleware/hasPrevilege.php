<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Sessions;
use App\Modules\Physician\Models\PermissionUser;

class hasPrevilege {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null) {
        $requestData = $request->all();
        $user = \App\User::find($request->user()->id);
        if ($permission == 'update_staff') {
            if ('D' == $user->user_role) {
                $isParent = \App\User::where(['id' => $requestData['id'], 'parent_id' => $request->user()->id])->first();
                if (!$isParent) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }
            }
            if (('S' == $user->user_role)) {
                $userObj = \App\User::where(['id' => $requestData['id']])->first();
                $return = false;                
                if($userObj) {
                    $return =  ($userObj->user_role == 'D') || ($userObj->parent_id != $user->parent_id);
                } 
                if (($requestData['id'] == $user->id) || $return ) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }
            }
        }
        if ($permission == 'delete_staff') {         
            $authUser = \Auth::user()->getUserId();
            if ('D' == $user->user_role) {
                            // $isParent = \App\User::where(['id' => $request->user_id, 'parent_id' => $authUser])->first();
                            // echo $request->user_id;exit;
                            $isParent = PermissionUser::where(['user_id' => $request->user_id, 'physician_id' => $authUser])->first(); 
                            // echo $isParent; exit;
                            if (!$isParent) {
                                Sessions::where('user_id', $request->user()->id)->delete();
                                return redirect('/');
                            }
                        }
             if (('S' == $user->user_role)) {
                $userObj = \App\User::where(['id' => $request->user_id])->first();
                $return = false;                
                if($userObj) {
                    $return =  ($userObj->user_role == 'D') || ($userObj->parent_id != $user->parent_id);
                } 
                if (($request->user()->id == $request->user_id) || $return ) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }
            }           
        }
        if ($permission == 'edit_staff') {         

            $authUser = \Auth::user()->getUserId();
            
            if ('D' == $user->user_role) 
            {
                /*echo $authUser.'****************';
                echo $request->user_id;
                exit;*/
               /* $isParent = PermissionUser::where(['permission_id' => 8,'user_id' => $request->user_id, 'physician_id' => $authUser])->first();
                if (!$isParent) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }*/

                //OLD LOGIC
                
                /*$isParent = \App\User::where(['id' => $request->user_id, 'parent_id' => $authUser])->first();
                if (!$isParent) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }*/
            }
             if (('S' == $user->user_role)) {
                $userObj = \App\User::where(['id' => $request->user_id])->first();
                $return = false;                
                if($userObj) {
                    $return =  ($userObj->user_role == 'D') || ($userObj->parent_id != $user->parent_id);
                }               
                if (($request->user()->id == $request->user_id) || $return ) {
                    Sessions::where('user_id', $request->user()->id)->delete();
                    return redirect('/');
                }
            }           
        }
        return $next($request);
    }
}