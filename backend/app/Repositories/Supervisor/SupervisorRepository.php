<?php

/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Supervisor;

use App\Core\CrudRepository;
use App\Models\Municipality;
use App\Models\Supervisor;
use Illuminate\Http\Request;

/** @property Supervisor $model */
class SupervisorRepository extends CrudRepository
{

    public function __construct(Supervisor $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $supervisors = $this->model::Filtro($request)
            ->addSelect([
                'municipality_name' => Municipality::select('nombre')->whereColumn('municipality_id', 'municipalities.id')->limit(1)
            ])
            ->get();

        if ($supervisors->count() === 0 && $request->has('municipality_id')) {
            $supervisors = $this->model->regional()
                ->addSelect([
                    'municipality_name' => Municipality::select('nombre')->whereColumn('municipality_id', 'municipalities.id')->limit(1)
                ])
                ->get();
        }

        return $supervisors;
    }
}
