<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalementController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\DepartementController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Signalements
    Route::apiResource('signalements', SignalementController::class);

    // Détection des doublons (IA)
    Route::get(
        '/signalements/{signalement}/similaires',
        [SignalementController::class, 'similaires']
    );

    // Mise à jour du statut
    Route::patch(
        '/signalements/{signalement}/statut',
        [SignalementController::class, 'updateStatus']
    );

    // Incidents
    Route::apiResource('incidents', IncidentController::class);

    Route::post(
        '/incidents/validate-grouping',
        [IncidentController::class, 'validateGrouping']
    );

    // Départements
    Route::apiResource('departements', DepartementController::class);

});
