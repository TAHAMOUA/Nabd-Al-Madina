<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('signalements', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

   $table->foreignId('incident_id')
    ->nullable()
    ->constrained()
    ->restrictOnDelete();

    $table->foreignId('departement_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->text('description');

    $table->decimal('latitude', 10, 7);
    $table->decimal('longitude', 10, 7);

    $table->string('photo')->nullable();

    $table->string('categorie', 100)->nullable();

    $table->enum('priorite', ['low', 'medium', 'high'])->nullable();

    $table->unsignedTinyInteger('urgence')->nullable();

    $table->text('resume')->nullable();

    $table->enum('statut', [
        'nouveau',
        'en_cours',
        'resolu',
        'rejete'
    ])->default('nouveau');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
