<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * US8 — Liste des tâches d'un projet
     */
    public function index(Project $project): View
    {
        $this->authorize('viewAny', [Task::class, $project]);

        $tasks = $project->tasks()
                         ->with(['assignee'])
                         ->latest()
                         ->get();

        return view('tasks.index', compact('project', 'tasks'));
    }

    /**
     * US9 — Formulaire de création
     */
    public function create(Project $project): View
    {
        $this->authorize('create', [Task::class, $project]);

        $members = $project->members;

        return view('tasks.create', compact('project', 'members'));
    }

    /**
     * US9 — Sauvegarder une nouvelle tâche
     */
    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('create', [Task::class, $project]);

        $project->tasks()->create($request->validated());

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tâche créée avec succès !');
    }

    /**
     * US10 — Formulaire de modification
     */
    public function edit(Project $project, Task $task): View
    {
        $this->authorize('update', $task);

        $members = $project->members;

        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    /**
     * US10 — Mettre à jour une tâche
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tâche mise à jour !');
    }

    /**
     * US11 — Changer le statut (developer assigné)
     */
    public function updateStatus(Request $request, Project $project, Task $task): RedirectResponse
    {
        $this->authorize('updateStatus', $task);

        $validated = $request->validate([
            'status' => ['required', 'in:todo,in_progress,done'],
        ]);

        $task->update(['status' => $validated['status']]);

        return redirect()
            ->back()
            ->with('success', 'Statut mis à jour !');
    }

    /**
     * US12 — Supprimer une tâche
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tâche supprimée !');
    }
}