<?php namespace App\Modules\Physician\Repositories;

use App\Models\QuestionReceipients;
use App\Modules\Physician\Models\Patient;
use App\Modules\Physician\Models\Notifications;
use App\Modules\Physician\Repositories\NotificationsRepository;
use App\Modules\Physician\Repositories\CategoryNarrativeOutputRepository;
use \DB;
use Carbon\Carbon;
use App\Models\Questions;

class QuestionReceipientsRepository extends BaseRepository
{

    protected $model;
    public $questionRec;

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->model             = new QuestionReceipients;
        $this->patient           = new Patient;
        $this->notificationsRepo = new NotificationsRepository;
        $this->CatNarrativeOutputRepo = new CategoryNarrativeOutputRepository;
        $this->questions         = new Questions;
    }

    /**
     * Sending question sets to patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function update($checkData, $updateData)
    {
        $query  = $this->model;
        if (key_exists('rid', $checkData))
            $query  = $query->where('id', '=', $checkData['rid']);
        if (key_exists('qid', $checkData))
            $query  = $query->where('question_id', '=', $checkData['qid']);
        if (key_exists('pid', $checkData))
            $query  = $query->where('patient_id', '=', $checkData['pid']);
        $result = $query->update($updateData);

        return $result;
    }

    /**
     * update question receipients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function resendToPatient($requestData)
    { 
        $physicianID              = $requestData['physician_id'];
        $checkData['rid']         = $requestData['rid'];
        $checkData['qid']         = $requestData['qid'];
        $checkData['pid']         = $requestData['pid'];
        $updateData['status']     =  'pending';
        $updateData['created_at'] = date('Y-m-d H:i:s');
        if ($this->update($checkData, $updateData)) {
            $notification = $this->notificationsRepo->save(array('question_id' => $checkData['qid'], 'notification_type' => 3, 'message' => 'trans_patient_received_qn_set_line1', 'sender_id' => $physicianID, 'sender_type' => 2, 'receiver_id' => $checkData['pid'], 'question_recipients_id' => $checkData['rid'], 'receiver_type' => 2));
            $patient = $this->patient->find($checkData['pid']);
            return $patient;
        }
    }

    /**
     * Sending question sets to patients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function sendToPatient($inputData)
    {
        $questionReceipients              = $this->model;
        $questionReceipients->question_id = $inputData['question_id'];
        $questionReceipients->status      = 'pending';


// getting patient details.
        $patientQry = $this->patient->select('id', 'email', DB::raw('CONCAT(patients.first_name," ",patients.last_name) AS name '), 'contact_number', 'is_account_active');
        if (key_exists('chkBxEmail', $inputData) && $inputData['chkBxEmail'] == 'email' || key_exists('email', $inputData))
            $result     = $patientQry->where('email', $inputData['email'])->first();
        else if (key_exists('chkBxText', $inputData) && $inputData['chkBxText'] == 'text')
            $result     = $patientQry->where('contact_number', $inputData['phone'])->first();

        if ($result) {
            $questionReceipients->physician_id = $inputData['physician_id'];
            $questionReceipients->patient_id   = $result->id;
            $patientID                         = $result->id;
            if ($result->is_account_active == 'P') {
                if (key_exists('chkBxEmail', $inputData) && $inputData['chkBxEmail'] == 'email')
                    $questionReceipients->uuid = encryptString($inputData['email'], 'base64');
                else if (key_exists('chkBxText', $inputData) && $inputData['chkBxText'] == 'text')
                    $questionReceipients->uuid = encryptString($inputData['phone'], 'base64');
                $result                    = $questionReceipients->uuid;
            }
        } else {
            if (key_exists('chkBxEmail', $inputData) && $inputData['chkBxEmail'] == 'email') {
// creating the new patient entry  (a dummy registration) . getting the user id to map to the question set
                $resultData                = $this->patient->create(array('first_name' => '-', 'email' => $inputData['email'], 'password' => str_random(32), 'is_account_active' => 'P', 'gender' => '-', 'entry_type' => 'E'));
                $questionReceipients->uuid = encryptString($inputData['email'], 'base64'); //$this->generateUUID();
            } else if (key_exists('chkBxText', $inputData) && $inputData['chkBxText'] == 'text') {
// creating the new patient entry  (a dummy registration) . getting the user id to map to the question set
            $inputs = array('first_name' => '-', 
                            'email' => str_random(32), 
                            'contact_number' => $inputData['phone'], 
                            'password' => str_random(32), 
                            'is_account_active' => 'P', 
                            'gender' => '-', 
                            'entry_type' => 'T'
                        );
                $resultData                = $this->patient->create($inputs);
                $questionReceipients->uuid = encryptString($inputData['phone'], 'base64'); //$this->generateUUID();
            }
            $questionReceipients->patient_id   = $resultData->id;
            $questionReceipients->physician_id = $inputData['physician_id'];
            $patientID                         = $resultData->id;
            $result                            = $questionReceipients->uuid;
        }
        $quesRecId              = 0;
        $checkIfSetActive       = $this->getPendingQuestionSets($patientID, 'pending', $inputData['question_id'], $inputData['physician_id']);
        if (count((array)$checkIfSetActive) == 0)
            $checkIfRespondedActive = $this->getPendingQuestionSets($patientID, 'responded', $inputData['question_id'], $inputData['physician_id']);
        else
            $checkIfRespondedActive = array();
        if (count((array)$checkIfRespondedActive) > 0)
            $this->updateQuestionSetsAsPending($checkIfRespondedActive->id);

        if (count((array)$checkIfSetActive) == 0 && count((array)$checkIfRespondedActive) == 0) {
// if the question set sending is by single entry
            if ($inputData['selectType'] == 'single') {
                $datach    = $questionReceipients->save();
                $quesRecId = $questionReceipients->id;
            } else {
// if the question set sending is by multiple entry
                $input['patient_id']   = $result->id;
                $input['status']       = $questionReceipients->status;
                $input['question_id']  = $inputData['question_id'];
                $input['physician_id'] = $inputData['physician_id'];
//inserting question id and patinet id
                $quesRec               = $questionReceipients->create($input);
                $quesRecId             = $quesRec->id;
            }
        }
        $notification = $this->notificationsRepo->save(array('question_id' => $inputData['question_id'], 'notification_type' => 3, 'message' => 'trans_patient_received_qn_set_line1', 'sender_id' => $inputData['physician_id'], 'sender_type' => 2, 'receiver_id' => $patientID, 'question_recipients_id' => $quesRecId, 'receiver_type' => 2));

        return $result;
    }

    public function updateQuestionSetsAsPending($questRecId)
    {
        return $this->model->where('id', $questRecId)->update(array('status' => 'pending'));
    }

    public function getPendingQuestionSets($patientId, $status, $questionId, $physicianId)
    {
        $result = $this->model->where('patient_id', $patientId)
                ->where('status', $status)
                ->where('question_id', $questionId)
                ->where('physician_id', $physicianId)
                ->get()->first();
        return $result;
    }

    /**
     * Generating uuid string
     * return string
     */
    public function generateUUID()
    {
        return str_random(32);
    }

    /**
     * Update patient id using uuid
     */
    public function updatePatientId($uuid, $patientId)
    {
        $result = $this->model
            ->where('uuid', 'like', $uuid)
            ->update(['patient_id' => $patientId, 'uuid' => NULL]);
        return true;
    }

    /**
     * get  patient id from uuid
     */
    public function getPatientIdFromUUid($uuid)
    {
        $result = $this->model->select('patient_id')
                ->where('uuid', 'like', $uuid)
                ->get()->first();
        return $result;
    }

    public function getIdFromEmailIdForActiveP($email)
    {
        $result = $this->patient->where('email', $email)//->orWhere('contact_number',$email)
                ->where('is_account_active', 'P')
                ->get()->first();
        return $result;
    }

    public function getIdFromContactNoForActiveP($contact)
    {
        $result = $this->patient->where('contact_number', $contact)
                ->where('is_account_active', 'P')
                ->get()->first();
        return $result;
    }

    public function getPatientDetails($id)
    {
        $result = $this->patient->where('id', $id)
                ->where('is_account_active', 'Y')
                ->get()->first();
        return $result;
    }

    /**
     * Get all receipients.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allReceipients($questionId, $userId)
    {
        return $this->model->select('patients.first_name', 'patients.last_name', 'patients.email', 'patients.contact_number', 'patients.is_account_active', 'patients.activation_code', 'patients.entry_type', 'question_recipients.id', 'question_recipients.status', 'question_recipients.created_at')
                ->where('status', '<>', 'cancelled')
                ->where('physician_id', $userId)
                ->leftJoin('patients', 'patients.id', '=', 'question_recipients.patient_id')
                ->where('patients.is_account_active', '<>', 'N');
    }

    /**
     * Initialize to get the details from the Recipient Id.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function summaryData($qRecId)
    {
        $summaryDet      = $this->model->with('patient', 'question', 'question.questionSets.category', 'answers', 'question.questionSets.defaultOptions', 'question.questionSets.narrativeOutput', 'question.questionSets.yesNoQuestions','question.questionNarrativeOutput')->where('id', $qRecId)->get()->toArray();
        $summaryDet      = end($summaryDet);  
        $answers         = [];
        $narrativeOutput = []; 
        $yesno = [];
        $yesnooutput = [];
        $questions = []; 

        $clinicalQscol = collect($summaryDet['question']['question_sets']);
        $clinicalQs = $clinicalQscol->where('clinical_question',1)->toArray(); 

        foreach ($summaryDet['question']['question_sets'] as $questionSet) {
            if (in_array($questionSet['id'], $questions))
                continue;

            $questions[]                                                                                          = $questionSet['id'];
            $narrativeOutput[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $questionSet['narrative_output']['narrative_output'];

            $answerColl     = collect($summaryDet['answers']);
            $filteredAnswer = $answerColl->where('question_category_id', $questionSet['id'])->toArray();
            $answerText     = "";
            $answer         = end($filteredAnswer);
            $answerText     = $answer['answer'];

            if (!empty($answer)) {
                if ($questionSet['answer_method'] == '3Combo' || $questionSet['answer_method'] == 'mcq' || $questionSet['answer_method'] == 'dropDown')
                    $answerText                                                                                   = $this->getAnswerBytype($questionSet, $answer);
                $answers[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $answerText;
                if ($questionSet['answer_method'] == 'yesNo') {

                    foreach ($questionSet['yes_no_questions'] as $yesnoques) {
                        $questions[]         = $yesnoques['ans_question_category_id'];
                        $answerTextyesNo     = '';
                        $ans                 = [];
                        $yesNoqs             = collect($summaryDet['question']['question_sets']);
                        $yesNoquestion       = $yesNoqs->where('id', $yesnoques['ans_question_category_id'])->toArray();
                        $yesNoquestion       = end($yesNoquestion);
                        $filteredAnsweryesNo = $answerColl->where('question_category_id', $yesnoques['ans_question_category_id'])->toArray();
                        $yesnoanswerText     = "";
                        $answeryesNo         = end($filteredAnsweryesNo);
                        $yesnoanswerText     = $answer['answer'];
                        if (count((array)$yesNoquestion) > 0) {
                            $yesnoanswerText = $answeryesNo['answer'];
                            if ($yesNoquestion['answer_method'] == '3Combo' || $yesNoquestion['answer_method'] == 'mcq' || $yesNoquestion['answer_method'] == 'dropDown')
                                $yesnoanswerText = $this->getAnswerBytype($yesNoquestion, $answeryesNo);

                            if (!empty($yesnoanswerText)) {
                                $yesno[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']]       = $yesnoanswerText;
                                $yesnooutput[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $yesNoquestion['narrative_output']['narrative_output'];
                            }
                        }
                    }
                }
            }
        }
        $questionRec                    = ['status' => $summaryDet['status'], 'patient_id' => $summaryDet['patient_id'], 'question_id' => $summaryDet['question_id'], 'id' => $summaryDet['id']];
        $question['title']              = $summaryDet['question']['title'];

        $questnarrativeOutput = $this->CatNarrativeOutputRepo->getDefaultNarrativeOutput()->narrative_output_p1;
        if(isset($summaryDet['question']['question_narrative_output']['narrative_output']))
            if(!empty($summaryDet['question']['question_narrative_output']['narrative_output']))
                $questnarrativeOutput = $summaryDet['question']['question_narrative_output']['narrative_output'];
       
        $question['narrative_output']   = $questnarrativeOutput;
        $questionRec['patient']         = [ 'id' => $summaryDet['patient']['id'],
            'first_name' => $summaryDet['patient']['first_name'],
            'last_name' => $summaryDet['patient']['last_name'],
            'dob' => $summaryDet['patient']['dob'],
            'gender' => $summaryDet['patient']['gender'],
            'contact_number' => $summaryDet['patient']['contact_number'],
            'email' => $summaryDet['patient']['email']
        ];
        $questionRec['answers']         = $answers;
        $questionRec['narrativeOutput'] = $narrativeOutput;
        $questionRec['yesno'] = $yesno;
        $questionRec['yesnooutput'] = $yesnooutput;
        $questionRec['question']        = $question;            
        $questionRec['clinical']        = $clinicalQs;            
        $this->questionRec = $questionRec;
        $questionRec['yesno']           = $yesno;
        $questionRec['yesnooutput']     = $yesnooutput;
        $questionRec['question']        = $question;
        $this->questionRec              = $questionRec;
    }
    /**
     * To Convert the answer based on answer method
     *
     * @var array questionSet,answer
     * @return \Illuminate\Support\Collection
     */
    public function getAnswerBytype($questionSet, $answer)
    {
        $answerText = "";
        if (empty($questionSet) && empty($answer))
            return null;
        $type       = $questionSet['answer_method'];
        if ('3Combo' == $type) {
            $answerArr  = unserialize($answer['answer']);                  
            if($answerArr['0'] == 1)
                $answerArr['1'] = str_singular($answerArr['1']);
            $answerText = implode(" ", $answerArr);
        }
        if ($type == 'mcq' || $type == 'dropDown') {
            $answerText = "";
            if ('Y' == $questionSet['allow_multiple_answer'])
                $answerArr  = unserialize($answer['answer']);
            else
                $answerArr  = $answer['answer'];
            $lastEle    = '';
            foreach ($questionSet['default_options'] as $defaultOpt) {
                if ($defaultOpt['question_category_id'] == $questionSet['id']) {
                    if (is_array($answerArr)) {
                        // To add 'and' before the last string
                        if (count((array)$answerArr) > 1) {
                            $lastArr = $answerArr;
                            $lastEle = array_pop($lastArr);
                        }
                        if (in_array($defaultOpt['id'], $answerArr)) {
                            if (!empty($lastEle) && $defaultOpt['id'] == $lastEle) {
                                // To add 'and' before the last string
                                $answerText = rtrim($answerText, ',');
                                $answerText .= ' and ' . $defaultOpt['default_option'] . ", ";
                            } else {
                                $answerText .= $defaultOpt['default_option'] . ", ";
                            }
                        }
                    } else {
                        if ($defaultOpt['id'] == $answerArr)
                            $answerText = $defaultOpt['default_option'];
                    }
                }
            }      
            $answerText = rtrim($answerText, ', ');
            if (!empty($answer['description'])) {
                if (!empty($answerText))
                    $answerText .= ', ';
                $answerText .= $answer['description'];
            }
        }
        return $answerText;
    }

    /**
     * Get Categorywise Summary report to Display in Full Evaluation.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function summaryReportByCategory($qRecId)
    {

        $category = $this->model->with('question.questionSets.category')->where('id', $qRecId)->get();
        $category = $category->map(function ($value) {
            return $value->question->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
        });
        $category = $category->all();
        $category = end($category)->unique();

        if (empty($this->questionRec))
            $this->summaryData($qRecId);

        $narrativeOutput = $this->questionRec['narrativeOutput'];
        $answers         = $this->questionRec['answers'];
        $question        = $this->questionRec['question'];
        $outputCat       = [];
        foreach ($category as $key => $val) {
            $answerStr = "";
            foreach ($answers as $ans => $ansVal) {
                if ($ans == $key) {
                    foreach ($ansVal as $ansvalkey => $answer) {
                        foreach ($answer as $ankey => $anVal) {
                            $answerStr .= formatSummary($narrativeOutput[$ans][$ansvalkey][$ankey], getAnswersAsString($answer));
                        }
                    }
                }
                $answerStr = strReplaceCC($answerStr, $question['title']);
                $answerStr = formatGender($answerStr, $this->questionRec['patient']['gender']);
            }
            if (!empty($answerStr))
                $outputCat[$val] = $answerStr;
        }
        return $outputCat;
    }

    /**
     * Summary report.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function summaryReport($qRecId)
    { 
        $summaryDet = $this->model->with('patient', 'question')->where('id', $qRecId)->get()->toArray();
        $summaryDet = end($summaryDet);

        if (empty($this->questionRec))
            $this->summaryData($qRecId);
        
        $convertData['name'] = $summaryDet['patient']['first_name'] . ' ' . $summaryDet['patient']['last_name'];
        $convertData['dob']  = $summaryDet['patient']['dob'];
        $questnarrativeoutput = $this->questionRec['question']['narrative_output']; 
        $narrativeOutput = $this->questionRec['narrativeOutput'];
        $answers         = $this->questionRec['answers'];
        $yesno           = $this->questionRec['yesno'];
        $yesnooutput     = $this->questionRec['yesnooutput'];

        $summary    = $questnarrativeoutput."&nbsp;&nbsp;";  
        if (isset($answers['2']['1'])) {
            foreach ($answers['2']['1'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['2']['1'][$answerKey], getAnswersAsString($answers['2']['1'][$answerKey])) . "&nbsp;&nbsp;";
                if (isset($yesno['2']['1'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['2']['1'][$answerKey], getAnswersAsString($yesno['2']['1'][$answerKey])) . "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['1']['2'])) {
            foreach ($answers['1']['2'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['1']['2'][$answerKey], getAnswersAsString($answers['1']['2'][$answerKey])) . "&nbsp;&nbsp;";
                if (isset($yesno['1']['2'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['1']['2'][$answerKey], getAnswersAsString($yesno['1']['2'][$answerKey])) . "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['1']['3'])) {
            foreach ($answers['1']['3'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['1']['3'][$answerKey], getAnswersAsString($answers['1']['3'][$answerKey])) . "&nbsp;&nbsp;";
                if (isset($yesno['1']['3'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['1']['3'][$answerKey], getAnswersAsString($yesno['1']['3'][$answerKey])). "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['4']['4'])) {
            foreach ($answers['4']['4'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['4']['4'][$answerKey], getAnswersAsString($answers['4']['4'][$answerKey])). "&nbsp;&nbsp;";
                if (isset($yesno['4']['4'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['4']['4'][$answerKey], getAnswersAsString($yesno['4']['4'][$answerKey])). "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['4']['5'])) {
            foreach ($answers['4']['5'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['4']['5'][$answerKey], getAnswersAsString($answers['4']['5'][$answerKey])). "&nbsp;&nbsp;";
                if (isset($yesno['4']['5'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['4']['5'][$answerKey], getAnswersAsString($yesno['4']['5'][$answerKey])). "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['3']['7'])) {
            foreach ($answers['3']['7'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['3']['7'][$answerKey], getAnswersAsString($answers['3']['7'][$answerKey])). "&nbsp;&nbsp;";
                if (isset($yesno['3']['7'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['3']['7'][$answerKey], getAnswersAsString($yesno['3']['7'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['3']['6'])) {
            foreach ($answers['3']['6'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['3']['6'][$answerKey], getAnswersAsString($answers['3']['6'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['3']['6'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['3']['6'][$answerKey], getAnswersAsString($yesno['3']['6'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['3']['8'])) {
            foreach ($answers['3']['8'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['3']['8'][$answerKey], getAnswersAsString($answers['3']['8'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['3']['8'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['3']['8'][$answerKey], getAnswersAsString($yesno['3']['8'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['5']['9'])) {
            foreach ($answers['5']['9'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['5']['9'][$answerKey], getAnswersAsString($answers['5']['9'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['5']['9'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['5']['9'][$answerKey], getAnswersAsString($yesno['5']['9'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['6']['10'])) {
            foreach ($answers['6']['10'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['6']['10'][$answerKey], getAnswersAsString($answers['6']['10'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['6']['10'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['6']['10'][$answerKey], getAnswersAsString($yesno['6']['10'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['7']['11'])) {
            foreach ($answers['7']['11'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['7']['11'][$answerKey], getAnswersAsString($answers['7']['11'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['7']['11'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['7']['11'][$answerKey], getAnswersAsString($yesno['7']['11'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['8']['14'])) {
            foreach ($answers['8']['14'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['8']['14'][$answerKey], getAnswersAsString($answers['8']['14'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['8']['14'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['8']['14'][$answerKey], getAnswersAsString($yesno['8']['14'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['9']['12'])) {
            foreach ($answers['9']['12'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['9']['12'][$answerKey], getAnswersAsString($answers['9']['12'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['9']['12'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['9']['12'][$answerKey], getAnswersAsString($yesno['9']['12'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['10']['13'])) {
            foreach ($answers['10']['13'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['10']['13'][$answerKey], getAnswersAsString($answers['10']['13'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['10']['13'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['10']['13'][$answerKey], getAnswersAsString($yesno['10']['13'][$answerKey])).  "&nbsp;&nbsp;";
                }
            }
        }
        if (isset($answers['11']['15'])) {
            foreach ($answers['11']['15'] as $answerKey => $answerVal) {
                $summary .= formatSummary($narrativeOutput['11']['15'][$answerKey], getAnswersAsString($answers['11']['15'][$answerKey])).  "&nbsp;&nbsp;";
                if (isset($yesno['11']['15'][$answerKey])) {
                    $summary .= formatSummary($yesnooutput['11']['15'][$answerKey], getAnswersAsString($yesno['11']['15'][$answerKey])). "&nbsp;&nbsp;";
                }
            }
        }

        $summary = strReplaceCC($summary, $summaryDet['question']['title']);
        $summary = formatGender($summary, $summaryDet['patient']['gender']);
        $summary = formatSummaryOptions($summary,$convertData);
        return $summary;
    }
     /**
     * Get clinical Question.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function clinicalInfo($qRecId)
    {

        if (empty($this->questionRec))
            $this->summaryData($qRecId);

        $narrativeOutput = $this->questionRec['narrativeOutput'];
        $answers         = $this->questionRec['answers'];
        $question        = $this->questionRec['question'];
        $clinical        = $this->questionRec['clinical'];
        $outputClinical  = [];     
        foreach ($clinical as $key => $val) {
            $answerStr = "";
            foreach ($answers as $ans => $ansVal) {                
                    foreach ($ansVal as $ansvalkey => $answer) {
                        foreach($answer as $ankey=>$anVal) {
                            if ($ankey == $val['id']) {
                                $answerStr .= formatSummary($narrativeOutput[$ans][$ansvalkey][$ankey], getAnswersAsString($answer));
                            }
                        }
                    }             
                $answerStr = strReplaceCC($answerStr, $question['title']);
                $answerStr = formatGender($answerStr, $this->questionRec['patient']['gender']);
            }
            if (!empty($answerStr)){
                $qsString = strReplaceCC($val['question'], $question['title']);
                $outputClinical[$qsString] = $answerStr;
            }                
        }      
        return $outputClinical;
    }

    /**
     * Summary report.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function summaryReportOfTestPreview($qRecId, $questions, $popupData)
    {
        $summaryDet = $this->model->with('patient', 'question')->where('id', $qRecId)->get()->toArray();
        $summaryDet = end($summaryDet);
        
        if (empty($this->questionRec))
            $this->testPreviewSummaryData($qRecId, $questions);   

        $convertData['name']    = 'Patient';
        $convertData['age']     = $popupData['age'];
        $questnarrativeoutput   = $this->questionRec['question']['narrative_output']; 
        $narrativeOutput        = $this->questionRec['narrativeOutput'];
        $answers                = $this->questionRec['answers'];
        $yesno                  = $this->questionRec['yesno'];
        $yesnooutput            = $this->questionRec['yesnooutput'];
        $question               = $this->questionRec['question'];
        $summary                = $questnarrativeoutput."&nbsp;&nbsp;";
        
        if (isset($answers['2']['1'])) {
            foreach ($answers['2']['1'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['2']['1'][$answerKey], getAnswersAsString($answers['2']['1'][$answerKey])) . "&nbsp;&nbsp;";
                    if (isset($yesno['2']['1'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['2']['1'][$answerKey], getAnswersAsString($yesno['2']['1'][$answerKey])) . "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['1']['2'])) {
            foreach ($answers['1']['2'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['1']['2'][$answerKey], getAnswersAsString($answers['1']['2'][$answerKey])) . "&nbsp;&nbsp;";
                    if (isset($yesno['1']['2'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['1']['2'][$answerKey], getAnswersAsString($yesno['1']['2'][$answerKey])) . "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['1']['3'])) {
            foreach ($answers['1']['3'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['1']['3'][$answerKey], getAnswersAsString($answers['1']['3'][$answerKey])) . "&nbsp;&nbsp;";
                    if (isset($yesno['1']['3'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['1']['3'][$answerKey], getAnswersAsString($yesno['1']['3'][$answerKey])). "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['4']['4'])) {
            foreach ($answers['4']['4'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['4']['4'][$answerKey], getAnswersAsString($answers['4']['4'][$answerKey])). "&nbsp;&nbsp;";
                    if (isset($yesno['4']['4'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['4']['4'][$answerKey], getAnswersAsString($yesno['4']['4'][$answerKey])). "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['4']['5'])) {
            foreach ($answers['4']['5'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['4']['5'][$answerKey], getAnswersAsString($answers['4']['5'][$answerKey])). "&nbsp;&nbsp;";
                    if (isset($yesno['4']['5'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['4']['5'][$answerKey], getAnswersAsString($yesno['4']['5'][$answerKey])). "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['3']['7'])) {
            foreach ($answers['3']['7'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['3']['7'][$answerKey], getAnswersAsString($answers['3']['7'][$answerKey])). "&nbsp;&nbsp;";
                    if (isset($yesno['3']['7'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['3']['7'][$answerKey], getAnswersAsString($yesno['3']['7'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['3']['6'])) {
            foreach ($answers['3']['6'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['3']['6'][$answerKey], getAnswersAsString($answers['3']['6'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['3']['6'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['3']['6'][$answerKey], getAnswersAsString($yesno['3']['6'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['3']['8'])) {
            foreach ($answers['3']['8'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['3']['8'][$answerKey], getAnswersAsString($answers['3']['8'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['3']['8'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['3']['8'][$answerKey], getAnswersAsString($yesno['3']['8'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['5']['9'])) {
            foreach ($answers['5']['9'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['5']['9'][$answerKey], getAnswersAsString($answers['5']['9'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['5']['9'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['5']['9'][$answerKey], getAnswersAsString($yesno['5']['9'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['6']['10'])) {
            foreach ($answers['6']['10'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['6']['10'][$answerKey], getAnswersAsString($answers['6']['10'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['6']['10'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['6']['10'][$answerKey], getAnswersAsString($yesno['6']['10'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['7']['11'])) {
            foreach ($answers['7']['11'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['7']['11'][$answerKey], getAnswersAsString($answers['7']['11'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['7']['11'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['7']['11'][$answerKey], getAnswersAsString($yesno['7']['11'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['8']['14'])) {
            foreach ($answers['8']['14'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['8']['14'][$answerKey], getAnswersAsString($answers['8']['14'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['8']['14'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['8']['14'][$answerKey], getAnswersAsString($yesno['8']['14'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['9']['12'])) {
            foreach ($answers['9']['12'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['9']['12'][$answerKey], getAnswersAsString($answers['9']['12'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['9']['12'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['9']['12'][$answerKey], getAnswersAsString($yesno['9']['12'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['10']['13'])) {
            foreach ($answers['10']['13'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['10']['13'][$answerKey], getAnswersAsString($answers['10']['13'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['10']['13'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['10']['13'][$answerKey], getAnswersAsString($yesno['10']['13'][$answerKey])).  "&nbsp;&nbsp;";
                    }
                }
            }
        }
        if (isset($answers['11']['15'])) {
            foreach ($answers['11']['15'] as $answerKey => $answerVal) {
                if (($answerVal!="") || ($answerVal!= null)) {
                    $summary .= formatSummary($narrativeOutput['11']['15'][$answerKey], getAnswersAsString($answers['11']['15'][$answerKey])).  "&nbsp;&nbsp;";
                    if (isset($yesno['11']['15'][$answerKey])) {
                        $summary .= formatSummary($yesnooutput['11']['15'][$answerKey], getAnswersAsString($yesno['11']['15'][$answerKey])). "&nbsp;&nbsp;";
                    }
                }
            }
        }

        $summary = strReplaceCC($summary, $question['title']);
        $summary = formatTestPreviewGender($summary, $popupData['gender']);
        $summary = formatTestPreviewSummaryOptions($summary,$convertData);
        return $summary;
    }
    
    /**
     * Initialize to get the details from the Recipient Id.
     *
     * @var integer question recipient Id
     * @return \Illuminate\Support\Collection
     */
    public function testPreviewSummaryData($qRecId, $request)
    {
        $summaryDet      = $this->questions->with('questionSets', 'questionSets.defaultOptions', 'questionSets.category', 'questionSets.narrativeOutput', 'questionSets.yesNoQuestions', 'questionSetsyesNoCount', 'questionNarrativeOutput')->where('id', $qRecId)->get()->toArray();
        // $summaryDet      = $this->model->with('patient', 'question', 'question.questionSets', 'question.questionSets.defaultOptions', 'answers', 'question.questionSets.category', 'question.questionSets.narrativeOutput', 'question.questionSets.yesNoQuestions', 'question.questionSetsyesNoCount', 'question.questionNarrativeOutput')->where('question_id', $qRecId)->get()->toArray();
        $summaryDet      = end($summaryDet);  

        $answers         = [];
        $narrativeOutput = []; 
        $yesno = [];
        $yesnooutput = [];
        $questions = []; 

        $clinicalQscol = collect($summaryDet['question_sets']);
        $clinicalQs = $clinicalQscol->where('clinical_question',1)->toArray(); 

        foreach ($summaryDet['question_sets'] as $questionSet) {
            if (in_array($questionSet['id'], $questions))
                continue;

            $questions[]                                                                                          = $questionSet['id'];
            $narrativeOutput[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $questionSet['narrative_output']['narrative_output'];

            $answerColl     = collect($request);
            $filteredAnswer = $answerColl->where('question_category_id', $questionSet['id'])->toArray();
            $answerText     = "";
            $answer         = end($filteredAnswer);
            $answerText     = $answer['answer'];

            //if (!empty($answer)) {
                if ($questionSet['answer_method'] == '3Combo' || $questionSet['answer_method'] == 'mcq' || $questionSet['answer_method'] == 'dropDown')
                    $answerText              = $this->getAnswerBytype($questionSet, $answer);
                    $answers[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $answerText;
                if ($questionSet['answer_method'] == 'yesNo') {

                    foreach ($questionSet['yes_no_questions'] as $yesnoques) {
                        $questions[]         = $yesnoques['ans_question_category_id'];
                        $answerTextyesNo     = '';
                        $ans                 = [];
                        $yesNoqs             = collect($summaryDet['question_sets']);
                        $yesNoquestion       = $yesNoqs->where('id', $yesnoques['ans_question_category_id'])->toArray();
                        $yesNoquestion       = end($yesNoquestion);
                        $filteredAnsweryesNo = $answerColl->where('question_category_id', $yesnoques['ans_question_category_id'])->toArray();
                        $yesnoanswerText     = "";
                        $answeryesNo         = end($filteredAnsweryesNo);
                        $yesnoanswerText     = $answer['answer'];
                        if (count((array)$yesNoquestion) > 0) {
                            $yesnoanswerText = $answeryesNo['answer'];
                            if ($yesNoquestion['answer_method'] == '3Combo' || $yesNoquestion['answer_method'] == 'mcq' || $yesNoquestion['answer_method'] == 'dropDown')
                                $yesnoanswerText = $this->getAnswerBytype($yesNoquestion, $answeryesNo);

                            if (!empty($yesnoanswerText)) {
                                $yesno[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']]       = $yesnoanswerText;
                                $yesnooutput[$questionSet['category_id']][$questionSet['master_question_id']][$questionSet['id']] = $yesNoquestion['narrative_output']['narrative_output'];
                            }
                        }
                    }
                }
            //}
        }

        $questionRec                    = ['question_id' => $summaryDet['id'], 'id' => $summaryDet['id']];
        $question['title']              = $summaryDet['title'];

        $questnarrativeOutput = $this->CatNarrativeOutputRepo->getDefaultNarrativeOutput()->narrative_output_p1;
        if(isset($summaryDet['question_narrative_output']['narrative_output']))
            if(!empty($summaryDet['question_narrative_output']['narrative_output']))
                $questnarrativeOutput = $summaryDet['question_narrative_output']['narrative_output'];
       
        $question['narrative_output']   = $questnarrativeOutput;
        $questionRec['answers']         = $answers;
        $questionRec['narrativeOutput'] = $narrativeOutput;
        $questionRec['yesno'] = $yesno;
        $questionRec['yesnooutput'] = $yesnooutput;
        $questionRec['question']        = $question;            
        $questionRec['clinical']        = $clinicalQs;            
        $this->questionRec = $questionRec;
        $questionRec['yesno']           = $yesno;
        $questionRec['yesnooutput']     = $yesnooutput;
        $questionRec['question']        = $question;
        $this->questionRec              = $questionRec;
    }
}
