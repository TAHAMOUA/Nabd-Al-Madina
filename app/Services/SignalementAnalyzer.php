<?php

namespace App\Services;

use App\Models\Signalement;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class SignalementAnalyzer
{
    public function analyze(Signalement $signalement)
    {
        try {

            $response = OpenAI::chat()->create([

                'model' => 'gpt-4.1-mini',

                'response_format' => [
                    'type' => 'json_object'
                ],

                'messages' => [

                    [
                        'role' => 'system',
                        'content' => 'Tu es un expert en analyse des signalements urbains.'
                    ],

                    [
                        'role' => 'user',
                        'content' =>
                        "Analyse ce signalement :

Description :
{$signalement->description}

Retourne uniquement un JSON valide :

{
    \"categorie\":\"Voirie\",
    \"priorite\":\"high\",
    \"urgence\":3,
    \"resume\":\"Résumé court\",
    \"departement\":\"Voirie\"
}"
                    ]

                ]

            ]);


            $content = $response->choices[0]->message->content;


            Log::info("IA RESPONSE:");
            Log::info($content);


            $result = json_decode($content, true);


            if (!$result) {

                throw new \Exception(
                    "JSON IA invalide : ".$content
                );

            }


            return $result;


        } catch (\Throwable $e) {


            Log::error(
                "Erreur IA : ".$e->getMessage()
            );


            return [

                'categorie' => 'Inconnu',
                'priorite' => 'low',
                'urgence' => 1,
                'resume' => 'Erreur analyse IA',
                'departement' => null

            ];

        }
    }
}
