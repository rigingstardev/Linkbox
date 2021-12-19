<?php

namespace App\Modules\Physician\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class SummaryReports extends Model implements Auditable{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manage_reports';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = []; 
}
