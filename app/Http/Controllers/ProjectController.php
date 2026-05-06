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
        $projects = Project::with(['owner', 'members'])
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereHas('members', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
            })
            ->get();

        $teamMembers = collect();
        foreach ($projects as $project) {
            foreach ($project->members as $member) {
                if ($member->id !== auth()->id()) {
                    $teamMembers->push($member);
                }
            }
            if ($project->owner->id !== auth()->id()) {
                $teamMembers->push($project->owner);
            }
        }
        $users = $teamMembers->unique('id')->values();

        return view('project-form', compact('users'));
    }

    /**
     * Sauvegarder un nouveau projet
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
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
    public function destroy(int $id): RedirectResponse
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()
            ->route('archives.index')
            ->with('success', 'Projet supprimé définitivement !');
    }

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
            ->route('archives.index')
            ->with('success', 'Projet restauré !');
    }
}