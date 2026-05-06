<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search', '');
        
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
        $teamMembers = $teamMembers->unique('id')->values();

        $allUsers = User::where('id', '!=', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('team.index', compact('teamMembers', 'allUsers', 'search', 'projects'));
    }

    public function addMember(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'role' => 'nullable|string|max:50',
        ]);

        $project = Project::findOrFail($request->project_id);
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

        $project = Project::findOrFail($request->project_id);
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