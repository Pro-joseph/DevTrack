@extends('layouts.app')

@section('title', 'Project Details | DevTrack')
@section('page-title', 'CRM System')

@section('content')
<div class="max-w-7xl mx-auto space-y-10 animate-in fade-in duration-700">
    <!-- Project Header -->
    <section>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                        Active
                    </span>
                    <span class="text-outline font-bold text-xs uppercase tracking-tighter tracking-widest">Project #829</span>
                </div>
                <h2 class="text-4xl font-black text-on-surface tracking-tight">CRM System</h2>
                <p class="text-on-surface-variant max-w-2xl text-base leading-relaxed">
                    Enterprise-grade customer relationship management module featuring real-time data synchronization and multi-tier permission controls.
                </p>
            </div>
            <div class="flex flex-col items-start md:items-end gap-4">
                <div class="flex items-center gap-2 text-outline font-bold text-xs uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    Deadline: <span class="text-on-surface">Oct 24, 2024</span>
                </div>
                <div class="flex gap-3">
                    <button class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                        Filter
                    </button>
                    <a href="/project/{{ $id ?? 1 }}/edit" class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                        Edit Project
                    </a>
                    <a href="/task/new" class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        New Task
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar Card -->
        <div class="mt-10 p-8 bg-white border border-outline-variant rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-bold text-on-surface uppercase tracking-wider">Overall Project Progress</span>
                <span class="text-xl font-black text-primary">68%</span>
            </div>
            <div class="w-full bg-surface-container-high rounded-full h-3">
                <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out" style="width: 68%"></div>
            </div>
        </div>
    </section>

    <!-- Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Left Column: Tasks -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-on-surface">Open Tasks</h3>
                <span class="bg-primary/5 text-primary px-3 py-1 rounded-full text-xs font-bold">3 Remaining</span>
            </div>

            <!-- Task Cards -->
            <div class="space-y-4">
                @php
                    $tasks = [
                        [
                            'title' => 'API Integration: Stripe',
                            'tags' => [['label' => 'Critical', 'color' => 'bg-error/10 text-error'], ['label' => 'Backend', 'color' => 'bg-surface-container text-outline']],
                            'progress' => 'In Progress',
                            'comments' => 12,
                        ],
                        [
                            'title' => 'Update README.md',
                            'tags' => [['label' => 'Docs', 'color' => 'bg-surface-container text-outline']],
                            'progress' => 'Pending',
                            'comments' => 2,
                        ],
                        [
                            'title' => 'Dashboard UI Refactor',
                            'tags' => [['label' => 'High', 'color' => 'bg-tertiary/10 text-tertiary'], ['label' => 'Frontend', 'color' => 'bg-surface-container text-outline']],
                            'progress' => 'In Progress',
                            'comments' => 8,
                        ],
                    ];
                @endphp

                @foreach($tasks as $task)
                <div class="bg-white border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md hover:translate-x-1 transition-all group cursor-pointer">
                    <div class="flex justify-between items-start mb-6">
                        <div class="space-y-3">
                            <h4 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">{{ $task['title'] }}</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($task['tags'] as $tag)
                                <span class="{{ $tag['color'] }} px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">{{ $tag['label'] }}</span>
                                @endforeach
                            </div>
                        </div>
                        <button class="text-outline hover:text-on-surface transition-colors p-1">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between border-t border-outline-variant/30 pt-4">
                        <div class="flex -space-x-2">
                            <img class="h-8 w-8 rounded-full border-2 border-white ring-1 ring-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBcyPXirYHVgJ2KsTr3ToY1S7A94TmLn83uzXhztl4yIcOC3e9CHtw8w42AQJMl3GqYxbHBI-dKME3AbLo_Q-fz9m9EScqINW0cR2bMb21W4-7X_EfOQFTOPdta8VTEbyLlcJ6Bg-ZKM248IbLUOr8uTf_4UdvllRL-NONNJAcpx6EOqNMJJeBIA-UzkkCKgQ-Q-JLV7688N2_NjqcdFgA4Txit7oqFrgb2uLkiK0i22AxWhCwXWRI3qrshOYxXCGszOkzWyJtVAsQu" alt="Assignee">
                            <div class="h-8 w-8 rounded-full border-2 border-white bg-primary/5 flex items-center justify-center text-[10px] font-bold text-primary ring-1 ring-outline-variant">+1</div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-bold text-outline flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">chat_bubble</span> {{ $task['comments'] }}
                            </span>
                            <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">{{ $task['progress'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-8">
            <!-- Quick Summary Card -->
            <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm space-y-6">
                <h3 class="text-sm font-bold text-on-surface uppercase tracking-widest border-b border-outline-variant pb-4">Quick Summary</h3>
                <div class="space-y-6">
                    <div>
                        <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Client</div>
                        <div class="text-sm font-bold text-on-surface">Nexus Global Corp</div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Tasks</div>
                            <div class="text-2xl font-black text-on-surface">24</div>
                        </div>
                        <div>
                            <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Done</div>
                            <div class="text-2xl font-black text-primary">16</div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-outline-variant/30">
                        <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Last Activity</div>
                        <div class="text-xs font-medium text-on-surface-variant leading-relaxed">Today, 2:45 PM by <span class="text-on-surface font-bold">Sarah J.</span></div>
                    </div>
                </div>
            </section>

            <!-- Project Members -->
            <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-on-surface uppercase tracking-widest">Team</h3>
                    <button class="text-primary text-[10px] font-bold uppercase tracking-widest hover:underline">Manage</button>
                </div>
                <div class="space-y-5">
                    @php
                        $team = [
                            ['name' => 'Alex Dev', 'role' => 'Lead Developer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_52dK_afz--YqBRZ_TfcjTF513Zk8v-q9mFsRTxR1eIDmi4knGOcGsYwpRi2kCe2frTBrXgE8RCtZFoKU5npNWyYjItk9bW-LiWnj2KmtxGKREonemlQ6a3_01vJ5aB4WHC58xiz5v1qtxI6J77GoJtVCBX9roaEN-R0R2CDmVfwNNgIOlMPWyLZCWSdpzwzGlGtOr_xAVnL2562pswPTlgJtfQGql7yHd_9wgmB0me7KXxcpaydP3VN7spUAkUVJ63JUSA8BEvz3'],
                            ['name' => 'Sarah Jenkins', 'role' => 'UX Designer', 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfaeZ8JEJxmWFFLnP12mVagn1SpGY9IaAw7LYduCIb-oESKF0Aj-_IkpbnlWSXHpDrsuUt-z7wmIG9Jk6Jm1HS-FchcZ2bv0Be44Q_0IgiZo7vECvpeay2BffMf9gwO4DW_Lw86pkD7VTDpUf65Sunohy6jdVPDrpTFv9gAsKLG7z5SvUv9tLVZBFIhxS1UySa0eAgjuDy0GpMGrTZ-6EOofBvKY1aOJ-l3UNrXk5bW_a0-eji6wQmX86XPiSDZraTazQV7BI_VNck'],
                        ];
                    @endphp

                    @foreach($team as $member)
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img class="w-10 h-10 rounded-full border border-outline-variant shadow-sm group-hover:ring-2 group-hover:ring-primary/20 transition-all" src="{{ $member['img'] }}" alt="Member">
                            <div>
                                <div class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors">{{ $member['name'] }}</div>
                                <div class="text-[10px] text-outline font-medium">{{ $member['role'] }}</div>
                            </div>
                        </div>
                        <button class="text-outline hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="w-full mt-8 py-3 border-2 border-dashed border-outline-variant rounded-xl text-outline font-bold text-[10px] uppercase tracking-widest hover:border-primary hover:text-primary hover:bg-primary/5 transition-all flex items-center justify-center gap-2 group">
                    <span class="material-symbols-outlined text-sm group-hover:rotate-90 transition-transform">person_add</span>
                    Invite Member
                </button>
            </section>
        </div>
    </div>
</div>
@endsection