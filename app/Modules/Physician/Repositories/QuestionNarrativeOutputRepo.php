<?php namespace App\Modules\Physician\Repositories;

use App\Models\QuestionNarrativeOutput;
use App\Modules\Physician\Repositories\CategoryNarrativeOutputRepository;

class QuestionNarrativeOutputRepo extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionNarrativeOutput = new QuestionNarrativeOutput();
        $this->categorynarrativeOutputrepo = new CategoryNarrativeOutputRepository;
    }
    /**
     * get category Narrative output text and display order .
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionNarrativeOutput($questionId)
    {
         return $this->questionNarrativeOutput->where('question_id', $questionId)->where('active', 'Y')->first(['narrative_output','id']);
    }

    /**
     * insert Narrative output text and display order .
     *
     * @return \Illuminate\Support\Collection
     */
    public function save($questionId)
    {
        $narrativeOutput = $this->categorynarrativeOutputrepo->getDefaultNarrativeOutput(); 
        $data['question_id'] = $questionId;
        $data['narrative_output'] = $narrativeOutput->narrative_output_p1;        
        return $this->questionNarrativeOutput->insert($data);
    }

    /**
     * update Narrative output  .
     *
     * @return \Illuminate\Support\Collection
     */
    public function update($updateData)
    {    
        $data['narrative_output'] = $updateData['defaultnarrativeoutput'];
        return $this->questionNarrativeOutput
                ->where('id', $updateData['noutput_id'])
                ->where('question_id', $updateData['qid'])
                ->update($data);
    }
    /**
     * Copy Narrative output.
     *
     * @return \Illuminate\Support\Collection
     */
    public function copyNarrativeOutput($requestData)
    {   
        $result = "";   
        $narrativeOutput = $this->getQuestionNarrativeOutput($requestData['qid']);       
        if (!empty($narrativeOutput)) {
            $data['question_id'] = $requestData['newQuestionSetId'];
            $data['narrative_output'] = $narrativeOutput->narrative_output;        
            $result = $this->questionNarrativeOutput->insert($data);
        }        
        return $result;     
    }   
}
