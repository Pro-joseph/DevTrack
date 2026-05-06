@extends('layouts.app')

@section('title', $project->name . ' | DevTrack')
@section('page-title', $project->title)

@section('content')
    <div class="max-w-7xl mx-auto space-y-10 animate-in fade-in duration-700">
        <!-- Project Header -->
        <section>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span
                            class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            {{ ucfirst($project->status) }}
                        </span>
                        <span class="text-outline font-bold text-xs uppercase tracking-tighter tracking-widest">Project
                            #{{ $project->id }}</span>
                    </div>
                    <h2 class="text-4xl font-black text-on-surface tracking-tight">{{ $project->title }}</h2>
                    <p class="text-on-surface-variant max-w-2xl text-base leading-relaxed">
                        {{ $project->description ?? 'No description provided.' }}
                    </p>
                </div>
                <div class="flex flex-col items-start md:items-end gap-4">
                    <div class="flex items-center gap-2 text-outline font-bold text-xs uppercase tracking-widest">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        Deadline: <span
                            class="text-on-surface">{{ $project->deadline ? \date('M d, Y', \strtotime($project->deadline)) : 'Not set' }}</span>
                    </div>
                    <div class="flex gap-3">
                        <form action="{{ route('projects.archive', $project->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2"
                                onclick="return confirm('Archive this project?')">
                                <span class="material-symbols-outlined text-[20px]">archive</span>
                                Delete
                            </button>
                        </form>
                        <a href="{{ route('projects.edit', $project) }}"
                            class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                            Edit Project
                        </a>
                        <a href="{{ route('tasks.create', $project->id) }}"
                            class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            New Task
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Bar Card -->
            <div
                class="mt-10 p-8 bg-white border border-outline-variant rounded-2xl shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-bold text-on-surface uppercase tracking-wider">Overall Project Progress</span>
                    <span
                        class="text-xl font-black text-primary">{{ $project->tasks->count() > 0 ? round(($project->tasks->where('status', 'done')->count() / $project->tasks->count()) * 100) : 0 }}%</span>
                </div>
                <div class="w-full bg-surface-container-high rounded-full h-3">
                    <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out"
                        style="width: {{ $project->tasks->count() > 0 ? ($project->tasks->where('status', 'done')->count() / $project->tasks->count()) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
        </section>

        <!-- Two-Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Column: Tasks -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-on-surface">Open Tasks</h3>
                    <span
                        class="bg-primary/5 text-primary px-3 py-1 rounded-full text-xs font-bold">{{ $project->tasks->where('status', '!=', 'done')->count() }}
                        Remaining</span>
                </div>

                @forelse($project->tasks as $task)
                    <div
                        class="bg-white border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md hover:translate-x-1 transition-all group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="space-y-3">
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">
                                    {{ $task->title }}</a>
                                <div class="flex flex-wrap gap-2">
                                    @if ($task->priority)
                                        <span
                                            class="{{ $task->priority === 'high' ? 'bg-error/10 text-error' : ($task->priority === 'medium' ? 'bg-tertiary/10 text-tertiary' : 'bg-surface-container text-outline') }} px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">{{ $task->priority }}</span>
                                    @endif
                                </div>
                            </div>
                            <button class="text-outline hover:text-on-surface transition-colors p-1">
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="text-outline hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                            </button>
                        </div>
                        <div class="flex items-center justify-between border-t border-outline-variant/30 pt-4">
                            <div class="flex -space-x-2">
                                @if ($task->assignee)
                                    <img class="h-8 w-8 rounded-full border-2 border-white ring-1 ring-outline-variant"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name) }}"
                                        alt="{{ $task->assignee->name }}">
                                @else
                                    <div
                                        class="h-8 w-8 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">
                                        ?</div>
                                @endif
                            </div>
                            <div class="flex items-center gap-4">
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">{{ $task->status }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-outline-variant p-8 rounded-xl text-center">
                        <div
                            class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center text-outline mb-4 mx-auto">
                            <span class="material-symbols-outlined text-4xl">assignment</span>
                        </div>
                        <p class="text-on-surface font-bold">No tasks yet</p>
                        <p class="text-sm text-outline mt-2">Create your first task to get started.</p>
                    </div>
                @endforelse
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-8">
                <!-- Quick Summary Card -->
                <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm space-y-6">
                    <h3
                        class="text-sm font-bold text-on-surface uppercase tracking-widest border-b border-outline-variant pb-4">
                        Quick Summary</h3>
                    <div class="space-y-6">
                        <div>
                            <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Owner</div>
                            <div class="text-sm font-bold text-on-surface">{{ $project->owner->name ?? 'Unknown' }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Tasks</div>
                                <div class="text-2xl font-black text-on-surface">{{ $project->tasks->count() }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Done</div>
                                <div class="text-2xl font-black text-primary">
                                    {{ $project->tasks->where('status', 'done')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Project Members -->
                <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-bold text-on-surface uppercase tracking-widest">Team</h3>
                        <a href="{{ route('projects.members.index', $project) }}"
                            class="text-primary text-[10px] font-bold uppercase tracking-widest hover:underline">Manage</a>
                    </div>
                    <div class="space-y-5">
                        @forelse($project->members as $member)
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full border border-outline-variant shadow-sm group-hover:ring-2 group-hover:ring-primary/20 transition-all"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}"
                                        alt="{{ $member->name }}">
                                    <div>
                                        <div
                                            class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors">
                                            {{ $member->name }}</div>
                                        <div class="text-[10px] text-outline font-medium">
                                            {{ $member->pivot->role ?? 'Member' }}</div>
                                    </div>
                                </div>
                                <button class="text-outline hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">mail</span>
                                </button>
                            </div>
                        @empty
                            <p class="text-sm text-outline">No team members</p>
                        @endforelse
                    </div>
                    <a href="{{ route('team.index') }}">
                        <button
                            class="w-full mt-8 py-3 border-2 border-dashed border-outline-variant rounded-xl text-outline font-bold text-[10px] uppercase tracking-widest hover:border-primary hover:text-primary hover:bg-primary/5 transition-all flex items-center justify-center gap-2 group">
                            <span
                                class="material-symbols-outlined text-sm group-hover:rotate-90 transition-transform">person_add</span>
                            Invite Member
                        </button>
                    </a>
                </section>
            </div>
        </div>
    </div>
@endsection
