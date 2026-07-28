<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'titre',
    'description',
])]
class Incident extends Model
{
    use HasFactory;

    /**
     * Un incident possède plusieurs signalements.
     */
    public function signalements(): HasMany
    {
        return $this->hasMany(Signalement::class);
    }
}