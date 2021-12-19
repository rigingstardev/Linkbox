<?php namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Admin extends Model implements Auditable{
	
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}
