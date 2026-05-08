@extends('layouts.app')

@php
$isEdit = isset($task) && $task;
$formAction = $isEdit ? route('tasks.update', [$project, $task]) : route('tasks.store', $project);
$method = $isEdit ? 'PUT' : 'POST';
$canFullUpdate = $isEdit ? (isset($canFullUpdate) && $canFullUpdate) : true;
$canUpdate = $isEdit ? (isset($canUpdate) && $canUpdate) : true;
@endphp

@section('title', $isEdit ? 'Edit Task | DevTrack' : 'New Task | DevTrack')
@section('page-title', $isEdit ? 'Edit Task' : 'New Task')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">{{ $isEdit ? 'Edit Task' : 'Define Task' }}</h1>
            <p class="text-sm text-on-surface-variant">{{ $isEdit ? 'Update task details.' : 'Define task requirements.' }}</p>
        </div>
        <a href="{{ isset($project) ? route('projects.show', $project) : route('tasks.index') }}" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ $formAction }}" method="POST" class="p-8 space-y-8">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-7 space-y-8">
@if($canFullUpdate || !$isEdit)
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="project_id">Project</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ $project->title ?? 'No Project' }}
                    </div>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Task Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., Implement Authentication Flow" type="text" value="{{ $isEdit ? $task->title : old('title') }}" {{ !$canFullUpdate && $isEdit ? 'readonly' : 'required' }}/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Detail the technical requirements and scope..." rows="6" {{ !$canUpdate && $isEdit ? 'readonly' : '' }}>{{ $isEdit ? $task->description : old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ $isEdit ? $task->deadline : old('deadline') }}" {{ !$canUpdate && $isEdit ? 'readonly' : '' }}/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="priority">Priority</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="priority" name="priority" {{ !$canUpdate && $isEdit ? 'disabled' : '' }}>
                            <option value="low" {{ $isEdit && $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ ($isEdit && $task->priority == 'medium') || (!$isEdit) ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $isEdit && $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>
                @else
                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                <input type="hidden" name="title" value="{{ $task->title }}">
                <input type="hidden" name="description" value="{{ $task->description }}">
                <input type="hidden" name="deadline" value="{{ $task->deadline }}">
                <input type="hidden" name="priority" value="{{ $task->priority }}">

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Project</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ $task->project->title ?? 'No Project' }}
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Task Title</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ $task->title }}
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Description</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ $task->description ?? 'No description' }}
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Deadline</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ $task->deadline ? \date('M d, Y', \strtotime($task->deadline)) : 'Not set' }}
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Priority</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        {{ ucfirst($task->priority) }}
                    </div>
                </div>
                @endif

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                    @if($isEdit)
                        @canany(['update', 'updateStatus'], $task)
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                            <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                        @else
                        <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                            {{ $task->status }}
                        </div>
                        @endcanany
                    @else
                    <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                        <option value="todo" {{ old('status', 'todo') == 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    @endif
                </div>
            </div>

            @if($canUpdate || !$isEdit)
            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Assign Team</label>
                <div class="border border-outline-variant rounded-lg overflow-hidden bg-surface-container-lowest flex-1 flex flex-col">
                    <div class="p-3 bg-surface-container-low border-b border-outline-variant relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                        <input class="w-full pl-8 pr-4 py-1 text-xs bg-transparent border-none focus:ring-0" placeholder="Search team members..." type="text"/>
                    </div>
                    <div class="flex-1 overflow-y-auto divide-y divide-outline-variant">
                        @forelse($members as $member)
                            <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group {{ $isEdit && $task->assigned_to == $member->id ? 'bg-primary/5' : '' }}">
                                <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="radio" name="assigned_to" value="{{ $member->id }}" {{ $isEdit && isset($task->assigned_to) && $task->assigned_to == $member->id ? 'checked' : '' }}/>
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-on-surface">{{ $member->name }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $member->email }}</p>
                                </div>
                            </label>
                        @empty
                            <div class="p-4 text-center text-outline text-sm">No members available</div>
                        @endforelse
                    </div>
                </div>
            </div>
            @elseif($isEdit && $task->user_id)
            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Assigned To</label>
                <div class="border border-outline-variant rounded-lg p-4 bg-surface-container-low">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                            {{ substr($task->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">{{ $task->user->name }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $task->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="{{ isset($project) ? route('projects.show', $project) : route('tasks.index') }}" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
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