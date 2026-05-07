<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Voir les tâches du projet (membres du projet)
     */
    public function viewAny(User $user, $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->exists();
    }

    /**
     * Voir cette tâche (membres du projet)
     */
    public function view(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->exists();
    }

    /**
     * Créer une tâche (lead du projet)
     */
    public function create(User $user, $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Modifier cette tâche (lead du projet)
     */
    public function update(User $user, Task $task): bool
    {
        return $this->isLead($user, $task->project);
    }

    /**
     * Changer le statut (lead du projet OU developer assigné)
     */
    public function updateStatus(User $user, Task $task): bool
    {
        if ($this->isLead($user, $task->project)) {
            return true;
        }

        return $task->assigned_to === $user->id;
    }

    /**
     * Supprimer cette tâche (lead du projet)
     */
    public function delete(User $user, Task $task): bool
    {
        return $this->isLead($user, $task->project);
    }

    /**
     * Vérifie si l'user est lead de ce projet
     */
    private function isLead(User $user, $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }
}