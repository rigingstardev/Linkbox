<?php

namespace App\Modules\Physician\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Permissions extends Model implements Auditable{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

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
    public $timestamps = true; 
    /**
     * The User that belong to the Permission.
     */
    public function users()
    {
        return $this->belongsToMany('App\User','permission_user','permission_id','user_id');
    } 
    /**
     * The Permission Menu.
     */
    public function menu()
    {
        return $this->belongsTo('App\Modules\Physician\Models\Menu');
    }     
}