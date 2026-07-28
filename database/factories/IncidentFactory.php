<?php

namespace Database\Factories;

use App\Models\Incident;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'titre' => fake()->randomElement([
            'Lampadaire en panne',
            'Fuite d’eau',
            'Nid-de-poule',
            'Arbre dangereux',
            'Feu de signalisation défectueux',
            'Poubelle débordante',
            'Chaussée endommagée',
        ]),

        'description' => fake()->sentence(12),
    ];
}
}
