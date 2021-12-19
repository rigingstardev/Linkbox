<?php namespace App\Modules\Physician\Repositories;

// Repository list
use App\Modules\Physician\Repositories\QuestionsRepository;
use App\Modules\Physician\Repositories\CategoryOptionsRepository;
use App\Modules\Physician\Repositories\CategoryNarrativeOutputRepository;
use App\Modules\Physician\Repositories\QuestionsOptionsRepository;
use App\Modules\Physician\Repositories\QuestionNarrativeOutputRepository;
use App\Modules\Physician\Repositories\QuestionsWithYesnoRepository;
// Models
use App\Modules\Physician\Models\Questions;
use App\Modules\Physician\Models\QuestionsCategory;
use App\Modules\Physician\Models\QuestionCategoryDefaultOptions;
use App\Modules\Physician\Models\CategoryDefaultOptions;
use \DB;

class QuestionsCategoryRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionsCategory           = new QuestionsCategory();
        $this->questions                   = new Questions();
        $this->questionsRepo               = new QuestionsRepository();
        $this->categoryRepo                = new CategoryRepository();
        $this->categoryDefaultOptions      = new CategoryDefaultOptions();
        $this->questionDefaultOptions      = new QuestionCategoryDefaultOptions();
        $this->categoryOptionsRepo         = new CategoryOptionsRepository();
        $this->categoryNarrativeOutputRepo = new CategoryNarrativeOutputRepository();
        $this->questionNarrativeOutputRepo = new QuestionNarrativeOutputRepository();
        $this->questionsOptionsRepo        = new QuestionsOptionsRepository();
        $this->questionsWithYesnoRepo      = new QuestionsWithYesnoRepository();
    }
    /*
      select("select *
      from
      (select c.*, cno.narrative_output as narrative_output_p1,cat.category,
      case when qyn.question_category_id is null then c.id
      else qyn.question_category_id end sort_category_id, qyn.ans_option, qyn.ans_question_category_id
      , qyn.question_category_id as qyn_question_category_id

      from `question_categories` c
      left join `question_category_narrative_output` cno on c.`id` = cno.`question_category_id`
      left join `categories` cat on c.`category_id` = cat.`id`
      left join questions_with_yesno  qyn on c.`id` = qyn.`ans_question_category_id` and  qyn.active='Y'
      where `cno`.`active` = 'Y'
      and `c`.`user_id` = :id
      and `c`.`question_id` = :qid
      and `c`.`active` = 'Y'
      ) q
      order by sort_category_id, id asc", ['id' => $userId, 'qid' => $qid]);
     */

    /**
     * Get all categories of the question.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($userId, $qid)
    {
        if ($userId > 0)
            $result = DB::select("select *
                                    from
                                       (select c.*, cno.narrative_output as narrative_output_p1,cat.category,
                                                case when qyn.question_category_id is null then c.id
                                                else qyn.question_category_id end sort_category_id, qyn.ans_option, qyn.ans_question_category_id
                                                , qyn.question_category_id as qyn_question_category_id
                                                ,case when ans_option is null then 0
                                                       when ans_option= 'Yes' then 1
                                                       when ans_option= 'No'  then 2
                                                 else 4 end sort_ans_opt
                                        from `question_categories` c
                                        left join `question_category_narrative_output` cno on c.`id` = cno.`question_category_id`
                                        left join `categories`          cat on c.`category_id` = cat.`id`
                                        left join questions_with_yesno  qyn on c.`id` = qyn.`ans_question_category_id`
                                        where `cno`.`active` = 'Y'
                                        and `c`.`user_id` = :id
                                        and `c`.`question_id` = :qid
                                        and `c`.`active` = 'Y'
                                         ) q
                                    order by sort_category_id, sort_ans_opt asc", ['id' => $userId, 'qid' => $qid]);
        else
            $result = DB::select("select *
                                    from
                                       (select c.*, cno.narrative_output as narrative_output_p1,cat.category,
                                                case when qyn.question_category_id is null then c.id
                                                else qyn.question_category_id end sort_category_id, qyn.ans_option, qyn.ans_question_category_id
                                                , qyn.question_category_id as qyn_question_category_id
                                                ,case when ans_option is null then 0
                                                       when ans_option= 'Yes' then 1
                                                       when ans_option= 'No'  then 2
                                                 else 4 end sort_ans_opt
                                        from `question_categories` c
                                        left join `question_category_narrative_output` cno on c.`id` = cno.`question_category_id`
                                        left join `categories`          cat on c.`category_id` = cat.`id`
                                        left join questions_with_yesno  qyn on c.`id` = qyn.`ans_question_category_id`
                                        where `cno`.`active` = 'Y'
                                        and `c`.`question_id` =:qid
                                        and `c`.`active` = 'Y'
                                         ) q
                                    order by sort_category_id, sort_ans_opt asc ", ['qid' => $qid]);
        return $result;
        /*
         * $query  = $this->questionsCategory->select(DB::raw('question_categories.*'), DB::raw('question_category_narrative_output.narrative_output'))->leftJoin('question_category_narrative_output', 'question_categories.id', '=', 'question_category_narrative_output.question_category_id')->where('question_category_narrative_output.active', 'Y');
          if ($userId > 0)
          $query  = $query->where('question_categories.user_id', $userId);
          $result = $query->where('question_id', $qid)->where('question_categories.active', 'Y')->orderBy('category_id', 'ASC')->get();
          return $result;
         */
    }

    /**
     * Get  Questions and category Info.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionCateogySettings($reqData, $userId)
    {
        $result = $this->questionsCategory->select(DB::raw('question_categories.*'), DB::raw('question_category_narrative_output.narrative_output'), 'questions.title')
            ->leftJoin('question_category_narrative_output', 'question_categories.id', '=', 'question_category_narrative_output.question_category_id')
            ->leftjoin('questions', 'question_categories.question_id', 'questions.id')
            ->where('question_category_narrative_output.active', 'Y')
            ->where('question_categories.id', $reqData['rid'])
            ->where('question_categories.user_id', $userId)
            ->where('question_categories.active', 'Y')
            ->get();


        return $result;
    }

    /**
     * Get all Remove already inserted.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestions($questionId, $userId)
    {
        $query  = $this->questionsCategory;
        if ($userId > 0)
            $query  = $query->where('user_id', $userId);
        $result = $query->where('question_id', $questionId)->where('active', 'Y')->get();
        return $result;
    }

    /**
     * Get all master id of already inserted .
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFieldsFromQuestions($checkData, $questionId, $userId)
    {
        $query = $this->questionsCategory;
        if ($checkData['field'] != 'all')
            $query = $query->select($checkData['fieldOptions']);
        return $query->where('user_id', $userId)->where('question_id', $questionId)->where('active', 'Y')->get();
    }

    /**
     * Get all Remove already inserted.
     *
     * @return \Illuminate\Support\Collection
     */
    public function removeAll($userId, $questionId)
    {
        return $this->questionsCategory->where('user_id', $userId)->where('question_id', $questionId)->where('active', 'Y')->delete();
    }

    /**
     * Save Question category.
     *
     * @return \Illuminate\Support\Collection
     */
    public function create($inputData, $userId, $questionId, $masterQuestions)
    {
        if (count($masterQuestions) > 0) {
            $alreadyInsertedIds = array();

            foreach ($masterQuestions as $row) {
                if (key_exists('checkFormatType', $inputData) && $inputData['checkFormatType'] == 'edit') {
                    if (!key_exists('masterQuestion' . $row->id, $inputData))
                        continue;
                }
                if ($row->category_id == 10) {
                    if (key_exists('rid', $inputData) && key_exists('answeringMethod' . $inputData['rid'], $inputData) && $inputData['answeringMethod' . $inputData['rid']] == 'yesNo') {
                        $question = $row->question;
                    } else
                        $question = $inputData['other_question'];
                } else
                    $question = $row->question;
                //insert master question to questions category.
                $inData   = array('user_id' => $userId, 'question_id' => $questionId, 'category_id' => $row->category_id, 'question' => $question, 'answer_method' => $row->answer_type, 'narrative_output' => '', 'comments' => $row->comments, 'quest_status' => '1', 'master_question_id' => $row->id, 'active' => 'Y');

                $rid                            = 0;
                $result                         = $this->questionsCategory->create($inData);
                $returnData[$row->id][0]        = $result->id;
                $returnData[$row->id]['Categy'] = $row->category_id;
                if (key_exists('rid', $inputData))
                    $rid                            = $inputData['rid'];

                // getting the default options
                $defaultOptions        = $this->categoryOptionsRepo->getDefaultValues($row->id);
                $inputData['rid']      = $result->id;
                $inputData['qid']      = $questionId;
                $inputData['cid']      = $row->category_id;
                $inputData['masterid'] = $row->id;
                if (count((array)$defaultOptions) > 0) {
                    // copying default options
                    $this->copyCategoryDefaultOptions($inputData, $userId, $defaultOptions);
                    $defaultOptions = '';
                }
                $this->copyCategoryNarrativeOutput($inputData, $userId);
                if (key_exists('rid', $inputData))
                    $inputData['rid'] = $rid;
            }
            // returns inserted id and master question id if it is part of a yes/no type question
            if (key_exists('returnData', $inputData) && $inputData['returnData'] == true)
                return $returnData;
            if ($result)
                return true;
        } else {
            return false;
        }
    }

    /**
     * update  Question narrative output.
     *
     * @return \Illuminate\Support\Collection
     */
    public function copyCategoryNarrativeOutput($inputData, $userId)
    {
        if (array_key_exists('flagType', $inputData) && $inputData['flagType'] == 'copy') {
            $inputData['id']         = $inputData['rid'];
            $categoryNarrativeOutput = $this->questionNarrativeOutputRepo->getQuestionNarrativeOutput($inputData, $userId);

            $inArray['question_category_id'] = $inputData['newId'];
            foreach ($categoryNarrativeOutput as $rw)
                $inArray['narrative_output']     = $rw->narrative_output;
        } else {
            $getData['question_id']          = $inputData['masterid'];
            $categoryNarrativeOutput         = $this->categoryNarrativeOutputRepo->getData($getData);
            $inArray['question_category_id'] = $inputData['rid'];
            foreach ($categoryNarrativeOutput as $rw)
                $inArray['narrative_output']     = $rw->narrative_output_p1;
        }
        $narrativeOutput = $this->questionNarrativeOutputRepo->insertRow($inArray);
    }

    /**
     * update  Question flags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateQuestionFlags($inputData, $input, $userId)
    {   
        if (array_key_exists('qsId', $inputData))
        return $this->questionsCategory->where('question_id', $inputData['qsId'])->where('user_id', $userId)->where('active', 'Y')->update($input);
        else 
            return $this->questionsCategory->where('id', $inputData['rid'])->where('user_id', $userId)->update($input);
    }

    /**
     * copy  Question flags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function copyQuestionFlags($inputData, $userId)
    {

        $checkExists = $this->getQuestionCateogySettings($inputData, $userId);


        if (count((array)$checkExists) > 0) {
            // replication question and category. return boolean . cannot use as we need the last inserted id
            $row = $this->questionsCategory->where('id', $inputData['rid'])->get();
            foreach ($row as $data) {
                // checkings to indicate that question set is created by use this question set method
                if (key_exists('createType', $inputData) && $inputData['createType'] == 'useThisSet') {
                    $input['user_id']     = $inputData['currentUserId'];
                    $input['question_id'] = $inputData['newQuestionSetId'];
                } else if (key_exists('createType', $inputData) && $inputData['createType'] == 'copy') {
                    $input['user_id']     = $data->user_id;
                    $input['question_id'] = $inputData['newQuestionSetId'];
                } else {
                    // checking for copying question from a question set. if so created via flag will be set to highlight the row.
                    if (key_exists('flagType', $inputData) && $inputData['flagType'] == 'copy')
                        $input['created_via'] = 'C';
                    $input['user_id']     = $data->user_id;
                    $input['question_id'] = $data->question_id;
                }
                $input['category_id']        = $data->category_id;
                $input['question']           = $data->question;
                $input['answer_method']      = $data->answer_method;
                $input['narrative_output']   = $data->narrative_output;
                $input['clinical_question']  = $data->clinical_question;
                $input['comments']           = $data->comments;
                $input['quest_status']       = $data->quest_status;
                $input['master_question_id'] = $data->master_question_id;

                $insert = $this->questionsCategory->create($input);
            }
            return $insert;
        }
    }

    /**
     * update  Question category settings.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateQuestionSettings($reqData, $userId)
    {
        $question = '';
        
        for ($j = 1; $j <= 3; $j++) {
            if ($reqData['labelQuestionPart' . $j] != '')
                if ($reqData['labelQuestionPart' . $j] == '?') { 
                    $question = $question . $reqData['labelQuestionPart' . $j]; }
                else {
                    $question = $question . ' ' . $reqData['labelQuestionPart' . $j]; }
        } 
        if ($reqData['labelQuestionPart1'] != '' || $reqData['labelQuestionPart3'] != '')  {
            // $inputQues = $question ;
            
            $inputQues = str_replace('?',' &#63;',$question);
            $input['question'] = $inputQues;
            // $input['active'] = "Y";
        }
        $this->updateQuestionFlags($reqData, $input, $userId);
    }

    /**
     * update  Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function copyCategoryDefaultOptions($reqData, $userId, $defaultOptions)
    {
        if (array_key_exists('flagType', $reqData) && $reqData['flagType'] == 'copy') {
            $inputData['rid'] = $reqData['rid'];
        }

        if ($defaultOptions) {
            $optionsList['question_category_id'] = $reqData['rid'];
            $optionsList['category_id']          = $reqData['cid'];
            foreach ($defaultOptions as $data) {
                $optionsList['default_option'] = $data->default_option;
                if (key_exists('createType', $reqData) && $reqData['createType'] == 'useThisSet') {
                    $optionsList['user_id']     = $reqData['currentUserId'];
                    $optionsList['question_id'] = $reqData['qid'];
                } else if (key_exists('createType', $reqData) && $reqData['createType'] == 'copy') {
                    $optionsList['user_id']     = $reqData['currentUserId'];
                    $optionsList['question_id'] = $reqData['newQuestionSetId'];
                } else {
                    $optionsList['user_id']     = $userId;
                    $optionsList['question_id'] = $reqData['qid'];
                }
                $optionsList['option_status'] = 1;
                $result                       = $this->questionDefaultOptions->insert($optionsList);
            }
        }
    }

    /**
     * update  Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionCategoryOptions($reqData, $userId)
    {
        $row = $this->questionDefaultOptions->where('question_category_id', $reqData['rid'])->where('active', 'Y')->get();
        return $row;
    }

    public function insertYesNoQuestion($reqData, $userId)
    { 
        $questionIDYes         = 0;
        $questionIDNo          = 0;
        //  checks if the question is already set for yes type . if will work if thre is not assignment.
        $reqData['returnType'] = 'count';
        $yesCheckData          = $this->getCheckDataForYesNo($reqData, 'Yes');
        $existingYesData       = $this->checkYesNoQustionExists($yesCheckData);
        if (key_exists('ansYesNoYes', $reqData) && $reqData['ansYesNoYes'] == 'Yes' && ($existingYesData == 0)) {
            $questionIDYes        = $reqData['ansYesNoYesQuestion'];
            //  checks if the question is already set for yes type . else will work if thre is assignment.
            // it will check if the id's are different. if so it will disable the previous assignemnts  unset($yesCheckData['ansquesCategyId']);
            unset($yesCheckData['ansquesCategyId']);
            unset($yesCheckData['returnType']);
            $updateData['active'] = 'N';
            $getRow               = $this->questionsWithYesnoRepo->getRow(array('qid' => $yesCheckData['qid'], 'quesCategyId' => $yesCheckData['quesCategyId'], 'ansOption' => $yesCheckData['ansOption']));
            $this->updateQuestionCategory($getRow, $updateData, $userId);
            $this->questionsWithYesnoRepo->updateRow($yesCheckData, $updateData);
        }
        $NoCheckData    = $this->getCheckDataForYesNo($reqData, 'No');
        $existingNoData = $this->checkYesNoQustionExists($NoCheckData);
        if (key_exists('ansYesNoNo', $reqData) && $reqData['ansYesNoNo'] == 'No' && ($existingNoData == 0)) {
            $questionIDNo         = $reqData['ansYesNoNoQuestion'];
            //  checks if the question is already set for yes type . else will work if thre is assignment.
            // it will check if the id's are different. if so it will disable the previous assignemnts  unset($yesCheckData['ansquesCategyId']);
            //   unset($NoCheckData['ansquesCategyId']);
            $getRow               = $this->questionsWithYesnoRepo->getRow(array('qid' => $yesCheckData['qid'], 'quesCategyId' => $NoCheckData['quesCategyId'], 'ansOption' => $NoCheckData['ansOption']));
            $updateData['active'] = 'N';
            $this->updateQuestionCategory($getRow, $updateData, $userId);
            unset($NoCheckData['returnType']);
            $this->questionsWithYesnoRepo->updateRow($NoCheckData, $updateData);
        }
        $returnData['No']  = $questionIDNo;
        $returnData['Yes'] = $questionIDYes;
        return $returnData;
    }

    public function updateQuestionCategory($getRow, $updateData, $userId)
    {
        if (count($getRow) > 0) {
            $getRow           = $getRow->toArray();
            foreach ($getRow as $row)
                $inputData['rid'] = $row['ans_question_category_id'];
            $this->updateQuestionFlags($inputData, $updateData, $userId);
            $this->questionsOptionsRepo->updateCategoryDefaultOptions($inputData, $updateData, $userId);
        }
    }

    public function getCheckDataForYesNo($reqData, $ansOption)
    {
        // dd($reqData, $ansOption);
        $checkData['qid']                = $reqData['qid'];
        $checkData['quesCategyId']       = $reqData['rid'];
        $checkData['ansOption']          = $ansOption;
//        $checkData['ansquesCategyId'] = $reqData['ansYesNo' . $ansOption . 'Question'];
        $checkData['categoryQuestionId'] = $reqData['ansYesNo' . $ansOption . 'Question'];
        $checkData['returnType']         = $reqData['returnType'];
        return $checkData;
    }

    public function checkYesNoQustionExists($checkData)
    {
        $returnData = ($this->questionsWithYesnoRepo->getRow($checkData));
        return $returnData;
    }

    public function deleteQuestionCategory($yesNoQues, $userId)
    {
        $updateData['active'] = 'N';
        for ($i = 0; $i < count((array)$yesNoQues); $i++) {
            $inputData['rid']                  = $yesNoQues[$i];
            // set questions inactive
            $this->updateQuestionFlags($inputData, $updateData, $userId);
            // set options inactive
            $this->questionsOptionsRepo->updateCategoryDefaultOptions($inputData, $updateData, $userId);
            // set narrative output inactive
            $checkData['question_category_id'] = $inputData['rid'];
            $this->questionNarrativeOutputRepo->update($checkData, $updateData);
        }
    }
}
