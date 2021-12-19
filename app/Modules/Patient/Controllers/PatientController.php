<?php

namespace App\Modules\Patient\Controllers;

use Carbon\Carbon;
use App\Http\Requests;
use App\Models\Allergy;
use App\Models\Practice;
use Illuminate\Http\Request;
use App\Helpers\ImageResizeHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
// use Yajra\Datatables\Facades\Datatables;
use App\Modules\Patient\Requests\AllergyRequest;
use App\Modules\Patient\Requests\EditImageRequest;
use App\Modules\Patient\Requests\MedicationsRequest;
use App\Modules\Patient\Requests\ProfileUpdateRequest;
use App\Modules\Patient\Requests\ChangePasswordRequest;
use App\Modules\Patient\Repositories\PatientRepository;
use App\Modules\Patient\Repositories\MedicationsRepository;
use App\Modules\Physician\Repositories\NotificationsRepository;
use App\Modules\Patient\Repositories\PatientAllergyRepository;
use App\Modules\Patient\Repositories\PastMedHistoryRepository;
use App\Modules\Patient\Repositories\SurgicalHistoryRepository;
use App\Modules\Patient\Repositories\FamilyHistoryRepository;
use App\Modules\Patient\Repositories\SocialHistoryRepository;
use App\Modules\Patient\Requests\MedicalHistoryRequest;
use App\Modules\Patient\Requests\SurgicalHistoryRequest;
use App\Modules\Patient\Requests\FamilyHistoryRequest;
use App\Modules\Patient\Requests\SocialHistoryRequest;
use Vinkla\Hashids\Facades\Hashids;

class PatientController extends Controller {

    protected $pat_profile_img_path;
    protected $report_file_path;
    protected $guard;
    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->guard = 'patient';
        Auth::shouldUse('patient');
        $this->pat_profile_img_path = public_path('uploads/patient/');
        $this->report_file_path = public_path('uploads/reports/');
    }

    /**
     * Display patient registration form.
     *
     * @return Response
     */
    public function dashboard() {
        return view("Patient::dashboard");
    }

    /**
     * Display patient registration form.
     *
     * @return Response
     */
    public function register($uuid = null) {
        // $data['practice_list'] = Practice::orderBy('name', 'asc')->pluck('name', 'id');
        //return view("Patient::register")->with(['uuid' => $uuid, 'data' => $data]);
        return view("Patient::register")->with(['uuid' => $uuid]);
    }

    /**
     * Home page.
     *
     * @return Response
     */
    public function receivedQuestionSets() {
        return view("Patient::received_question_sets");
    }

    /**
     * profile.
     *
     * @return Response
     */
    public function profile() {
        $data['patient'] = Patient::select('id', 'first_name', 'last_name', 'email', 'gender', 'dob', 'contact_number', 'profile_image')->where('id', Auth::guard('patient')->user()->id)->first();
        $data['patient']->profile_image = ($data['patient']->profile_image != '') ? asset('uploads/patient/' . config('settings.thumb_prefix') . $data['patient']->profile_image) : asset('assets/dummy-profile-pic.png');
        return view("Patient::profile", compact('data'));
    }

    /**
     * Change password
     *
     * @return Response
     */
    public function postChangePwd(ChangePasswordRequest $request) {
        $current_password = Auth::guard('patient')->User()->password;
        if (Hash::check($request['old_password'], $current_password)) {
            $user_id = Auth::guard('patient')->User()->id;
            $obj_user = Patient::find($user_id);
            $obj_user->password = Hash::make($request['password']);
            $obj_user->save();
            Session::flash('success', trans('custom.password_change_success'));
        } else {
            return json_encode(array('status' => 401, 'success' => false, 'message' => trans('custom.old_password_mismatch')));
        }
    }

    /**
     * Profile updating
     *
     * @return Response
     */
    public function postProfile(ProfileUpdateRequest $request) {
        $postData['first_name'] = $request->input('first_name');
        $postData['last_name'] = $request->input('last_name');
        $postData['email'] = $request->input('email');
        $postData['gender'] = $request->input('gender');
        $postData['dob'] = Carbon::parse($request->input('dob'))->format('Y-m-d');
        $postData['contact_number'] = '+' . (ltrim($request->input('country_code') . "-" . $request->input('contact_number'), '+'));
        Patient::where('id', Auth::guard('patient')->user()->id)
                ->update($postData);
        Session::flash('success', trans('custom.profile_update_success'));
    }

    /**
     * profile.
     *
     * @return Response
     */
    public function medicalRecords() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->socialHistoryRepo = new SocialHistoryRepository();
        $socialHistoryData = $this->socialHistoryRepo->getSocialHistory($patientId);
//        print_r($socialHistoryData);
//        exit;

        return view("Patient::medical_records", compact('socialHistoryData'));
    }

    /**
     * profile.
     *
     * @return Response
     */
    public function notifications() {
        return view("Patient::notifications");
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function getNotificationsList(Request $request, NotificationsRepository $notificationsRepo) {
        $userData = Auth::guard('patient')->User();
        $sendData['request'] = $request->all();
        $sendData['user'] = $userData;
        $requestData = $sendData['request'];
        $requestData['userId'] = $userData->id;
        $notications = $notificationsRepo->getData($sendData);
        // return if the request is for count only.

        if (key_exists('queryType', $requestData) && $requestData['queryType'] == 'count') {
            if ($sendData['request']['listType'] == 'Clinical')
                $sendData['request']['listType'] = 'Admin';
            else if ($sendData['request']['listType'] == 'Notifications')
                $sendData['request']['listType'] = 'Approvals';
            $notications2 = $notificationsRepo->getData($sendData);

            return ($notications + $notications2) . '###' . $notications . '###' . $notications2;
        }
        return Datatables::of($notications)
                        ->editColumn('name', function($notications) use ($requestData, $notificationsRepo) {
                            if ($requestData['listType'] == 'Notifications') {
                                if ($notications->is_seen)
                                    $return = '<div id="divPanel' . $notications->id . '" class="content-sub noti-box noti-read mrgn-btm-20">';
                                else
                                    $return = '<div id="divPanel' . $notications->id . '" class="content-sub noti-box noti-unread mrgn-btm-20"><a href="' . url('patient/questions/' . Hashids::encode($notications->question_recipients_id) . '/brief') . '">';

                                $profileImage = ($notications->profile_image != '') ? asset('uploads/physician/' . config('settings.thumb_prefix') . $notications->profile_image) : asset('assets/dummy-profile-pic.png');

                                $return .= '<div class="col-md-1"><img src="' . $profileImage . '" alt="profile-img" class="profile-img-noti"></div>
                                    <div class="col-md-7"><p>' . trans('Patient::messages.' . $notications->message);
                                $return .= '<strong><i>' . $notications->title . ' Question Set</i></strong> ';
                                $return .= 'from Dr. ' . $notications->name . ', ' . $notications->hospital_name . '.<br>' . trans('Patient::messages.trans_patient_received_qn_set_line2') . '
                                        </p>                                       
                                        </div>
                                        <div class="col-md-4">
                                            <p class="pull-right date-blue">' . convertDateToMMDDYYYY($notications->created_at, 'MFirst'); 
                                $return .= '<a href="javascript:void(0);" class="deleteNotification" data-nottype="notifications" data-url="'. route('patient.notifications.delete', $notications->id).'"><i class="fa fa-trash-o"></i></a>
                                            </p>                                            
                                         </div>';
                                        if (!($notications->is_seen))
                                            $return .= '</a>';
                                    $return .= '</div>';                                    
                            }elseif ($requestData['listType'] == 'Approvals') {
                                if ($notications->pdf_file != '')
                                    $url = url($notications->pdf_file);
                                else
                                    $url = '';
                                $profileImage = ($notications->profile_image != '') ? asset('uploads/physician/' . config('settings.thumb_prefix') . $notications->profile_image) : asset('assets/dummy-profile-pic.png');
                                $return = '<div class="content-sub noti-box mrgn-btm-20">
                                <div class="col-md-1"><img src="' . $profileImage . '" alt="profile-img" class="profile-img-noti"> </div>
                                <div class="col-md-9">
                                    <p><b>Dr. ' . $notications->name . ', ' . $notications->hospital_name . '</b>' . trans('Patient::messages.trans_patient_requires_authorization') . '<a href="' . $url . '" target="_blank"><b>' . $notications->title . '';

                                if ($notications->report_type == 'E')
                                    $return .= trans('Patient::messages.trans_patient_evaluation_report_to');
                                else
                                    $return .= trans('Patient::messages.trans_patient_summary_report_to');

                                $return .= '</b></a> to <br>Dr. ' . $notications->ref_user_name . ', ' . $notications->ref_user_hospital_name . '.</p>';
                                
                                $return .= '</div>';
                                $return .= '<div class="col-md-2"><p class=" date-blue">' . convertDateToMMDDYYYY($notications->created_at, 'MFirst'); 

                                if($notications->status == 'A' || $notications->status == 'D' )
                                    $return .= '<a href="javascript:void(0);" class="deleteNotification" data-nottype="approvals" data-url="'. route('patient.notifications.delete', $notications->id).'"><i class="fa fa-trash-o"></i></a>';
                                $return .= '</p>';
                                if ($notications->status == 'P')
                                    $return .= '<button type="button" class="btn acp-btn btn-third btn-block pull-right btn-approve" onclick="updateApprovals(' . $notications->id . ', \'Approve\')">Approve</button>
                            <button type="button" class="btn acp-btn btn-third btn-block pull-right" onclick="updateApprovals(' . $notications->id . ', \'Decline\')">Decline</button>';
                                elseif ($notications->status == 'A')
                                    $return .= '<p class="approved"><i class="fa fa-check-circle mrgn-rgt-10" aria-hidden="true"></i>Approved</p>';
                                elseif ($notications->status == 'D')
                                    $return .= '<p class="declined"><i class="fa fa-times mrgn-rgt-10" aria-hidden="true"></i>Declined</p>';

                                $return .= '</div>';
                               
                            $return .= '</div>';
                            }
                            return $return;
                        })->make(true);
    }
    /**
     * update Notification
     *
     * @return Response
     */
    public function updateNotification(Request $request, NotificationsRepository $notificationsRepo) {
        $userData = Auth::guard('patient')->User();
        $sendData = $request->all();
        $inputData['nid'] = $sendData['nid'];
        $inputData['userId'] = $userData->id;
        if (key_exists('user', $sendData) && $sendData['user'] == 'patient') {
            if ($sendData['type'] == 'Approve') {
                $updateData['status'] = 'A';
                $emailReport = $notificationsRepo->emailSummaryReport($inputData['nid']);
            } elseif ($sendData['type'] == 'Decline')
                $updateData['status'] = 'D';
        } else {
            $inputData['is_seen'] = 0;
            $updateData['is_seen'] = 1;
        }
        $notications = $notificationsRepo->updateData($inputData, $updateData);
    }

    /**
     * profile.
     *
     * @return Response
     */
    public function questionSetBrief() {
        return view("Patient::question_set_brief");
    }

    /**
     * profile.
     *
     * @return Response
     */
    public function questionSetDetail() {
        return view("Patient::question_set_detail");
    }

    /**
     * Uploading profile image
     *
     * @return Response
     */
    public function editProfileImage(EditImageRequest $request) {
        $user_id = Auth::guard('patient')->user()->id;
        $imageName = $user_id . '_' . time() . Config::get('settings.phy_profile_img_prefix') . '.' . $request->profile_image->getClientOriginalExtension();
        ImageResizeHelper::resizeImage($request->profile_image->getRealPath(), $imageName, 'thumb', Config::get('settings.pat_profile_img_path'));
        ImageResizeHelper::resizeImage($request->profile_image->getRealPath(), $imageName, 'icon', Config::get('settings.pat_profile_img_path'));
        $request->profile_image->move($this->pat_profile_img_path, $imageName);
        $userData['profile_image'] = $imageName;
        Patient::where('id', Auth::guard('patient')->user()->id)->update($userData);
        Session::flash('success', trans('custom.profile_image_update_success'));
    }

    public function updateMenuSettings(Request $req, PatientRepository $patientRepo) {
        $userData = Auth::guard('patient')->User();
        $menuType = $userData->left_menu_display_type;

        if ($menuType == 1)
            $inputData['left_menu_display_type'] = 0;
        else
            $inputData['left_menu_display_type'] = 1;

        $return = $patientRepo->updateUserProfile($userData->id, $inputData);
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getAllergyList() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->patientAllergyRepo = new PatientAllergyRepository();
        $allergyList = $this->patientAllergyRepo->getAllergyList($patientId);
        return Datatables::of($allergyList)
                        ->addColumn('action', function($allergyList) {
                            return '<a href="' . route('patient.delete.allergies', $allergyList->id) . '" class="med-rec-del edit pull-right delete_allergy" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                            <span data-toggle="modal" data-target="#allergyModal" data-remote="' . route('patient.edit.allergies', $allergyList->id) . '"><a href="javascript:void(0);" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a></span>';
                        })
                        ->make(true);
    }

    /**
     * Insert new allergies added by patients.
     *
     * @return Response
     */
    public function addPatientAllergy() {
        $allergyData = new PatientAllergyRepository();
        $allergyData->id = '';
        return view("Patient::popups.add_allergies", compact('allergyData'));
    }

    /**
     * Insert new allergies added by patients.
     *
     * @return Response
     */
    public function postPatientAllergy(AllergyRequest $request) {
        $inputData = $request->all();
        $allergyId = $inputData['allergy_id'];
        $this->patientAllergyRepo = new PatientAllergyRepository();
        if ($allergyId == '') {
            $response = $this->patientAllergyRepo->createPatientAllergy($inputData);
        } else {
            $response = $this->patientAllergyRepo->updatePatientAllergy($inputData, $allergyId);
        }
//        return redirect('/patient/medicalRecords');
        return json_encode(array('success' => true, 'action' => 'reloadDatatable', 'table' => 'allergies'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function editPatientAllergy(Request $request, $id) {
        $this->patientAllergyRepo = new PatientAllergyRepository();
        $allergyData = $this->patientAllergyRepo->getAllergyById($id);
        return view("Patient::popups.add_allergies", compact('allergyData'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function deletePatientAllergy(Request $request, $id) {
        $this->patientAllergyRepo = new PatientAllergyRepository();
        $allergyData = $this->patientAllergyRepo->deletePatientAllergy($id);
        return redirect('/patient/medicalRecords');
    }

    /**
     * Get the list of medications added by patients.
     *
     * @return Response
     */
    public function getMedicationsList() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->medicationsRepo = new MedicationsRepository();
        $medicationsList = $this->medicationsRepo->getMedicationsList($patientId);
        return Datatables::of($medicationsList)
                        ->addColumn('action', function($medicationsList) {
                            return '<a href="' . route('patient.delete.medications', $medicationsList->id) . '" class="med-rec-del edit pull-right delete_medications" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                            <span data-toggle="modal" data-target="#medicationsModal" data-remote="' . route('patient.edit.medications', $medicationsList->id) . '"><a href="javascript:void(0);" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a></span>';
                        })
                        ->make(true);
    }

    /**
     * Insert new medications added by patients.
     *
     * @return Response
     */
    public function addMedications() {
        $medicationsData = new MedicationsRepository();
        $medicationsData->id = '';
        return view("Patient::popups.add_medications", compact('medicationsData'));
    }

    /**
     * Insert new medications added by patients.
     *
     * @return Response
     */
    public function postMedications(MedicationsRequest $request) {
        $inputData = $request->all();
        $medicationsId = $inputData['medications_id'];
        $this->medicationsRepo = new MedicationsRepository();
        if ($medicationsId == '') {
            $response = $this->medicationsRepo->createMedications($inputData);
        } else {
            $response = $this->medicationsRepo->updateMedications($inputData, $medicationsId);
        }
        return json_encode(array('success' => true, 'action' => 'reloadDatatable', 'table' => 'medications'));
    }

    /**
     * Edit medications added by patients.
     *
     * @return Response
     */
    public function editMedications(Request $request, $id) {
        $this->medicationsRepo = new MedicationsRepository();
        $medicationsData = $this->medicationsRepo->getMedicationsById($id);
        return view("Patient::popups.add_medications", compact('medicationsData'));
    }

    /**
     * Edit medications added by patients.
     *
     * @return Response
     */
    public function deleteMedications(Request $request, $id) {
        $this->medicationsRepo = new MedicationsRepository();
        $medicationsData = $this->medicationsRepo->deleteMedications($id);
        return redirect('/patient/medicalRecords');
    }

    /**
     * Get the list of past medical histories of patients.
     *
     * @return Response
     */
    public function getPastMedHistory() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->patientMedHistoryRepo = new PastMedHistoryRepository;
        $medHistoryList = $this->patientMedHistoryRepo->getPastMedHistoryList($patientId);
        return Datatables::of($medHistoryList)
                        ->addColumn('action', function($medHistoryList) {
                            return '<a href="' . route('patient.delete.med_history', $medHistoryList->id) . '" class="med-rec-del edit pull-right delete_med_history" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                            <span data-toggle="modal" data-target="#medHistoryModal" data-remote="' . route('patient.edit.med_history', $medHistoryList->id) . '"><a href="javascript:void(0);" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a></span>';
                        })
                        ->make(true);
    }

    /**
     * Insert new medical histories added by patients.
     *
     * @return Response
     */
    public function addPastMedHistory() {
        $medHistoryData = new PastMedHistoryRepository();
        $medHistoryData->id = '';
        return view("Patient::popups.add_med_history", compact('medHistoryData'));
    }

    /**
     * Insert new medical history added by patients.
     *
     * @return Response
     */
    public function postMedicalHistory(MedicalHistoryRequest $request) {
        $inputData = $request->all();
        $medHistoryId = $inputData['med_history_id'];
        $this->patientMedHistoryRepo = new PastMedHistoryRepository;
        if ($medHistoryId == '') {
            $response = $this->patientMedHistoryRepo->createMedicalHistory($inputData);
        } else {
            $response = $this->patientMedHistoryRepo->updateMedicalHistory($inputData, $medHistoryId);
        }
//        return redirect('/patient/medicalRecords');
        return json_encode(array('success' => true, 'action' => 'reloadDatatable', 'table' => 'past_medical_history'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function editPastMedHistory(Request $request, $id) {
        $this->patientMedHistoryRepo = new PastMedHistoryRepository;
        $medHistoryData = $this->patientMedHistoryRepo->getMedHistoryById($id);
        return view("Patient::popups.add_med_history", compact('medHistoryData'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function deletePastMedHistory(Request $request, $id) {
        $this->patientMedHistoryRepo = new PastMedHistoryRepository;
        $medHistoryData = $this->patientMedHistoryRepo->deletePastMedHistory($id);
        return redirect('/patient/medicalRecords');
    }

    /**
     * Get the list of past medical histories of patients.
     *
     * @return Response
     */
    public function getSurgicalHistory() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->surgicalHistoryRepo = new SurgicalHistoryRepository();
        $surgicalHistoryList = $this->surgicalHistoryRepo->getSurgicalHistoryList($patientId);
        return Datatables::of($surgicalHistoryList)
                        ->editColumn('surgery_date', function($surgicalHistoryList) {
                            return (!empty($surgicalHistoryList->surgery_date)) ? Carbon::parse($surgicalHistoryList->surgery_date)->format('m/d/Y') : "-";
                        })
                        ->addColumn('action', function($surgicalHistoryList) {
                            return '<a href="' . route('patient.delete.surgical_history', $surgicalHistoryList->id) . '" class="med-rec-del edit pull-right delete_surgical_history" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                            <span data-toggle="modal" data-target="#surgicalHistoryModal" data-remote="' . route('patient.edit.surgical_history', $surgicalHistoryList->id) . '"><a href="javascript:void(0);" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a></span>';
                        })
                        ->make(true);
    }

    /**
     * Insert new medical histories added by patients.
     *
     * @return Response
     */
    public function addSurgicalHistory() {
        $surgicalHistoryData = new SurgicalHistoryRepository();
        $surgicalHistoryData->id = '';
        return view("Patient::popups.add_surgical_history", compact('surgicalHistoryData'));
    }

    /**
     * Insert new medical history added by patients.
     *
     * @return Response
     */
    public function postSurgicalHistory(SurgicalHistoryRequest $request) {
        $inputData = $request->all();
        $surgicalHistoryId = $inputData['surgical_history_id'];
        $this->surgicalHistoryRepo = new SurgicalHistoryRepository();
        if ($surgicalHistoryId == '') {
            $response = $this->surgicalHistoryRepo->createSurgicalHistory($inputData);
        } else {
            $response = $this->surgicalHistoryRepo->updateSurgicalHistory($inputData, $surgicalHistoryId);
        }
//        return redirect('/patient/medicalRecords');
        return json_encode(array('success' => true, 'action' => 'reloadDatatable', 'table' => 'surgical_history'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function editSurgicalHistory(Request $request, $id) {
        $this->surgicalHistoryRepo = new SurgicalHistoryRepository();
        $surgicalHistoryData = $this->surgicalHistoryRepo->getSurgicalHistoryById($id);
        return view("Patient::popups.add_surgical_history", compact('surgicalHistoryData'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function deleteSurgicalHistory(Request $request, $id) {
        $this->surgicalHistoryRepo = new SurgicalHistoryRepository();
        $surgicalHistoryData = $this->surgicalHistoryRepo->deleteSurgicalHistory($id);
        return redirect('/patient/medicalRecords');
    }

    /**
     * Get the list of past family histories of patients.
     *
     * @return Response
     */
    public function getFamilyHistory() {
        $patientId = Auth::guard('patient')->user()->id;
        $this->familyHistoryRepo = new FamilyHistoryRepository();
        $familyHistoryList = $this->familyHistoryRepo->getFamilyHistoryList($patientId);
        return Datatables::of($familyHistoryList)
                        ->addColumn('action', function($familyHistoryList) {
                            return '<a href="' . route('patient.delete.family_history', $familyHistoryList->id) . '" class="med-rec-del edit pull-right delete_family_history" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                            <span data-toggle="modal" data-target="#familyHistoryModal" data-remote="' . route('patient.edit.family_history', $familyHistoryList->id) . '"><a href="javascript:void(0);" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a></span>';
                        })
                        ->make(true);
    }

    /**
     * Insert new family histories added by patients.
     *
     * @return Response
     */
    public function addFamilyHistory() {
        $familyHistoryData = new FamilyHistoryRepository();
        $familyHistoryData->id = '';
        return view("Patient::popups.add_family_history", compact('familyHistoryData'));
    }

    /**
     * Insert new family history added by patients.
     *
     * @return Response
     */
    public function postFamilyHistory(FamilyHistoryRequest $request) {
        $inputData = $request->all();
        $familyHistoryId = $inputData['family_history_id'];
        $this->familyHistoryRepo = new FamilyHistoryRepository();
        if ($familyHistoryId == '') {
            $response = $this->familyHistoryRepo->createFamilyHistory($inputData);
        } else {
            $response = $this->familyHistoryRepo->updateFamilyHistory($inputData, $familyHistoryId);
        }
//        return redirect('/patient/medicalRecords');
        return json_encode(array('success' => true, 'action' => 'reloadDatatable', 'table' => 'family_history'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function editFamilyHistory(Request $request, $id) {
        $this->familyHistoryRepo = new FamilyHistoryRepository();
        $familyHistoryData = $this->familyHistoryRepo->getFamilyHistoryById($id);
        return view("Patient::popups.add_family_history", compact('familyHistoryData'));
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function deleteFamilyHistory(Request $request, $id) {
        $this->familyHistoryRepo = new FamilyHistoryRepository();
        $familyHistoryData = $this->familyHistoryRepo->deleteFamilyHistory($id);
        return redirect('/patient/medicalRecords');
    }

    /**
     * Edit allergies added by patients.
     *
     * @return Response
     */
    public function postSocialHistory(SocialHistoryRequest $request) {
        $this->socialHistoryRepo = new SocialHistoryRepository();
        $socialHistoryData = $this->socialHistoryRepo->updateSocialHistory($request->all());
        return redirect('/patient/medicalRecords');
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
            $user['receiver_type']  = 2;  
            $user['receiver_id']  = Auth::guard('patient')->User()->id;    
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
        $agree      = $request['agree'];
        $id         = $request['userId'];
        
        // To update the agreement status
        if ($agree == 1) {
            $agreement = Patient::find($id);
            $agreement ->agreed = 'Y';
            $agreement ->agreed_at = \Carbon\Carbon::now(); 
            $agreement->save();
        }
        return 'success';
    }
}
