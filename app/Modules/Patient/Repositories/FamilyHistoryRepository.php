<?php

namespace App\Modules\Patient\Repositories;

use App\Modules\Patient\Models\FamilyHistory;
use Illuminate\Support\Facades\Auth;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vinkla\Hashids\Facades\Hashids;


class FamilyHistoryRepository extends BaseRepository implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct() {
        $this->familyHistory = new FamilyHistory();
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getFamilyHistoryList($patientId = 0) {
         if(!is_numeric($patientId)){
           $patientId = Hashids::decode($patientId);
           $patientId = $patientId[0]; 
         }
        if ($patientId > 0)
            $query = $this->familyHistory->where('patient_id', '=', $patientId)->orderBy('id', 'desc')->get();
        else
            $query = $this->familyHistory->get();
        return $query;
    }

    /**
     * create medical history added by patients.
     *
     * @return Response
     */
    public function createFamilyHistory($data) {
        $familyHistoryData['patient_id'] = Auth::guard('patient')->id();
        $familyHistoryData['illness'] = $data['illness'];
        $familyHistoryData['relation'] = $data['relation'];
        $query = $this->familyHistory->create($familyHistoryData);
        return true;
    }

    /**
     * update medical history added by patients.
     *
     * @return Response
     */
    public function updateFamilyHistory($data, $familyHistoryId) {
        $familyHistoryData['illness'] = $data['illness'];
        $familyHistoryData['relation'] = $data['relation'];
        $query = $this->familyHistory->where('id', $familyHistoryId)->update($familyHistoryData);
        return true;
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function deleteFamilyHistory($familyHistoryId) {
        $query = $this->familyHistory->where('id', $familyHistoryId)->delete();
        return true;
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getFamilyHistoryById($id) {
        return $this->familyHistory->where('id', $id)->first();
    }

}
