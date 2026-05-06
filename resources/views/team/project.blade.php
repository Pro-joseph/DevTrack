@extends('layouts.app')

@section('title', 'Team | ' . $project->title . ' | DevTrack')
@section('page-title', 'Team: ' . $project->title)

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <a href="{{ route('projects.show', $project) }}" class="text-sm text-outline hover:text-primary mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to project
            </a>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">{{ $project->title }}</h2>
                <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">{{ $project->members->count() }} Members</span>
            </div>
            <p class="text-sm text-outline">Manage team members for this project.</p>
        </div>
    </div>

    <!-- Current Members -->
    <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-bold text-on-surface mb-4">Current Members</h3>
        @if($project->members->count() > 0)
        <div class="space-y-3">
            @foreach($project->members as $member)
            <div class="flex items-center justify-between p-3 bg-surface-container rounded-lg">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" 
                        alt="{{ $member->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="font-bold text-on-surface">{{ $member->name }}</h4>
                        <p class="text-xs text-outline">{{ $member->email }}</p>
                    </div>
                    <span class="px-2 py-0.5 bg-primary/10 text-primary text-xs rounded-full">{{ $member->pivot->role }}</span>
                </div>
                @if($member->id !== auth()->id())
                <form method="POST" action="{{ route('team.removeMember') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <button type="submit" class="text-error hover:text-error-container" onclick="return confirm('Remove this member?')">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-outline">No team members yet.</p>
        @endif
    </div>

    <!-- Add Members -->
    <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-bold text-on-surface mb-4">Add New Member</h3>
        @if($allUsers->count() > 0)
        <div class="space-y-3">
            @foreach($allUsers as $user)
            @if(!$project->members->contains('id', $user->id))
            <div class="flex items-center justify-between p-3 bg-surface-container rounded-lg">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                        alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="font-bold text-on-surface">{{ $user->name }}</h4>
                        <p class="text-xs text-outline">{{ $user->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('team.addMember') }}" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <select name="role" class="text-sm border border-outline-variant rounded-lg px-3 py-2">
                        <option value="developer">Developer</option>
                        <option value="lead">Lead</option>
                    </select>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-container transition-colors">
                        Add
                    </button>
                </form>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <p class="text-sm text-outline">No users available to add.</p>
        @endif
    </div>
</div>
@endsection