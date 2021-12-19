<?php
namespace App\Modules\Patient\Repositories;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;


 abstract class BaseRepository  implements Auditable {
    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Destroy a model.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        $this->getById($id)->delete();
    }

    /**
     * Get Model by id.
     *
     * @param  int  $id
     * @return \App\Models\Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
}
