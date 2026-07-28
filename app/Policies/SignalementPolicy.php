<?php

namespace App\Policies;

use App\Models\Signalement;
use App\Models\User;

class SignalementPolicy
{
    /**
     * Voir la liste des signalements
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['citoyen', 'agent']);
    }

    /**
     * Voir un signalement
     */
    public function view(User $user, Signalement $signalement): bool
    {
        // Citoyen : seulement ses propres signalements
        if ($user->role === 'citoyen') {
            return $user->id === $signalement->user_id;
        }

        // Agent : accès aux signalements
        if ($user->role === 'agent') {
            return true;
        }

        return false;
    }

    /**
     * Créer un signalement
     */
    public function create(User $user): bool
    {
        // Seul un citoyen peut créer un signalement
        return $user->role === 'citoyen';
    }

    /**
     * Modifier un signalement
     */
    public function update(User $user, Signalement $signalement): bool
    {
        // Seul l'agent peut modifier le statut
        return $user->role === 'agent';
    }

    /**
     * Supprimer un signalement
     */
    public function delete(User $user, Signalement $signalement): bool
    {
        return $user->role === 'agent';
    }

    public function restore(User $user, Signalement $signalement): bool
    {
        return false;
    }

    public function forceDelete(User $user, Signalement $signalement): bool
    {
        return false;
    }
}