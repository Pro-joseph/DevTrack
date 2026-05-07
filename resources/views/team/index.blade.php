@extends('layouts.app')

@section('title', 'Team | DevTrack')
@section('page-title', 'Team')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Team Members</h2>
                <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">@isset($teamMembers){{ $teamMembers->count() }}@else 0 @endisset Members</span>
            </div>
            <p class="text-sm text-outline">Manage your team and assignments.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('team.index') }}" class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-outline">search</span>
        </div>
        <input type="text" name="search" value="{{ $search }}" 
            placeholder="Search users to add to your team..."
            class="w-full pl-12 pr-4 py-3 bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
    </form>

    @if($search && isset($allUsers) && $allUsers->count() > 0)
    <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-bold text-on-surface mb-4">Add to Team</h3>
        <div class="space-y-3">
            @foreach($allUsers as $user)
            <div class="flex items-center justify-between p-3 bg-surface-container rounded-lg">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                        alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="font-bold text-on-surface">{{ $user->name }}</h4>
                        <p class="text-xs text-outline">{{ $user->email }}</p>
                    </div>
                </div>
                @if(isset($myProjects) && $myProjects->count() > 0)
                    <form method="POST" action="{{ route('team.addMember') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <select name="project_id" class="text-sm border border-outline-variant rounded-lg px-3 py-2">
                            <option value="">Select Project</option>
                            @foreach($myProjects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="role" value="developer">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-container transition-colors">
                            Add
                        </button>
                    </form>
                @else
                <span class="text-xs text-outline">No projects you can manage</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div>
        <h3 class="text-lg font-bold text-on-surface mb-4">My Team</h3>
        @if(isset($myProjects) && $myProjects->count() > 0)
        <div class="space-y-6">
            @foreach($myProjects as $project)
            <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-on-surface">{{ $project->title }}</h4>
                    <span class="text-xs text-outline">{{ $project->members->filter(fn($m) => $m->id !== $project->user_id)->count() + 1 }} members</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="flex items-center gap-3 p-3 bg-surface-container rounded-lg">
                        <img class="w-10 h-10 rounded-full border border-outline-variant" 
                            src="https://ui-avatars.com/api/?name={{ urlencode($project->owner->name) }}&background=random" alt="{{ $project->owner->name }}">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm text-on-surface truncate">{{ $project->owner->name }}</p>
                            <p class="text-xs text-outline">Lead</p>
                        </div>
                    </div>
                    @foreach($project->members->filter(fn($m) => $m->id !== $project->user_id) as $member)
                    <div class="flex items-center justify-between gap-2 p-3 bg-surface-container rounded-lg">
                        <div class="flex items-center gap-3">
                            <img class="w-10 h-10 rounded-full border border-outline-variant" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" alt="{{ $member->name }}">
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-on-surface truncate">{{ $member->name }}</p>
                                <p class="text-xs text-outline">{{ $member->pivot->role ?? 'Developer' }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('team.removeMember') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $member->id }}">
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button type="submit" class="text-outline hover:text-error p-1" onclick="return confirm('Remove {{ $member->name }}?')">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white border border-outline-variant rounded-xl">
            <div class="w-16 h-16 bg-surface-container mx-auto rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[32px] text-outline">folder</span>
            </div>
            <h3 class="text-lg font-bold text-on-surface mb-2">No projects yet</h3>
            <p class="text-sm text-outline">Create a project to start adding team members.</p>
        </div>
        @endif
    </div>
</div>
@endsection