<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer des utilisateurs
        User::factory(10)->create();

        // Lancer les autres seeders
        $this->call([
            DepartementSeeder::class,
            IncidentSeeder::class,
            SignalementSeeder::class,
        ]);
    }
}