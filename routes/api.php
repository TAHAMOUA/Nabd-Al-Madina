<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalementController;
use App\Http\Controllers\Api\IncidentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('signalements', SignalementController::class);

});
Route::patch(
    '/signalements/{signalement}/status',
    [SignalementController::class, 'updateStatus']
);
Route::middleware('auth:sanctum')->group(function () {

    Route::post(
        '/incidents/validate-grouping',
        [IncidentController::class, 'validateGrouping']
    );

});