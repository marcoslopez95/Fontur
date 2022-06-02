<?php

namespace App\Core;

use App\Traits\ApiResponse;
use App\Traits\ManageRoles;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

/** @property CrudService $service */

class CrudController extends BaseController
{
    use ApiResponse, ManageRoles;

    protected $service;
    protected $object;
    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        try{

            $this->object = $this->service->index($request);

            return custom_response(true,'Index',$this->object);
        }catch(Exception $e){
            return custom_error($e);
        }

    }

    public function show($id)
    {
        DB::beginTransaction();
        try{

            $this->object = $this->service->show($id);
            DB::commit();
            return custom_response(true,'show',$this->object);
        }catch(Exception $e){
            DB::rollback();
            return custom_error($e);
        }
    }

    public function _store(FormRequest $request)
    {
        DB::beginTransaction();
        try{

            $this->object = $this->service->store($request);
            DB::commit();
            return custom_response(true,'show',$this->object);
        }catch(Exception $e){
            DB::rollback();
            return custom_error($e);
        }
    }

    public function _update($id, Request $request)
    {
        DB::beginTransaction();
        try{

            $this->object = $this->service->update($id, $request);
            DB::commit();
            return custom_response(true,'show',$this->object);
        }catch(Exception $e){
            DB::rollback();
            return custom_error($e);
        }

    }

    public function destroy($id, Request $request)
    {
        DB::beginTransaction();
        try{

            $this->object = $this->service->destroy($id, $request);
            DB::commit();
            return custom_response(true,'show',$this->object);
        }catch(Exception $e){
            DB::rollback();
            return custom_error($e);
        }
    }
}
