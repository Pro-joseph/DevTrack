@extends('layouts.app')

@php
$isEdit = isset($project) && $project;
@endphp

@section('title', $isEdit ? 'Edit Project | DevTrack' : 'New Project | DevTrack')
@section('page-title', $isEdit ? 'Edit Project' : 'New Project')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">{{ $isEdit ? 'Edit Project' : 'Define Project' }}</h1>
            <p class="text-sm text-on-surface-variant">{{ $isEdit ? 'Update project details and settings.' : 'Define project requirements and assign a team.' }}</p>
        </div>
        <a href="/projects" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="{{ $isEdit ? '/project/'.$project->id : '/project/new' }}" method="POST" class="p-8 space-y-8">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-7 space-y-8">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Project Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., CRM System" type="text" value="{{ $isEdit ? $project->title : '' }}" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Describe the project scope and goals..." rows="6">{{ $isEdit ? $project->description : '' }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="{{ $isEdit ? $project->deadline : '' }}"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                            <option value="planning">Planning</option>
                            <option value="active" {{ $isEdit && $project->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="on_hold">On Hold</option>
                            <option value="completed">Completed</option>
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
                        @php
                            $team = [
                                ['id' => 1, 'name' => 'Alex Dev', 'role' => 'Lead Developer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_52dK_afz--YqBRZ_TfcjTF513Zk8v-q9mFsRTxR1eIDmi4knGOcGsYwpRi2kCe2frTBrXgE8RCtZFoKU5npNWyYjItk9bW-LiWnj2KmtxGKREonemlQ6a3_01vJ5aB4WHC58xiz5v1qtxI6J77GoJtVCBX9roaEN-R0R2CDmVfwNNgIOlMPWyLZCWSdpzwzGlGtOr_xAVnL2562pswPTlgJtfQGql7yHd_9wgmB0me7KXxcpaydP3VN7spUAkUVJ63JUSA8BEvz3'],
                                ['id' => 2, 'name' => 'Sarah Jenkins', 'role' => 'UX Designer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfaeZ8JEJxmWFFLnP12mVagn1SpGY9IaAw7LYduCIb-oESKF0Aj-_IkpbnlWSXHpDrsuUt-z7wmIG9Jk6Jm1HS-FchcZ2bv0Be44Q_0IgiZo7vECvpeay2BffMf9gwO4DW_Lw86pkD7VTDpUf65Sunohy6jdVPDrpTFv9gAsKLG7z5SvUv9tLVZBFIhxS1UySa0eAgjuDy0GpMGrTZ-6EOofBvKY1aOJ-l3UNrXk5bW_a0-eji6wQmX86XPiSDZraTazQV7BI_VNck'],
                                ['id' => 3, 'name' => 'Marcus Kim', 'role' => 'Backend Engineer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBkh3sexpxTbIUU-zOnGyVOqB6w208Ln7sQr_nAybLWC1jH2ONJpfUKIDurepaEDi0BeBwoGW27VU5DtZAU1S2ZDnR0QA2PF0NyYwH-nnDmVtWH_Vg8bnyuNmKQ_GKI8U7-JeRWAvNYWsJbIlrVeEvfSEn4tRVUScv7ZyiainQ6PRBSBT5nM3Yg01FZLrTFZXcW5rxo9pjtTKecrkJPuiqNZEOaqwU3Dy8tCaUSbLMtlKyEsmZt6G_sc7Ekl-veLW96AOoil1Go0DCM'],
                            ];
                        @endphp
                        
                        @foreach($team as $member)
                        <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="checkbox" name="members[]" value="{{ $member['id'] }}"/>
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

        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="/projects" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                Cancel
            </a>
            <button class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 text-sm font-bold rounded-lg shadow-sm active:scale-95 transition-all flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-[18px]">save</span>
                {{ $isEdit ? 'Update Project' : 'Create Project' }}
            </button>
        </div>
    </form>
</div>
@endsection