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
     * Liste de tous les projets
     */
    public function index(): View
    {
        $projects = Project::with(['owner', 'members', 'tasks'])
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    /**
     * Sauvegarder un nouveau projet
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
            'status' => $request->input('status', 'planning'),
        ]);

        $project->members()->attach(auth()->id(), ['role' => 'lead']);

        if ($request->has('members')) {
            foreach ($request->input('members') as $userId) {
                if ($userId != auth()->id()) {
                    $project->members()->attach($userId, ['role' => 'developer']);
                }
            }
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
        $project->load(['owner', 'members', 'tasks.user']);

        return view('projects.show', compact('project'));
    }

    /**
     * Formulaire de modification
     */
    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Mettre à jour un projet
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Projet mis à jour !');
    }

    /**
     * Archiver un projet (SoftDelete)
     */
    public function destroy(int $id): RedirectResponse
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()
            ->route('archives.index')
            ->with('success', 'Projet supprimé définitivement !');
    }

    /**
     * Archive a project using POST
     */
    public function archive(int $id): RedirectResponse
    {
        $project = Project::findOrFail($id);
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
        $project->restore();

        return redirect()
            ->route('archives.index')
            ->with('success', 'Projet restauré !');
    }
}