<?php

namespace App\Http\Controllers\Person;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Http\Requests\PersonRequest;
use App\Services\Person\PersonService;
/** @property PersonService $service */
class PersonController extends CrudController
{
    public function __construct(PersonService $service)
    {
        parent::__construct($service);
    }

    public function store(PersonRequest $request){
        return parent::_store($request);
    }

    public function update($person, PersonRequest $request)
    {
        return parent::_update($person,$request);
    }
}
