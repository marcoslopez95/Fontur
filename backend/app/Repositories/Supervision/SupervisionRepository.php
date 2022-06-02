<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Supervision;

use App\Core\CrudRepository;
use App\Models\Supervision;
use Illuminate\Http\Request;

/** @property Supervision $model */
class SupervisionRepository extends CrudRepository
{

    public function __construct(Supervision $model)
    {
        parent::__construct($model);
    }

    public function storeByArray(array $data){
        $this->object = $this->model::create($data);
        return $this->object;
    }

}
