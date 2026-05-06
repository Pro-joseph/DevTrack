@extends('layouts.app')

@section('title', 'Team | DevTrack')
@section('page-title', 'Team')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Team Members</h2>
                <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">@isset($teamMembers){{ $teamMembers->count() }}@else 0 @endisset Members</span>
            </div>
            <p class="text-sm text-outline">Manage your team and assignments.</p>
        </div>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('team.index') }}" class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-outline">search</span>
        </div>
        <input type="text" name="search" value="{{ $search }}" 
            placeholder="Search users to add to your team..."
            class="w-full pl-12 pr-4 py-3 bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
    </form>

    @if($search && isset($allUsers) && $allUsers->count() > 0)
    <!-- Search Results -->
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
                @if(isset($projects) && $projects->count() > 0)
                <form method="POST" action="{{ route('team.addMember') }}" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <select name="project_id" class="text-sm border border-outline-variant rounded-lg px-3 py-2">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="role" value="developer">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-container transition-colors">
                        Add
                    </button>
                </form>
                @else
                <span class="text-xs text-outline">Create a project first</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- My Team Members -->
    <div>
        <h3 class="text-lg font-bold text-on-surface mb-4">My Team</h3>
        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($teamMembers as $member)
            <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="relative">
                        <img class="w-14 h-14 rounded-full border-2 border-white ring-2 ring-outline-variant" 
                            src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" alt="{{ $member->name }}">
                    </div>
                </div>
                <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">{{ $member->name }}</h3>
                <p class="text-sm text-outline mb-3">{{ $member->email }}</p>
                <div class="mt-4 pt-4 border-t border-outline-variant">
                    @if(isset($projects))
                    @foreach($projects as $project)
                        @php $isMember = $project->members->contains('id', $member->id); @endphp
                        @if($isMember || (isset($project->owner) && $project->owner->id == $member->id))
                        <form method="POST" action="{{ route('team.removeMember') }}" class="flex items-center justify-between">
                            @csrf
                            <span class="text-xs text-outline">{{ $project->title }}</span>
                            <input type="hidden" name="user_id" value="{{ $member->id }}">
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button type="submit" class="text-xs text-error hover:text-error-container" onclick="return confirm('Remove from {{ $project->title }}?')">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </form>
                        @endif
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white border border-outline-variant rounded-xl">
            <div class="w-16 h-16 bg-surface-container mx-auto rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[32px] text-outline">group</span>
            </div>
            <h3 class="text-lg font-bold text-on-surface mb-2">No team members yet</h3>
            <p class="text-sm text-outline">Search for users above to add them to your projects.</p>
        </div>
        @endif
    </div>
</div>
@endsection