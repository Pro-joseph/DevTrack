@extends('layouts.app')

@section('title', 'Projects | DevTrack')
@section('page-title', 'Projects')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-lg animate-in fade-in slide-in-from-left duration-500">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <h2 class="text-3xl font-bold text-on-surface">All Projects</h2>
            <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">{{ $projects->total() }} Projects</span>
        </div>
        <p class="text-sm text-outline">View and manage all your development projects.</p>
    </div>
    <a href="{{ route('projects.create') }}" class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all active:scale-95">
        <span class="material-symbols-outlined text-[20px]">add</span>
        New Project
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
@forelse($projects as $project)
    <a href="{{ route('projects.show', $project) }}" class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-secondary-container/30 text-secondary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">folder</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                    <p class="text-xs text-outline font-medium uppercase tracking-wider">{{ $project->status }}</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] rounded-md font-bold uppercase tracking-widest">{{ $project->status }}</span>
        </div>
        
        <p class="text-sm text-on-surface-variant mb-8 line-clamp-2 leading-relaxed">
            {{ $project->description ?? 'No description' }}
        </p>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                <span class="text-on-surface/70">Tasks</span>
                <span class="text-primary">{{ $project->tasks->count() }} Tasks</span>
            </div>
            <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full w-[0%] transition-all duration-1000"></div>
            </div>
            <div class="flex justify-between items-center pt-4">
                <div class="flex -space-x-3">
                    @foreach($project->members->take(3) as $member)
                        <img class="w-9 h-9 rounded-full border-2 border-white ring-1 ring-outline-variant" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}" alt="{{ $member->name }}">
                    @endforeach
                    @if($project->members->count() > 3)
                        <div class="w-9 h-9 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">+{{ $project->members->count() - 3 }}</div>
                    @endif
                </div>
                @if($project->deadline)
                    <div class="flex items-center gap-1.5 text-error font-bold text-xs">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        {{ \date('M d', \strtotime($project->deadline)) }}
                    </div>
                @endif
            </div>
        </div>
    </a>
@empty
    <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
        <div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center text-outline mb-4">
            <span class="material-symbols-outlined text-4xl">folder_off</span>
        </div>
        <p class="text-lg font-bold text-on-surface">No projects yet</p>
        <p class="text-sm text-outline mt-2">Create your first project to get started.</p>
    </div>
@endforelse
</div>

<a href="{{ route('projects.create') }}" class="border-2 border-dashed border-outline-variant rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-white hover:border-primary transition-all group cursor-pointer group">
    <div class="w-14 h-14 rounded-full bg-surface-container-low flex items-center justify-center text-outline group-hover:bg-primary/10 group-hover:text-primary mb-4 transition-all">
        <span class="material-symbols-outlined text-3xl">add_circle</span>
    </div>
    <p class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Initiate Project</p>
    <p class="text-xs text-outline px-4 mt-2 leading-relaxed">Start a new workflow and assign your core development team.</p>
</a>
@endsection