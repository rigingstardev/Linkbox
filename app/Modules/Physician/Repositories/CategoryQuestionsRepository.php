<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\CategoryQuestions;

class CategoryQuestionsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->categoryQuestions = new CategoryQuestions();
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->categoryQuestions->where('active', 'Y')->get();
    }

    /**
     * get  Master Questions based on the given seach criteria.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMasterQuestions($checkData)
    {
        $query = $this->categoryQuestions;
        if (key_exists('listType', $checkData) && $checkData['listType'] == 'byCategory')
            $query = $query->whereIn('category_id', $checkData['categoryId']);
        if (key_exists('Except', $checkData) && $checkData['Except'] == 'qid') {
            // for listing in yes not type questions 
            $query = $query->select('category_questions.id', 'category_questions.question', 'categories.category')
                ->join('question_categories', function($join) use ($checkData) {
                    $join->on('category_questions.id', '!=', 'question_categories.master_question_id')
                    ->where('question_categories.question_id', '=', $checkData['qid'])->where('question_categories.id', $checkData['rid'])->where('question_categories.active', 'Y');
                })
                ->leftJoin('categories', function($join) {
                $join->on('category_questions.category_id', '=', 'categories.id')->where('categories.active', 'Y');
            });
        }

        if (key_exists('CatgyQuesId', $checkData) && $checkData['CatgyQuesId'] > 0)
            $query = $query->whereIn('category_questions.id', $checkData['CatgyQuesId']);

        if (key_exists('Except', $checkData) && $checkData['Except'] == 'qid')
            $result = $query->where('category_questions.active', 'Y')->orderBy('categories.category', 'ASC')->get();
        else
            $result = $query->where('category_questions.active', 'Y')->get();

        return $result;
    }
    /**
     * get Category.
     *
     * @return \Illuminate\Support\Collection
     */
    /*   public function getData($category)
      {
      $result = $this->categoryQuestions->find($category);
      return $result;
      } */

    /**
     * get default question of the answer type.
     *
     * @return \Illuminate\Support\Collection
     */
    /*  public function getQuestion($inputData)
      {
      //        $result = $this->category->select('question', 'narrative_output')->where('answer_type', $inputData['answerType'])->where('id', $inputData['cid'])->get()->first();
      $result = $this->category->select('question', 'narrative_output')->where('answer_type', $inputData['answerType'])->get()->first();
      return $result;
      } */
}
