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


    // Signalements CRUD
    Route::apiResource('signalements', SignalementController::class);


    // Détection doublons IA
    Route::get(
        '/signalements/{signalement}/similaires',
        [SignalementController::class, 'similaires']
    );


    // Analyse IA manuelle
    Route::post(
        '/signalements/{signalement}/analyze',
        [SignalementController::class, 'analyze']
    );


    // Mise à jour statut
    Route::patch(
        '/signalements/{signalement}/statut',
        [SignalementController::class, 'updateStatus']
    );


    // Incidents
    Route::apiResource('incidents', IncidentController::class);


    // Validation regroupement IA
    Route::post(
        '/incidents/validate-grouping',
        [IncidentController::class, 'validateGrouping']
    );


    // Départements
    Route::apiResource('departements', DepartementController::class);

});
