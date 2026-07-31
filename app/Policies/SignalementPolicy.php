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
        return true; // Tout le monde peut voir la liste des signalements
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
        return true;
    }

    /**
     * Modifier un signalement
     */
public function update(User $user, Signalement $signalement): bool
{
    return $user->role === 'admin'
        || $user->role === 'agent'
        || (
            $user->role === 'citoyen'
            && $user->id === $signalement->user_id
        );
}

    /**
     * Supprimer un signalement
     */
  public function delete(User $user, Signalement $signalement): bool
{
    return $user->role === 'admin'
        || (
            $user->role === 'citoyen'
            && $user->id === $signalement->user_id
        );
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
