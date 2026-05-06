<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Liste des projets où l'utilisateur est membre
     */
    public function index(): View
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::with(['owner', 'members', 'tasks'])
            ->whereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        $this->authorize('create', Project::class);

        $users = User::all();

        return view('projects.create', compact('users'));
    }

    /**
     * Sauvegarder un nouveau projet
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        // Créateur devient automatiquement lead
        $project->members()->attach(auth()->id(), ['role' => 'lead']);

        // Ajouter les membres sélectionnés comme developers
        if ($request->has('members')) {
            $members = collect($request->input('members'))
                ->reject(fn($userId) => $userId == auth()->id())
                ->mapWithKeys(fn($userId) => [$userId => ['role' => 'developer']]);

            $project->members()->attach($members);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Projet créé avec succès !');
    }

    /**
     * Voir un projet en détail
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members', 'tasks.assignee']);

        return view('projects.show', compact('project'));
    }

    /**
     * Formulaire de modification
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Mettre à jour un projet
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Projet mis à jour !');
    }

    /**
     * Archiver un projet (SoftDelete)
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet archivé !');
    }

    /**
     * Restaurer un projet archivé
     */
    public function restore(int $id): RedirectResponse
    {
        $project = Project::withTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet restauré !');
    }
}