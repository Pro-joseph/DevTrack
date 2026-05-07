@extends('layouts.app')

@section('title', 'Edit Project | DevTrack')
@section('page-title', 'Edit Project')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Edit Project</h1>
            <p class="text-sm text-on-surface-variant">Update project details and settings.</p>
        </div>
        <a href="{{ route('projects.show', $project) }}" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ route('projects.update', $project) }}" method="POST" class="p-8 space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-12 space-y-8">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Project Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., CRM System" type="text" value="{{ old('title', $project->title) }}" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Describe the project scope and goals..." rows="6">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ old('deadline', $project->deadline) }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                            <option value="planning" {{ $project->status == 'planning' ? 'selected' : '' }}>Planning</option>
                            <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="{{ route('projects.show', $project) }}" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                Cancel
            </a>
            <button class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 text-sm font-bold rounded-lg shadow-sm active:scale-95 transition-all flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Update Project
            </button>
        </div>
    </form>
</div>
@endsection