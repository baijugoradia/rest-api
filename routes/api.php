<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AddressController;
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


Route::resource('employee', EmployeeController::class);


//Add/Delete for department, address and contact

Route::group(["prefix" => 'department'], function () {
    Route::get('/', [DepartmentController::class, 'list']);
    Route::post('/', [DepartmentController::class, 'create']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'delete']);
});

Route::group(["prefix" => 'contact'], function () {
    Route::post('/', [ContactController::class, 'create']);
    Route::put('/{id}', [ContactController::class, 'update']);
    Route::delete('/{id}', [ContactController::class, 'delete']);
});

Route::group(["prefix" => 'address'], function () {
    Route::post('/', [AddressController::class, 'create']);
    Route::put('/{id}', [AddressController::class, 'update']);
    Route::delete('/{id}', [AddressController::class, 'delete']);
});
