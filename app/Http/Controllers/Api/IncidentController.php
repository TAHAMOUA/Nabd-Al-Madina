<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IncidentController extends Controller
{
    /**
     * Liste des incidents
     */
    public function index()
    {
        Gate::authorize('isAgent');

        return response()->json(Incident::with('signalements')->latest()->get());
    }

    /**
     * Créer un incident
     */
    public function store(Request $request)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $incident = Incident::create($validated);

        return response()->json([
            'message' => 'Incident créé avec succès.',
            'data' => $incident,
        ], 201);
    }

    /**
     * Afficher un incident
     */
    public function show(Incident $incident)
    {
        Gate::authorize('isAgent');

        return response()->json(
            $incident->load('signalements')
        );
    }

    /**
     * Modifier un incident
     */
    public function update(Request $request, Incident $incident)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $incident->update($validated);

        return response()->json([
            'message' => 'Incident mis à jour.',
            'data' => $incident,
        ]);
    }

    /**
     * Supprimer un incident
     */
    public function destroy(Incident $incident)
    {
        Gate::authorize('isAgent');

        if ($incident->signalements()->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer un incident contenant des signalements.'
            ], 409);
        }

        $incident->delete();

        return response()->json([
            'message' => 'Incident supprimé avec succès.'
        ]);
    }

    /**
     * Validation du regroupement
     */
    public function validateGrouping(Request $request)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'signalements' => 'required|array|min:2',
            'signalements.*' => 'exists:signalements,id',
        ]);

        $incident = Incident::create([
            'titre' => 'Incident regroupé',
            'description' => 'Incident créé après validation du regroupement',
        ]);

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