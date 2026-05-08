<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Voir les tâches (tous ou d'un projet spécifique)
     */
    public function viewAny(User $user, $project = null): bool
    {
        if (!$project) {
            return $user->projects()->exists();
        }

        return $project->members()
                       ->where('user_id', $user->id)
                       ->exists();
    }

    /**
     * Voir cette tâche (membres du projet, lead, ou assignee)
     */
    public function view(User $user, Task $task): bool
    {
        return true;
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

        return $task->user_id === $user->id || $task->assigned_to === $user->id;
    }

    /**
     * Supprimer cette tâche (lead du projet)
     */
    public function delete(User $user, Task $task): bool
    {
        return $this->isLead($user, $task->project);
    }

    /**
     * Supprimer définitivement une tâche (lead du projet)
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $this->isLead($user, $task->project);
    }

    /**
     * Vérifie si l'user est lead de ce projet
     */
    private function isLead(User $user, $project): bool
    {
        if ($project->owner && $project->owner->is($user)) {
            return true;
        }

        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }
}