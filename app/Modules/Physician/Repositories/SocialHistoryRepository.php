<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Patient\Models\SocialHistory;
use Illuminate\Support\Facades\Auth;

class SocialHistoryRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->socialHistory = new SocialHistory();
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function getSocialHistory($patientId = 0)
    {
        if ($patientId > 0)
            $query = $this->socialHistory->where('patient_id', $patientId)->first();
        else
            $query = $this->socialHistory->where('patient_id', Auth::guard('patient')->id())->first();

        return $query;
    }

    /**
     * Get the list of allergies added by patients.
     *
     * @return Response
     */
    public function updateSocialHistory($data)
    {
        $socialHistoryData           = $this->socialHistory->firstOrNew(array('patient_id' => Auth::guard('patient')->id()));
        $socialHistoryData->smoke    = $data['patient_smoke'];
        $socialHistoryData->drink    = $data['patient_drink'];
        $socialHistoryData->drug     = $data['patient_drug'];
        $socialHistoryData->comments = $data['comments'];
        $socialHistoryData->save();
        return true;
    }
}
