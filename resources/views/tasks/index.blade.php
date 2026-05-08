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
                <div class="bg-white border border-outline-variant rounded-xl p-4 hover:shadow-md transition-all cursor-pointer flex items-center gap-4 task-row"
                     data-task-id="{{ $task->id }}"
                     data-task-title="{{ $task->title }}"
                     data-task-description="{{ $task->description ?? '' }}"
                     data-task-priority="{{ $task->priority }}"
                     data-task-status="{{ $task->status }}"
                     data-task-deadline="{{ $task->deadline ?? '' }}"
                     data-project-title="{{ $task->project->title ?? 'No Project' }}"
                      data-user-name="{{ $task->assignee->name ?? 'Unassigned' }}">

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
                        {{ $task->assignee->name ?? 'Unassigned' }}
                    </div>

                    @can('updateStatus', $task)
                    <form action="{{ route('tasks.updateStatus', [$task->project, $task]) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-outline-variant rounded px-2 py-1 bg-white cursor-pointer">
                            <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </form>
                    @endcan


                    @can('delete', $task)
                    <form action="{{ route('tasks.archive', [$task->project, $task]) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                        @csrf
                        <button type="submit" class="text-outline hover:text-primary p-2" onclick="return confirm('Archive this task?')">
                            <span class="material-symbols-outlined text-sm">archive</span>
                        </button>
                    </form>
                    <form action="{{ route('tasks.destroy', [$task->project, $task]) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-outline hover:text-error p-2" onclick="return confirm('Delete this task permanently?')">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                    @endcan

                    <button type="button" class="text-outline hover:text-primary p-2" onclick="event.stopPropagation()">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </button>
                </div>
            @empty
                <div class="text-center py-8 text-outline">
                    No tasks found. <a href="{{ isset($project) ? route('tasks.create', $project) : route('dashboard') }}" class="text-primary hover:underline">Create one</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="taskModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50" onclick="closeTaskModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 mx-4">
            <button type="button" onclick="closeTaskModal()" class="absolute top-4 right-4 text-outline hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>

            <h3 id="modalTitle" class="text-xl font-bold text-on-surface mb-4"></h3>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold uppercase text-outline">Description</label>
                    <p id="modalDescription" class="text-sm text-on-surface mt-1"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Project</label>
                        <p id="modalProject" class="text-sm text-on-surface mt-1"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Assigned To</label>
                        <p id="modalUser" class="text-sm text-on-surface mt-1"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Priority</label>
                        <p id="modalPriority" class="text-sm text-on-surface mt-1 capitalize"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Status</label>
                        <p id="modalStatus" class="text-sm text-on-surface mt-1 capitalize"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Deadline</label>
                        <p id="modalDeadline" class="text-sm text-on-surface mt-1"></p>
                    </div>
</div>
                </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.task-row').forEach(row => {
            row.addEventListener('click', function() {
                const modal = document.getElementById('taskModal');
                document.getElementById('modalTitle').textContent = this.dataset.taskTitle;
                document.getElementById('modalDescription').textContent = this.dataset.taskDescription || 'No description';
                document.getElementById('modalProject').textContent = this.dataset.projectTitle;
                document.getElementById('modalUser').textContent = this.dataset.userName;
                document.getElementById('modalPriority').textContent = this.dataset.taskPriority;
                document.getElementById('modalStatus').textContent = this.dataset.taskStatus.replace('_', ' ');
                
                if (this.dataset.taskDeadline) {
                    const date = new Date(this.dataset.taskDeadline);
                    document.getElementById('modalDeadline').textContent = date.toLocaleDateString();
                } else {
                    document.getElementById('modalDeadline').textContent = 'No deadline';
                }

                
                
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            });
        });

        function closeTaskModal() {
            const modal = document.getElementById('taskModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    </script>
@endsection