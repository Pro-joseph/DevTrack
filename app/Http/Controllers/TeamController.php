<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search', '');
        
        $myProjects = Project::withoutGlobalScopes()
            ->with(['owner', 'members'])
            ->where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->get();

        $activeProjectIds = Project::withoutGlobalScopes()
            ->whereNull('deleted_at')
            ->pluck('id');

        $myProjectIds = Project::withoutGlobalScopes()
            ->where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->pluck('id');

        $memberProjectIds = DB::table('project_user')
            ->where('user_id', auth()->id())
            ->whereIn('project_id', $activeProjectIds)
            ->pluck('project_id');

        $allProjectIds = $myProjectIds->merge($memberProjectIds)->unique();

        $projects = Project::withoutGlobalScopes()
            ->with(['owner', 'members'])
            ->whereIn('id', $allProjectIds)
            ->whereNull('deleted_at')
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
        $teamMembers = $teamMembers->unique('id')->values();

        $allUsers = User::where('id', '!=', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('team.index', compact('teamMembers', 'allUsers', 'search', 'projects', 'myProjects'));
    }

    public function addMember(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'role' => 'nullable|string|max:50',
        ]);

        $project = Project::withoutGlobalScopes()->findOrFail($request->project_id);
        
        $this->authorize('addMember', $project);
        
        $user = User::findOrFail($request->user_id);

        if ($project->members()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'User is already a member of this project!');
        }

        $project->members()->attach($user->id, [
            'role' => $request->role ?? 'developer',
        ]);

        return back()->with('success', $user->name . ' added to ' . $project->title . '!');
    }

    public function removeMember(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $project = Project::withoutGlobalScopes()->findOrFail($request->project_id);
        
        $this->authorize('removeMember', $project);
        
        $project->members()->detach($request->user_id);

        return back()->with('success', 'Member removed from project!');
    }

    public function projectTeam(Request $request, Project $project): View
    {
        $search = $request->get('search', '');
        
        $allUsers = User::where('id', '!=', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();
        
        $availableUsers = $allUsers->filter(fn($user) => !$project->members->contains('id', $user->id));
        
        return view('team.project', compact('project', 'allUsers', 'availableUsers', 'search'));
    }
}