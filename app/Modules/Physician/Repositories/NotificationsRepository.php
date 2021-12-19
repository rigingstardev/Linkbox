<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\Notifications;
use \DB;
use App\Modules\Physician\Models\Physician;
use Illuminate\Support\Facades\Mail;
use App\Mail\SummaryReport;
use App\Modules\Admin\Repositories\PatientsRepository;
use App\Modules\Physician\Repositories\PhysicianRepository;

class NotificationsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->notifications = new Notifications();
    }

    /**
     * Save notification.
     *
     * @return \Illuminate\Support\Collection
     */
    public function save($inputData)
    {
        return $this->notifications->create($inputData);
    }

    /**
     * Save notification.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getData($sendData)
    {
        $userData    = $sendData['user'];
        $requestData = $sendData['request'];


        if ($requestData['listType'] == 'Notifications')
            $query = $this->notifications
                    ->select(DB::raw('notifications.*'), 'users.name', 'users.hospital_name', 'users.profile_image', 'questions.title', 'question_recipients.id as qResId')->leftJoin('users', 'notifications.sender_id', '=', 'users.id');
        if ($requestData['listType'] == 'Admin')
            $query = $this->notifications
                    ->select(DB::raw('notifications.*'), 'users.name', 'users.hospital_name', 'users.profile_image', 'questions.title')->leftJoin('users', 'notifications.sender_id', '=', 'users.id');

        if ($requestData['listType'] == 'Admin')
            $query = $query->where('notification_type', '=', '2')->where('sender_type', '=', '1')
                ->leftJoin('questions', 'notifications.question_id', '=', 'questions.id')
                ->where('notifications.receiver_id', '=', $userData->id);


        elseif ($requestData['listType'] == 'Notifications') {
            $query = $query->where('notification_type', '=', '3')->where('sender_type', '=', '2')
                ->leftJoin('questions', function($join) {
                    $join->on('notifications.question_id', '=', 'questions.id');
                })
                ->leftJoin('question_recipients', function($join) {
                    $join->on(DB::raw('notifications.receiver_id'), '=', 'question_recipients.patient_id')
                    ->where(DB::raw('question_recipients.physician_id'), '=', 'notifications.sender_id')
                    ->where('question_recipients.question_id', '=', DB::raw('questions.id'));
                })
                ->where('notifications.receiver_id', '=', $userData->id);
        } elseif ($requestData['listType'] == 'Approvals') {
            $query = $this->notifications
                ->select(DB::raw('notifications.*'), 'users.name', 'users.hospital_name', 'users.profile_image', 'questions.title', DB::raw('ref.name as ref_user_name'), 'ref.is_account_active', DB::raw('ref.hospital_name as ref_user_hospital_name'), 'question_recipients.id as qResId', 'manage_reports.report_type', 'manage_reports.pdf_file')
                ->where('notification_type', '=', '4')->where('sender_type', '=', '2')
                ->leftJoin('questions', 'notifications.question_id', '=', 'questions.id')
                ->leftJoin('question_recipients', 'questions.id', '=', 'question_recipients.question_id')
                ->where('notifications.question_recipients_id', '=', DB::raw('question_recipients.id'))
                ->where('question_recipients.status', '=', 'completed')
                ->where('notifications.sender_id', '=', DB::raw('question_recipients.physician_id'))
                ->leftJoin(DB::raw('users ref'), 'notifications.send_report_to', '=', 'ref.id')
                ->leftJoin('users', 'notifications.sender_id', '=', 'users.id')
                ->leftJoin('manage_reports', 'notifications.id', '=', 'manage_reports.notification_id')
                ->where('notifications.receiver_id', '=', $userData->id);
        } elseif ($requestData['listType'] == 'Clinical')
            $query = $this->notifications->select(DB::raw('notifications.*'), DB::raw('CONCAT(patients.first_name," ",patients.last_name) AS name '), 'questions.title')
//                    ->leftJoin('patients', 'notifications.sender_id', '=', 'patients.id')
                ->leftJoin('patients', function($join) {

                    $join->on('notifications.sender_id', '=', 'patients.id');
                })
                ->leftJoin('questions', 'notifications.question_id', '=', 'questions.id')
                ->where('patients.is_account_active', '=', 'Y')
                ->where('notification_type', '=', '1')
                ->where('notifications.receiver_id', '=', $userData->id)
                ->where(function($query) {
                $query->where('sender_type', '=', '2')->orWhere('sender_type', '=', '3');
            });

        // getting query count only of un read messages
        if (key_exists('queryType', $requestData) && $requestData['queryType'] == 'count') {
            if ($requestData['listType'] == 'Notifications')
                $result = $query->where('questions.active', '<>', 'N')->where('is_seen', '=', '0')->get()->count();
//                $result = $query->where('is_seen', '=', '0')->groupBy('question_recipients.id')->get()->count();
            else
                $result = $query->where('questions.active', '<>', 'N')->where('is_seen', '=', '0')->get()->count();
        } else {
            if ($requestData['listType'] == 'Notifications')
//                $result = $query->groupBy('question_recipients.id')->orderBy('notifications.updated_at', 'DESC')->get();
                $result = $query->where('questions.active', '<>', 'N')->orderBy('notifications.updated_at', 'DESC')->get();
            else
                $result = $query->where('questions.active', '<>', 'N')->orderBy('notifications.updated_at', 'DESC')->get();
        }

        return $result;
    }

    /**
     * Save notification.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateData($inputData, $updateData)
    {
        if ((key_exists('nid', $inputData) && key_exists('is_seen', $inputData) && key_exists('userId', $inputData)) || key_exists('notifId', $inputData))
            $result = $this->notifications->where('id', $inputData['nid'])->update($updateData);

        elseif (key_exists('nid', $inputData) && key_exists('status', $updateData) && key_exists('userId', $inputData)) {
            $updateData['is_seen'] = 1;
            $result                = $this->notifications->where('id', $inputData['nid'])->update($updateData);
        }
        return $result;
    }

    public function getID($inData)
    {
        $result = $this->notifications->where('is_seen', '=', '0')->where('question_id', '=', $inData['question_id'])->where('receiver_id', '=', $inData['receiver_id'])->where('receiver_type', '=', $inData['receiver_type'])->get()->first();
        return $result;
    }

    public function emailSummaryReport($notification_id)
    {
        $this->patientsRepo  = new PatientsRepository();
        $this->physicianRepo = new PhysicianRepository();
        $query               = $this->notifications
            ->select('notifications.id', 'notifications.sender_id', 'notifications.receiver_id', 'users.name', 'users.email', 'manage_reports.report_type', 'manage_reports.pdf_file')
            ->leftJoin('users', 'notifications.send_report_to', '=', 'users.id')
            ->leftJoin('manage_reports', 'manage_reports.notification_id', '=', 'notifications.id')
            ->where('notifications.id', '=', $notification_id);
        $result              = $query->first();
        $patientDetails      = $this->patientsRepo->getPatientById($result->receiver_id);
        $physicianDetails    = $this->physicianRepo->getPhysicianById($result->sender_id);

        $result->patient_name   = $patientDetails->first_name . " " . $patientDetails->last_name;
        $result->physician_name = $physicianDetails->name;
        //        $result->email;
        Mail::to($result->email)->send(new SummaryReport($result));
    }
    /**
     * Delete notification.
     *
     * @return \Illuminate\Support\Collection
     */
    public function delete($notificationId,$user)
    {           
        $data = $this->notifications->where('id',$notificationId)->where('receiver_type',$user['receiver_type'])->where('receiver_id',$user['receiver_id'])->first();
        $response = 0;
        if ($data) {
            $response = 1;
            $data->delete();
        }
        return $response;
    }
}
