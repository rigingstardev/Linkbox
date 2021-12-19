<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class QuestionReceipients extends Model implements Auditable
{
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_recipients';

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

    //protected $fillable = array('user_id', 'question_id', 'category_id', 'question', 'answer_method', 'narrative_output', 'clinical_question', 'quest_status','active');
    /**
     * Relation with Category.
     *
     * 
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * Relation with Answers.
     *
     *
     */
    public function answers()
    {
        return $this->hasMany('App\Models\QuestionReceipientsAnswers', 'question_recipient_id');
    }

    /**
     * Relation with Question.
     *
     *
     */
    public function question() {
        return $this->belongsTo('App\Models\Questions', 'question_id')->where('active','Y');
    }

    /**
     * Relation with Patient.
     *
     *
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id');
    }

    /**
     * Relation with Physician.
     *
     *
     */
    public function physician()
    {
        return $this->belongsTo('App\Models\Physician', 'physician_id');
    }

    /**
     * Relation with Patient allergies table.
     *
     */
    public function patient_allergies()
    {
        return $this->hasMany('App\Modules\Patient\Models\PatientAllergy', 'patient_id', 'patient_id');
    }
    
    /**
     * Relation with Patient allergies table.
     *
     */
    public function medications()
    {
        return $this->hasMany('App\Modules\Patient\Models\Medications', 'patient_id', 'patient_id');
    }

    /**
     * Relation with Past medical history table.
     *
     */
    public function past_medical_history()
    {
        return $this->hasMany('App\Modules\Patient\Models\PastMedHistory', 'patient_id', 'patient_id');
    }

    /**
     * Relation with Surgical history table.
     *
     */
    public function surgical_history()
    {
        return $this->hasMany('App\Modules\Patient\Models\SurgicalHistory', 'patient_id', 'patient_id');
    }

    /**
     * Relation with Family history table.
     *
     */
    public function family_history()
    {
        return $this->hasMany('App\Modules\Patient\Models\FamilyHistory', 'patient_id', 'patient_id');
    }

    /**
     * Relation with Social history table.
     *
     */
    public function social_history()
    {
        return $this->hasMany('App\Modules\Patient\Models\SocialHistory', 'patient_id', 'patient_id');
    }
}
