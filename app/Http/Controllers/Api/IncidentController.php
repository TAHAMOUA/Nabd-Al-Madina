<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IncidentController extends Controller
{
    public function validateGrouping(Request $request)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'signalements' => 'required|array|min:2',
            'signalements.*' => 'exists:signalements,id',
        ]);

        // Création d'un nouvel incident
        $incident = Incident::create([
            'titre' => 'Incident regroupé',
            'description' => 'Incident créé après validation du regroupement',
        ]);

        // Association des signalements à l'incident
        Signalement::whereIn('id', $validated['signalements'])
            ->update([
                'incident_id' => $incident->id,
            ]);

        return response()->json([
            'message' => 'Regroupement validé avec succès.',
            'incident' => $incident,
        ], 201);
    }
}