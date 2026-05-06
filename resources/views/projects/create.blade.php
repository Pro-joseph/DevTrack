@extends('layouts.app')

@section('title', 'New Project | DevTrack')
@section('page-title', 'New Project')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Define Project</h1>
            <p class="text-sm text-on-surface-variant">Define project requirements and assign a team.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ route('projects.store') }}" method="POST" class="p-8 space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-7 space-y-8">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Project Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., CRM System" type="text" value="{{ old('title') }}" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Describe the project scope and goals..." rows="6">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ old('deadline') }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                            <option value="planning" {{ old('status', 'planning') == 'planning' ? 'selected' : '' }}>Planning</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Team Members</label>
                <div class="border border-outline-variant rounded-lg overflow-hidden bg-surface-container-lowest flex-1 flex flex-col">
                    <div class="p-3 bg-surface-container-low border-b border-outline-variant relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                        <input class="w-full pl-8 pr-4 py-1 text-xs bg-transparent border-none focus:ring-0" placeholder="Search members..." type="text"/>
                    </div>
                    <div class="flex-1 overflow-y-auto divide-y divide-outline-variant">
                        @forelse($users as $user)
                        <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="checkbox" name="members[]" value="{{ $user->id }}"/>
                            <img alt="{{ $user->name }}" class="w-10 h-10 rounded-full border border-outline-variant" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"/>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">{{ $user->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $user->email }}</p>
                            </div>
                        </label>
                        @empty
                        <p class="p-4 text-sm text-on-surface-variant">No users available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="{{ route('projects.index') }}" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                Cancel
            </a>
            <button class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 text-sm font-bold rounded-lg shadow-sm active:scale-95 transition-all flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Create Project
            </button>
        </div>
    </form>
</div>
@endsection