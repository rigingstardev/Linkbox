<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class QuestionsCategory extends Model implements Auditable
{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_categories';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps  = true;
    protected $fillable = array('user_id', 'question_id', 'category_id', 'question', 'answer_method', 'narrative_output', 'clinical_question', 'quest_status','active');
    /**
     * Relation with Category
     *
     * 
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->orderBy('sort_order', 'desc');
    }
     /**
     * Relation with Default Options
     *
     * @var bool
     */
    public function defaultOptions()
    {
        return $this->hasMany('App\Models\QuestionCategoryDefaultOptions', 'question_category_id')->where('active','Y');
    }    
    /**
     * Relation with Narrative output
     *
     * @var bool
     */
    public function narrativeOutput()
    {
        return $this->hasOne('App\Models\QuestionCategoryNarrativeOutput', 'question_category_id');
    }  
    /**
     * Relation with YesNo Questions
     *
     * @var bool
     */
    public function yesNoQuestions()
    {
        return $this->hasMany('App\Models\QuestionsWithYesno', 'question_category_id');
    }         
}