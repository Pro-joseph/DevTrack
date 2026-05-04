@extends('layouts.app')

@section('title', 'Projects | DevTrack')
@section('page-title', 'Projects')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-lg animate-in fade-in slide-in-from-left duration-500">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <h2 class="text-3xl font-bold text-on-surface">All Projects</h2>
            <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs rounded-full font-bold">4 Projects</span>
        </div>
        <p class="text-sm text-outline">View and manage all your development projects.</p>
    </div>
    <a href="/project/new" class="flex items-center justify-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all active:scale-95">
        <span class="material-symbols-outlined text-[20px]">add</span>
        New Project
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
    <a href="/project/1" class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
        
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-secondary-container/30 text-secondary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">database</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface group-hover:text-primary transition-colors">CloudScale Architecture</h3>
                    <p class="text-xs text-outline font-medium uppercase tracking-wider">Internal Infrastructure</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] rounded-md font-bold uppercase tracking-widest">On Track</span>
        </div>
        
        <p class="text-sm text-on-surface-variant mb-8 line-clamp-2 leading-relaxed">
            Rebuilding the core microservices architecture to support 10x concurrent user growth and implementing global load balancing across AWS regions.
        </p>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                <span class="text-on-surface/70">Development Progress</span>
                <span class="text-primary">12 / 20 Tasks</span>
            </div>
            <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full w-[60%] transition-all duration-1000"></div>
            </div>
            <div class="flex justify-between items-center pt-4">
                <div class="flex -space-x-3">
                    <img class="w-9 h-9 rounded-full border-2 border-white ring-1 ring-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3MISATok3194m2Y6Zjnhewuuvq01osxxTDakpdjXgqv5ih8ockBeP-ChptFv2akq9XneF-qnNJ5mHv5xBsI--LpI-SKFsbHa6XIAp9-ui9Fnt4KZURWq141TgP3w3zBEKuWl8-LiPi-eoeOYg65_Ix847Azu0JzgKrC15xLa7XFKXZb9XjDTH_qqgGXUV6meUH0pwpIIySZHG45LcJgFcIjxZtdf3sSdXJ8mwuUP4d9hk4YO1SVrQ3SkqGugbcDdoE5G0BGjoBXCV" alt="User">
                    <img class="w-9 h-9 rounded-full border-2 border-white ring-1 ring-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUxMmD4oioY6H4tHu4-ROvcklOaZ-lC0DojktiNIJSo4TsTdJPiVaAlN5JvGc_MCNVSoq3pq-PWfti-oFZItCd-NHBml-Hr96jOgIXwYpcPpwLydf2Ni2Xq4Qr_Q6dKnS2xmxuED3H-LXvY8H4hxt2MzitQvA9CiIIhUS--M6e_oqNU_Ab7zN1NmXLJvPAZUAGGXwumCj1Ty9mXmuouVZufqN-baCB1C7uIhpJengEXigSHZXashI1A6wUIV593LgkBZ-Hn9JaXQUq" alt="User">
                    <div class="w-9 h-9 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">+3</div>
                </div>
                <div class="flex items-center gap-1.5 text-error font-bold text-xs">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    Deadline: Oct 24
                </div>
            </div>
        </div>
    </a>

    <a href="/project/2" class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-tertiary-container/10 text-tertiary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">security</span>
            </div>
            <span class="px-2 py-1 bg-tertiary/10 text-tertiary text-[10px] rounded-md font-bold uppercase tracking-widest">Priority</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">Auth2.0 Migration</h3>
        <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">Updating identity providers and securing legacy API endpoints.</p>
        <div class="space-y-4">
            <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                <span class="text-outline">Tasks</span>
                <span class="text-on-surface">8 / 10</span>
            </div>
            <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                <div class="bg-tertiary h-full rounded-full w-[80%]"></div>
            </div>
            <div class="pt-4 flex items-center gap-1.5 text-outline font-bold text-xs">
                <span class="material-symbols-outlined text-sm">schedule</span>
                Due in 4 days
            </div>
        </div>
    </a>

    <a href="/project/3" class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">palette</span>
            </div>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">Design System</h3>
        <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">Standardizing component library for cross-platform apps.</p>
        <div class="space-y-4">
            <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                <span class="text-outline">Tasks</span>
                <span class="text-on-surface">15 / 45</span>
            </div>
            <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full w-[33%]"></div>
            </div>
            <div class="pt-4 flex items-center gap-1.5 text-outline font-bold text-xs">
                <span class="material-symbols-outlined text-sm">event</span>
                Nov 12, 2023
            </div>
        </div>
    </a>

    <a href="/project/4" class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-error/10 text-error rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-[28px]">code</span>
            </div>
            <span class="px-2 py-1 bg-error/10 text-error text-[10px] rounded-md font-bold uppercase tracking-widest">Blocked</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">CRM System</h3>
        <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">Enterprise-grade customer relationship management module.</p>
        <div class="space-y-4">
            <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                <span class="text-outline">Tasks</span>
                <span class="text-on-surface">16 / 24</span>
            </div>
            <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                <div class="bg-error h-full rounded-full w-[66%]"></div>
            </div>
            <div class="pt-4 flex items-center gap-1.5 text-outline font-bold text-xs">
                <span class="material-symbols-outlined text-sm">event</span>
                Oct 24, 2024
            </div>
        </div>
    </a>

    <a href="/project/new" class="border-2 border-dashed border-outline-variant rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-white hover:border-primary transition-all group cursor-pointer group">
        <div class="w-14 h-14 rounded-full bg-surface-container-low flex items-center justify-center text-outline group-hover:bg-primary/10 group-hover:text-primary mb-4 transition-all">
            <span class="material-symbols-outlined text-3xl">add_circle</span>
        </div>
        <p class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Initiate Project</p>
        <p class="text-xs text-outline px-4 mt-2 leading-relaxed">Start a new workflow and assign your core development team.</p>
    </a>
</div>
@endsection