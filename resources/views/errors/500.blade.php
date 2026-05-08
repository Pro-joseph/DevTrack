@extends('layouts.app')

@section('title', '500 | DevTrack')
@section('page-title', 'Server Error')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center space-y-6 animate-in fade-in zoom-in-95 duration-500">
        <div class="w-32 h-32 mx-auto bg-error/10 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-[80px] text-error">warning</span>
        </div>
        
        <div class="space-y-2">
            <h1 class="text-6xl font-black text-error">500</h1>
            <h2 class="text-2xl font-bold text-on-surface">Something Went Wrong</h2>
            <p class="text-outline text-sm max-w-md mx-auto">We're experiencing technical difficulties. Please try again later.</p>
        </div>
        
        <div class="flex items-center justify-center gap-4 pt-4">
            <a href="/" onclick="history.back(); return false;" class="px-6 py-3 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">arrow_back</span>
                Go Back
            </a>
            <a href="/" class="px-6 py-3 text-sm font-bold bg-primary text-white hover:bg-primary-container rounded-lg transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">home</span>
                Home
            </a>
        </div>
    </div>
</div>
@endsection
