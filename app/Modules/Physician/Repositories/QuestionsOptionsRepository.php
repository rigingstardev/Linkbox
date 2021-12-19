<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\QuestionCategoryDefaultOptions;

class QuestionsOptionsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionDefaultOptions = new QuestionCategoryDefaultOptions();
    }

    /**
     * disable Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateCategoryDefaultOptions($inputData, $input, $userId)
    {
        return $this->questionDefaultOptions->where('question_category_id', $inputData['rid'])->where('user_id', $userId)->where('active', 'Y')->update($input);
    }

    /**
     * update Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateCategoryDefaultOptionsByRow($inputData, $input, $userId)
    {
        return $this->questionDefaultOptions->where('id', $inputData['optionId'])->where('user_id', $userId)->where('active', 'Y')->update($input);
    }

    /**
     * update Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryDefaultOptionsByRow($inputData, $userId)
    {
        return $this->questionDefaultOptions->where('id', $inputData['optionId'])->where('user_id', $userId)->where('active', 'Y')->get()->first();
    }

    /**
     * get Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionCategoryDefaultOptions($inputData, $userId)
    {
//        return $this->questionDefaultOptions->where('question_id', $inputData['qid'])->where('user_id', $userId)->where('active', 'Y')->orderBy('default_option', 'ASC')->get();

        $query  = $this->questionDefaultOptions->where('question_id', $inputData['qid']);
        if ($userId > 0)
            $query  = $query->where('user_id', $userId);
        $result = $query->where('active', 'Y')->orderBy('default_option', 'ASC')->get();
        return $result;
    }

    /**
     * get Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionCategoryDefaultOptionsByQuestion($inputData, $userId)
    {
        return $this->questionDefaultOptions->where('question_category_id', $inputData['rid'])->where('user_id', $userId)->where('active', 'Y')->orderBy('default_option', 'ASC')->get();
    }

//    /**
//     * manage Question category default options.
//     *
//     * @return \Illuminate\Support\Collection
//     */
//    public function insertOrUpdateCategoryOptions($reqData, $userId)
//    {
//        $rid              = $reqData['rid'];
//        $qid              = $reqData['qid'];
//        $cid              = $reqData['cid'];
//        $inputData['rid'] = $rid;
//        $input['active']  = 'N';
//
//        $this->updateCategoryDefaultOptions($inputData, $input, $userId);
//        // inserting new added with check boxes not checked as disabled row
//        $this->insertDefaultOptions(array('rid' => $rid, 'qid' => $qid, 'cid' => $cid, 'option' => 'dateT', 'flag' => 1), $userId);
//    }

    /**
     * manage Question category default options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function editCategoryOptions($reqData, $userId)
    {
        $rid                    = $reqData['rid'];
        $qid                    = $reqData['qid'];
        $cid                    = $reqData['cid'];
        $maxCount               = 0;
        if (array_key_exists("dropDownOptionCount$rid", $reqData))
            $maxCount               = $reqData['dropDownOptionCount' . $rid];
        $inputData['rid']       = $rid;
        // getting the request array
        $input['option_status'] = 2;
        for ($i = 1; $i <= $maxCount; $i++) {

            // checking if the option is active by selecting the check box
            if (array_key_exists("dropDownOptionCheck-$rid-$i", $reqData)) {

                // getting the current value
                $currentDefaultOption    = $reqData["txtOption-$rid-$i"];
                $input['default_option'] = $currentDefaultOption;
                $input['option_status']  = 1;
                // getting exact option row id
                $rowId                   = $reqData["dropDownOptionCheck-$rid-$i"];
                // checking for default row id . if greater than one , assume it as existing value id
                if ($rowId > 1) {

                    // // checking if the previous value and current value are same.
                    // updating db with latest value.
                    $inputData['optionId'] = $rowId;
                    $this->updateCategoryDefaultOptionsByRow($inputData, $input, $userId);
                } else {

                    // inserting new row
                    if ($input['default_option'] != '') {// $input['default_option']    changed to $currentDefaultOption
                        $this->insertDefaultOptions(array('rid' => $rid, 'qid' => $qid, 'cid' => $cid, 'option' => $currentDefaultOption, 'flag' => 1), $userId);
                    }
                }
            } else {

                $updateData = '';
                // checking for already existing value
                if (array_key_exists("hiddenID-$rid-$i", $reqData)) {

                    $checkData['optionId']        = $reqData["hiddenID-$rid-$i"];
                    $checkData['qid']             = $qid;
                    // setting the option value if changed
//                    if ($reqData["hiddenOption-$rid-$i"] != $reqData["txtOption-$rid-$i"])
                    $updateData['default_option'] = $reqData["txtOption-$rid-$i"];
                    // disbling the option
                    $updateData['option_status']  = 2;
                    $checkRow                     = $this->getQuestionCategoryDefaultOptions($checkData, $userId);
                    if (count((array)$checkRow) > 0)
                        $this->updateCategoryDefaultOptionsByRow($checkData, $updateData, $userId);
                    else {
                        $this->insertDefaultOptions(array('rid' => $rid, 'qid' => $qid, 'cid' => $cid, 'option' => $reqData["txtOption-$rid-$i"], 'flag' => 2), $userId);
                    }
                } else if (array_key_exists("removeOption-$rid-$i", $reqData)) {// updating the removed options in db
                    $updateData['active']  = 'N';
                    $checkData['optionId'] = $reqData["removeOption-$rid-$i"];
                    $this->updateCategoryDefaultOptionsByRow($checkData, $updateData, $userId);
                } else if (array_key_exists("txtOption-$rid-$i", $reqData)) {
                    // inserting new added with check boxes not checked as disabled row
                    $this->insertDefaultOptions(array('rid' => $rid, 'qid' => $qid, 'cid' => $cid, 'option' => $reqData["txtOption-$rid-$i"], 'flag' => 2), $userId);
                }
            }/// end else
        }
        
        if ($reqData["answeringMethod$rid"] == '3Combo') {
            $input['active']  = 'N';
            $inputData['rid'] = $reqData['rid'];
            $this->updateCategoryDefaultOptions($inputData, $input, $userId);
            // inserting new added with check boxes not checked as disabled row
            $this->insertDefaultOptions(array('rid' => $reqData['rid'], 'qid' => $reqData['qid'], 'cid' => $reqData['cid'], 'option' => $reqData['txt3ComboAnswer'], 'flag' => 1), $userId);
        }
    }

    public function insertDefaultOptions($reqData, $userId)
    {
        $optionsList['question_category_id'] = $reqData['rid'];
        $optionsList['question_id']          = $reqData['qid'];
        $optionsList['category_id']          = $reqData['cid'];
        $optionsList['default_option']       = $reqData["option"];
        $optionsList['user_id']              = $userId;
        $optionsList['option_status']        = $reqData['flag'];
        $this->insertRow($optionsList, $userId);
    }

    public function insertRow($optionsList, $userId)
    {
        $result = $this->questionDefaultOptions->create($optionsList);
        return $result;
    }
}
