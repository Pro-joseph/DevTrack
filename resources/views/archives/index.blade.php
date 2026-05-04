@extends('layouts.app')

@section('title', 'Archives | DevTrack')
@section('page-title', 'Archives')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-on-surface">Archived Projects</h2>
                <span class="px-2.5 py-0.5 bg-outline/10 text-outline text-xs rounded-full font-bold">3 Archived</span>
            </div>
            <p class="text-sm text-outline">Previously completed projects and tasks.</p>
        </div>
        <button class="flex items-center justify-center gap-2 bg-white border border-outline-variant text-on-surface px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined text-[20px]">download</span>
            Export Archive
        </button>
    </div>

    <!-- Archived Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $archived = [
                ['title' => 'Mobile App v1.0', 'description' => 'Initial mobile application release with core features.', 'completed' => 'Dec 15, 2023', 'team' => 4, 'tasks' => '32/32'],
                ['title' => 'API Gateway', 'description' => 'Centralized API gateway for all services.', 'completed' => 'Nov 28, 2023', 'team' => 3, 'tasks' => '18/18'],
                ['title' => 'Analytics Dashboard', 'description' => 'Real-time analytics and reporting module.', 'completed' => 'Oct 10, 2023', 'team' => 2, 'tasks' => '12/12'],
            ];
        @endphp

        @foreach($archived as $project)
        <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group opacity-75 hover:opacity-100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-surface-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px] text-outline">archive</span>
                </div>
                <span class="px-2 py-1 bg-surface-container text-outline text-[10px] rounded font-bold uppercase tracking-widest">Archived</span>
            </div>
            <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">{{ $project['title'] }}</h3>
            <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">{{ $project['description'] }}</p>
            <div class="space-y-3 pt-4 border-t border-outline-variant/50">
                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                    <span class="text-outline">Completed</span>
                    <span class="text-on-surface">{{ $project['completed'] }}</span>
                </div>
                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                    <span class="text-outline">Team</span>
                    <span class="text-on-surface">{{ $project['team'] }} members</span>
                </div>
                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                    <span class="text-outline">Tasks</span>
                    <span class="text-primary">{{ $project['tasks'] }}</span>
                </div>
            </div>
            <div class="flex gap-2 mt-4 pt-4 border-t border-outline-variant">
                <button class="flex-1 py-2 text-sm font-medium text-outline hover:text-primary hover:bg-surface-container rounded-lg transition-colors flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    View
                </button>
                <button class="flex-1 py-2 text-sm font-medium bg-surface-container text-on-surface rounded-lg hover:bg-surface-container-high transition-colors flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">restore</span>
                    Restore
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State (if no archives) -->
    <div class="text-center py-12">
        <div class="w-20 h-20 bg-surface-container mx-auto rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[40px] text-outline">inventory_2</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2">No archived items</h3>
        <p class="text-sm text-outline">Completed projects will appear here for your records.</p>
    </div>
</div>
@endsection