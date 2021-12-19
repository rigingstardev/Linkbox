<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\CategoryNarrativeOutput;

class CategoryNarrativeOutputRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->categoryNarrativeOutput = new CategoryNarrativeOutput();
    }

    /**
     * get category Narrative output text and display order .
     *
     * @return \Illuminate\Support\Collection
     */
//    public function getCategoryNarrativeOutput($inputData, $userId)
//    {
////        return $this->categoryNarrativeOutput->where('answer_type', $inputData['answerType'])->where('active', 'Y')->orderBy('display_order', 'ASC')->get();
//    }
    
    
    public function getData($inputData)
    {
        $query = $this->categoryNarrativeOutput;
        if (key_exists('question_id', $inputData))
            $query = $query->where('question_id', $inputData['question_id']);

        return $query->where('active', 'Y')->get();
    }
    /**
     * To get the Default Narrative Output for Question
     *
     * @return \Illuminate\Support\Collection
    */
    public function getDefaultNarrativeOutput()
    {
        return $this->categoryNarrativeOutput->where('question_id','0')->first();       
    }
}
