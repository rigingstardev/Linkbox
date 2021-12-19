<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class QuestionNarrativeOutput extends Model
{   
    use AuditableTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_narrative_output';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
}
