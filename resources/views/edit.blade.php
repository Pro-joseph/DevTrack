@extends('layouts.app')

@php
$isEdit = isset($task) && $task;
$formAction = $isEdit ? route('tasks.update', $task->id) : route('tasks.store');
$method = $isEdit ? 'PUT' : 'POST';
@endphp

@section('title', $isEdit ? 'Edit Task | DevTrack' : 'New Task | DevTrack')
@section('page-title', $isEdit ? 'Edit Task' : 'New Task')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <!-- Form Header -->
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">{{ $isEdit ? 'Edit Task' : 'Define Task' }}</h1>
            <p class="text-sm text-on-surface-variant">{{ $isEdit ? 'Update task details and assignments.' : 'Define project requirements and assign a lead.' }}</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ $formAction }}" method="POST" class="p-8 space-y-8">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <!-- Left Column: Primary Details -->
            <div class="md:col-span-7 space-y-8">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="project_id">Project</label>
                    <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="project_id" name="project_id" required>
                        <option value="">Select a project</option>
                        @foreach($projects ?? [] as $proj)
                            <option value="{{ $proj->id }}" {{ ($isEdit && $task->project_id == $proj->id) || (isset($selectedProjectId) && $selectedProjectId == $proj->id) ? 'selected' : '' }}>
                                {{ $proj->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Task Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., Implement Authentication Flow" type="text" value="{{ $isEdit ? $task->title : old('title') }}" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Detail the technical requirements and scope..." rows="6">{{ $isEdit ? $task->description : old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ $isEdit ? $task->deadline : old('deadline') }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="priority">Priority</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="priority" name="priority">
                            <option value="low" {{ $isEdit && $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ ($isEdit && $task->priority == 'medium') || (!$isEdit) ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $isEdit && $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                    <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                        <option value="todo" {{ $isEdit && $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ $isEdit && $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ $isEdit && $task->status == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
            </div>

            <!-- Right Column: Team Assignment -->
            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Assign Team</label>
                <div class="border border-outline-variant rounded-lg overflow-hidden bg-surface-container-lowest flex-1 flex flex-col">
                    <div class="p-3 bg-surface-container-low border-b border-outline-variant relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                        <input class="w-full pl-8 pr-4 py-1 text-xs bg-transparent border-none focus:ring-0" placeholder="Search team members..." type="text"/>
                    </div>
                    <div class="flex-1 overflow-y-auto divide-y divide-outline-variant">
                        @forelse($users ?? [] as $user)
                            <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group">
                                <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="radio" name="assigned_to" value="{{ $user->id }}" {{ $isEdit && $task->user_id == $user->id ? 'checked' : '' }}/>
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-on-surface">{{ $user->name }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $user->email }}</p>
                                </div>
                            </label>
                        @empty
                            <div class="p-4 text-center text-outline text-sm">No users available</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="{{ route('tasks.index') }}" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                Cancel
            </a>
            <button class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 text-sm font-bold rounded-lg shadow-sm active:scale-95 transition-all flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-[18px]">save</span>
                {{ $isEdit ? 'Update Task' : 'Save Task' }}
            </button>
        </div>
    </form>
</div>
@endsection