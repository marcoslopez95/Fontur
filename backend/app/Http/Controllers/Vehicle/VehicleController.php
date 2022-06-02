<?php

namespace App\Http\Controllers\Vehicle;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Services\Vehicle\VehicleService;
/** @property VehicleService $service */
class VehicleController extends CrudController
{
    public function __construct(VehicleService $service)
    {
        parent::__construct($service);
    }
}