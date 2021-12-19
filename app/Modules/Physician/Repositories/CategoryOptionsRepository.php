<?php namespace App\Modules\Physician\Repositories;

use App\Modules\Physician\Models\CategoryDefaultOptions;

class CategoryOptionsRepository extends BaseRepository
{

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->categoryDefaultOptions = new CategoryDefaultOptions();
    }

    /**
     * get  Master Questions based on the given seach criteria.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDefaultValues($questionIdList)
    {
        return $this->categoryDefaultOptions->where('question_id', $questionIdList)->where('active', 'Y')->get();
    }
}
