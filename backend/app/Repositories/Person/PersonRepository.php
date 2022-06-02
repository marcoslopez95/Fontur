<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\Person;

use App\Core\CrudRepository;
use App\Models\Person;
use Illuminate\Http\Request;

/** @property Person $model */
class PersonRepository extends CrudRepository
{

    public function __construct(Person $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request){
        parent::index($request);
        $this->object->load('vehicle');
        return $this->object;

    }

    public function store(Request $request)
    {
        $person = parent::store($request);
        self::show($person->id);
        //dd($request->vehiculo);
        $this->object->vehicle()->create($request->vehiculo);
        return $this->object->load('vehicle');
    }

    public function update($id, Request $request)
    {
        $vehiculo = $request->vehiculo;
        parent::update($id,new Request($request->except('vehiculo')));

        $this->object->vehicle()->update($vehiculo);
        $this->object->refresh();
        return $this->object;
    }
}
