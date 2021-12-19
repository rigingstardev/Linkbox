<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\QuestionCategoryNarrativeOutput;

class QuestionNarrativeOutputRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionNarrativeOutput = new QuestionCategoryNarrativeOutput();
    }

    /**
     * get category Narrative output text and display order .
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionNarrativeOutput($inputData, $userId)
    {
         return $this->questionNarrativeOutput->where('question_category_id', $inputData['id'])->where('active', 'Y')->get();
    }

    /**
     * insert Narrative output text and display order .
     *
     * @return \Illuminate\Support\Collection
     */
    public function insertRow($inArray)
    {
        return $this->questionNarrativeOutput->insert($inArray);
    }

    /**
     * update Narrative output  .
     *
     * @return \Illuminate\Support\Collection
     */
    public function update($checkData, $updateData)
    {
        return $this->questionNarrativeOutput
                ->where('question_category_id', $checkData['question_category_id'])
                ->update($updateData);
    }

    /**
     * update Narrative output  request.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateNarrativeoutput($requestData, $userId)
    {
        $output = '';
        for ($i = 1; $i <= 3; $i++) {
            if (trim($requestData['txtNarrativeOutput' . $i]) != '')
                $output .= trim($requestData['txtNarrativeOutput' . $i]) . ' ';
        } $output = trim($output);

        $updateData['narrative_output']    = $output;
        $checkData['question_category_id'] = $requestData['rid'];
        $this->update($checkData, $updateData);
    }

    /**
     * remove Narrative output text and display order of question set.
     *
     * @return \Illuminate\Support\Collection
     */
    public function removeQuestionNarrativeOutput($inputData, $userId)
    {
        return $this->questionNarrativeOutput->where('question_category_id', $inputData['rid'])->delete();
    }
}
