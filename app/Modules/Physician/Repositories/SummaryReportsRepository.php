<?php namespace App\Modules\Physician\Repositories;

// Models
use App\Modules\Physician\Models\SummaryReports;

class SummaryReportsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->summaryReports = new SummaryReports();
    }

    public function createRow($requestData)
    {
        $insertData['patient_id']             = $requestData['pid'];
        $insertData['physician_id']           = $requestData['phyId'];
        $insertData['question_set_id']        = $requestData['qid'];
        $insertData['send_to_id']             = $requestData['sendToId'];
        $insertData['report_type']            = $requestData['report_type'];
        $insertData['question_recipients_id'] = $requestData['rid'];
        $insertData['report']                 = $requestData['summary'];
        $insertData['pdf_file']                 = $requestData['pdf_file'];
 
        return $this->summaryReports->create($insertData);
    }
    
//     public function createRow($requestData)
//    {
        
}
