<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use App\Http\Requests\StoreSignalementRequest;
use App\Http\Requests\UpdateSignalementRequest;


class SignalementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSignalementRequest $request)
{
    $data = $request->validated();

    // Associer automatiquement l'utilisateur connecté
    $data['user_id'] = auth()->id();

    // Upload de la photo (optionnel)
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('signalements', 'public');
    }

    $signalement = Signalement::create($data);

    return response()->json([
        'message' => 'Signalement créé avec succès.',
        'data' => $signalement
    ], 201);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
