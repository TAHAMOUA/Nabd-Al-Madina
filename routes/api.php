<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalementController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\DepartementController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('signalements', SignalementController::class);

    Route::apiResource('incidents', IncidentController::class);

    Route::apiResource('departements', DepartementController::class);

    Route::patch(
        '/signalements/{signalement}/statut',
        [SignalementController::class, 'updateStatus']
    );

    Route::post(
        '/incidents/validate-grouping',
        [IncidentController::class, 'validateGrouping']
    );

});
