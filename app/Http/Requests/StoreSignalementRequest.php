<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSignalementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
              'incident_id' => 'nullable|exists:incidents,id',
        'departement_id' => 'nullable|exists:departements,id',

        'description' => 'required|string',

        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',

        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        'categorie' => 'nullable|string|max:100',

        'priorite' => 'nullable|in:low,medium,high',

        'urgence' => 'nullable|integer|between:0,255',

        'resume' => 'nullable|string',

        'statut' => 'nullable|in:nouveau,en_cours,resolu,rejete',
        ];
    }
}
