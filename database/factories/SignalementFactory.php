<?php

namespace Database\Factories;

use App\Models\Signalement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Signalement>
 */
class SignalementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->value('id'),
            'incident_id' => \App\Models\Incident::inRandomOrder()->value('id'),
            'departement_id' => \App\Models\Departement::inRandomOrder()->value('id'),

            'description' => fake()->paragraph(),

            'latitude' => fake()->latitude(33.0, 36.0),
            'longitude' => fake()->longitude(-10.0, -1.0),

            'photo' => null,

            'categorie' => fake()->randomElement([
                'Voirie',
                'Éclairage',
                'Espaces verts',
                'Eau',
                'Accessibilité',
            ]),

            'priorite' => fake()->randomElement([
                'low',
                'medium',
                'high',
            ]),

            'urgence' => fake()->numberBetween(1, 5),

            'resume' => fake()->sentence(),

            'statut' => fake()->randomElement([
                'nouveau',
                'en_cours',
                'resolu',
                'rejete',
            ]),
        ];
    }
}