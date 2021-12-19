<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\Category;

class CategoryRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->category = new Category();
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->category->where('active', 'Y')->orderBy('sort_order', 'ASC')->get();
    }

    /**
     * get Category.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getData($category)
    {
        $result = $this->category->find($category);
        return $result;
    }

    /**
     * get default question of the answer type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestion($inputData)
    {
//        $result = $this->category->select('question', 'narrative_output')->where('answer_type', $inputData['answerType'])->where('id', $inputData['cid'])->get()->first();        
//        $result = $this->category->select('question', 'narrative_output')->where('answer_type', $inputData['answerType'])->get()->first();
//        return $result;
    }
}
