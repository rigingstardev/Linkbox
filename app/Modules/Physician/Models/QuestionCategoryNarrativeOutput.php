<?php namespace App\Modules\Physician\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class QuestionCategoryNarrativeOutput extends Model implements Auditable
{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_category_narrative_output';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
//    protected $guarded = [ 'created_at', 'updated_at'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
