<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\Supervision;


use App\Core\CrudService;
use App\Repositories\Supervision\SupervisionRepository;
use Illuminate\Http\Request;

/** @property SupervisionRepository $repository */
class SupervisionService extends CrudService
{

    protected $name = "supervision";
    protected $namePlural = "supervisions";

    public function __construct(SupervisionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {

        foreach($request->vehicles as $vehicle){
            $data = [
                'vehicle_id' => $vehicle['id'],
                'activo' => $vehicle['active'],
                'fecha' => $request['date'],
            ];
            $this->repository->storeByArray($data);
        }

        //dd($data);
        return $request->all();
    }

}
