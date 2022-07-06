<?php

namespace App\Http\Controllers\Line;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Http\Requests\LineRequest;
use App\Services\Line\LineService;
/** @property LineService $service */
class LineController extends CrudController
{
    public function __construct(LineService $service)
    {
        parent::__construct($service);
    }

    public function store(LineRequest $request){
        return parent::_store($request);
    }

    public function update($line, LineRequest $request){
        return parent::_update($line,$request);
    }
}
