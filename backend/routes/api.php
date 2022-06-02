<?php

use App\Core\ImageService;
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

/** routes para Person **/

Route::apiResource('people', \App\Http\Controllers\Person\PersonController::class);

/** routes para Supervision **/

Route::apiResource('supervisions', \App\Http\Controllers\Supervision\SupervisionController::class);
