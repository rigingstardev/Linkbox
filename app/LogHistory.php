<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class LogHistory extends Model
{   
    use AuditableTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_history';

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
    protected $fillable = ['session_id','user_id','user_type','ip_address','user_agent','session_identifier','last_logging_in','last_logout_in'];
    
}
