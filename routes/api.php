<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(["auth:sanctum"])->group(function(){

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/divisions/search', [DivisionController::class, 'searchDivisions']);

    Route::prefix('employees')->group(function () {
        Route::get('/search', [EmployeeController::class, 'searchEmployees']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    });



});