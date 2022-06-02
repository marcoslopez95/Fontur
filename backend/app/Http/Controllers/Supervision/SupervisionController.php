<?php

namespace App\Http\Controllers\Supervision;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Http\Requests\SupervisionRequest;
use App\Services\Supervision\SupervisionService;
/** @property SupervisionService $service */
class SupervisionController extends CrudController
{
    public function __construct(SupervisionService $service)
    {
        parent::__construct($service);
    }

    public function store(SupervisionRequest $request){
        return parent::_store($request);
    }

    public function update($id,SupervisionRequest $request){
        return parent::_update($id,$request);
    }
}
