<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class QuestionsWithYesno extends Model
{   
    use AuditableTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions_with_yesno';

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
