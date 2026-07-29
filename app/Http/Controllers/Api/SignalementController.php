<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use App\Http\Requests\StoreSignalementRequest;
use App\Http\Requests\UpdateSignalementRequest;
use App\Http\Resources\SignalementResource;


class SignalementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $signalements = Signalement::with(['user', 'incident', 'departement'])
        ->latest()
        ->get();

    return SignalementResource::collection($signalements);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSignalementRequest $request)
{
    $data = $request->validated();

    // Associer l'utilisateur connecté
    $data['user_id'] = auth()->id();

    // Upload de la photo
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('signalements', 'public');
    }

    $signalement = Signalement::create($data);

    return response()->json([
        'message' => 'Signalement créé avec succès.',
        'data' => $signalement,
    ], 201);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $signalement = Signalement::with(['user', 'incident', 'departement'])
        ->findOrFail($id);

   return new SignalementResource($signalement);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSignalementRequest $request, string $id)
{
    $signalement = Signalement::findOrFail($id);

    $data = $request->validated();

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('signalements', 'public');
    }

    $signalement->update($data);

    return response()->json([
        'message' => 'Signalement mis à jour avec succès.',
        'data' => $signalement,
    ]);
}
    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    $signalement = Signalement::findOrFail($id);

    $signalement->delete();

    return response()->json([
        'message' => 'Signalement supprimé avec succès.'
    ]);
}
public function updateStatus(Request $request, Signalement $signalement)
{
    Gate::authorize('isAgent');

    $request->validate([
        'status' => 'required|in:nouveau,en_cours,resolu,rejete',
    ]);

    $signalement->update([
        'status' => $request->status,
    ]);

    return response()->json([
        'message' => 'Statut mis à jour avec succès.',
        'data' => $signalement
    ]);
}
}
