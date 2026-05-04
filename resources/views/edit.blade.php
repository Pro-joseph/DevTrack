@extends('layouts.app')

@php
$isEdit = isset($task) && $task;
$formAction = $isEdit ? '/task/' . $task->id : '/task/new';
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
        <a href="/projects" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ $formAction }}" method="POST" class="p-8 space-y-8">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
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
                        <option value="1" {{ $isEdit && $task->project_id == 1 ? 'selected' : '' }}>CloudScale Architecture</option>
                        <option value="2" {{ $isEdit && $task->project_id == 2 ? 'selected' : '' }}>Auth2.0 Migration</option>
                        <option value="3" {{ $isEdit && $task->project_id == 3 ? 'selected' : '' }}>Design System</option>
                        <option value="4" {{ $isEdit && $task->project_id == 4 ? 'selected' : '' }}>CRM System</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Task Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., Implement Authentication Flow" type="text" value="{{ $isEdit ? $task->title : '' }}" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Detail the technical requirements and scope..." rows="6">{{ $isEdit ? $task->description : '' }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ $isEdit ? $task->deadline : '' }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="priority">Priority</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="priority" name="priority">
                            <option value="low" {{ $isEdit && $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $isEdit && $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
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
                        @php
                            $team = [
                                ['id' => 1, 'name' => 'Jane Smith', 'role' => 'Frontend Lead', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCyB6aLDWb6LdTXNd1B8OrgRrHUU-plU5NU687gWaU0A0uVekIl7pjleup5y_ZHTem6I1xwp7Oh21BJtExq-jB0Wi5T6aCtuqU1b3fjK6WO5d7OUduzV9cOu3WGL6q6HGWNtse4ISrf8FB5Vs3WMHRSVqTmX1R_Y3x17fmO9fNoR8WDtpRXa_814AGvifqhA7ij70JhiHiNfWQYwr8eyH-YSYV_4DgCKFCi3fV3E6jiAWiKsHLAwj1o_Uk0Za_gy8m5DbobYN6yQMZR'],
                                ['id' => 2, 'name' => 'Marcus Kim', 'role' => 'Backend Engineer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBkh3sexpxTbIUU-zOnGyVOqB6w208Ln7sQr_nAybLWC1jH2ONJpfUKIDurepaEDi0BeBwoGW27VU5DtZAU1S2ZDnR0QA2PF0NyYwH-nnDmVtWH_Vg8bnyuNmKQ_GKI8U7-JeRWAvNYWsJbIlrVeEvfSEn4tRVUScv7ZyiainQ6PRBSBT5nM3Yg01FZLrTFZXcW5rxo9pjtTKecrkJPuiqNZEOaqwU3Dy8tCaUSbLMtlKyEsmZt6G_sc7Ekl-veLW96AOoil1Go0DCM'],
                                ['id' => 3, 'name' => 'Sarah Rose', 'role' => 'UX Designer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2M0bf1YPAOl-b6qbxgyQww8z25yTHTobwfFychGn6aOW08liZZ-3nF4u8j6D9LgQAujNDKrsWdC_LmRvX0Kadstcf0VMaT0BGG5jcZdaTvpXsLw5I1CIP-y_1GC7IchFzfxdms6CL50sncZlC9Nf4kTqRbGBoS27-LouiDa_XCq_0QMomXNCF2JZzMto4T51z93YGODJfFokff-I89Qw8dmwA6Tu0dRBWEvSVmVeAu5eNS0zdxWIrOrkVHyEuJcqFkyXvPGH6YiT_'],
                            ];
                        @endphp
                        
                        @foreach($team as $member)
                        <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="radio" name="assigned_to" value="{{ $member['id'] }}" {{ $isEdit && $task->assigned_to == $member['id'] ? 'checked' : '' }}/>
                            <img alt="{{ $member['name'] }}" class="w-10 h-10 rounded-full border border-outline-variant" src="{{ $member['img'] }}"/>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">{{ $member['name'] }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $member['role'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="/projects" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
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