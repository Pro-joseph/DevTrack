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
        @forelse($projects->take(4) as $index => $project)
            @if($index === 0 && $projects->isNotEmpty())
            <div class="col-span-1 lg:col-span-2 bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-secondary-container/30 text-secondary rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-[28px]">database</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-on-surface group-hover:text-primary transition-colors">
                                {{ $project->title }}
                            </h3>
                            <p class="text-xs text-outline font-medium uppercase tracking-wider">{{ $project->owner?->name ?? 'No owner' }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] rounded-md font-bold uppercase tracking-widest">
                        {{ $project->status }}
                    </span>
                </div>
                <p class="text-sm text-on-surface-variant mb-8 line-clamp-2 leading-relaxed">
                    {{ $project->description ?? 'No description available.' }}
                </p>
                <div class="space-y-4">
                    @php
                        $totalTasks = $project->tasks->count();
                        $completedTasks = $project->tasks->where('status', 'done')->count();
                        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    @endphp
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                        <span class="text-on-surface/70">Development Progress</span>
                        <span class="text-primary">{{ $completedTasks }} / {{ $totalTasks }} Tasks</span>
                    </div>
                    <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                        <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
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
                        <div class="flex items-center gap-1.5 text-error font-bold text-xs">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            {{ $project->deadline ? \date('M d', \strtotime($project->deadline)) : 'No deadline' }}
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">folder</span>
                    </div>
                    <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] rounded-md font-bold uppercase tracking-widest">
                        {{ $project->status }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">
                    {{ $project->title }}
                </h3>
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
                        <span class="text-outline">Tasks</span>
                        <span class="text-on-surface">{{ $completedTasks }} / {{ $totalTasks }}</span>
                    </div>
                    <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                        <div class="bg-primary h-full rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="pt-4 flex items-center gap-1.5 text-outline font-bold text-xs">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        {{ $project->deadline ? \date('M d, Y', \strtotime($project->deadline)) : 'No deadline' }}
                    </div>
                </div>
            </div>
            @endif
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

        {{-- @if($projects->count() < 4)
        <a href="{{ route('projects.create') }}" class="border-2 border-dashed border-outline-variant rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-white hover:border-primary transition-all group cursor-pointer">
            <div class="w-14 h-14 rounded-full bg-surface-container-low flex items-center justify-center text-outline group-hover:bg-primary/10 group-hover:text-primary mb-4 transition-all">
                <span class="material-symbols-outlined text-3xl">add_circle</span>
            </div>
            <p class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Initiate Project</p>
            <p class="text-xs text-outline px-4 mt-2 leading-relaxed">Start a new workflow and assign your core development team.</p>
        </a>
        @endif --}}
    </div>
@endsection