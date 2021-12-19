<?php namespace App\Modules\Patient\Repositories;

use App\Models\QuestionReceipients;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


class QuestionReceipientRepository extends BaseRepository  implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    public $model;
    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->model = new QuestionReceipients();
    }
    /**
     * The Get All Questions With Details.
     *
     * @var \App\Models\Role
     */
    public function getQuestions()
    {
        return $this->model;
    }
}