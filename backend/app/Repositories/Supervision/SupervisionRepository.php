<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Supervision;

use App\Core\CrudRepository;
use App\Models\Supervision;
use App\Models\Vehicle;
use Illuminate\Http\Request;

/** @property Supervision $model */
class SupervisionRepository extends CrudRepository
{

    public function __construct(Supervision $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $object = $this->model::addSelect([
            'placa' => Vehicle::select('placa')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'type_fuel' => Vehicle::select('type_fuel')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'num_controller' => Vehicle::select('num_controller')->whereColumn('vehicle_id','vehicles.id')->limit(1),
        ])->get();

        return $object;
    }

    public function storeByArray(array $data){
        $this->object = $this->model::create($data);
        return $this->object;
    }

}
