<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripRequestController;

// TODO: tratamento de erros e validações?

Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:api');


Route::middleware('auth:api')->group(function () {
    Route::get('/trips', [TripRequestController::class, 'getAll']);
    Route::get('/trips/{trip_request_id}', [TripRequestController::class, 'getOne']);
    Route::post('/trips', [TripRequestController::class, 'create']);
    Route::put('/trips/{trip_request_id}', [TripRequestController::class, 'update']);
    Route::delete('/trips/{trip_request_id}', [TripRequestController::class, 'cancel']);
});