<?php
namespace App\Modules\Physician\Controllers;

use Twilio\Rest\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Physician\Models\Speciality;
use App\Modules\Physician\Models\Physician;
use Vinkla\Hashids\Facades\Hashids;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
use Illuminate\Support\Facades\DB;
// Repository list
//-------- category & questions master -----------------
use App\Modules\Physician\Repositories\CategoryRepository;
use App\Modules\Physician\Repositories\CategoryQuestionsRepository;
use App\Modules\Physician\Repositories\PhysicianRepository;
use App\Modules\Physician\Repositories\QuestionsRepository;
use App\Modules\Physician\Repositories\QuestionsCategoryRepository;
use App\Modules\Physician\Repositories\QuestionsOptionsRepository;
use App\Modules\Physician\Repositories\QuestionNarrativeOutputRepository;
use App\Modules\Physician\Repositories\CategoryNarrativeOutputRepository;
use App\Modules\Physician\Repositories\QuestionReceipientsRepository;
use App\Modules\Physician\Repositories\NotificationsRepository;
use App\Modules\Physician\Repositories\PatientRepository;
use App\Modules\Physician\Repositories\SocialHistoryRepository;
// Requests
use App\Modules\Physician\Requests\CreateQuestionSetRequest;
use App\Modules\Physician\Requests\AnswerMethodRequest;
use App\Modules\Physician\Requests\ProfileUpdateRequest;
use App\Modules\Physician\Requests\ChangePasswordRequest;
use App\Modules\Physician\Requests\EditImageRequest;
use App\Modules\Physician\Requests\DeleteQSRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Practice;
use App\Helpers\ImageResizeHelper;
use Illuminate\Support\Facades\Config;
use App\Modules\Physician\Requests\SendQuestionSetRequest;
use App\Notifications\SendQuestionNotify;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\QuestionSetSms;
use Illuminate\Support\Facades\Mail;
use App\Mail\SummaryReport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;

use App\Modules\Physician\Models\Permissions;
use App\Modules\Physician\Models\Menus;
use App\Modules\Physician\Models\PermissionUser;

class PhysicianController extends Controller
{

    protected $categoryRepo;
    protected $phy_profile_img_path;

    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->categoryRepo                = new CategoryRepository();
        $this->CategoryQuestionsRepo       = new CategoryQuestionsRepository();
        $this->questionsRepo               = new QuestionsRepository();
        $this->questionsCategoryRepo       = new QuestionsCategoryRepository();
        $this->questionsOptionsRepo        = new QuestionsOptionsRepository();
        $this->questionsOptionsRepo        = new QuestionsOptionsRepository();
        $this->questionNarrativeOutputRepo = new QuestionNarrativeOutputRepository();
        $this->categoryNarrativeOutputRepo = new CategoryNarrativeOutputRepository();
        $this->patientRepo                 = new PatientRepository();
        $this->questionReceipientsRepo     = new QuestionReceipientsRepository();
        $this->socialHistoryRepo           = new SocialHistoryRepository();

        $this->phy_profile_img_path = public_path('uploads/physician/');
                
        $this->middleware(function ($request, $next)
        {
            $this->paysicianid = \Session::get('physician_id');
            return $next($request);
        });
    }

    /**
     * Display patient registration form.
     *
     * @return Response
     */
    public function register()
    {
        $data['practice_list'] = Practice::orderBy('name', 'asc')->pluck('name', 'id');
        $data['speciality_list'] = Speciality::orderBy('name', 'asc')->pluck('name', 'id');
        return view("Physician::register")->with(['data' => $data]);
    }

    /**
     * To view the Dashboard
     *
     * @return Response
     */
    public function dashboard()
    {
        return view("Physician::dashboard");
    }

    /**
     * Post login.
     *
     * @return Response
     */
    public function home()
    {

        //get session data
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        return view("Physician::home");
    }

    public function getQuestionSets(Request $request)
    {
        //get session data
        $userData = Auth::user();
        $userId      = $this->paysicianid;
        $requestData = $request->all();
        // if ('S' == $userData->user_role)
            // $userId      = $userData->parent_id;

        // get question set
        $permCls = (hasPermission()) ? '' : 'nopermission';
        // checking for published question set only
        if (key_exists('setType', $requestData) && $requestData['setType'] == 'public') {
            //---------------------- need to check the user is subscribed user or not.
            $inputData['setType'] = 'public';
        } else
            $inputData['user_id']    = $userId;
        $inputData['returnType'] = 'Datatable';
        // common function call to get public or private question set.
        $questionSets            = $this->questionsRepo->getQuestionList($inputData); //getQuestions($userId);
        if (key_exists('setType', $requestData) && $requestData['setType'] == 'public') {
            // showing published question sets
            return Datatables::of($questionSets)
                    ->editColumn('title', function($questionSets) use ($requestData) {
                        $return = '<div class="content-sub mrgn-btm-20">
                                    <div class="col-sm-7 col-md-9 col-lg-10 q-list">
                                        <img src="' . asset('assets/physician/images/question-set-icon.png') . '"/>
                                        <b>' . $questionSets->title . ' Question Set</b>
                                        <p>' . $questionSets->description . '</p>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-sm-5 col-md-3 col-lg-2 q-optn">';
                        if ($questionSets->is_sponsored == 'Y')
                            $return = $return . '<label class="sponsored mrgn-btm-25"><i class="fa fa-star" aria-hidden="true"></i> Sponsored</label>';
                        // checking if list is shown in create question set page with the use this question button
                        if (key_exists('showUseButton', $requestData) && $requestData['showUseButton'] == '1') {
                            $return .= '<button type="button" class="btn btn-third btn-block mrgn-btm-15" title="Preview"
                                        onclick="location.href =\'' . url('physician/questionSetPreview/' . Hashids::encode($questionSets->id) . '/create-set') . '\'">Preview</button>';
                            if (Auth::user()->isAuthorizedStaff('')) {
                                $return .='<button type="button" class="btn btn-third btn-block"  title="Send"
                                            onclick="location.href= \'' . url('physician/use-the-question-set/' . Hashids::encode($questionSets->id)) . '\'">Use this Question Set</button>';
                            }
                        } else {
                            // listing the published quetsion sets
                            $return .= '<button type="button" class="btn btn-third btn-block mrgn-btm-15" title="Preview"
                                        onclick="location.href =\'' . url('physician/questionSetPreview/' . Hashids::encode($questionSets->id) . '/published-list') . '\'">Preview</button>';
                            if (Auth::user()->isAuthorizedStaff('questionset_send')) {
                                $return .= '<button type="button" class="btn btn-third btn-block"  title="Send"
                                        onclick="location.href = \'' . url('physician/sendQuestionSet/' . Hashids::encode($questionSets->id)) . '\'">Send</button>';
                            }
                        }
                        $return .= ' </div>
                                </div>';
                        return $return;
                    })->make(true);
        } else {  // showing all question sets without any filtering
            return Datatables::of($questionSets)
                    ->editColumn('title', function($questionSets) use ($permCls) {
                        return '<a href="' . url('physician/question-set-detail/' . $questionSets->id) . '"  class="txt-blue ' . $permCls . '">'
                            . $questionSets->title . ' Question Set</a><p class="txt-sm">Created  ' . convertDateToMMDDYYYY($questionSets->created_at, '') . '</p>';
                    })
                    ->editColumn('modified', function($questionSets) {
                        return convertDateToMMDDYYYY($questionSets->updated_at, '');
                    })
                    ->editColumn('edit', function($questionSets) use ($permCls) {
                        if (Auth::user()->isAuthorizedStaff(''))
                            return '<a href="' . url('physician/question-set-detail/' .$questionSets->id . '/edit') . '" class="edit ' . $permCls . '" title="Edit" >'
                                . '<i class="fa fa-pencil-square-o" ></i></a>';
                    })
                    ->addColumn('testpreview', function($questionSets) use ($permCls) {
                        // if (Auth::user()->isAuthorizedStaff(''))
                            // return '<a href="' . url('physician/question-set-detail/' .$questionSets->id . '/show') . '" class="btn btn-default read-more clear-div" title="Test Preview" >'
                                // . ' Test Preview</a>';
                                return '<a href="#" class="btn btn-default read-more clear-div testPreviewModal" data-toggle="modal" data-question_set_id='. Hashids::encode($questionSets->id) .' data-target="#testPreviewModal" title="Test Preview">'
                                . 'Preview</a>';
                            
                    })
                    ->editColumn('visibility', function($questionSets) {
                        $changeStatusTo = 'Private';
                        if ($questionSets->visibility == 'private') {
                            $cls            = 'label-private';
                            $changeStatusTo = 'Public';
                        } else
                            $cls = 'label-public';
                        if (Auth::user()->isAuthorizedStaff(''))
                            return '<a href="javascript:void(0)"><span onclick="setQuestionFlags(\'visibility\',\'' . $changeStatusTo . '\',0,' . $questionSets->id . ')" id="changeQestion' . $questionSets->id . '" class="label ' . $cls . ' ">' . ucwords($questionSets->visibility) . '</span></a>';
                    })
                    ->addColumn('duplicate', function($questionSets) use ($permCls) {
                        if (Auth::user()->isAuthorizedStaff(''))
                            return '<a href="javascript:void(0)" onclick="duplicateQuestion()"><button type="button" class="btn btn-default read-more clear-div" data-toggle="modal" data-target="#duplicateQSet' . $questionSets->id . '" >Copy</button></a>
                        <!-- start duplicate pop up-->
                        <div id="duplicateQSet' . $questionSets->id . '" class="modal fade popup-div" tabindex="-1" role="dialog" aria-labelledby="duplicateQSetReason' . $questionSets->id . '">
                           <!-- start duplicate modal-->
                           <div class="modal-dialog" role="document" style="width:400px;">
                              <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="duplicateQSetReason' . $questionSets->id . '">Copy ' . $questionSets->title . ' Question set</h4>
                                </div>
                                <div class="modal-body">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control autoComplete" autofocus="" id="title' . $questionSets->id . '" placeholder="Question set Title" name="title' . $questionSets->id . '"/>
                                        </div>
                                        <div class="clearfix"></div>
                                </div>
                                <div class="modal-footer">

                                       <button type="button" class="btn btn-default mrgn-lft-15" data-dismiss="modal">Cancel</button>
                                       <button type="button" class="btn btn-primary" id="send_qsqt_btn_popup" onclick="setQuestionFlags(\'duplicate\',0,0,' . $questionSets->id . ')">Submit</button>

                                </div>
                              </div>
                           </div> <!-- end duplicate modal  -->
                        </div><!-- end duplicate pop up -->';
                    })
                    ->editColumn('steps_completed', function($questionSets) use ($permCls) {
                        if (Auth::user()->isAuthorizedStaff('questionset_send'))
                            return '<a href="' . url('physician/sendQuestionSet/' . Hashids::encode($questionSets->id)) . '" class="' . $permCls . '"><button type="button" class="btn btn-default read-more">Send</button></a>';
                    })
                    ->addColumn('delete', function($questionSets) use ($permCls) {
                        if (Auth::user()->isAuthorizedStaff('questionset_send'))
                            return '<a href="javascript:void(0)" onclick="deleteQS(' . $questionSets->id . ')" class="' . $permCls . '"><button type="button" class="btn btn-default read-more" id="delete_btn_qs' . $questionSets->id . '" >Delete</button></a>';
                    })
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('search')) {
                            $instance->where(function ($query) use ($request) {
                                $searchString1 = trim($request->get('search'));
                                if ($searchString1 != "") {
                                    $query->where('title', 'like', "%{$searchString1}%");
                                    $query->orWhere('description', 'like', "%{$searchString1}%");
                                    // $query->orWhere('questions.created_at', 'like', "%{$searchString1}%");
                                    // $query->orWhere('questions.updated_at', 'like', "%{$searchString1}%");
                                }
                            });
                        }
                    })
                    ->make(true);
        }
    }

    /**
     * Post login.
     *
     * @return Response
     */
    public function postLogin()
    {
        return view("Physician::home");
    }

    /**
     * Listing question sets
     *
     * @return Response
     */
    public function questionSet()
    {
        //get session data
        $userData             = Auth::user();
        //$userId             = $userData['id'];
        $userId               = $this->paysicianid;
        // get published question set .
        $inputData['user_id'] = $userId;
        $inputData['setType'] = 'public';
        $questionSets         = $this->questionsRepo->getQuestionList($inputData);
        return view("Physician::question_set", compact('questionSets'));
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function questionSetPreview($id)
    {
        //get session data
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        $id = Hashids::decode($id);
        $id = $id[0];
        // get public queuestion question set .
        if (\Request::segment(4) == 'published-list' || \Request::segment(4) == 'create-set') {
            $questionSets       = $this->questionsRepo->all($id, 0);
            // getting the qestion category
            $questionCategories = $this->questionsCategoryRepo->all(0, $id); //all($userId, $qid)getQuestions($id, 0);
            $selectedCategories = $questionCategories;
            $questionSet        = $questionSets;
            $inputData['qid']   = $id;
            $defaultOptions     = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, 0);
        } else {
            $questionSets       = $this->questionsRepo->all($id, $userId);
            // getting the qestion category
            $questionCategories = $this->questionsCategoryRepo->all(0, $id); //getQuestions($id, $userId);
            $selectedCategories = $questionCategories;
            $questionSet        = $questionSets;
            $inputData['qid']   = $id;
            $defaultOptions     = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, $userId);
            if (!$questionSets)
                return redirect('/physician/home');
        }
        return view("Physician::question_set_preview", compact('questionSets', 'questionSet', 'questionCategories', 'defaultOptions', 'selectedCategories'));
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function sendQuestionSet($questionId, Request $request)
    { 
        //get session data
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        // get question set .
        $questionId = Hashids::decode($questionId);
        $questionId = $questionId[0];
        $questionSets = $this->questionsRepo->all($questionId, 0);
        if ($questionSets->user_id != $userId) {
            $id              = $questionId;
            $inputData['id'] = $id;
            $checkQuestion   = $this->questionsRepo->getQuestionList($inputData);
            if (count((array)$checkQuestion) > 0) {
                foreach ($checkQuestion as $row)
                    $prevUserId = $row->user_id;

                $newQuestion = $this->questionsRepo->replicateQuestion($id, $userId);

                if ($newQuestion) {
                    //getting the master questions list of master question set
                    $allQuestions                = $this->questionsCategoryRepo->getQuestions($id, 0);
                    $reqData['qid']              = $id;
                    // settings to indicate that question set is created by use this question set method
                    $reqData['createType']       = 'useThisSet';
                    $reqData['prevUserId']       = $prevUserId;
                    $reqData['currentUserId']    = $userId;
                    $reqData['newQuestionSetId'] = $newQuestion->id;
                    foreach ($allQuestions as $ques) {
                        $reqData['rid'] = $ques->id;
                        $reqData['cid'] = $ques->category_id;
                        $result         = $this->questionsCategoryRepo->copyQuestionFlags($reqData, $prevUserId);
                        if ($result) {
                            $defaultOptions          = $this->questionsCategoryRepo->getQuestionCategoryOptions($reqData, $prevUserId);
                            $reqData['qid']          = $newQuestion->id;
                            $reqData['rid']          = $result->id;
                            $resultOption            = $this->questionsCategoryRepo->copyCategoryDefaultOptions($reqData, $prevUserId, $defaultOptions);
                            $reqData['qid']          = $id;
                            $copyReqData['newId']    = $result->id;
                            $copyReqData['rid']      = $ques->id;
                            $copyReqData['flagType'] = 'copy';
                            $narrativeOp             = $this->questionsCategoryRepo->copyCategoryNarrativeOutput($copyReqData, $userId);
                        }
                    }
                }
            }
            return redirect('/physician/sendQuestionSet/' . Hashids::encode($newQuestion->id));
        }
        return view("Physician::send_question_set")->with(['question_id' => $questionId, 'questionSets' => $questionSets]);
    }

    /**
     * Get send questions request
     *
     * @return Response
     */
    public function resendQuestionSet(Request $request)
    {
        $requestData                 = $request->all();
        $requestData['physician_id'] = $this->paysicianid;
        // flag for Resending the question set
        $requestData['sendType']     = 'Resend';
        $return                      = $this->sendQuestionSetToRecipient($requestData);
        if ($return)
            return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Physician::messages.questionaire_send_success')));
    }

    /**
     * Get send questions request
     *
     * @return Response
     */
    public function validateSendQuestionSet(SendQuestionSetRequest $request)
    {
        return 'true';
    }

    /**
     * Get send questions request
     *
     * @return Response
     */
    public function postSendQuestionSet(SendQuestionSetRequest $request)
    {
        $requestData = $request->all();
        
        // flag for  sending the question set for the first time
        $requestData['sendType'] = 'Send';
        if ($requestData['selectType'] == 'single') {
            $requestData['physician_id'] = $this->paysicianid;
            $this->sendQuestionSetToRecipient($requestData);
            // Session::flash('success', trans('Physician::messages.questionaire_send_success'));
            return json_encode(array('status' => 200, 'success' => 'true', 'message' => trans('Physician::messages.questionaire_send_success')));
        } else if ($requestData['selectType'] == 'list') {
            $totalRows                  = $requestData['totalRows'];
            $inputData['chkBxEmail']    = 'email';
            $inputData['customMessage'] = $requestData['customMessagePopUp'];
            $inputData['selectType']    = $requestData['selectType'];
            $inputData['question_id']   = $requestData['question_id'];
            $inputData['physician_id']  = $this->paysicianid;
            ;
            for ($k = 1; $k <= $totalRows; $k++) {
                if (array_key_exists('checkPatient' . $k, $requestData)) {
                    $inputData['email'] = $requestData['checkPatient' . $k];
                    $this->sendQuestionSetToRecipient($inputData);
                }
            } 
            return json_encode(array('status' => 200, 'success' => 'true', 'message' => trans('Physician::messages.questionaire_send_success')));
        }
    }

    /**
     * Submit send questions
     *
     * @return Response
     */
    public function sendQuestionSetToRecipient($requestData)
    {
        // Resending the question set
        if ((key_exists('sendType', $requestData) && $requestData['sendType'] == 'Resend')) {
            $patient                   = $this->questionReceipientsRepo->resendToPatient($requestData);
            if ($patient->entry_type == 'T')
                $requestData['chkBxText']  = 'text';
            else
                $requestData['chkBxEmail'] = 'email';
        } else
        // sending question set for the first time.
            $patient = $this->questionReceipientsRepo->sendToPatient($requestData);

        // checking if the custom message is not there. In Resend qeustion set, custom message option is not available
        if (!key_exists('customMessage', $requestData))
            $requestData['customMessage'] = '';
        if (is_object($patient)) {
            $data = array('name' => $patient->name, 'user_exists' => TRUE, 'customMessage' => $requestData['customMessage']);
            if (key_exists('chkBxEmail', $requestData) && $requestData['chkBxEmail'] == 'email') {
                $return = $patient->notify(new SendQuestionNotify($data));
            } else if (key_exists('chkBxText', $requestData) && $requestData['chkBxText'] == 'text') {
                // send sms
                //$patient->phone_number = $patient->contact_number;
                $patientObj->phone_number = '+' . $requestData['country_code'] . $requestData['phone'];
                // $return                   = $patient->notify(new QuestionSetSms($data));
                $return = $this->sendMessage($requestData['customMessage'], $patientObj->phone_number);
            }
        } else {
            $data       = array('user_exists' => FALSE, 'uuid' => $patient, 'customMessage' => $requestData['customMessage']);
            $patientObj = new \App\Modules\Physician\Models\Patient;
            if (key_exists('chkBxEmail', $requestData) && $requestData['chkBxEmail'] == 'email') {
                $patientObj->email = $requestData['email'];
                $return            = $patientObj->notify(new SendQuestionNotify($data));
            } else if (key_exists('chkBxText', $requestData) && $requestData['chkBxText'] == 'text') {
                // send sms
                //$patientObj->phone_number = $requestData['phone']; // $patientObj->contact_number;
                $patientObj->phone_number = '+' . $requestData['country_code'] . $requestData['phone']; // $patientObj->contact_number;
                $return = $this->sendMessage($requestData['customMessage'], $patientObj->phone_number);
                // $return                   = $patientObj->notify(new QuestionSetSms($data));
            }
        }
        return true;
    }


    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients string or array of phone number of recepient
     */
    private function sendMessage($message, $recipients)
    {
        $message = 'Dr. ' . ucwords(Auth::user()->name) . ' has sent you a few questions to answer prior to your office visit.  ' . $message . ' Please visit site ' . url('/') . ' for further details. ';

        // Tested with Kristian Account
        // $account_sid = 'AC5677443a4607bfbeebea6f7467e8e155';
        // $auth_token = '4570bc027283b2e65bed828b35b199db';
        // $twilio_number = '+13518881191';

        $account_sid = getenv('TWILIO_ACCOUNT_SID');
        $auth_token = getenv('TWILIO_AUTH_TOKEN');
        $twilio_number = getenv('TWILIO_FROM');
        try{
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($recipients, 
                    ['from' => $twilio_number, 'body' => $message] );
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
    }

    /**
     * edit question settings
     *
     * @return
     */
    public function editQustionSettings(Request $req)
    {
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        $reqData  = $req->all();
        $rid      = $reqData['rid'];
        $cid      = $reqData['cid'];
        $qid      = $reqData['qid'];
        $serialNo = $reqData['i'];
        $result   = $this->questionsCategoryRepo->getQuestionCateogySettings($reqData, $userId);

        return view("Physician::edit-question", compact('rid', 'cid', 'qid', 'result', 'serialNo'));
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function patientDetails()
    {
        return view("Physician::patient_details");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function viewMedicalRecord($id)
    {
        $id = Hashids::decode($id);
        $id = $id[0];
        if (!(Auth::user()->isAuthorizedStaff('patient_medicalRecordsList')))
            return redirect()->back()->with('error', trans('Physician::messages.permission_error'));

        $patientDetails = $this->patientRepo->getData($id);
        $socialHistory  = $this->socialHistoryRepo->getSocialHistory($id);

        if (count((array)$patientDetails) > 0)
            return view("Physician::view_medical_record", compact('patientDetails', 'socialHistory'));
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function patientQuestionSetDetail()
    {
        return view("Physician::patient_question_set_detail");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function postPatientQuestionSetDetail()
    {
        return view("Physician::patient_details");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function summaryReport()
    {
        return view("Physician::summary_report");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function evaluationReport()
    {
        return view("Physician::evaluation_report");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function listNotifications()
    {

        return view("Physician::notifications");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function getNotificationsList(Request $request, NotificationsRepository $notificationsRepo)
    {
        $userData              = Auth::user();
        $sendData['request']   = $request->all();
        $sendData['user']      = $userData;
        $requestData           = $sendData['request'];
        $requestData['userId'] = $userData->id;
        $notications           = $notificationsRepo->getData($sendData);

        if (key_exists('queryType', $requestData) && $requestData['queryType'] == 'count') {
            if ($sendData['request']['listType'] == 'Clinical')
                $sendData['request']['listType'] = 'Admin';
            else if ($sendData['request']['listType'] == 'Notifications')
                $sendData['request']['listType'] = 'Approvals';
            $notications2                    = $notificationsRepo->getData($sendData);

            return ($notications + $notications2) . '###' . $notications . '###' . $notications2;
        } else {
            return Datatables::of($notications)
                    ->editColumn('name', function($notications) use ($requestData, $notificationsRepo) {
                        if ($requestData['listType'] == 'Admin') {
                            if ($notications->is_seen)
                                $return = '<div id="divPanel' . $notications->id . '" class="panel panel-default mrgn-tp-15">';
                            else
                                $return = '<div id="divPanel' . $notications->id . '" class="panel panel-default unread mrgn-tp-15">';
                            $return .= '<div class="panel-heading">
                                        <h4 class="panel-title">';
                            if ($notications->is_seen)
                                $return .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $notications->id . '">';
                            else
                                $return .= '<a class="accordion-toggle" data-toggle="collapse" onclick="markAsRead(' . $notications->id . ')" data-parent="#accordion" href="#collapse' . $notications->id . '">';

                            $return .= trans('Physician::messages.admin_has_unpublished_part1') . '<b>' . $notications->getQuestionSet->title . ' Question Set</b>' . trans('Physician::messages.admin_has_unpublished_part2') . '<span>' . convertDateToMMDDYYYY($notications->created_at, 'at') . '</span>
                                 </a>
                              </h4>
                              <a href="javascript:void(0);" class="deleteNotification" data-nottype="admin" data-url="'. route('physician.notifications.delete', $notications->id).'">
                                <i class="fa fa-trash-o"></i>
                              </a>
                           </div>
                           <div id="collapse' . $notications->id . '" class="panel-collapse collapse">
                              <div class="panel-body">
                                 <p><b>Reason Specified:</b> ' . $notications->message . '</p>
                              </div>                              
                           </div>
                        </div>';
                        } else if ($requestData['listType'] == 'Clinical') {
                            if ($notications->is_seen)
                                $return = '<div class="panel panel-default mrgn-tp-15">';
                            else
                                $return = '<div class="panel panel-default unread mrgn-tp-15">';
                            $return .= '<div class="panel-heading">
                            <h4 class="panel-title">' . trans('Physician::messages.' . $notications->message) . '<b>' . $notications->name . '</b> for the <b>';
                            if ($notications->is_seen)
                                $return .= $notications->title . ' </b>Question Set.';
                            else
                                $return .= '<a href="' . url('physician/patients/' . Hashids::encode($notications->question_recipients_id) . '/questionset') . '" >' . $notications->title . '</a></b> Question Set.';
                            $return .= '<span>' . convertDateToMMDDYYYY($notications->created_at, 'at') . '</span>
                               </h4>
                               <a href="javascript:void(0);" class="deleteNotification" data-nottype="clinical" data-url="'. route('physician.notifications.delete', $notications->id).'">
                               <i class="fa fa-trash-o"></i>
                               </a>
                            </div>
                         </div>';
                            if ($notications->is_seen == 0) {
                                $inputData['nid']      = $notications->id;
                                $inputData['userId']   = $requestData['userId'];
                                $inputData['is_seen']  = 0;
                                $updateData['is_seen'] = 1;
                                $notications           = $notificationsRepo->updateData($inputData, $updateData);
                            }
                        }
                        return $return;
                    })->make(true);
        }
    }

    /**
     * update Notification
     *
     * @return Response
     */
    public function updateNotification(Request $request, NotificationsRepository $notificationsRepo)
    {
        $userData              = Auth::user();
        $sendData              = $request->all();
        $inputData['nid']      = $sendData['nid'];
        $inputData['userId']   = $userData->id;
        $inputData['is_seen']  = 0;
        $updateData['is_seen'] = 1;
        $notications           = $notificationsRepo->updateData($inputData, $updateData);
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function profile()
    {
        $data['physician']                = Physician::where('id', Auth::id())->where('user_role', 'D')->first();
        $data['speciality_list']          = Speciality::pluck('name', 'id');
        $data['physician']->profile_image = ($data['physician']->profile_image != '') ? asset('uploads/physician/' . config('settings.thumb_prefix') . $data['physician']->profile_image) : asset('assets/dummy-profile-pic.png');
        return view("Physician::profile", compact('data'));
    }

    /**
     * Profile updating
     *
     * @return Response
     */
    public function postProfile(ProfileUpdateRequest $request)
    {
        $postData['name']                = $request->input('physician_name');
        $postData['email']               = $request->input('email');
        $postData['speciality_id']       = $request->input('speciality');
        $postData['hospital_name']       = $request->input('hospital_name');
        $postData['npi_number']          = $request->input('npi_number');
        $postData['city']                = $request->input('city');
        $postData['contact_number']      = '+' . (ltrim($request->input('country_code') . "-" . $request->input('contact_number'), '+'));
        $postData['profile_description'] = $request->input('profile_description');
        Physician::where('id', Auth::id())->where('user_role', 'D')
            ->update($postData);
        Session::flash('success', trans('Physician::messages.profile_update_success'));
    }

    /**
     * Change password
     *
     * @return Response
     */
    public function postChangePwd(ChangePasswordRequest $request)
    {
        $current_password = Auth::User()->password;
        if (Hash::check($request['old_password'], $current_password)) {
            $user_id            = Auth::User()->id;
            $obj_user           = User::find($user_id);
            $obj_user->password = Hash::make($request['password']);
            $obj_user->save();
            Session::flash('success', trans('Physician::messages.password_change_success'));
        } else {
            return json_encode(array('status' => 401, 'success' => false, 'message' => trans('Physician::messages.old_password_mismatch')));
        }
    }

    /**
     * Uploading profile image
     *
     * @return Response
     */
    public function editProfileImage(EditImageRequest $request)
    {
        $user_id                   = Auth::User()->id;
        $imageName                 = $user_id . '_' . time() . Config::get('settings.phy_profile_img_prefix') . '.' . $request->profile_image->getClientOriginalExtension();
        ImageResizeHelper::resizeImage($request->profile_image->getRealPath(), $imageName, 'thumb', Config::get('settings.phy_profile_img_path'));
        ImageResizeHelper::resizeImage($request->profile_image->getRealPath(), $imageName, 'icon', Config::get('settings.phy_profile_img_path'));
        $request->profile_image->move($this->phy_profile_img_path, $imageName);
        $userData['profile_image'] = $imageName;
        Physician::where('id', Auth::id())->where('user_role', 'D')
            ->update($userData);
        Session::flash('success', trans('Physician::messages.profile_image_update_success'));
    }

    public function updateMenuSettings(Request $req, PhysicianRepository $physicianRepo)
    {
        $userData = Auth::User();
        $menuType = $userData->left_menu_display_type;

        if ($menuType == 1)
            $inputData['left_menu_display_type'] = 0;
        else
            $inputData['left_menu_display_type'] = 1;

        $return = $physicianRepo->updateUserProfile($userData->id, $inputData);
    }

    public function deleteQuestionSet(DeleteQSRequest $req, QuestionsRepository $questionsRepo)
    {
        $inputData = $req->all();
        if ($inputData['qid'] > 0) {
            $input['active']      = 'N';
            $inputData['uType']   = 'Own';
            $inputData['user_id'] = Auth::User()->id;
            $return               = $questionsRepo->update($inputData, $input);
            if ($return)
                return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Physician::messages.delete_qs_success')));
            else
                return json_encode(array('status' => 401, 'success' => 'false', 'message' => trans('Physician::messages.delete_qs_failed')));
        } else
            return json_encode(array('status' => 401, 'success' => 'false', 'message' => trans('Physician::messages.delete_qs_failed')));
    }    
    /**
     * Delete Notification
     * @param int id- Notification Id
     * @return Response
     */
    public function deleteNotification(Request $request, NotificationsRepository $notificationsRepo)
    {
        $notificationId = $request->id;        
        if (!empty($notificationId)) {
            $user['receiver_type']  = 1;  
            $user['receiver_id']  = Auth::User()->id;  
            $return               = $notificationsRepo->delete($notificationId,$user);            
            if ($return)
                return json_encode(array('status' => 401, 'success' => 'true', 'message' => trans('Physician::messages.delete_qs_success')));
            else
                return json_encode(array('status' => 401, 'success' => 'false', 'message' => trans('Physician::messages.delete_qs_failed')));
        } else
            return json_encode(array('status' => 401, 'success' => 'false', 'message' => trans('Physician::messages.delete_qs_failed')));
    }

    /**
     *  Update the Agreement Status by User
     *  @param $user_inputs
     *  @return json_array
     */
    public function updateAgreementStatus(Request $request)
    {
        $request    = $request->all();
        // $userRole   = $request['user_role'];
        $agree      = $request['agree'];
        $id         = $request['userId'];
        
        // To update the agreement status
        if ($agree == 1) {
            $agreement = User::find($id);
            $agreement ->agreed = 'Y';
            $agreement ->agreed_at = \Carbon\Carbon::now(); 
            $agreement->save();
        }
        return 'success';
    }
}
