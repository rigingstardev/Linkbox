<?php namespace App\Modules\Physician\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Notifications extends Model implements Auditable
{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

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
 
    /**
     * question set relation
     *
     * @return \Illuminate\Support\Collection
     */
    public function getQuestionSet()
    {
        return $this->belongsTo('App\Modules\Physician\Models\Questions', 'question_id', 'id');
    }
}
