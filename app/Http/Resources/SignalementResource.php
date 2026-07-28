<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SignalementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
        'id' => $this->id,
        'user' => $this->user,
        'incident' => $this->incident,
        'departement' => $this->departement,
        'description' => $this->description,
        'latitude' => $this->latitude,
        'longitude' => $this->longitude,
        'photo' => $this->photo,
        'categorie' => $this->categorie,
        'priorite' => $this->priorite,
        'urgence' => $this->urgence,
        'resume' => $this->resume,
        'statut' => $this->statut,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ];
    }
}
