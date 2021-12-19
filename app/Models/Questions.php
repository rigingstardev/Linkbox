<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Questions extends Model implements Auditable
{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

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
    protected $fillable = array('user_id', 'title', 'description', 'visibility');

    /**
     * Relation with Users
     *
     * @var array
     */
    public function user()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    /**
     * Relation with Receipients
     *
     * @var array
     */
    public function receipients()
    {
        return $this->hasMany('App\Models\QuestionReceipients', 'question_id', 'patient_id');
    }

    /**
     * Relation with Questions
     *
     * @var array
     */
    public function questionSets()
    {
        return $this->hasMany('App\Models\QuestionsCategory', 'question_id')->where('active', 'Y');
    }
    /*
     * Relation with Questions
     *
     * @var array
     */

    public function questionSetWithoutCQ()
    {
        return $this->hasMany('App\Models\QuestionsCategory', 'question_id')->where('clinical_question', '=', '0')->where('active', 'Y');
    }

    /**
     * Relation with Questions
     *
     * @var array
     */
    public function questionSetsyesNoCount()
    {
        return $this->questionSets()->where('answer_method', 'yesNo');
    }

    /**
     * Relation with Questions
     *
     * @var array
     */
    public function questionSetsWoCQyesNoCount()
    {
        return $this->questionSetWithoutCQ()->where('answer_method', 'yesNo')->where('clinical_question', '=', '0');
    }
    /**
     * Relation with Question Narrative Output
     *
     * @var array
     */
    public function questionNarrativeOutput()
    {
        return $this->hasOne('App\Models\QuestionNarrativeOutput', 'question_id')->where('active', 'Y');
    }
}
