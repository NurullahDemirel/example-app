<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth:sanctum','auth:clinics']],function (){
    Route::get('take/appointment/{id}',[UserController::class,'apponitmentView']);
    Route::get('get/doctors/ajax',[UserController::class,'getDoctors'])->name('get.doctors');
    Route::get('get/appointments/ajax/{id}',[UserController::class,'getAppiontments'])->name('get.appointments');
    Route::post('get/appointments/from/doctor',[UserController::class,'takeAppiontmentFromDoctor'])->name('take.appointment.from.doctor');
});


