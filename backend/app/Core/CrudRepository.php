<?php

namespace App\Core;

use Illuminate\Http\Request;
class CrudRepository implements CrudInterfaz
{
    protected $model;
    protected $object;

    public function __construct(CrudModel $model = null)
    {
        $this->model = $model;
    }

    public function index(Request $request){
        $this->object = $this->model::all();

        return $this->object;
    }

    public function show($id){
        $this->object = $this->model::findOrFail($id);
        return $this->object;
    }

    public function store(Request $request){
        $this->object = $this->model::create($request->all());
        return $this->object;
    }

    public function update($id, Request $request){
        self::show($id);
        $this->object->update($request->all());

        return self::show($id);
    }

    public function destroy($id, Request $request){
        self::show($id);
       // dd($this->object);
        return $this->object->delete();
    }

}
