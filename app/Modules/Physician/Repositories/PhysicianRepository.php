<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\Physician;
use \DB;

class PhysicianRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->physician = new Physician();
    }

    /**
     * update  Question flags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateUserProfile($userId, $inputData)
    {
        return $this->physician->where('id', $userId)->update($inputData);
    }

    /**
     * unlock physician.
     *
     * @return \Illuminate\Support\Collection
     */
    public function unlockPhysician($userId, $updateData)
    {
        $result = $this->physician->where('id', $userId)->update($updateData);
        return $result;
    }

    /**
     * get physicians
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsers($inputData)
    {//distinct question_recipients.patient_id AS link_patients  , 
        // print_r($inputData);
        if (key_exists('selectWith', $inputData) && $inputData['selectWith'] == 'PatientsCount')
            $query = $this->physician->select(DB::raw('COUNT(DISTINCT question_recipients.patient_id) AS link_patients'), 'users.id', 'users.name', 'users.hospital_name', 'users.last_logged_in', 'users.is_account_active', 'users.isLocked');
        else
            $query = $this->physician->select('users.id', 'users.name', 'users.hospital_name', 'users.last_logged_in', 'users.is_subscribed');
            
        if (key_exists('userType', $inputData))
            $query = $query->where('users.user_role', '=', 'D');  
        if (key_exists('selectWith', $inputData) && $inputData['selectWith'] == 'PatientsCount')
            $query = $query->leftJoin('question_recipients', 'users.id', '=', 'question_recipients.physician_id');

        if (key_exists('email', $inputData))
            $query  = $query->where('users.email', $inputData['email']);
        if (!key_exists('email', $inputData) &&  ( (key_exists('listType', $inputData) && $inputData['listType'] != 'list' )))
            $query  = $query->where('users.is_account_active', 'Y');
        $result = $query->groupBy('users.id')->orderBy('users.id','DESC');
        if (key_exists('email', $inputData))
            $result = $query->get()->first();
        
    
        return $result;
    }

    /**
     * get  physician by id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPhysicianById($userId)
    {
        $query = $this->physician->where('id', $userId)->first();
        return $query;
    }

    public function createRow($inputData)
    {
        return $this->physician->create([
                'email' => $inputData['email'],
                'user_role' => 'D',
        ]);
    }
}
