<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Supervision;

use App\Core\CrudRepository;
use App\Models\Line;
use App\Models\Municipality;
use App\Models\Supervision;
use App\Models\Supervisor;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** @property Supervision $model */
class SupervisionRepository extends CrudRepository
{

    public function __construct(Supervision $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $supervisions = $this->model::filtro($request)
        ->addSelect([
            'placa'          => Vehicle::select('placa')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'type_fuel'      => Vehicle::select('type_fuel')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'num_controller' => Vehicle::select('num_controller')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'line_id'        => Vehicle::select('line_id')->whereColumn('vehicle_id','vehicles.id')->limit(1),
            'supervisor'     => Supervisor::select(DB::raw("first_name||' '||last_name"))->whereColumn('supervisor_id','supervisors.id')->limit(1),
        ])
        ->get();

        $lines = Line::all();
        $municipalities = Municipality::all();
        foreach($supervisions as $supervision){
            $line = $lines->where('id',$supervision->line_id)->first();
            $municipality = $municipalities->where('id',$line->municipality_id)->first();
            $supervision['line'] = $line->name;
            $supervision['municipality'] = $municipality->nombre;
            $supervision['municipality_id'] = $municipality->id;
        }

        return $supervisions;
    }

    public function storeByArray(array $data){
        $this->object = $this->model::create($data);
        return $this->object;
    }

}
