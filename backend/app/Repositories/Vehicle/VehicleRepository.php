<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Vehicle;

use App\Core\CrudRepository;
use App\Models\Vehicle;
use Illuminate\Http\Request;

/** @property Vehicle $model */
class VehicleRepository extends CrudRepository
{

    public function __construct(Vehicle $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $vehicles = $this->model::Filtro($request)->get();
        return $vehicles;
    }
}
