@extends('layouts.app')

@section('title', 'Dashboard | DevTrack')
@section('page-title', 'Dashboard')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-lg animate-in fade-in slide-in-from-left duration-500">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Active Projects</h2>
                <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">{{ $activeProjects }} Active</span>
            </div>
            <p class="text-sm text-outline">Manage and track your ongoing development initiatives.</p>
        </div>
        {{-- <a href="{{ route('projects.create') }}"
            class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all active:scale-95">
            <span class="material-symbols-outlined text-[20px]">add</span>
            New Project
        </a> --}}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @forelse($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}" class="block bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                @if($project->status === 'active')
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                @endif
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 {{ $project->status === 'active' ? 'bg-secondary-container/30 text-secondary' : 'bg-primary/10 text-primary' }} rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">{{ $project->status === 'active' ? 'database' : 'folder' }}</span>
                    </div>
                    <span class="px-2 py-1 {{ $project->status === 'active' ? 'bg-secondary/10 text-secondary' : 'bg-primary/10 text-primary' }} text-[10px] rounded-md font-bold uppercase tracking-widest">
                        {{ $project->status }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">
                    {{ $project->title }}
                </h3>
                <p class="text-xs text-outline font-medium uppercase tracking-wider mb-4">{{ $project->owner?->name ?? 'No owner' }}</p>
                <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">
                    {{ $project->description ?? 'No description available.' }}
                </p>
                <div class="space-y-4">
                    @php
                        $totalTasks = $project->tasks->count();
                        $completedTasks = $project->tasks->where('status', 'done')->count();
                        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    @endphp
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                        <span class="{{ $project->status === 'active' ? 'text-on-surface/70' : 'text-outline' }}">Tasks</span>
                        <span class="{{ $project->status === 'active' ? 'text-primary' : 'text-on-surface' }}">{{ $completedTasks }} / {{ $totalTasks }}</span>
                    </div>
                    <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                        <div class="{{ $project->status === 'active' ? 'bg-primary' : 'bg-secondary' }} h-full rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <div class="flex -space-x-3">
                            @forelse($project->members->take(3) as $member)
                                <img class="w-9 h-9 rounded-full border-2 border-white ring-1 ring-outline-variant"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random"
                                    alt="{{ $member->name }}">
                            @empty
                                <div class="w-9 h-9 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">
                                    0
                                </div>
                            @endforelse
                            @if($project->members->count() > 3)
                                <div class="w-9 h-9 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">
                                    +{{ $project->members->count() - 3 }}
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-1.5 {{ $project->status === 'active' ? 'text-error' : 'text-outline' }} font-bold text-xs">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            {{ $project->deadline ? \date('M d, Y', \strtotime($project->deadline)) : 'No deadline' }}
                        </div>
                    </div>
                </div>
            </a>
        @empty
        <div class="col-span-full bg-white border border-outline-variant rounded-xl p-12 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl">folder_off</span>
            </div>
            <h3 class="text-xl font-bold text-on-surface mb-2">No projects yet</h3>
            <p class="text-sm text-outline mb-6">Get started by creating your first project.</p>
            <a href="{{ route('projects.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg transition-all">
                Create Project
            </a>
        </div>
        @endforelse
    </div>
@endsection