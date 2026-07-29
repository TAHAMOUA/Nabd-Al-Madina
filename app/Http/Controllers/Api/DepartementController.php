<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepartementController extends Controller
{
    /**
     * Afficher tous les départements
     */
    public function index()
    {
        Gate::authorize('isAgent');

        return response()->json(
            Departement::with('signalements')->latest()->get()
        );
    }

    /**
     * Créer un département
     */
    public function store(Request $request)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:departements,nom',
        ]);

        $departement = Departement::create($validated);

        return response()->json([
            'message' => 'Département créé avec succès.',
            'data' => $departement,
        ], 201);
    }

    /**
     * Afficher un département
     */
    public function show(Departement $departement)
    {
        Gate::authorize('isAgent');

        return response()->json(
            $departement->load('signalements')
        );
    }

    /**
     * Modifier un département
     */
    public function update(Request $request, Departement $departement)
    {
        Gate::authorize('isAgent');

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:departements,nom,' . $departement->id,
        ]);

        $departement->update($validated);

        return response()->json([
            'message' => 'Département mis à jour avec succès.',
            'data' => $departement,
        ]);
    }

    /**
     * Supprimer un département
     */
    public function destroy(Departement $departement)
    {
        Gate::authorize('isAgent');

        if ($departement->signalements()->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer un département contenant des signalements.'
            ], 409);
        }

        $departement->delete();

        return response()->json([
            'message' => 'Département supprimé avec succès.'
        ]);
    }
}