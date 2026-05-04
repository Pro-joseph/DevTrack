@extends('layouts.app')

@section('title', 'Tasks | DevTrack')
@section('page-title', 'Tasks')

@section('content')
<div class="space-y-6 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-on-surface">My Tasks</h2>
            <p class="text-sm text-outline mt-1">You have 12 tasks across all projects</p>
        </div>
        <a href="/task/new" class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-primary-container transition-all">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Task
        </a>
    </div>

    <!-- Task Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white border border-outline-variant rounded-xl p-4">
            <div class="text-2xl font-black text-primary">12</div>
            <div class="text-xs text-outline font-bold uppercase tracking-wider">Total</div>
        </div>
        <div class="bg-white border border-outline-variant rounded-xl p-4">
            <div class="text-2xl font-black text-on-surface">5</div>
            <div class="text-xs text-outline font-bold uppercase tracking-wider">To Do</div>
        </div>
        <div class="bg-white border border-outline-variant rounded-xl p-4">
            <div class="text-2xl font-black text-primary">4</div>
            <div class="text-xs text-outline font-bold uppercase tracking-wider">In Progress</div>
        </div>
        <div class="bg-white border border-outline-variant rounded-xl p-4">
            <div class="text-2xl font-black text-secondary">3</div>
            <div class="text-xs text-outline font-bold uppercase tracking-wider">Done</div>
        </div>
    </div>

    <!-- Task List -->
    <div class="space-y-3">
        @php
            $tasks = [
                ['title' => 'API Integration: Stripe', 'project' => 'CloudScale Architecture', 'priority' => 'Critical', 'status' => 'in_progress', 'assignee' => 'Alex Dev'],
                ['title' => 'Update README.md', 'project' => 'Auth2.0 Migration', 'priority' => 'low', 'status' => 'todo', 'assignee' => 'Sarah J.'],
                ['title' => 'Dashboard UI Refactor', 'project' => 'Design System', 'priority' => 'high', 'status' => 'in_progress', 'assignee' => 'Jane S.'],
                ['title' => 'Setup CI/CD Pipeline', 'project' => 'CloudScale Architecture', 'priority' => 'medium', 'status' => 'done', 'assignee' => 'Marcus K.'],
                ['title' => 'Database Migration', 'project' => 'CRM System', 'priority' => 'high', 'status' => 'in_progress', 'assignee' => 'Marcus K.'],
                ['title' => 'Fix Login Bug', 'project' => 'Auth2.0 Migration', 'priority' => 'critical', 'status' => 'done', 'assignee' => 'Alex Dev'],
            ];
        @endphp

        @foreach($tasks as $task)
        <div class="bg-white border border-outline-variant rounded-xl p-4 hover:shadow-md transition-all cursor-pointer flex items-center gap-4">
            <input type="checkbox" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary">
            
            <div class="flex-1 min-w-0">
                <h4 class="font-bold text-on-surface truncate">{{ $task['title'] }}</h4>
                <p class="text-xs text-outline truncate">{{ $task['project'] }}</p>
            </div>
            
            <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded
                {{ $task['priority'] === 'critical' ? 'bg-error/10 text-error' : ($task['priority'] === 'high' ? 'bg-tertiary/10 text-tertiary' : ($task['priority'] === 'medium' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline')) }}">
                {{ $task['priority'] }}
            </span>
            
            <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded whitespace-nowrap
                {{ $task['status'] === 'done' ? 'bg-secondary/10 text-secondary' : ($task['status'] === 'in_progress' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline') }}">
                {{ str_replace('_', ' ', $task['status']) }}
            </span>
            
            <div class="flex items-center gap-2 text-xs text-outline">
                <span class="material-symbols-outlined text-sm">person</span>
                {{ $task['assignee'] }}
            </div>
            
            <a href="/task/{{ $loop->iteration }}/edit" class="text-outline hover:text-primary p-2">
                <span class="material-symbols-outlined text-sm">edit</span>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection