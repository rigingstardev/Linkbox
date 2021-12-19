<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
//Unlock user
use Illuminate\Support\Str;
use Illuminate\Cache\RateLimiter;
// Repositories
use App\Modules\Physician\Repositories\QuestionsRepository;
use App\Modules\Physician\Repositories\QuestionsCategoryRepository;
use App\Modules\Physician\Repositories\QuestionsOptionsRepository;
use App\Modules\Physician\Repositories\QuestionsUnpublishedRepository;
use App\Modules\Physician\Repositories\CategoryRepository;
use App\Modules\Physician\Repositories\NotificationsRepository;
use App\Modules\Physician\Repositories\PhysicianRepository;
use App\Modules\Admin\Repositories\PatientsRepository;
use Illuminate\Foundation\Auth\ThrottlesLogins;

// use Yajra\Datatables\Facades\Datatables;
use Yajra\DataTables\Facades\DataTables;
// use Auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
// use DB
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Requests\UploadImageRequest;
use Illuminate\Support\Facades\Config;
use App\Helpers\ImageResizeHelper;
// Mail Sending
use Mail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserUnlockNotify;
use App\Notifications\UserStatusChangeNotify;
use App\Notifications\QuestionUnpublishNotify;
use App\User;

class QuestionSetController extends Controller 
{
    use ThrottlesLogins;
    protected $qset_bg_img_path;
    protected $guard;
    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->guard = 'admin';
        Auth::shouldUse('admin');
        
        $this->questionsRepo     = new QuestionsRepository();
        $this->patientsRepo      = new PatientsRepository();
        $this->CategoryRepo      = new CategoryRepository();
        $this->notificationsRepo = new NotificationsRepository();
        $this->physicianRepo     = new PhysicianRepository();

        $this->questionsCategoryRepo    = new QuestionsCategoryRepository();
        $this->questionsOptionsRepo     = new QuestionsOptionsRepository();
        $this->questionsUnpublishedRepo = new QuestionsUnpublishedRepository();

        $this->qset_bg_img_path = public_path('uploads/question_set/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listpublishedQuestions(Request $request)
    {
        //get session data
        $userData             = Auth::user();
        $requestData          = $request->all();
        $inputData['setType'] = 'public';
//        $inputData['userType'] = 'Admin';
        // common function call to get public or private question set.
        $questionSets         = $this->questionsRepo->getQuestionList($inputData);
        // showing published question sets
        return Datatables::of($questionSets)
                ->editColumn('title', function($questionSets) use ($requestData) {
                    $return = '<div class="content-sub mrgn-btm-5 pdng-0" id="question-set-' . $questionSets->id . '">
   <div class="content-area-sub">
      <div class="col-sm-7 col-md-9 col-lg-10 q-list su-q-list">
         <img src="' . asset('assets/admin/images/question-set-icon.png') . '">
         <b>' . $questionSets->title . ' Question Set</b>
         <p class="mrgn-tp-5">' . $questionSets->description . '</p>
         <p class="mrgn-tp-25 italic">Created By: <a href="' . url('admin/physicianProfileView/' . $questionSets->user_id) . '"><span>' . $questionSets->name . '</span></a></p>
         <p class="mrgn-tp-5 italic">' . $questionSets->hospital_name . '</p>
         <div class="clearfix"></div>
      </div>
      <div class="col-sm-5 col-md-3 col-lg-2 q-optn">
         <button type="button" class="btn btn-third btn-block mrgn-btm-15" onclick="location.href = \'' . url('admin/editLibrary/' . Hashids::encode($questionSets->id)) . '\'">Open</button>
         <button type="button" class="btn btn-third btn-block mrgn-btm-25 " onclick="resetUnpublishPopup(' . $questionSets->id . ')" data-toggle="modal" data-target="#divUnpublish' . $questionSets->id . '" >Unpublish</button>
         <!-- start unpublish pop up-->
         <div id="divUnpublish' . $questionSets->id . '" class="modal modal-unpublish fade" tabindex="-1" role="dialog" aria-labelledby="divUnpublishReason' . $questionSets->id . '">
            <!-- start unpublish modal-->
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" id="divUnpublishReason' . $questionSets->id . '">Specify Reason to Unpublish</h4>
                  </div>
                  <div class="modal-body">
                     <textarea class="form-control" rows="4" autofocus="" cols="5" id="reason-' . $questionSets->id . '" placeholder="Reason" name="reason-' . $questionSets->id . '"></textarea>
                  </div>
                  <div class="modal-footer">
                     <div class="btn-wrap">
                        <button type="button" class="btn btn-default mrgn-lft-15" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="send_qsqt_btn_popup" onclick="setOrResetAdminOptions(\'upm\',' . $questionSets->id . ', \'unpublishMe\')">OK</button>
                     </div>
                  </div>
               </div>
               <!-- end unpublish modal-->
            </div>
            <!-- end unpublish pop up-->
         </div>
      </div>
   </div>
</div>';
                    return $return;
                })->make(true);
    }

    public function patientsList(Request $request)
    {
        //get session data
        $userData                  = Auth::user();
        $requestData               = $request->all();
        $inputData['selectFields'] = '';
        // common function call to get public or private question set.
        $patients                  = $this->patientsRepo->getPatients($inputData);
        // $id = Hashids::encode($patients->id);
        return Datatables::of($patients)
//                ->edit_column('slNo', function($patients) use ($requestData) {
//                    return '';//$patients->id;
//                })
                ->editColumn('first_name', function($patients) use ($requestData) {
                    return '<a href="' . url('admin/patientProfileView/' .  Hashids::encode($patients->id)) . '">' . $patients->first_name . ' ' . $patients->last_name . '</a>';
                })
                ->editColumn('email', function($patients) use ($requestData) {
                    return '<p class="txt-blue">' . $patients->email . '</p>';
                })
                ->editColumn('dob', function($patients) use ($requestData) {
                    return convertDateToMMDDYYYY($patients->dob, '/');
                })
                ->editColumn('', function($patients) use ($requestData) {
                    if ($patients->is_account_active == 'Y') {
                        $class      = 'label-active';
                        $classLabel = 'Active';
                    } else {
                        $class      = 'label-inactive';
                        $classLabel = 'Inactive';
                    }
                    return '<a id="patientStatus' . $patients->id . '" onclick="setOrResetAdminOptions(\'patient\',' . $patients->id . ', \'' . $classLabel . '\')" href="javascript:void(0)"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                })
                ->editColumn('isLocked', function($patients) use ($requestData) {
                    if ($patients->isLocked == 1) {
                        $class      = 'label-inactive';
                        $classLabel = 'Unlock';
                        return '<a id="patientLocked' . $patients->id . '" onclick="setOrResetAdminOptions(\'patient\' ,' . $patients->id . ', \'' . $classLabel . '\')" href="javascript:void(0)"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                    } else {
                        $class      = 'label-active';
                        $classLabel = 'Open';
                        return '<a id="patientLocked' . $patients->id . '"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                    }
                    
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('searchlist')) {
                        $instance->where(function ($query) use ($request) {
                            $searchString1 = trim($request->get('searchlist'));
                            if ($searchString1 != "") {
                                $query->where('first_name', 'like', "%{$searchString1}%");
                                $query->orWhere('last_name', 'like', "%{$searchString1}%");
                            }
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function editLibrary($id)
    { 
        $id = Hashids::decode($id);
        $id = $id[0];
        $userId             = '';
        $defaultOptions     = array();
        $allReceipients     = array();
        $questionCategories = array();
        $questionCategories = array();
        $selectedCategories = array();
        $masterQuestions    = array();
        $questionSets       = $this->questionsRepo->all($id, 0);
        $questionSet        = $questionSets;
        
        // getting the qestion category
        if (count((array)$questionSets) > 0) {
            // getting selected question category
            $selectedCategories = $this->questionsCategoryRepo->all(0, $id);
            // getting selected question category
            $questionCategories = $this->questionsCategoryRepo->getQuestions($id, 0);
            $qid                = $id;
            $inputData['qid']   = $id;
            // getting the default options of the questions
            $defaultOptions     = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, 0);
            return view("Admin::edit_library", compact('id', 'qid', 'questionSets', 'questionCategories', 'selectedCategories', 'defaultOptions', 'questionSet', 'defaultOptions'));
        }
    }



    public function physiciansListtest(Request $request) {
        //return \Datatables::of(User::query())->make(true);
        return DataTables::of(User::query())->make(true);
        // return true;
        // echo "test";
    }




    public function physiciansList(Request $request)
    { 
        //get session data
        $userData                = Auth::user();
        $requestData             = $request->all();
        $inputData['userType']   = 'D';
        $inputData['selectWith'] = 'PatientsCount';
        $inputData['getUsers']   = 'physicians';
        $inputData['listType']   = 'list';
       
        // common function call to get public or private question set.
        $users = $this->physicianRepo->getUsers($inputData);
        // print_r($users);die;
        // $userid = encrypt($users->id);
        return Datatables::of($users)
//                ->add_column('slNo', function($users) use ($requestData) {
//                     return '';
//                })
                ->editColumn('name', function($users) use ($requestData) {
                    return '<a href="' . url('admin/physicianProfileView/' . Hashids::encode($users->id)) . '">' . $users->name . '</a>';
                })
                ->editColumn('hospital_name', function($users) use ($requestData) {
                    return '<p class="txt-blue">' . $users->hospital_name . '</p>';
                })
                ->editColumn('last_logged_in', function($users) use ($requestData) {
                    return convertDateToMMDDYYYY($users->last_logged_in, 'withTime');
                })
                ->editColumn('id', function($users) use ($requestData) {

                    return '<span class="">' . $users->link_patients . '</span>';
                })

                ->editColumn('', function($users) use ($requestData) {
                    if ($users->is_account_active == 'Y') {
                        $class      = 'label-active';
                        $classLabel = 'Active';
                    } else {
                        $class      = 'label-inactive';
                        $classLabel = 'Inactive';
                    } 
                    return '<a id="physicianStatus' . $users->id . '" onclick="setOrResetAdminOptions(\'physician\' ,' . $users->id . ', \'' . $classLabel . '\')" href="javascript:void(0)"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                })
                ->editColumn('isLocked', function($users) use ($requestData) {
                    if ($users->isLocked == 1) {
                        $class      = 'label-inactive';
                        $classLabel = 'Unlock';
                        return '<a id="physicianLocked' . $users->id . '" onclick="setOrResetAdminOptions(\'physician\' ,' . $users->id . ', \'' . $classLabel . '\')" href="javascript:void(0)"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                    } else {
                        $class      = 'label-active';
                        $classLabel = 'Open';
                        return '<a id="physicianLocked' . $users->id . '"><span class="label ' . $class . '">' . $classLabel . '</span></a>';
                    }
                    
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('searchlist')) {
                        $instance->where(function ($query) use ($request) {
                            $searchString1 = trim($request->get('searchlist'));
                            if ($searchString1 != "") {
                                $query->where('users.name', 'like', "%{$searchString1}%");
                                $query->orWhere('users.hospital_name', 'like', "%{$searchString1}%");
                            }
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function updateFlagSettings(Request $request)
    {
    // use 

        if (!\Request::ajax())
            return redirect('admin/home');
        $requestData = $request->all();
        if ($requestData['uid'] > 0) {
            if ($requestData['flagType'] == 'sponsored' && ( $requestData['setFlag'] == 'Y' || $requestData['setFlag'] == 'N')) {
                $inputData['qid']      = $requestData['uid'];
                $input['is_sponsored'] = $requestData['setFlag'];
                $questionSets          = $this->questionsRepo->update($inputData, $input);
                if ($questionSets)
                    if ($requestData['setFlag'] == 'Y')
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Admin::messages.set_as_sponsored')));
                    else
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Admin::messages.removed_sponsored_settings')));
            }else if ($requestData['flagType'] == 'unpublishMe') {
                $input['visibility'] = 'private';
                $updateData['qid']   = $requestData['uid'];
                // updating database
                $unpublish           = $this->questionsRepo->update($updateData, $input);
                if ($unpublish) {
                    $inputData['question_id'] = $requestData['uid'];
                    $inputData['reason']      = $requestData['reason'];

                    $questionDetails = $this->questionsRepo->all($requestData['uid'], 0);
                    $receiverId      = $questionDetails->user_id;
                    $unpublish       = $this->questionsUnpublishedRepo->save($inputData);
                    $notification    = $this->notificationsRepo->save(array('question_id' => $requestData['uid'], 'notification_type' => 2, 'message' => $requestData['reason'], 'sender_id' => 1, 'sender_type' => 1, 'receiver_id' => $receiverId));
                    $this->notifyUnpublished($requestData['uid'], $questionDetails->user_id, $requestData['reason']);
                    return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Admin::messages.question_unpublished')));
                }
            } else if ($requestData['flagType'] == 'Active' || $requestData['flagType'] == 'Inactive') {

                if ($requestData['uType'] == 'patient') {
                    if ($requestData['flagType'] == 'Inactive') {
                        $changeStatusTo = 'Y'; // change to active
                        $returnMsg      = trans('Admin::messages.patient_activated');
                    } else {
                        $changeStatusTo = 'N';
                        $returnMsg      = trans('Admin::messages.patient_inactivated');
                    }
                    $inputData['id']                 = $requestData['uid'];
                    $updateData['is_account_active'] = $changeStatusTo;
                    $patients                        = $this->patientsRepo->updatePatients($inputData, $updateData);
                    if ($patients) {
                        $patient         = $this->patientsRepo->getPatientById($requestData['uid']);
                        $patient->status = $changeStatusTo;
                        $patient->notify(new UserStatusChangeNotify($patient));
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => $returnMsg));
                    }
                } else if ($requestData['uType'] == 'physician') {
                    if ($requestData['flagType'] == 'Inactive') {
                        $changeStatusTo = 'Y'; // change to active
                        $returnMsg      = trans('Admin::messages.physician_activated');
                    } else {
                        $changeStatusTo = 'N';
                        $returnMsg      = trans('Admin::messages.physician_inactivated');
                    }
                    $inputData['id']                 = $requestData['uid'];
                    $updateData['is_account_active'] = $changeStatusTo;
                    $users                           = $this->physicianRepo->updateUserProfile($inputData['id'], $updateData);
                    if ($users) {
                        $user             = $this->physicianRepo->getPhysicianById($requestData['uid']);
                        $user->status     = $changeStatusTo;
                        $user->first_name = $user->name;
                        $user->notify(new UserStatusChangeNotify($user));
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => $returnMsg));
                    }
                }
            } else if ($requestData['flagType'] == 'Unlock' ) 
            { 
                $userDetails = User::find($requestData['uid']); 
                $request->request->add(['email' => $userDetails['email'], 'name' => $userDetails['name'] ]); 
                $clear =  $this->clearLoginAttempts($request);
                if ($requestData['uType'] == 'patient') {
                    $changeStatusTo = '0'; // change to active
                    $returnMsg      = trans('Admin::messages.patient_unlocked');
                 
                    $inputData['id']                 = $requestData['uid'];
                    $updateData['isLocked']          = $changeStatusTo;
                    $patients                        = $this->patientsRepo->unlockPatient($inputData, $updateData);
                    if ($patients) {
                        $patient         = $this->patientsRepo->getPatientById($requestData['uid']);
                        $patient->status = $changeStatusTo;
                        $patient->first_name = $user->name;
                        $patient->notify(new UserUnlockNotify($patient));
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => $returnMsg));
                    }
                } else if ($requestData['uType'] == 'physician') {
                    
                    $changeStatusTo = '0'; // unlock user
                    $returnMsg      = trans('Admin::messages.physician_unlocked');
                     
                    $inputData['id']                 = $requestData['uid'];
                    $updateData['isLocked']          = $changeStatusTo;
                    $users                           = $this->physicianRepo->unlockPhysician($inputData['id'], $updateData);
                    if ($users) {
                        $user             = $this->physicianRepo->getPhysicianById($requestData['uid']);
                        $user->status     = $changeStatusTo;
                        $user->first_name = $user->name;
                        $user->notify(new UserUnlockNotify($user));
                        return json_encode(array('status' => 401, 'success' => 'true', 'message' => $returnMsg));
                    }
                }
            }
        }
    }

    public function clearThrottle(Request $request) {
        // $this->clearLoginAttempts($request);
        // Forward elsewhere or display a view
        ThrottlesLogins::limiter()->clear($this->throttleKey($request));
    }

    /**
     * Uploading profile image
     *
     * @return Response
     */
    public function uploadBgImage(UploadImageRequest $request)
    {
        $qset_id                   = $request->qset_id;
        $imageName                 = $qset_id . '_' . time() . Config::get('settings.qset_bg_img_prefix') . '.' . $request->bg_image->getClientOriginalExtension();
        $request->bg_image->move(Config::get('settings.qset_bg_img_path'), $imageName);
        $userData['profile_image'] = $imageName;
        $this->questionsRepo->updateBgImage($qset_id, $imageName);
        Session::flash('success', trans('custom.profile_image_update_success'));
    }

    /**
     * Send unpublished notification mail to user
     *
     * @return Response
     */
    public function notifyUnpublished($quesId, $userId, $reason)
    {
        $physician           = $this->physicianRepo->getPhysicianById($userId);
        $question            = $this->questionsRepo->all($quesId, $userId);
        $physician->question = $question->title;
        $physician->reason   = $reason;
        $physician->notify(new QuestionUnpublishNotify($physician));
    }

     /**
     * Unlock User from Admin
     *
     * @param $request
     */

    public static function clearLoginAttempts(Request $request) {
        self::limiter()->clear(self::throttleKey($request));
    }
 
    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    public static function limiter()
    {
        return app(RateLimiter::class);
    }
    
    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public static function throttleKey(Request $request)
    {
        $request = $request->all();
        $email = $request['email'];
        $ip = \Request::ip();
        return Str::lower($email).'|'.$ip;
    }
}
