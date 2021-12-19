<?php namespace App\Modules\Physician\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
use Illuminate\Support\Facades\DB;
// Repository list
//-------- category & questions master -----------------
use App\Modules\Physician\Repositories\CategoryRepository;
use App\Modules\Physician\Repositories\CategoryQuestionsRepository;
use App\Modules\Physician\Repositories\CategoryOptionsRepository;
use App\Modules\Physician\Repositories\QuestionsRepository;
use App\Modules\Physician\Repositories\QuestionsCategoryRepository;
use App\Modules\Physician\Repositories\QuestionsOptionsRepository;
use App\Modules\Physician\Repositories\QuestionReceipientsRepository;
use App\Modules\Physician\Repositories\QuestionNarrativeOutputRepository;
use App\Modules\Physician\Repositories\QuestionsWithYesnoRepository;
use App\Modules\Physician\Repositories\QuestionNarrativeOutputRepo;
// Requests
use App\Modules\Physician\Requests\CreateQuestionSetRequest;
use App\Modules\Physician\Requests\ChangeNarrativeOutputRequest;
use App\Modules\Physician\Requests\AnswerMethodRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
//use App\User;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Questions;
use App\Models\QuestionReceipients;
use App\Models\QuestionsCategory;

class QuestionSetController extends Controller
{

    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->categoryRepo                = new CategoryRepository();
        $this->categoryQuestionsRepo       = new CategoryQuestionsRepository();
        $this->categoryOptionsRepo         = new CategoryOptionsRepository();
        $this->questionsRepo               = new QuestionsRepository();
        $this->questionsCategoryRepo       = new QuestionsCategoryRepository();
        $this->questionsOptionsRepo        = new QuestionsOptionsRepository();
        $this->questionReceipientsRepo     = new QuestionReceipientsRepository();
        $this->questionNarrativeOutputRepo = new QuestionNarrativeOutputRepository();
        $this->questionsWithYesnoRepo      = new QuestionsWithYesnoRepository();
        $this->questionDefaultOutputRepo   = new QuestionNarrativeOutputRepo();
        /*if(\Session::has('physician_id'))
        {
            $this->paysicianid = \Session::get('physician_id');
        }
        else
        {
            $this->paysicianid = 0;  
        }*/
        $this->middleware(function ($request, $next)
        {
            $this->paysicianid = \Session::get('physician_id');
            return $next($request);
        });
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function createQuestionSet()
    {//get session data
        $userData   = Auth::user();
        $userId     = $this->paysicianid;
        $result     = $this->questionsRepo->getImcompleteQuestions($userId);
        if (count((array)$result) > 0)
            return redirect('/physician/createQuestionSetNext/' . $result->id);
// getting the category
        $categories = $this->categoryRepo->all();
        return view("Physician::create_question_set", compact('categories'));
    }
    /**
     * Display patient registration form.
     *
     * @return Response
     */

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function getSelectedCategory($inputData)
    {
        $categoryArray = array();
        // getting the current list
        for ($i = 1; $i <= $inputData['categoryCount']; $i++) {
            // checking if the category is in the current selected list
            if (array_key_exists('category' . $i, $inputData)) {
                $categoryArray[] = $inputData['category' . $i];
            }
        }
        return $categoryArray;
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function insertQuestionSetStepOne(CreateQuestionSetRequest $questionReq)
    {

        //get session data
        $userData    = Auth::user();
        // inserting question set step one.
        $requestData = $questionReq->all();
        $result      = $this->questionsRepo->save($questionReq->all(), $userData);
        if ($result) {

            // Insert into question narrative output
            $this->questionDefaultOutputRepo->save($result->id);    

            $questionId              = $result->id;
            $userId                  = $this->paysicianid;
            // filtering the category selected
            $checkData['listType']   = 'byCategory';
            $checkData['categoryId'] = $this->getSelectedCategory($requestData);

            // filtering the master questions based of the category selected
            $masterQuestions = $this->categoryQuestionsRepo->getMasterQuestions($checkData);
            // copy master questions to selected questions list
            $resultCatgy     = $this->questionsCategoryRepo->create($requestData, $userId, $questionId, $masterQuestions);
        }

        if (count((array)$result) > 0) {
            $returnData = json_encode(array('status' => true, 'redirectUrl' => '/physician/createQuestionSetNext/' . $questionId));
        } else {
            $returnData = json_encode(array('status' => false));
        }
        return $returnData;
    }

    /**
     * extracting question id from the question list
     *
     * @return Response
     */
    public function getQuestionIds($masterQuestions)
    {
        $qID = array();
        if (count((array)$masterQuestions) > 0) {
            foreach ($masterQuestions as $row) {
                $qID[] = $row->id;
            }
        }
        return $qID;
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function createQuestionSetNext($id)
    {
        $userData       = Auth::user();
        $userId         = $this->paysicianid;
        $qid            = $id;
        $defaultOptions = array();
// getting the category list

        $categories  = $this->categoryRepo->all();
// getting the question info
        $questionSet = $this->questionsRepo->all($id, $userId);
        if (count((array)$questionSet) > 0) {

            // getting selected question category
            $defaultOutput        = $this->questionDefaultOutputRepo->getQuestionNarrativeOutput($qid);

            $selectedCategories   = $this->questionsCategoryRepo->all($userId, $id);
            $masterQuestions      = $this->categoryQuestionsRepo->all();
            $inputData['qid']     = $id;
// getting the deefault options of the questions
            $defaultOptions       = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, $userId);
            // getting yes / no
//            $defaultOptions       = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, $userId);
            // updating created by flag as displayed for 'C' type and making it as CN'
            $input['created_via'] = 'CN';
            $inputData['qsId']    = $id;
            $this->questionsCategoryRepo->updateQuestionFlags($inputData, $input, $userId);

            $yesNoQues        = $this->questionsWithYesnoRepo->getRow($inputData);
            if (count((array)$yesNoQues) > 0)
                $yesNoQues        = $yesNoQues->toArray();
            $yesNoQuesCatgyId = array();
            $yesNoCategyList  = array();

            for ($i = 0; $i < count((array)$yesNoQues); $i++) {
// assigning values to variables
                $quesCategoryId = $yesNoQues[$i]['question_category_id'];
                $answerOption   = $yesNoQues[$i]['ans_option'];
                $ansQuescatgyId = $yesNoQues[$i]['ans_question_category_id'];

                if (!in_array($quesCategoryId, $yesNoQuesCatgyId)) {
                    $yesNoQuesCatgyId[] = $quesCategoryId;
                }
                //list
                $yesNoCategyList[$quesCategoryId][$answerOption] = $ansQuescatgyId;
            }
            // getting all sub question of yes no type question.
            // used to add or remove Yes/No option in answer method
            $yesNoSubQuestions = $this->questionsWithYesnoRepo->getRow($inputData);
            $yesNoSubQuestions = extractRequiredColumn($yesNoSubQuestions, 'ans_question_category_id');

// return data to
            return view("Physician::create_question_set_next", compact('id', 'qid', 'categories', 'questionSet', 'selectedCategories', 'defaultOptions', 'masterQuestions', 'yesNoQues', 'yesNoQuesCatgyId', 'yesNoCategyList', 'yesNoSubQuestions','defaultOutput'));
        }
        return redirect('/physician/createQuestionSet');
    }

    /**
     * edit question settings
     *
     * @return
     */
    public function showAnswerOption(Request $req)
    {
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        $reqData  = $req->all();

        $option     = $reqData['option'];
        $prev       = $reqData['prev'];
        $rid        = $reqData['rid'];
        $cid        = $reqData['cid'];
        $qid        = $reqData['qid'];
        $optionFlag = $reqData['optionChangedFlag'];

        $answer_method     = $option;
        $inputData['qid']  = $qid;
        $inputData['rid']  = $rid;
        $categoryOptions   = array();
        $yesNoQues         = array();
        $yesNoSubQuestions = array();
        $yesNoMasterQues   = [];
        $questionSet       = $this->questionsRepo->all($qid, $userId);

        // getting the deefault options of the question
        if (($prev == $option ) && ($option == '3Combo' || $option == 'mcq' || $option == 'dropDown' || $option == 'dateT' || $option == 'duration'))
            $categoryOptions = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptionsByQuestion($inputData, $userId);
        // getting the question category row
        $result          = $this->questionsCategoryRepo->getQuestionCateogySettings($reqData, $userId);
        if ($option == 'yesNo') {
            $inputData['quesCategyId'] = $rid;
            $yesNoQues                 = $this->questionsWithYesnoRepo->getRow($inputData);
            // converting to array
            if (count((array)$yesNoQues) > 0)
                $yesNoQues                 = $yesNoQues->toArray();
            $yesNoMasterQues           = $this->yesNoQuestions($inputData);
        }
        // getting all sub question of yes no type question.
        // used to add or remove Yes/No option in answer method
        unset($inputData['quesCategyId']);
        $yesNoSubQuestions = $this->questionsWithYesnoRepo->getRow($inputData);
        $yesNoSubQuestions = extractRequiredColumn($yesNoSubQuestions, 'ans_question_category_id');


        // getting the narrative output
        $inputData['id']            = $rid;
        $inputData['answerType']    = $option;
        $narrativeOutput            = '';
        $inputData['cid']           = $cid;
        $defaultQustionOfAnswerType = $this->categoryRepo->getQuestion($inputData);
        return view("Physician::AnsweringOptions/answer_option_" . $option, compact('questionSet', 'option', 'answer_method', 'rid', 'qid', 'cid', 'categoryOptions', 'result', 'narrativeOutput', 'optionFlag', 'yesNoQues', 'yesNoMasterQues', 'yesNoSubQuestions'));
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function editQuestionSetStepOne(CreateQuestionSetRequest $questionReq)
    {
//get session data
        $userData   = Auth::user();
// inserting question set step one.
        $inputData  = $questionReq->all();
        $questionId = $inputData['qid'];
        $result     = $this->questionsRepo->updateQuestin($inputData, $userData);
        if (!\Request::ajax())
            return redirect('/physician/home');
        $returnData = json_encode(array('status' => true, 'redirectUrl' => '/physician/createQuestionSetNext/' . $questionId));
        return $returnData;
    }

    /**
     * update question settings
     *
     * @return
     */
    public function updateQustionSettings(AnswerMethodRequest $answerMethodRequest)
    {  
        $userData    = Auth::user();
        $userId      = $this->paysicianid;
        $reqData     = $answerMethodRequest->all();
        $requestData = $reqData; 
        // update master question settings
        $result      = $this->questionsCategoryRepo->updateQuestionSettings($reqData, $userId);
        $rid                    = $reqData['rid'];
        $prevAnsMethod          = $reqData['prevAnsweringMethod' . $rid];
        $nowAnsMethod           = $reqData['answeringMethod' . $rid];
        $inputData['rid']       = $rid;
        // checking and updating answer type
        $input['answer_method'] = $nowAnsMethod;
        $input['comments']      = $reqData['txtComments'];
        // dd($input);
        if ($prevAnsMethod != $nowAnsMethod)
        $this->questionsOptionsRepo->updateCategoryDefaultOptions(array('rid' => $rid), array('active' => 'N'), $userId);
        // disabling option of dateT answer method if the answer method is  changed to another
        //checking for the question category options
        
        if ($nowAnsMethod != 'dateT') {
            $this->questionsOptionsRepo->editCategoryOptions($reqData, $userId); 
            if ($nowAnsMethod == 'yesNo') {
                // getting the qeustion id of yes and no answer types
                
                $questionIds              = $this->questionsCategoryRepo->insertYesNoQuestion($reqData, $userId);
                $checkData['CatgyQuesId'] = array($questionIds['Yes'], $questionIds['No']);
                // getting the master question details
                $masterQuestions          = $this->categoryQuestionsRepo->getMasterQuestions($checkData);
                
                // copy master questions to selected questions list
                $questionId                = $reqData['qid'];
                $requestData['returnData'] = true;
                // inserting new sub questions of yes / no question to question_categories table
                
                $resultCatgy = $this->questionsCategoryRepo->create($requestData, $userId, $questionId, $masterQuestions);
                // inserting main question and sub question relation to questions_with_yesno table
                $this->insertYesNoQuestions($resultCatgy, $questionIds, $questionId, $rid);
            }
        }
        // dd($inputData);
        // checking if the previous answer method is yes no type and now its changed.
        // if so we will need to disable the questions selected for the yes no question and its settings.
        $this->disableOptionsOfPreviousAnswerType($prevAnsMethod, 'yesNo', $nowAnsMethod, $userId, $rid);
        // updating narrative output
        $this->questionNarrativeOutputRepo->updateNarrativeoutput($requestData, $userId);
        $input['allow_multiple_answer'] = 'N';
        // updating question category row with new answer type , narrative output etc 
        if ($nowAnsMethod == 'mcq' && array_key_exists("allowMultipleAnswer-$rid", $requestData))
            $input['allow_multiple_answer'] = 'Y'; 
        $result                         = $this->questionsCategoryRepo->updateQuestionFlags($inputData, $input, $userId);
    }

    /**
     * manage reset/disable/delete old data
     *
     * @return
     */
    public function disableOptionsOfPreviousAnswerType($prevAnsMethod, $checkAnsMetho, $nowAnsMethod, $userId, $rid)
    {
        if (($prevAnsMethod == $checkAnsMetho) && ($checkAnsMetho == 'yesNo') && $prevAnsMethod != $nowAnsMethod) {
            $this->disableYesNoSettings($rid, $userId);
        }
    }

    /**
     * performs reset/disable/delete old data
     *
     * @return
     */
    public function disableYesNoSettings($rid, $userId)
    {
        $inputData['quesCategyId'] = $rid;
        // getting rows from yes no setting table questions_with_yesno
        $yesNoQues                 = $this->questionsWithYesnoRepo->getRow($inputData);
        // extracting required row from the result set
        $yesNoQues                 = extractRequiredColumn($yesNoQues, 'ans_question_category_id');
        // delete questions of   previous answer method yes / no from question_categories
        $this->questionsCategoryRepo->deleteQuestionCategory($yesNoQues, $userId);
        //disable yes no settings
        $updateData['active']      = 'N';
        $this->questionsWithYesnoRepo->updateRow($inputData, $updateData);
    }

    /**
     *  inserting main question and sub question relation to questions_with_yesno table
     *
     * @return
     */
    public function insertYesNoQuestions($resultCatgy, $questionIds, $questionId, $rid)
    {
        // inserting yes / not qustion setting to another table for reference.
        for ($m = 0; $m <= 1; $m++) {
            if ($m == 0)
                $arrKey = 'No';
            else
                $arrKey = 'Yes';
            // checking if the question against Yes/No is selected or not... if the qeustion is selected , it will insert
            if ($questionIds[$arrKey] > 0) {
                // check if the question already exists. Insert only if its not exists.

                $insertToYesNo = array('question_id' => $questionId, 'question_category_id' => $rid, 'ans_option' => $arrKey, 'category_question_id' => $questionIds[$arrKey], 'ans_question_category_id' => $resultCatgy[$questionIds[$arrKey]][0]);

                $res = $this->questionsWithYesnoRepo->createRow($insertToYesNo);
            }
        }
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function editCategoryList(CreateQuestionSetRequest $questionReq)
    {
//get session data
        $userData                = Auth::user();
// inserting question set step one.
        $inputData               = $questionReq->all();
        $questionId              = $inputData['qid'];
        $userId                  = $this->paysicianid;
        // filtering the category selected
        $checkData['listType']   = 'byCategory';
        $checkData['categoryId'] = $this->getSelectedCategory($inputData);
        // filtering the master questions based of the category selected
        $masterQuestions         = $this->categoryQuestionsRepo->getMasterQuestions($checkData);
        // copy master questions to selected questions list

        $resultCatgy = $this->questionsCategoryRepo->create($questionReq->all(), $userId, $questionId, $masterQuestions);
        if ($resultCatgy) {
            $returnData = json_encode(array('status' => true, 'redirectUrl' => '/physician/createQuestionSetNext/' . $questionId));
        } else {
            $returnData = json_encode(array('status' => false));
        }
        return $returnData;
    }

    /**
     * set or Unset Clicical Questin flag
     *
     * @return
     */
    public function setQuestionFlags(Request $req)
    {
        if (!$req->ajax())
            return;
        $userData    = Auth::user();
        $userId      = $this->paysicianid;
        $reqData     = $req->all();
        $copyReqData = $reqData;

        // inserting question set step one.
        if ($reqData['flagType'] == 'clinicalQuestion')
            $input['clinical_question'] = $reqData['flag'];

        elseif ($reqData['flagType'] == 'disable')
            $input['quest_status'] = $reqData['flag'];

        elseif ($reqData['flagType'] == 'delete')
            $input['active'] = 'N';

        elseif ($reqData['flagType'] == 'copy') {
            $result = $this->questionsCategoryRepo->copyQuestionFlags($reqData, $userId);
            if ($result) {
                $defaultOptions       = $this->questionsCategoryRepo->getQuestionCategoryOptions($reqData, $userId);
                $reqData['rid']       = $result->id;
                $resultOption         = $this->questionsCategoryRepo->copyCategoryDefaultOptions($reqData, $userId, $defaultOptions);
                $copyReqData['newId'] = $result->id;
                $narrativeOp          = $this->questionsCategoryRepo->copyCategoryNarrativeOutput($copyReqData, $userId);
                
            }
            return;
        } elseif ($reqData['flagType'] == 'visibility') {
            $input['visibility'] = strtolower($reqData['rid']);
            $input['user_id']    = $userId;

            $result = $this->questionsRepo->update($reqData, $input);
            return trans('custom.question_status_change_success');
        } elseif ($reqData['flagType'] == 'duplicate') {
            $id                           = $reqData['qid'];
            $questionSets                 = $this->questionsRepo->all($id, $userId);
            $inputData['chiefComplaint']  = $reqData['title'];
            $inputData['steps_completed'] = 'Y';
            $inputData['description']     = $questionSets->description;
            $newQuestion                  = $this->questionsRepo->save($inputData, $userData);

            if ($newQuestion) {
                $prevUserId                  = $userId;   
                //getting the master questions list of master question set
                $allQuestions                = $this->questionsCategoryRepo->getQuestions($id, $userId);
                $reqData['qid']              = $id;
                // settings to indicate that question set is created by use this question set method
                $reqData['prevUserId']       = $prevUserId;
                $reqData['currentUserId']    = $userId;
                $reqData['newQuestionSetId'] = $newQuestion->id;
                // Copy Narrative Output
                $qnarrativeOutputRes = $this->questionDefaultOutputRepo->copyNarrativeOutput($reqData);
                foreach ($allQuestions as $ques) {

                    $reqData['rid']        = $ques->id;
                    $reqData['cid']        = $ques->category_id;
                    $reqData['createType'] = 'copy';
                    $result                = $this->questionsCategoryRepo->copyQuestionFlags($reqData, $prevUserId);
                    if ($result) {
                        $defaultOptions          = $this->questionsCategoryRepo->getQuestionCategoryOptions($reqData, $prevUserId);
                        $copyReqData['flagType'] = 'copy';
                        $reqData['flagType']     = 'copy';
                        $reqData['rid']          = $result->id;
                        $resultOption            = $this->questionsCategoryRepo->copyCategoryDefaultOptions($reqData, $prevUserId, $defaultOptions);
                        $copyReqData['newId']    = $result->id;
                        $copyReqData['rid']      = $ques->id;
                        
                        $narrativeOp             = $this->questionsCategoryRepo->copyCategoryNarrativeOutput($copyReqData, $userId);
                        $quesIDArray[$ques->id]  = $result->id;
                         
                    }
                }
                $inputData         = array('qid' => $id, 'newQuesId' => $reqData['newQuestionSetId']);
                $copyYesNoSettings = $this->questionsWithYesnoRepo->copyYesNoQuestionSettings($quesIDArray, $inputData);
            }
            return (array('flag' => 'success', 'url' => '/physician/createQuestionSetNext/' . $newQuestion->id));
        }

        if (count((array)$input) > 0)
            $result = $this->questionsCategoryRepo->updateQuestionFlags($reqData, $input, $userId);
        if ($reqData['flagType'] == 'delete') {
            if ($result)
                $this->disableYesNoSettings($reqData['rid'], $userId);
        }
        if ($reqData['flagType'] == 'disable')
            return trans('custom.disabled_question_category_success');
        else
            return 1;
    }

    /**
     *   Receipients List
     *
     * @return Response
     */
    public function getReceipientsList(Request $request)
    {
        //  get session data

        $userData       = Auth::user();
        $userId         = $this->paysicianid;
        $requestData    = $request->all();
        $qid            = $requestData['qid'];
        $allReceipients = $this->questionReceipientsRepo->allReceipients($qid, $userId);

        return Datatables::of($allReceipients)
                ->editColumn('first_name', function($allReceipients) {
                    if ($allReceipients->status == 'completed')
                        return '<a href="' . url('physician/patients/' . Hashids::encode($allReceipients->id) . '/questionset') . '">' .
                            $allReceipients->first_name . ' ' . $allReceipients->last_name . '</a>';
                    else
                        return formatData($allReceipients->is_account_active, $allReceipients->entry_type, 'text', $allReceipients->first_name . ' ' . $allReceipients->last_name);
                })
                ->editColumn('email', function($allReceipients) {
                    if ($allReceipients->entry_type == 'T' && $allReceipients->is_account_active == 'P')
                        return '-';
                    return $allReceipients->email;
                })
                ->editColumn('contact_number', function($allReceipients) {
                    return $allReceipients->contact_number;
                })
                ->editColumn('created_at', function($allReceipients) {
                    return date("m/j/Y", strtotime($allReceipients->created_at));
                })
                ->editColumn('is_account_active', function($allReceipients) {
                    if ($allReceipients->activation_code == '')
                        return isLinkBoxMember($allReceipients->is_account_active);
                    else
                        return 'No';
                })
                ->editColumn('status', function($allReceipients) {
                    return '<span class="color-' . $allReceipients->status . '">' . ucwords($allReceipients->status) . '</span>';
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('searchlist') || $request->has('qid')) {
                        $instance->where(function ($query) use ($request) {
                            $searchString1 = trim($request->get('searchlist'));
                            $searchString2 = trim($request->get('qid'));
                            if ($searchString1 != "")
                                $query->where('status', 'like', "%{$searchString1}%");
                            if ($searchString2 != "")
                                $query->where('question_id', '=', $searchString2);
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Detailed view of question sets
     *
     * @return Response
     */
    public function questionSetDetail($id) {   
        // dd($id);
        // $id = Hashids::decode($id);
        // dd($id);
        // $id = $id[0];
        //get session data
        $userData = Auth::user();

        $userId             = $this->paysicianid;
        $categories         = $this->categoryRepo->all();
        // get question set .
        $defaultOptions     = array();
        $allReceipients     = array();
        $questionCategories = array();
        $questionCategories = array();
        $selectedCategories = array();
        $masterQuestions    = array();
        $questionSets       = $this->questionsRepo->all($id, $userId);
        $questionSet        = $questionSets;
        // getting the qestion category
        if (count((array)$questionSets) > 0) {
            // getting selected question category
            $selectedCategories = $this->questionsCategoryRepo->all($userId, $id);
            $masterQuestions    = $this->categoryQuestionsRepo->all();

            // getting selected question category
            $questionCategories   = $this->questionsCategoryRepo->getQuestions($id, $userId);
            $qid                  = $id;
            $inputData['qid']     = $id;
            $defaultOutput        = $this->questionDefaultOutputRepo->getQuestionNarrativeOutput($id);
            // getting the default options of the questions
            $defaultOptions       = $this->questionsOptionsRepo->getQuestionCategoryDefaultOptions($inputData, $userId);
            // getting the question receipient and response details
            $allReceipients       = $this->questionReceipientsRepo->allReceipients($id, $userId);
            $input['created_via'] = 'CN';
            $inputData['qsId']    = $id;
            $this->questionsCategoryRepo->updateQuestionFlags($inputData, $input, $userId);

            $yesNoQues        = $this->questionsWithYesnoRepo->getRow($inputData);
            if (count((array)$yesNoQues) > 0)
                $yesNoQues        = $yesNoQues->toArray();
            $yesNoQuesCatgyId = array();
            $yesNoCategyList  = array();

            for ($i = 0; $i < count((array)$yesNoQues); $i++) {
// assigning values to variables
                $quesCategoryId = $yesNoQues[$i]['question_category_id'];
                $answerOption   = $yesNoQues[$i]['ans_option'];
                $ansQuescatgyId = $yesNoQues[$i]['ans_question_category_id'];

                if (!in_array($quesCategoryId, $yesNoQuesCatgyId)) {
                    $yesNoQuesCatgyId[] = $quesCategoryId;
                }
                //list
                $yesNoCategyList[$quesCategoryId][$answerOption] = $ansQuescatgyId;
            }
            // getting all sub question of yes no type question.
            // used to add or remove Yes/No option in answer method
            $yesNoSubQuestions = $this->questionsWithYesnoRepo->getRow($inputData);
            $yesNoSubQuestions = extractRequiredColumn($yesNoSubQuestions, 'ans_question_category_id');


            return view("Physician::question_set_detail", compact('id', 'qid', 'categories', 'questionSets', 'questionCategories', 'selectedCategories', 'defaultOptions', 'questionSet', 'masterQuestions', 'allReceipients', 'yesNoQues', 'yesNoQuesCatgyId', 'yesNoCategyList', 'yesNoSubQuestions','defaultOutput'));
        }
        return redirect('/physician/home');
    }


    // /**
    //  * Create question set
    //  *
    //  * @return Response
    //  */
    // public function questionSetDetailShow(Request $request)
    // {
    //     // dd('in');
    //     $qResId       = Hashids::decode($request->id);
    //     //dd($request->id);
    //     // get questions and its answer methods
    //     // If the user is authorized allow them to view the deatils
    //     // $patientId    = \Auth::Guard('patient')->user()->id;
    //     //$qRecId = QuestionReceipients::where('id',$qResId)->first(['id']);
    //     $questionSets = QuestionReceipients::with('question', 'question.questionSets', 'question.questionSets.defaultOptions', 'answers', 'question.questionSets.category', 'question.questionSets.yesNoQuestions', 'question.questionSetsyesNoCount')->where('questions.id', $qResId)->get();

    //     if (empty($qResId) || $questionSets->isEmpty()) {
    //         return redirect('home'); //->back()->with('error', trans('Patient::messages.unauthorized'));
    //     }
    //     $categories = $questionSets->map(function ($value) {
    //         return $value->question->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
    //     });


    //     /* $questionSets = $questionSets->map(function ($value) {
    //     return $value->question->questionSets->sortBy('category.sort_order');
    //     }); */

    //     $category = $categories->all();
    //     $category = end($category)->unique();
    //     /*
    //     echo "<pre>";
    //     print_r($questionSets);
    //     print_r($qs);

    //     die; */

    //     return view("Physician::show", compact('questionSets', 'category'));
    // }

    /**
     * Create question set
     *
     * @return Response
     */
    public function buiildThisQuestionSet(Request $request)
    {
        $userData = Auth::user();
        $userId   = $this->paysicianid;
        $reqData  = $request->all();

        $input['user_id']         = $userId;
        $input['steps_completed'] = 'Y';
        $inputData['qid']         = $reqData['qid'];
        $result                   = $this->questionsRepo->update($inputData, $input);
        if ($result) {
            // redirect to home after  updating question
            $returnData = json_encode(array('status' => true, 'redirectUrl' => '/physician/home'));
        } else {
            $returnData = json_encode(array('status' => false));
        }
        return $returnData;
    }

    public function useTheQuestionSet($id, Request $request)
    {
        $userData             = Auth::user();
        $userId               = $this->paysicianid;
        $reqData              = $request->all();
        $ids                  = Hashids::decode($id);
        $id                   = $ids[0];
        $inputData['id']      = $id;
        $inputData['setType'] = 'public';
        $checkQuestion        = $this->questionsRepo->getQuestionList($inputData);
        if (count((array)$checkQuestion) > 0) {
            foreach ($checkQuestion as $row)
                $prevUserId = $row->user_id;

            $newQuestion = $this->questionsRepo->replicateQuestion($id, $userId);
            if ($newQuestion) {
                //getting the master questions list of master question set
                $allQuestions                = $this->questionsCategoryRepo->getQuestions($id, 0);
                $reqData['qid']              = $id;
                // settings to indicate that question set is created by use this question set method
                $reqData['createType']       = 'useThisSet';
                $reqData['prevUserId']       = $prevUserId;
                $reqData['currentUserId']    = $userId;
                $reqData['newQuestionSetId'] = $newQuestion->id;
                foreach ($allQuestions as $ques) {
                    $reqData['rid'] = $ques->id;
                    $reqData['cid'] = $ques->category_id;
                    $result         = $this->questionsCategoryRepo->copyQuestionFlags($reqData, $prevUserId);
                    if ($result) {
                        $defaultOptions          = $this->questionsCategoryRepo->getQuestionCategoryOptions($reqData, $prevUserId);
                        $reqData['rid']          = $result->id;
                        $resultOption            = $this->questionsCategoryRepo->copyCategoryDefaultOptions($reqData, $prevUserId, $defaultOptions);
                        $copyReqData['newId']    = $result->id;
                        $copyReqData['rid']      = $ques->id;
                        $copyReqData['flagType'] = 'copy';
                        $narrativeOp             = $this->questionsCategoryRepo->copyCategoryNarrativeOutput($copyReqData, $userId);
                        // getting row id of question_categories
                        $quesIDArray[$ques->id]  = $result->id;
                    }
                } // copy yes/no settings from questions_with_yesno
                $inputData         = array('qid' => $id, 'newQuesId' => $reqData['newQuestionSetId']);
                $copyYesNoSettings = $this->questionsWithYesnoRepo->copyYesNoQuestionSettings($quesIDArray, $inputData);
                return redirect('/physician/createQuestionSetNext/' . $newQuestion->id);
            }
        }
    }

    public function getNextQuestionOnYesNo(Request $request)
    {
        $reqData = $request->all();
        $result  = $this->yesNoQuestions($reqData);
        return $this->getnerationYesNoQuestionOptions($result);
    }

    public function yesNoQuestions($reqData)
    {
        $checkData['Except']    = 'qid';
        $checkData['qid']       = $reqData['qid'];
        $checkData['rid']       = $reqData['rid'];
        $checkData['exceptCid'] = 0;
        $result                 = $this->categoryQuestionsRepo->getMasterQuestions($checkData);
        return $result;
    }

    public function getnerationYesNoQuestionOptions($result)
    {
        $return = '<option value=""> </option>';
        foreach ($result as $row) {
            $return .='<option value="' . $row->id . '"';
            $return .=' >' . $row->question . ' ( ' . $row->category . ' )</option>';
        }
        return $result;
    }
    /**
     * Edit Question Narrative output
     *
     * @return Response
     */
    public function editQuestionNarrativeOutput(ChangeNarrativeOutputRequest $request)
    {
        $returnData = json_encode(array('status' => false));
        $defaultOutput        = $this->questionDefaultOutputRepo->update($request->all());  
        if ($defaultOutput) {
            $returnData = json_encode(array('status' => true, 'redirectUrl' => '/physician/createQuestionSetNext/' . $request->qid));
        } 
        return $returnData; 
    }

    /**
     * To post the user input for Test Preview question set
     * @param $request
     * @return Session
     */    
    public function getQuestionSetFirstPhase(Request $request)
    {
        $request = $request->all();
        Session::forget('setQuestionPostValue');
        Session::push('setQuestionPostValue', ['_token' => $request['_token'], 'id'=>$request['questionId'], 'age'=>$request['age'], 'gender'=>$request['gender']]);
    }
    
    /**
     * Show Test Preview question set
     * @param $request
     * @return Response
     */
    public function testPreviewQuestionSetDetail(Request $request)
    {
        $sessionValue                   = [];
        if (Session::has('setQuestionPostValue')) {
            $session                    = $request->session()->get('setQuestionPostValue');
            $sessionValue['id']         = $session[0]['id'];
            $sessionValue['age']        = $session[0]['age'];
            $sessionValue['gender']     = $session[0]['gender'];
        }
        $qResId       = Hashids::decode($request->id);
        //dd($qResId);
        $questionSets = Questions::with('questionSets', 'questionSets.defaultOptions', 'questionSets.category', 'questionSets.yesNoQuestions', 'questionSetsyesNoCount')->where('id', $qResId)->get();
        //$questionSets = QuestionReceipients::with('question', 'question.questionSets', 'question.questionSets.defaultOptions', 'answers', 'question.questionSets.category', 'question.questionSets.yesNoQuestions', 'question.questionSetsyesNoCount')->leftJoin('questions', 'question_recipients.question_id', 'questions.id')->select('question_recipients.*')->where('questions.active', 'Y')->where('question_recipients.id', $qResId)->get();
        // dd($questionSets);
        // $questionSets = QuestionReceipients::with('question', 'question.questionSets', 'question.questionSets.defaultOptions', 'question.questionSets.category', 'question.questionSets.yesNoQuestions', 'question.questionSetsyesNoCount')->where('question_id', $qResId)->groupBy('question_id')->get();
        // dd($questionSets);
        if (empty($qResId) || $questionSets->isEmpty()) {
            return redirect('home');
        }
        $categories = $questionSets->map(function ($value) {
            return $value->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
            //return $value->question->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
        });
        $category = $categories->all();
        $category = end($category)->unique();
        // dd($category);
        
        return view("Physician::show_test_preview", compact('questionSets', 'category', 'sessionValue'));
    }
    
}
