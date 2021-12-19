<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\QuestionsWithYesno;
use \DB;

class QuestionsWithYesnoRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionsWithYesno = new QuestionsWithYesno();
    }

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function createRow($insertData)
    {
        return $this->questionsWithYesno->create($insertData);
    }

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function getRow($checkData)
    {
        $query = $this->questionsWithYesno;
        if (key_exists('qid', $checkData))
            $query = $query->where('question_id', '=', $checkData['qid']);
        if (key_exists('quesCategyId', $checkData))
            $query = $query->where('question_category_id', '=', $checkData['quesCategyId']);
        if (key_exists('ansOption', $checkData))
            $query = $query->where('ans_option', '=', $checkData['ansOption']);
        if (key_exists('categoryQuestionId', $checkData))
            $query = $query->where('category_question_id', '=', $checkData['categoryQuestionId']);
          if (key_exists('ansquesCategyId', $checkData))
            $query = $query->where('ans_question_category_id', '=', $checkData['ansquesCategyId']);

        if (key_exists('returnType', $checkData) && $checkData['returnType'] == 'count')
            $result = $query->where('active', '=', 'Y')->get()->count();
        else
            $result = $query->where('active', '=', 'Y')->get();
        return $result;
    }

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function updateRow($checkData, $updateData)
    {
        
        $query = $this->questionsWithYesno;
        if (key_exists('id', $checkData))
            $query = $query->where('id', '=', $checkData['id']);
       if (key_exists('qid', $checkData))
            $query = $query->where('question_id', '=', $checkData['qid']);
        if (key_exists('quesCategyId', $checkData))
            $query = $query->where('question_category_id', '=', $checkData['quesCategyId']);
        if (key_exists('ansOption', $checkData))
            $query = $query->where('ans_option', '=', $checkData['ansOption']);
        if (key_exists('ansquesCategyId', $checkData))
            $query = $query->where('ans_question_category_id', '=', $checkData['ansquesCategyId']);

        $result = $query->where('active', '=', 'Y')->update($updateData);

        return $result;
    }

    public function copyYesNoQuestionSettings($quesIDArray, $inputData)
    {
        $yesNoQues = $this->getRow($inputData);
        if (count((array)$yesNoQues) > 0) {
            $yesNoQues = $yesNoQues->toArray();

            for ($i = 0; $i < count((array)$yesNoQues); $i++) {
// assigning values to variables
                $quesCategoryId   = $yesNoQues[$i]['question_category_id'];
                $answerOption     = $yesNoQues[$i]['ans_option'];
                $categyQuestionId = $yesNoQues[$i]['category_question_id'];
                $ansQuescatgyId   = $yesNoQues[$i]['ans_question_category_id'];
                // insert data
                $insertToYesNo    = array('question_id' => $inputData['newQuesId'], 'question_category_id' => $quesIDArray[$quesCategoryId], 'ans_option' => $answerOption, 'category_question_id' => $categyQuestionId, 'ans_question_category_id' => $quesIDArray[$ansQuescatgyId]);
                $this->createRow($insertToYesNo);
            }
        }
    }
}
