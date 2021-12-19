<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Patient\Models\Patient;

class PatientRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->patient = new Patient();
    }

    /**
     * update  Question flags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateUserProfile($userId, $inputData)
    {
        return $this->patient->where('id', $userId)->update($inputData);
    }
    
    /**
     * get  patient info
     *
     * @return \Illuminate\Support\Collection
     */
    public function getData($userId)
    {
        return $this->patient->where('id', $userId)->get()->first();
    }
}
