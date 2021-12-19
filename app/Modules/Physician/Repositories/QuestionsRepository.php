<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\Questions;
use \DB;

class QuestionsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->questions = new Questions();
    }

    /**
     * Get all Questions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($id, $userId)
    {
        $query  = $this->questions;
        if ($userId > 0)
            $query  = $query->where('user_id', $userId);
        $result = $query->find($id);
        //echo '<pre>';print_r($result);exit;
        return $result;
    }
    /**
     * Get all Questions of the user .
     *
     * @return \Illuminate\Support\Collection
     */
//    public function getQuestions($userId)
//    {
//        return $this->questions->where('user_id', $userId)->where('steps_completed', 'Y')->orderBy('id', 'DESC');
//    }

    /**
     * Get all Questions of the user .
     *
     * @return \Illuminate\Support\Collection
     */
//    public function allQuestions($userId)
//    {
//        return $this->questions->where('user_id', $userId)->where('steps_completed', 'Y')->orderBy('id', 'DESC')->get();
//    }

    /**
     * Get all Questions of the user .
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionList($inputData)
    {
        $query  = $this->questions->select(DB::raw('questions.*'), 'users.name', 'users.hospital_name');
        if (key_exists('user_id', $inputData))
            $query  = $query->where('questions.user_id', $inputData['user_id']);
        if (key_exists('setType', $inputData))
            $query  = $query->where('questions.visibility', $inputData['setType']);
        if (key_exists('id', $inputData))
            $query  = $query->where('questions.id', $inputData['id']);
        $query  = $query->leftJoin('users', 'users.id', 'questions.user_id')
            ->where('users.is_account_active', 'Y')
            ->where('steps_completed', 'Y')
            ->where('questions.active', 'Y')
            ->orderBy('questions.id', 'DESC');
        if (key_exists('returnType', $inputData) && $inputData['returnType'] == 'Datatable')
            return $query;
        else
            $result = $query->get();
        return $result;
    }

    /**
     * Get   incomplete Questions of the user .
     *
     * @return \Illuminate\Support\Collection
     */
    public function getImcompleteQuestions($userId)
    {
        return $this->questions->where('user_id', $userId)->where('steps_completed', 'N')->orderBy('id', 'DESC')->get()->first();
    }
    /**
     * Save Question.
     *
     * @return \Illuminate\Support\Collection
     */
    public function save($inputData, $userData)
    {
        $input['user_id']         = $userData->id;
        $input['title']           = $inputData['chiefComplaint'];
        $input['description']     = $inputData ['description'];
        $input['visibility']      = 'private';
        if (key_exists('steps_completed', $inputData))
            $input['steps_completed'] = $inputData ['steps_completed'];

        $result = $this->questions->create($input);
        return $result;
    }

    /**
     * update Question.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateQuestin($inputData, $userData)
    {
        $input['user_id']     = $userData->id;
        $input['title']       = $inputData['chiefComplaint'];
        $input['description'] = $inputData ['description'];
        $this->update($inputData, $input);
    }

    /**
     * Save Question.
     *
     * @return \Illuminate\Support\Collection
     */
    public function update($inputData, $input)
    {
        $query = $this->questions;
        if (key_exists('qset_id', $input))
            $query = $query->where('id', $input['qset_id']);
        if (key_exists('qid', $inputData))
            $query = $query->where('id', $inputData['qid']);

        if (key_exists('uType', $inputData) && $inputData['uType'] == 'Own')
            $query  = $query->where('user_id', $inputData['user_id']);
        
        
        $result = $query->update($input);
        return $result;
    }

    /**
     * replicateQuestion  duplication question set
     *
     * @return \Illuminate\Support\Collection
     */
    public function replicateQuestion($id, $userId)
    {
        $question                     = $this->questions->find($id);
        $inputData['user_id']         = $userId;
        $inputData['title']           = $question->title;
        $inputData['description']     = $question->description;
        $inputData['steps_completed'] = 'Y';
        $inputData['visibility']      = 'private';
        $newRow                       = $this->questions->create($inputData);
        return($newRow);
    }

    /**
     * update Question BgImage.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateBgImage($qset_id, $imageName)
    {
        $query  = $this->questions;
        $query  = $query->where('id', $qset_id);
        $result = $query->update(['bg_image' => $imageName]);
        return $result;
    }
}
