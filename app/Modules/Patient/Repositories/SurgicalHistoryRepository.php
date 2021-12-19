<?php namespace App\Modules\Patient\Repositories;

use App\Modules\Patient\Models\SurgicalHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vinkla\Hashids\Facades\Hashids;

class SurgicalHistoryRepository extends BaseRepository  implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->surgicalHistory = new SurgicalHistory();
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getSurgicalHistoryList($patientId = 0)
    {
        if(!is_numeric($patientId)){
            $patientId = Hashids::decode($patientId);
            $patientId = $patientId[0]; 
        }
        if ($patientId > 0)
            $query = $this->surgicalHistory->where('patient_id', '=', $patientId)->orderBy('id', 'desc')->get();
        else
            $query = $this->surgicalHistory->get();
        return $query;
    }

    /**
     * create medical history added by patients.
     *
     * @return Response
     */
    public function createSurgicalHistory($data)
    {
        $surgicalHistoryData['patient_id']   = Auth::guard('patient')->id();
        $surgicalHistoryData['surgery']      = $data['surgery'];
        $surgicalHistoryData['surgery_date'] = Carbon::parse($data['surgery_date'])->format('Y-m-d');
        $query                               = $this->surgicalHistory->create($surgicalHistoryData);
        return true;
    }

    /**
     * update medical history added by patients.
     *
     * @return Response
     */
    public function updateSurgicalHistory($data, $surgicalHistoryId)
    {
        $surgicalHistoryData['surgery']      = $data['surgery'];
        $surgicalHistoryData['surgery_date'] = Carbon::parse($data['surgery_date'])->format('Y-m-d');
        $query                               = $this->surgicalHistory->where('id', $surgicalHistoryId)->update($surgicalHistoryData);
        return true;
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function deleteSurgicalHistory($surgicalHistoryId)
    {
        $query = $this->surgicalHistory->where('id', $surgicalHistoryId)->delete();
        return true;
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getSurgicalHistoryById($id)
    {
        return $this->surgicalHistory->where('id', $id)->first();
    }
}
