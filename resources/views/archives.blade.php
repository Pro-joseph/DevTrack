@extends('layouts.app')

@section('title', 'Archives | DevTrack')
@section('page-title', 'Archives')

@section('content')
<div class="max-w-6xl mx-auto space-y-lg">
    <!-- Info Box: Automatic Cleanup -->
    <section class="bg-primary-container/10 border border-primary-container/20 rounded-xl p-md flex items-start gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <div class="bg-primary-container text-white p-2 rounded-lg">
            <span class="material-symbols-outlined">info</span>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-lg text-primary mb-1">Automatic Cleanup is active</h3>
            <p class="text-sm text-on-surface-variant">
                Archived projects are automatically moved to permanent deletion after 30 days. You can restore them at any time before the countdown ends.
            </p>
        </div>
        <button class="text-primary hover:bg-primary/5 px-3 py-1.5 rounded-lg transition-colors font-bold text-sm">
            Settings
        </button>
    </section>

    <!-- Archives Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        @php
            $archives = [
                ['name' => 'CloudSync 2.0', 'icon' => 'cloud_sync', 'icon_color' => 'text-primary', 'days' => 12, 'desc' => 'Enterprise cloud synchronization module for high-latency environments.'],
                ['name' => 'Alpha Portal', 'icon' => 'security', 'icon_color' => 'text-secondary', 'days' => 5, 'desc' => 'Legacy authentication gateway for internal staging environments.'],
                ['name' => 'Webhooks SDK', 'icon' => 'api', 'icon_color' => 'text-tertiary', 'days' => 28, 'desc' => 'Universal event listener package for third-party integrations.'],
            ];
        @endphp

        @foreach($archives as $item)
        <div class="bg-white border border-outline-variant rounded-xl p-md shadow-sm flex flex-col hover:shadow-md hover:translate-y-[-2px] transition-all duration-300 group">
            <div class="flex justify-between items-start mb-md">
                <div class="bg-surface-container p-2 rounded-lg group-hover:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined {{ $item['icon_color'] }}">{{ $item['icon'] }}</span>
                </div>
                <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                    {{ $item['days'] }} Days Left
                </span>
            </div>
            <h2 class="text-xl font-bold text-on-surface mb-xs">{{ $item['name'] }}</h2>
            <p class="text-sm text-on-surface-variant mb-xl flex-1">
                {{ $item['desc'] }}
            </p>
            <div class="flex items-center gap-sm mt-auto border-t border-gray-50 pt-md">
                <button class="flex-1 flex items-center justify-center gap-2 bg-primary/5 text-primary py-2 rounded-lg font-bold text-sm hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-lg">restore</span>
                    Restore
                </button>
                <button class="p-2 text-error hover:bg-error-container/50 rounded-lg transition-colors" title="Delete Permanently">
                    <span class="material-symbols-outlined">delete_forever</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State Suggestion -->
    <div class="bg-surface-container-lowest border border-dashed border-outline-variant rounded-xl p-xl flex flex-col items-center justify-center text-center opacity-80">
        <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center mb-md">
            <span class="material-symbols-outlined text-outline text-3xl">inventory_2</span>
        </div>
        <h3 class="text-lg font-bold text-on-surface">No other projects found</h3>
        <p class="text-sm text-on-surface-variant max-w-sm mt-2">
            You've reached the end of the archive. Only projects deleted within the last 30 days appear here.
        </p>
    </div>
</div>
@endsection