<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\QuestionsUnpublished;
use \DB;

class QuestionsUnpublishedRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questionsUnpublished = new QuestionsUnpublished();
    }

    /**
     * Save Question.
     *
     * @return \Illuminate\Support\Collection
     */
    public function save($inputData)
    {
        return $this->questionsUnpublished->create($inputData);
    }

   
}
