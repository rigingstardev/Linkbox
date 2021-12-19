<?php namespace App\Modules\Admin\Repositories;

use App\Modules\Admin\Models\Patient;
use \DB;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class PatientsRepository extends BaseRepository  implements Auditable{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

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
     * get  patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPatients($inputData)
    {
        $query = $this->patient->select(DB::raw('patients.*'));
        if ($inputData['selectFields'] == 'all')
            $query = $query->whereIn('is_account_active', ['Y']);
        else
            $query = $query->whereIn('is_account_active', ['Y', 'N']);
        return $query;
    }

    /**
     * get  patient by id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPatientById($userId)
    {
        $query = $this->patient->where('id', $userId)->first();
        return $query;
    }

    /**
     * update patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updatePatients($inputData, $updateData)
    {
        $result = $this->patient->where('id', $inputData['id'])->update($updateData);
        return $result;
    }

    /**
     * unlock patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function unlockPatient($inputData, $updateData)
    {
        $result = $this->patient->where('id', $inputData['id'])->update($updateData);
        return $result;
    }
}
