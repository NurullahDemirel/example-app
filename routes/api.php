<?php

use App\Http\Controllers\Api\ClinicController;
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

Route::post('clinics/register',[ClinicController::class,'clinicRegister']);
Route::post('clinic/data',[ClinicController::class,'clinicData']);
Route::post('clinic/login',[ClinicController::class,'clinicLogin']);


Route::group(['prefix' => 'clinic/','name' => 'clinic.','middleware' => ['auth:sanctum','abilities:clinics']],function (){
    Route::post('data',[ClinicController::class,'clinicData']);
    Route::post('update/appointment',[ClinicController::class,'updateAppoinment']);
    Route::post('update/treatment',[ClinicController::class,'updateTreatment']);
    Route::post('create/treatment',[ClinicController::class,'createTreatment']);
});
