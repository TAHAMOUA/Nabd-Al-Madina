<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalementController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\DepartementController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('incidents', IncidentController::class);

    Route::post(
        '/incidents/validate-grouping',
        [IncidentController::class, 'validateGrouping']
    );

});

