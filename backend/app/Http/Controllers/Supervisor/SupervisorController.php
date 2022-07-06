<?php

namespace App\Http\Controllers\Supervisor;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Http\Requests\SupervisorRequest;
use App\Services\Supervisor\SupervisorService;
/** @property SupervisorService $service */
class SupervisorController extends CrudController
{
    public function __construct(SupervisorService $service)
    {
        parent::__construct($service);
    }

    public function store(SupervisorRequest $request){
        return parent::_store($request);
    }

    public function update($id, SupervisorRequest $request){
        return parent::_update($id,$request);
    }
}
