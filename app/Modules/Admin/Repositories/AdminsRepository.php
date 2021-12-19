<?php namespace App\Modules\Admin\Repositories;

use App\Modules\Admin\Models\Admins;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class AdminsRepository extends BaseRepository  implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->admins = new Admins();
    }

    /**
     * update  Question flags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function updateUserProfile($userId, $inputData)
    {
        return $this->admins->where('id', $userId)->update($inputData);
    }
}
