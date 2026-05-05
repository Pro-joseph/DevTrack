@extends('layouts.app')

@section('title', 'Tasks | DevTrack')
@section('page-title', 'Tasks')

@section('content')
    <div class="space-y-6 animate-in fade-in duration-500">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-on-surface">My Tasks</h2>
                <p class="text-sm text-outline mt-1">You have {{ $tasks->count() }} tasks across all projects</p>
            </div>
            <a href="{{ route('tasks.create') }}"
                class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Add Task
            </a>
        </div>

        <!-- Task Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-primary">{{ $tasks->count() }}</div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">Total</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-on-surface">{{ $tasks->where('status', 'todo')->count() }}</div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">To Do</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-primary">{{ $tasks->where('status', 'in_progress')->count() }}</div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">In Progress</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-secondary">{{ $tasks->where('status', 'done')->count() }}</div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">Done</div>
            </div>
        </div>

        <!-- Task List -->
        <div class="space-y-3">
            @forelse($tasks as $task)
                <div class="bg-white border border-outline-variant rounded-xl p-4 hover:shadow-md transition-all cursor-pointer flex items-center gap-4">
                    <input type="checkbox" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary"
                        {{ $task->status === 'done' ? 'checked' : '' }}>

                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-on-surface truncate">{{ $task->title }}</h4>
                        <p class="text-xs text-outline truncate">{{ $task->project->title ?? 'No Project' }}</p>
                    </div>

                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded
                        {{ $task->priority === 'high' ? 'bg-error/10 text-error' : ($task->priority === 'medium' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline') }}">
                        {{ $task->priority }}
                    </span>

                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded whitespace-nowrap
                        {{ $task->status === 'done' ? 'bg-secondary/10 text-secondary' : ($task->status === 'in_progress' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline') }}">
                        {{ str_replace('_', ' ', $task->status) }}
                    </span>

                    <div class="flex items-center gap-2 text-xs text-outline">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ $task->user->name ?? 'Unassigned' }}
                    </div>

                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-outline hover:text-primary p-2">
                        <span class="material-symbols-outlined text-sm">edit</span>
                    </a>
                    <form action="{{ route('tasks.archive', $task->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-outline hover:text-primary p-2" onclick="return confirm('Archive this task?')">
                            <span class="material-symbols-outlined text-sm">archive</span>
                        </button>
                    </form>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-outline hover:text-error p-2" onclick="return confirm('Delete this task permanently?')">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-8 text-outline">
                    No tasks found. <a href="{{ route('tasks.create') }}" class="text-primary hover:underline">Create one</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection