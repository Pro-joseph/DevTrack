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
     * US8 — Liste des tâches (tous les projets ou un projet spécifique)
     */
    public function index(?Project $project = null): View
    {
        if ($project) {
            $this->authorize('viewAny', [Task::class, $project]);

            $tasks = $project->tasks()
                             ->with(['assignee'])
                             ->latest()
                             ->get();

            return view('tasks.index', compact('project', 'tasks'));
        }

        $tasks = Task::where(function ($query) {
                         $query->where('assigned_to', auth()->id())
                               ->orWhere('user_id', auth()->id());
                     })
                     ->with(['project', 'assignee'])
                     ->latest()
                     ->get();

        return view('tasks.index', compact('tasks'));
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
            ->route('projects.show', $project)
            ->with('success', 'Tâche créée avec succès !');
    }

    /**
     * US10 — Formulaire de modification
     */
    public function edit(Project $project, Task $task): View
    {
        $this->authorize('view', $task);
        $this->authorize('updateStatus', $task);

        $canFullUpdate = auth()->user()->id === $project->user_id ||
            $project->members()->where('user_id', auth()->id())->wherePivot('role', 'lead')->exists();

        $members = $project->members;

        return view('tasks.edit', compact('project', 'task', 'members', 'canFullUpdate'))->with('canUpdate', $canFullUpdate);
    }

    /**
     * US10 — Mettre à jour une tâche
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $isLead = auth()->user()->id === $project->user_id || 
            $project->members()->where('user_id', auth()->id())->wherePivot('role', 'lead')->exists();
        
        $isAssignee = $task->user_id === auth()->id() || $task->assigned_to === auth()->id();

        if (!$isLead && !$isAssignee) {
            abort(403, 'Unauthorized');
        }

        if ($isAssignee && !$isLead) {
            $request->validate([
                'status' => ['required', 'in:todo,in_progress,done'],
            ]);
            $task->update(['status' => $request->status]);
            return redirect()
                ->back()
                ->with('success', 'Statut mis à jour !');
        }

        $task->update($request->validated());

        return redirect()
            ->route('tasks.index', $project)
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
            ->route('projects.show', $project)
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
            ->route('tasks.index')
            ->with('success', 'Tâche supprimée !');
    }

    /**
     * Archiver une tâche
     */
    public function archive(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->back()
            ->with('success', 'Tâche archivée !');
    }

    /**
     * Restaurer une tâche
     */
    public function restore(Task $task): RedirectResponse
    {
        $task->restore();

        return redirect()
            ->back()
            ->with('success', 'Tâche restaurée !');
    }
}