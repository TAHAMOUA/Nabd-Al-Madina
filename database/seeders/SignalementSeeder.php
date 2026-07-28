<?php

namespace Database\Seeders;

use App\Models\Signalement;
use Illuminate\Database\Seeder;

class SignalementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Signalement::factory()->count(30)->create();
    }
}