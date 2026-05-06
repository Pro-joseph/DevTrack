<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /*
     * Voir la liste(utilisateurs connectés)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Voir ce projet (membres seulement)
     */
    public function view(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->exists();
    }

    /**
     * Créer un projet (utilisateurs connectés seulement)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Modifier ce projet(Lead du projet)
     */
    public function update(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Archiver ce projet(Lead du projet)
     */
    public function delete(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Restaurer ce projet (Lead du projet)
     */
    public function restore(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }
  /**
     * Vérifie si l'utilisateur est le lead de ce projet
     */
    private function isLead(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }
}