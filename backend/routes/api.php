<?php

use App\Core\ImageService;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Vehicle\VehicleReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** routes para Vehicle **/

Route::apiResource('vehicles', \App\Http\Controllers\Vehicle\VehicleController::class);

//Reportes
Route::prefix('report')->group(function () {
    Route::get('vehicles', [VehicleReportController::class,'report']);
});
Route::get('p',function(){
    return view('Reports.Header');
});
/** routes para Person **/
Route::apiResource('people', \App\Http\Controllers\Person\PersonController::class);

/** routes para Supervision **/
Route::apiResource('supervisions', \App\Http\Controllers\Supervision\SupervisionController::class);

Route::get('municipalities',[GeneralController::class,'getMunicipalities']);

/** routes para Line **/
Route::apiResource('lines', \App\Http\Controllers\Line\LineController::class);

/** routes para Supervisor **/
Route::apiResource('supervisors', \App\Http\Controllers\Supervisor\SupervisorController::class);
