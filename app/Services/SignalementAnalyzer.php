<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class SignalementAnalyzer
{
    public function analyze(string $description): array
    {
$prompt = "
Tu es un assistant chargé d'analyser un signalement citoyen.

Retourne uniquement un JSON valide avec cette structure :

{
  \"categorie\": \"...\",
  \"urgence\": 1,
  \"priorite\": \"low|medium|high\",
  \"resume\": \"...\",
  \"departement\": \"...\"
}

Urgence :
1 = faible
2 = moyenne
3 = élevée

Signalement :
$description
";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        return json_decode(
            $response->choices[0]->message->content,
            true
        );
    }
}
