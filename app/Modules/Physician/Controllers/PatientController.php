<?php namespace App\Modules\Physician\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modules\Physician\Models\Patient;
use App\Models\QuestionReceipients;
use App\Models\QuestionReceipientsAnswers;
use App\Modules\Physician\Models\QuestionsCategory;
use Vinkla\Hashids\Facades\Hashids;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
// Repository
use App\Modules\Patient\Repositories\PatientAllergyRepository;
use App\Modules\Patient\Repositories\MedicationsRepository;
use App\Modules\Patient\Repositories\PastMedHistoryRepository;
use App\Modules\Patient\Repositories\SurgicalHistoryRepository;
use App\Modules\Patient\Repositories\FamilyHistoryRepository;
use App\Modules\Patient\Repositories\SocialHistoryRepository;
use App\Modules\Physician\Repositories\SummaryReportsRepository;
use App\Modules\Physician\Repositories\PhysicianRepository;
use App\Modules\Physician\Repositories\NotificationsRepository;
use App\Modules\Physician\Repositories\QuestionReceipientsRepository;
// Requests
use App\Modules\Physician\Requests\SendSummaryRequest;
use Illuminate\Http\Response;

class PatientController extends Controller
{

    protected $report_file_path;

    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        /*if(\Session::has('physician_id'))
        {
            $this->paysicianid = \Session::get('physician_id');
        }
        else
        {
            $this->paysicianid = 0;  
        }*/
        $this->middleware(function ($request, $next)
        {
            $this->paysicianid = \Session::get('physician_id');
            return $next($request);
        });

        $this->report_file_path = public_path('uploads/reports/');
        $this->report_file_url  = 'uploads/reports/';
    }

    /**
     * Listing of Patients who is registered in linkbox
     *
     * @return Response
     */
    public function index()
    {
        return view("Physician::patient.list");
    }

    /**
     * Ajax content for Listing
     *
     * @return Response
     */
    public function getList(Request $request)
    {
        $user_id  = $this->paysicianid;
        $patients = QuestionReceipients::select(DB::raw('DISTINCT patient_id'), 'patients.*')->join('patients', DB::raw('patient_id'), '=', 'patients.id')
//            ->where('patients.is_account_active', '=', 'Y')->whereNull('patients.activation_code')
            ->where('physician_id', '=', $user_id);
        return Datatables::of($patients)
                ->addColumn('first_name', function($patients) {
                    if (Auth::user()->isAuthorizedStaff('patient_edit')) {
                        if ($patients->is_account_active == 'Y')
                            return "<a href='" . route('physician.patient.details', Hashids::encode($patients->id)) . "'>$patients->first_name </a>";
                        else
                            return "<a href='" . route('physician.patient.details', Hashids::encode($patients->id)) . "'>" . trans("Physician::messages.span_registration_pending") . "</span></a>";
                    }
                    else {
                        if ($patients->is_account_active == 'Y')
                            return $patients->first_name;
                        else
                            return trans("Physician::messages.span_registration_pending");
                    }
                })
                ->addColumn('last_name', function($patients) {
                    $result = "-";
                    if (!empty($patients->last_name)) {
                        if (Auth::user()->isAuthorizedStaff('patient_edit'))
                            $result = "<a href='" . route('physician.patient.details', Hashids::encode($patients->id)) . "'>$patients->last_name</a>";
                        else
                            $result = $patients->first_name;
                    }
                    return $result;
                })
                ->editColumn('email', function($patients) {
                    if ($patients->entry_type == 'T' && $patients->is_account_active == 'P')
                        return '-';
                    else
                        return $patients->email;
                })
                ->addColumn('dob', function($patients) {
                    return (!empty($patients->dob)) ? date('m/d/Y', strtotime($patients->dob)) : "-";
                })
                ->addColumn('age', function($patients) {
                    return (!empty($patients->dob)) ? Carbon::parse($patients->dob)->diff(Carbon::now())->format('%y') : "-";
                })
                ->addColumn('gender', function($patients) {
                    if ($patients->is_account_active == 'Y')
                        return ($patients->gender == 'M') ? 'Male' : 'Female';
                    else
                        return $patients->gender;
                })
                ->addColumn('contact_no', function($patients) {
                    return $patients->contact_number;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search')) {
                        $searchText = $request->get('search');
                        $instance->where(function ($query) use ($searchText) {
                            $query->orWhere('first_name', 'like', "%{$searchText}%")
                            ->orWhere('last_name', 'like', "%{$searchText}%")
                            ->orWhere('email', 'like', "%{$searchText}%");
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Ajax content for Listing in popup
     *
     * @return Response
     */
    public function getPopupList(Request $request)
    {
        //$user_id = Auth::user()->id;
        //$patients = User::Patient()->join('patients','user_id','=','users.id')->select('users.id','users.name','users.email','patients.dob','patients.gender','users.contact_number')->orderBy('users.id','DESC');
        $patients = Patient::select('*')->where('is_account_active', 'Y')->whereNull('activation_code');
        return Datatables::of($patients)
                ->addColumn('id', function($patients) {
                    return "<input type='checkbox' value='" . $patients->email . "' class='check_boxes check-list-box'>";
                })
                ->addColumn('name', function($patients) {
                    return "<a href='#' class='not-done'>" . $patients->first_name . " " . $patients->last_name . " </a>";
                })
                ->addColumn('dob', function($patients) {
                    return (!empty($patients->dob)) ? date('m/d/Y', strtotime($patients->dob)) : "-";
                })
                ->addColumn('contact_no', function($patients) {
                    return $patients->contact_number;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search') || $request->has('dobSearch')) {
                        $instance->where(function ($query) use ($request) {
                            $searchString1 = trim($request->get('search'));
                            $searchString2 = trim($request->get('dobSearch'));
                            if ($searchString1 != "") {
                                $query->orWhere('first_name', 'like', "%{$searchString1}%")->orWhere('last_name', 'like', "%{$searchString1}%")
                                ->orWhere('email', 'like', "%{$searchString1}%");
                            }
                            if ($searchString2 != "") {
                                $query->orWhere('dob', '=', Carbon::createFromFormat('m/d/Y', $searchString2)->format('Y-m-d'));
                            }
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Get Patient Details
     * @param int id
     * @return HTML
     */
    public function getPatientDetails(Request $request)
    {
        $patientId      = Hashids::decode($request->id);
        //$patientDetails = Patient::where('id', $patientId)->whereIn('is_account_active', array('Y', 'P'))->whereNull('activation_code')->first();
        $patientDetails = Patient::where('id', $patientId)->whereIn('is_account_active', array('Y', 'P'))->first();
        return view("Physician::patient.details", compact('patientDetails'));
    }

    /**
     * Get Ajax content for Datatable - Patient Question Sets
     * @param int id
     * @return HTML
     */
    public function checkClinicalQuestions(Request $reqeust)
    {//dd($reqeust);
        $reqeustData = $reqeust->all();
        $qid         = $reqeustData['qid'];
        $qrid        = $reqeustData['qrid'];
        $qrid        = $reqeustData['qrid'];
        $types       = $reqeustData['types'];
        $questions   = QuestionsCategory::select('id')->where('question_id', $qid)->where('clinical_question', '1')->where('active', 'Y')->get();
        if (count((array)$questions) > 0) {
            $idArray   = array();
            for ($i = 0; $i < count((array)$questions); $i++)
                $idArray[] = $questions[$i]['id'];

            $clinical = QuestionReceipientsAnswers::whereIn('question_category_id', $idArray)->get()->count();
            if (( count((array)$questions) - $clinical ) > 0)
                $count    = 1;
            else
                $count    = 0;
        } else
            $count = 0;
        if ($types == 'S')
            return array('c' => $count, 't' => url('/physician/patients/' . $qrid . '/questionset'), 'f' => route("physician.patient.summary", $qrid));
        else if ($types == 'E')
            return array('c' => $count, 't' => url('/physician/patients/' . $qrid . '/questionset'), 'f' => route("physician.patient.evaluation", $qrid));
    }

    /**
     * Get Ajax content for Datatable - Patient Question Sets
     * @param int id
     * @return HTML
     */
    public function getQuestionSetList(Request $request)
    {

        $patientId   = $request->id;
        $physicianId = $this->paysicianid;

        // if empty patient id return back with error
        $patientDetails = QuestionReceipients::with(array('question' => function($query) {
                        $query->where('active', '=', 'Y');
                    }))->select('question_recipients.id as qResId', 'question_recipients.*')
                ->leftJoin('questions', 'question_recipients.question_id', '=', 'questions.id')
                ->where('patient_id', $patientId)->where('physician_id', $physicianId)->where('questions.active', '=', 'Y')->orderBy('question_recipients.updated_at', 'DESC');

        return Datatables::of($patientDetails)
                ->addColumn('title', function($patientDetails) {
                    $patientName = '';

                    $patientName = $patientDetails->question->title;
                    if (Auth::user()->isAuthorizedStaff('questionset_list'))
                        return "<a href=" . route('physician.patient.questionsetdetail', Hashids::encode($patientDetails->qResId)) . ">" . $patientName . "</a>";
                    else
                        return $patientName;
                })
                ->addColumn('created_at', function($patientDetails) {
                    return (!empty($patientDetails->created_at)) ? date('m/d/Y', strtotime($patientDetails->created_at)) : "-";
                })
                ->addColumn('status', function($patientDetails) {
                    $clsTxt = ('completed' == $patientDetails->status) ? 'txt-blue' : 'txt-orange';
                    return "<span class=\"$clsTxt\">" . ucfirst($patientDetails->status) . "</span>";
                })
                ->addColumn('actions', function($patientDetails) {
//                    if ('pending' == $patientDetails->status)
                    return "<a href=\"javascript:void(0)\" class=\"txt-orange\" onclick=\"resendQuestionSet(" . $patientDetails->patient_id . "," . $patientDetails->question_id . "," . $patientDetails->id . ")\" >Resend</a>";
                })
                ->addColumn('reports', function($patientDetails) {
                    if ('completed' == $patientDetails->status) {
                        $reportLinks = "";
                        if (Auth::user()->isAuthorizedStaff('patient_summaryReportList'))
                            $reportLinks .= '<a onclick="return checkClinicalQuestions(' . $patientDetails->question_id . ',' . Hashids::encode($patientDetails->qResId) . ', \'S\')" href=' . route("physician.patient.summary", Hashids::encode($patientDetails->qResId)) . ' class=\"txt-blue\">Summary Report</a><br>';
                        if (Auth::user()->isAuthorizedStaff('patient_evaluationReportList'))
                            $reportLinks .= '  <a onclick="return checkClinicalQuestions(' . $patientDetails->question_id . ',' . Hashids::encode($patientDetails->qResId) . ', \'E\')" href=' . route("physician.patient.evaluation", Hashids::encode($patientDetails->qResId)) . ' class=\"txt-blue mrgn-lft-25\">Full Evaluation Report</a>';
                        return $reportLinks;
                    }
                })
                ->make(true);
    }

    /**
     * Summary Report Based on the Question Set
     * @param int id
     * @return HTML
     */
    public function getSummaryReport(Request $request, QuestionReceipientsRepository $questionReceipientRepo)
    {
// dd($request->id);
        $qRecId      = $request->id;
        $qRecId      = Hashids::decode($request->id);
        $qRecId = $qRecId[0];
        $physicianId = $this->paysicianid;
        // if empty patient id return back with error
        $summary     = $questionReceipientRepo->summaryReport($qRecId);
        $summaryDet  = $questionReceipientRepo->questionRec;
        if ($questionReceipientRepo->questionRec['status'] == 'pending')
            return redirect('physician/home');
        return view("Physician::patient.summary_report", compact('summary', 'summaryDet', 'qRecId'));
    }

    /**
     * Summary Report Based on the Question Set
     * @param int id
     * @return HTML
     */
    public function sendSummaryReport(SendSummaryRequest $request, SummaryReportsRepository $summaryReportsRepo, PhysicianRepository $physicianRepo, NotificationsRepository $notificationsRepo, QuestionReceipientsRepository $questionReceipientRepo)
    {
        $requestData                = $request->all();
        $requestData['phyId']       = $this->paysicianid;
        $inputData['email']         = $requestData['email'];
        $sendToId                   = 0;
        $requestData['report_type'] = $requestData['rType']; //'S';
        $userInfo                   = $physicianRepo->getUsers($inputData);
        if (count((array)$userInfo) > 0) {
            $sendToId = $userInfo->id;
            if ($requestData['rType'] == 'S') {
                $requestData['summary']  = $questionReceipientRepo->summaryReport($requestData['rid']);
                $message                 = 'trans_patient_received_qn_set_line1';
                $requestData['pdf_file'] = $this->generatePdf($requestData['rid'], 'summary');
            } else {
                $requestData['summary']  = '';
                $message                 = 'trans_patient_received_qn_set_line1_eval';
                $requestData['pdf_file'] = $this->generatePdf($requestData['rid'], 'evaluation');
            } $requestData['sendToId'] = $sendToId;

            $result = $summaryReportsRepo->createRow($requestData);

            //send notification to the patient
            $notification = $notificationsRepo->save(array('question_id' => $requestData['qid'], 'notification_type' => 4, 'message' => $message, 'sender_id' => $requestData['phyId'], 'sender_type' => 2, 'receiver_id' => $requestData['pid'], 'receiver_type' => 2, 'send_report_to' => $sendToId, 'status' => 'P', 'question_recipients_id' => $requestData['rid']));
            $result->update(array('notification_id' => $notification->id));

            return json_encode(array('status' => true, 'message' => trans("Physician::messages.report_sent_request_success")));
        } else
            return json_encode(array('status' => false, 'message' => trans("Physician::messages.email_not_found")));

//            $newPhysician = $physicianRepo->createRow($inputData);
//            $sendToId     = $newPhysician->id;
    }

    /**
     * Full Evaluation Report Based on the Question Set
     * @param int id
     * @return HTML
     */
    public function getEvaluationReport(Request $request, QuestionReceipientsRepository $questionReceipientRepo)
    {

        $qRecId = $request->id;
        $qRecId      = Hashids::decode($request->id);
        $qRecId = $qRecId[0];
        $physicianId            = $this->paysicianid;
        // if empty qRecId id return back with error
        $summary                = $questionReceipientRepo->summaryReport($qRecId);
        $summaryByCat           = $questionReceipientRepo->summaryReportByCategory($qRecId);
        $evaluationData         = $questionReceipientRepo->questionRec;
        $clinicalReport         = $questionReceipientRepo->clinicalInfo($qRecId);
        $questionRecepientModel = new QuestionReceipients;
        $medicalHistoryDetails  = $questionRecepientModel->with('patient_allergies', 'medications','past_medical_history', 'surgical_history', 'family_history', 'social_history')->where('id', $qRecId)->get()->toArray();

        $medicalHistoryDetails = end($medicalHistoryDetails);
        return view("Physician::patient.evaluation_report", compact('evaluationData', 'summary', 'summaryByCat', 'qRecId', 'medicalHistoryDetails', 'clinicalReport'));
    }

    /**
     * View Answers with Question Set
     * @param int id - Question Receipient Id
     * @return HTML
     */
    public function getQuestionSetDetail(Request $request)
    {

        $qRecId      = Hashids::decode($request->id); 
        $qRecId      = $qRecId[0];
        $physicianId = $this->paysicianid;

        $questionSets = QuestionReceipients::with('question', 'question.questionSets', 'question.questionSets.defaultOptions', 'answers', 'question.questionSets.category', 'patient', 'question.questionSetsyesNoCount')->leftJoin('questions', 'question_recipients.question_id', '=', 'questions.id')->where('question_recipients.id', $qRecId)->where('questions.active', '=', 'Y')->select('question_recipients.*')->get();

        if (!$questionSets || count((array)$questionSets) == 0) {
            return redirect()->back();
        }
        $categories = $questionSets->map(function ($value) {
            return $value->question->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
        });
        $category = $categories->all();
        $category = end($category)->unique();
        return view("Physician::patient.question_set_detail", compact('questionSets', 'category'));
    }

    /**
     * To Update Question Set Answers
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function postAnswer(Request $request)
    {
        
        $qRecId    = Hashids::decode($request->id); 
        $qRecId    = $qRecId[0];
        // $qRecId    = $request->id;
        $questions = $request->all();

        $physicianId         = $this->paysicianid;
        $questionReceipients = QuestionReceipients::where('id', $qRecId)->first();
        
        // Conditions its status, logined physicians question set

        if (($physicianId != $questionReceipients->physician_id) || ('completed' != $questionReceipients->status))
            return json_encode(array('error' => true, 'message' => trans('Patient::messages.error_message'), 'redirectUrl' => route('physician.patient.questionsetdetail', $questionId)));

        $receivedAnswers       = [];
        $receivedAnswersUpdate = [];
        $answered              = 0;
        $description           = "";
        foreach ($questions['answer'] as $questKey => $questVal) {
            $description = "";
            foreach ($questVal as $ansKey => $ansVal) {
                if (!empty($ansVal))
                    $answered++;

                if (is_array($ansVal)) {
                    if (array_key_exists('3combo', $ansVal)) {
                        $ansVal = serialize(array_values($ansVal['3combo']));
                    } else {
                        $ansVal = serialize(array_keys($ansVal));
                    }
                }
                if (isset($questions['description'])) {
                    if (array_key_exists($questKey, $questions['description']))
                        $description = $questions['description'][$questKey][$ansKey];
                }
                $exists = QuestionReceipientsAnswers::where('question_recipient_id', $qRecId)->where('question_category_id', $questKey)->first();
                if ($exists) {
                    $exists->answer      = $ansVal;
                    $exists->description = $description;
                    $exists->save();
                    if (empty($exists->answer) && empty($exists->description)) {
                        $exists->delete();
                    }
                    // if empty answers delete this row
                } else {
                    if (!empty($ansVal) || !empty($description)) {
                        $receivedAnswers[] = [
                            'question_recipient_id' => $qRecId,
                            'question_id' => $questionReceipients['question_id'],
                            'question_category_id' => $questKey,
                            'answer' => $ansVal,
                            'description' => $description
                        ];
                    }
                }
            }
        }

        if ($answered == 0) {
            //return redirect()->back()->with('error', trans('Patient::messages.error_message'));
            \Session::flash('error', trans('Patient::messages.error_message'));
            return json_encode(array('success' => false, 'message' => trans('Patient::messages.error_message'), 'redirectUrl' => route('patient.question.show', $questionId)));
        }
        // if save update status of question receipient
        if (!empty($receivedAnswers))
            QuestionReceipientsAnswers::insert($receivedAnswers);

        // updating notification as seen.
        /* $notifDetails = $notificationsRepo->getID(array('is_seen' => 0, 'question_id' => $questionReceipients['question_id'], 'receiver_id' => $patientId, 'receiver_type' => 2));
          if (count((array)$notifDetails) > 0) {
          $notifId      = $notifDetails->id;
          $notificationsRepo->updateData(array('notifId' => $notifId, 'nid' => $notifId), array('is_seen' => 1));
          // sending notification
          $notification = $notificationsRepo->save(array('question_id' => $questionReceipients['question_id'], 'notification_type' => 1, 'message' => 'trans_received_response', 'sender_id' => $patientId, 'sender_type' => 3, 'receiver_id' => $questionReceipients['physician_id'], 'receiver_type' => 1));
          } */
        //$recStatus                   = ('2' == $questions['saved']) ? 'completed' : 'responded';
        //$questionReceipients->status = $recStatus;
        //$questionReceipients->save();
        $succMsg = trans('Patient::messages.submit_answer'); //('2' == $questions['saved']) ? trans('Patient::messages.submit_answer') : trans('Patient::messages.saved_answer');

        \Session::flash('success', $succMsg);
        return json_encode(array('success' => true, 'message' => $succMsg, 'redirectUrl' => route('physician.patient.questionsetdetail', Hashids::encode($qRecId))));
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getAllergyList(Request $request)
    {
        $requestData              = $request->all();
        $patientId                = $requestData['pid'];
        $this->patientAllergyRepo = new PatientAllergyRepository();
        $allergyList              = $this->patientAllergyRepo->getAllergyList($patientId);
        return Datatables::of($allergyList)->make(true);
    }
    /**
     * Get the list of medications added by patients.
     *
     * @return Response
     */
    public function getMedicationsList(Request $request)
    {
        $requestData              = $request->all();
        $patientId                = $requestData['pid'];
        $this->medicationsRepo    = new MedicationsRepository();
        $medicationsList              = $this->medicationsRepo->getMedicationsList($patientId);
        return Datatables::of($medicationsList)->make(true);
    }

    /**
     * Get the list of past medical histories of patients.
     *
     * @return Response
     */
    public function getPastMedHistory(Request $request)
    {
        $requestData = $request->all();
        $patientId   = $requestData['pid'];

        $this->patientMedHistoryRepo = new PastMedHistoryRepository;
        $medHistoryList              = $this->patientMedHistoryRepo->getPastMedHistoryList($patientId);
        return Datatables::of($medHistoryList)->make(true);
    }

    /**
     * Get the list of past medical histories of patients.
     *
     * @return Response
     */
    public function getSurgicalHistory(Request $request)
    {
        $requestData               = $request->all();
        $patientId                 = $requestData['pid'];
        $this->surgicalHistoryRepo = new SurgicalHistoryRepository();
        $surgicalHistoryList       = $this->surgicalHistoryRepo->getSurgicalHistoryList($patientId);
        return Datatables::of($surgicalHistoryList)
                ->editColumn('surgery_date', function($surgicalHistoryList) {
                    return (!empty($surgicalHistoryList->surgery_date)) ? Carbon::parse($surgicalHistoryList->surgery_date)->format('m/d/Y') : "-";
                })->make(true);
    }

    /**
     * Get the list of past family histories of patients.
     *
     * @return Response
     */
    public function getFamilyHistory(Request $request)
    {
        $requestData             = $request->all();
        $patientId               = $requestData['pid'];
        $this->familyHistoryRepo = new FamilyHistoryRepository();
        $familyHistoryList       = $this->familyHistoryRepo->getFamilyHistoryList($patientId);
        return Datatables::of($familyHistoryList)->make(true);
    }

    /**
     * PDF stream of Summary Report Based on the Question Set
     * @param int id
     * @return HTML
     */
    public function pdfStream(Request $request, QuestionReceipientsRepository $questionReceipientRepo)
    {
        $qRecId     = $request->id;
        $summaryDet = QuestionReceipients::with('physician', 'patient', 'question')->where('id', $qRecId)->get()->toArray();
        $summaryDet = end($summaryDet);
        $summary    = strip_tags($questionReceipientRepo->summaryReport($qRecId));
        $view       = \View::make('Physician::patient.pdf.summary', compact('summary', 'summaryDet'))->render();
        return $this->generateInlinePdf($view, $qRecId);
    }

    /**
     * Full Evaluation Report Based on the Question Set
     * @param int id
     * @return HTML
     */
    public function fullPdfStream(Request $request, QuestionReceipientsRepository $questionReceipientRepo)
    {
        $qRecId         = $request->id;
        $physicianId    = $this->paysicianid;
        $summary        = strip_tags($questionReceipientRepo->summaryReport($qRecId));
        $summaryByCat   = $questionReceipientRepo->summaryReportByCategory($qRecId);
        $evaluationData = $questionReceipientRepo->questionRec;

        $questionRecepientModel = new QuestionReceipients;
        $medicalHistoryDetails  = $questionRecepientModel->with('patient_allergies', 'medications', 'past_medical_history', 'surgical_history', 'family_history', 'social_history')->where('id', $qRecId)->get()->toArray();
        $clinicalReport         = $questionReceipientRepo->clinicalInfo($qRecId);
        $medicalHistoryDetails  = end($medicalHistoryDetails);

        $view = \View::make('Physician::patient.pdf.evaluation', compact('summary', 'summaryByCat', 'evaluationData', 'medicalHistoryDetails', 'clinicalReport'))->render();
        return $this->generateInlinePdf($view, $qRecId);
    }

    public function generatePdf($qRecId, $type = 'summary')
    {
        $questionReceipientRepo = new QuestionReceipientsRepository();
        if ($type == 'summary') {
            $summaryDet = QuestionReceipients::with('physician', 'patient', 'question')->where('id', $qRecId)->get()->toArray();
            $summaryDet = end($summaryDet);
            $summary    = strip_tags($questionReceipientRepo->summaryReport($qRecId));
            $view       = \View::make('Physician::patient.pdf.summary', compact('summary', 'summaryDet'))->render();
            $patientId  = $summaryDet['patient']['id'];
        } else if ($type == 'evaluation') {
            $physicianId    = $this->paysicianid;
            $summary        = strip_tags($questionReceipientRepo->summaryReport($qRecId));
            $summaryByCat   = $questionReceipientRepo->summaryReportByCategory($qRecId);
            $evaluationData = $questionReceipientRepo->questionRec;

            $questionRecepientModel = new QuestionReceipients;
            $medicalHistoryDetails  = $questionRecepientModel->with('patient_allergies', 'medications','past_medical_history', 'surgical_history', 'family_history', 'social_history')->where('id', $qRecId)->get()->toArray();
            $clinicalReport         = $questionReceipientRepo->clinicalInfo($qRecId);
            $medicalHistoryDetails = end($medicalHistoryDetails);
            $view           = \View::make('Physician::patient.pdf.evaluation', compact('clinicalReport','medicalHistoryDetails','summary', 'summaryByCat', 'evaluationData'))->render();
            $patientId      = $evaluationData['patient']['id'];
        }
        $fileName = str_random(32) . '_' . $qRecId . '.pdf';
        $filePath = $this->report_file_path . $patientId . '/';
        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }
        $snappy         = \App::make('snappy.pdf');
        $snappy->generateFromHtml($view, $filePath . $fileName);
        $file_load_path = $this->report_file_url . $patientId . '/' . $fileName;
        return $file_load_path;
    }

    public function generateInlinePdf($view, $qRecId)
    {
        $snappy = \App::make('snappy.pdf');
        $pdf    = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->inline(str_random(32) . '_' . $qRecId . '.pdf');
    }

    /**
     * To Update Question Set Answers
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function postSetPreviewAnswer(Request $request, QuestionReceipientsRepository $questionReceipientRepo)
    {
        $qRecId                 = Hashids::decode($request->id); 
        $qRecId                 = $qRecId[0];
        $questions              = $request->all();

        $popUpData['age']       = $questions['age'];
        $popUpData['gender']    = $questions['gender'];
        $physicianId            = $this->paysicianid;
        $questionReceipients    = QuestionReceipients::where('id', $qRecId)->first();
        $receivedAnswers        = [];
        $receivedAnswersUpdate  = [];
        $answered               = 0;
        $description            = "";

        foreach ($questions['answer'] as $questKey => $questVal) {
            $description = "";
            foreach ($questVal as $ansKey => $ansVal) {
                if (!empty($ansVal))
                    $answered++;

                if (is_array($ansVal)) {
                    if (array_key_exists('3combo', $ansVal)) {
                        $ansVal = serialize(array_values($ansVal['3combo']));
                    } else {
                        $ansVal = serialize(array_keys($ansVal));
                    }
                }
                if (isset($questions['description'])) {
                    if (array_key_exists($questKey, $questions['description']))
                        $description = $questions['description'][$questKey][$ansKey];
                }
                if (!empty($ansVal) || !empty($description)) {
                    $receivedAnswers[] = [
                        'question_recipient_id' => $qRecId,
                        'question_id' => $questionReceipients['question_id'],
                        'question_category_id' => $questKey,
                        'answer' => $ansVal,
                        'description' => $description
                    ];
                }
            }
        }
        
        // if empty patient id return back with error
        $summary     = $questionReceipientRepo->summaryReportOfTestPreview($qRecId, $receivedAnswers, $popUpData);
        $summaryDet  = $questionReceipientRepo->questionRec;
        return view("Physician::testpreview_summary_report", compact('summary', 'summaryDet', 'qRecId'));
    }
     
}
