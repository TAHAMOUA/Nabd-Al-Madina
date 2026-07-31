<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use App\Models\Departement;
use App\Services\SignalementAnalyzer;
use App\Http\Requests\StoreSignalementRequest;
use App\Http\Requests\UpdateSignalementRequest;
use App\Http\Resources\SignalementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SignalementController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'citoyen') {

            $signalements = Signalement::where('user_id', $user->id)
                ->with(['user', 'incident', 'departement'])
                ->latest()
                ->get();

        } else {

            $signalements = Signalement::with([
                'user',
                'incident',
                'departement'
            ])
            ->latest()
            ->get();
        }

        return SignalementResource::collection($signalements);
    }



    public function store(
        StoreSignalementRequest $request,
        SignalementAnalyzer $analyzer
    )
    {

        $data = $request->validated();

        $data['user_id'] = auth()->id();


        if ($request->hasFile('photo')) {

            $data['photo'] = $request
                ->file('photo')
                ->store('signalements','public');

        }


        $signalement = Signalement::create($data);


        try {

            $analysis = $analyzer->analyze($signalement);


            if ($analysis) {

                $signalement->categorie =
                    $analysis['categorie'] ?? null;

                $signalement->priorite =
                    $analysis['priorite'] ?? null;

                $signalement->urgence =
                    $analysis['urgence'] ?? null;

                $signalement->resume =
                    $analysis['resume'] ?? null;


                if (!empty($analysis['departement'])) {

                    $departement = Departement::where(
                        'nom',
                        $analysis['departement']
                    )->first();


                    if ($departement) {

                        $signalement->departement_id =
                            $departement->id;
                    }
                }


                $signalement->save();

            }


        } catch(\Throwable $e){

            Log::error(
                "Erreur IA : ".$e->getMessage()
            );

        }


        return response()->json([
            'message'=>'Signalement créé avec succès.',
            'data'=>$signalement->fresh()
        ],201);

    }




    public function show(string $id)
    {

        $signalement = Signalement::with([
            'user',
            'incident',
            'departement'
        ])
        ->findOrFail($id);


        $this->authorize(
            'view',
            $signalement
        );


        return new SignalementResource($signalement);

    }




    public function update(
        UpdateSignalementRequest $request,
        string $id
    )
    {

        $signalement = Signalement::findOrFail($id);


        $this->authorize(
            'update',
            $signalement
        );


        $signalement->update(
            $request->validated()
        );


        return response()->json([
            'message'=>'Signalement mis à jour.',
            'data'=>$signalement
        ]);

    }




    public function destroy(string $id)
    {

        $signalement = Signalement::findOrFail($id);


        $this->authorize(
            'delete',
            $signalement
        );


        $signalement->delete();


        return response()->json([
            'message'=>'Signalement supprimé.'
        ]);

    }




    public function updateStatus(
        Request $request,
        Signalement $signalement
    )
    {

        if(auth()->user()->role !== 'agent'){

            return response()->json([
                'message'=>'Accès interdit'
            ],403);

        }


        $request->validate([
            'statut'=>'required|in:nouveau,en_cours,resolu,rejete'
        ]);



        $signalement->update([

            'statut'=>$request->statut

        ]);



        return response()->json([

            'message'=>'Statut mis à jour.',
            'data'=>$signalement

        ]);

    }





    public function similaires(
        Signalement $signalement,
        \App\Services\DuplicateDetector $detector
    )
    {

        return response()->json(

            $detector->findSimilar($signalement)

        );

    }





    public function analyze(
        Signalement $signalement,
        SignalementAnalyzer $analyzer
    )
    {

        $analysis = $analyzer->analyze($signalement);


        Log::info(
            'RESULTAT IA:',
            $analysis ?? []
        );


        if(!$analysis){

            return response()->json([

                'message'=>'IA n’a retourné aucun résultat'

            ],500);

        }



        $signalement->update([

            'categorie'=>$analysis['categorie'] ?? null,

            'priorite'=>$analysis['priorite'] ?? null,

            'urgence'=>$analysis['urgence'] ?? null,

            'resume'=>$analysis['resume'] ?? null,

        ]);



        return response()->json([

            'message'=>'Analyse IA terminée',

            'analysis'=>$analysis,

            'data'=>$signalement->fresh()

        ]);

    }


}
