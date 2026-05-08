@extends('layouts.app')

@section('title', 'Archives | DevTrack')
@section('page-title', 'Archives')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Archived Items</h2>
                <span class="px-2.5 py-0.5 bg-outline/10 text-outline text-xs rounded-full font-bold">{{ $archivedProjects->count() + $archivedTasks->count() }}</span>
            </div>
            <p class="text-sm text-outline">Restored projects and tasks can be accessed again.</p>
        </div>
    </div>

    @if($archivedProjects->count() > 0)
    <!-- Archived Projects -->
    <div>
        <h3 class="text-lg font-bold text-on-surface mb-4">Projects ({{ $archivedProjects->count() }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($archivedProjects as $project)
            <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group opacity-75 hover:opacity-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-surface-container rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px] text-outline">folder</span>
                    </div>
                    <span class="px-2 py-1 bg-surface-container text-outline text-[10px] rounded font-bold uppercase tracking-widest">Archived</span>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">{{ $project->description ?? 'No description' }}</p>
                <div class="space-y-3 pt-4 border-t border-outline-variant/50">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                        <span class="text-outline">Deleted</span>
                        <span class="text-on-surface">{{ $project->deleted_at ? \date('M d, Y', \strtotime($project->deleted_at)) : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                        <span class="text-outline">Tasks</span>
                        <span class="text-primary">{{ $project->tasks->count() }}</span>
                    </div>
                </div>
                <div class="flex gap-2 mt-4 pt-4 border-t border-outline-variant">
                    <form method="POST" action="{{ route('projects.restore', $project) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-2 text-sm font-medium bg-surface-container text-on-surface rounded-lg hover:bg-surface-container-high transition-colors flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm">restore</span>
                            Restore
                        </button>
                    </form>
                    <form method="POST" action="{{ route('projects.force-delete', $project) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-2 px-3 text-sm font-medium text-error hover:bg-error-container rounded-lg transition-colors" onclick="return confirm('Delete permanently?')">
                            <span class="material-symbols-outlined text-sm">delete_forever</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($archivedTasks->count() > 0)
    <!-- Archived Tasks -->
    <div>
        <h3 class="text-lg font-bold text-on-surface mb-4">Tasks ({{ $archivedTasks->count() }})</h3>
        <div class="space-y-3">
            @foreach($archivedTasks as $task)
            <div class="bg-white border border-outline-variant rounded-xl p-4 flex items-center gap-4 opacity-75 hover:opacity-100">
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-on-surface truncate">{{ $task->title }}</h4>
                    <p class="text-xs text-outline truncate">{{ $task->project->title ?? 'No Project' }}</p>
                </div>
                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded bg-surface-container text-outline">
                    {{ $task->status }}
                </span>
                <span class="text-xs text-outline">{{ $task->deleted_at ? \date('M d', \strtotime($task->deleted_at)) : '-' }}</span>
                <form method="POST" action="{{ route('tasks.restore-simple', $task) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-outline hover:text-primary p-2">
                        <span class="material-symbols-outlined text-sm">restore</span>
                    </button>
                </form>
                <form method="POST" action="{{ route('tasks.force-delete', $task) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-outline hover:text-error p-2" onclick="return confirm('Delete permanently?')">
                        <span class="material-symbols-outlined text-sm">delete_forever</span>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Empty State -->
    @if($archivedProjects->count() == 0 && $archivedTasks->count() == 0)
    <div class="text-center py-12">
        <div class="w-20 h-20 bg-surface-container mx-auto rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[40px] text-outline">inventory_2</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2">No archived items</h3>
        <p class="text-sm text-outline">Archived projects and tasks will appear here.</p>
    </div>
    @endif
</div>
@endsection