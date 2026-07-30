<?php

namespace App\Services;

use App\Models\Signalement;
use OpenAI\Laravel\Facades\OpenAI;

class DuplicateDetector
{
    public function findSimilar(Signalement $signalement)
    {
        $others = Signalement::where('id', '!=', $signalement->id)
            ->where('statut', '!=', 'resolu')
            ->get();

        $results = [];

        foreach ($others as $other) {

            try {

                $response = OpenAI::chat()->create([
                    'model' => 'gpt-4.1-mini',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "
Compare ces deux signalements.

Signalement A :
{$signalement->description}

Signalement B :
{$other->description}

Retourne uniquement un JSON :

{
  \"score\": 0
}
"
                        ]
                    ]
                ]);

                $json = json_decode(
                    $response->choices[0]->message->content,
                    true
                );

                $results[] = [
                    'signalement' => $other,
                    'score' => $json['score'] ?? 0,
                ];

            } catch (\Throwable $e) {

                $results[] = [
                    'signalement' => $other,
                    'score' => 0,
                ];

            }

        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return $results;
    }
}
