<?php

namespace App;

use App\Notifications\PatientResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Patient extends Authenticatable implements Auditable{

    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    protected $guard = 'patient';
    protected $auditEvents = [
        'created',
        'updated',
        'deleted',
        'restored',
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new PatientResetPassword($token));
    }

    // Set the verified status to true and make the email token null
    public function verified() {
        $this->is_account_active = 'Y';
        $this->activation_code = null;
        $this->save();
    }

    


}
