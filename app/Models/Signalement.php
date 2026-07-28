<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'incident_id',
    'departement_id',
    'description',
    'latitude',
    'longitude',
    'photo',
    'categorie',
    'priorite',
    'urgence',
    'resume',
    'statut',
])]
class Signalement extends Model
{
    use HasFactory;

    /**
     * Un signalement appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un signalement peut appartenir à un incident.
     */
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    /**
     * Un signalement peut appartenir à un département.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}