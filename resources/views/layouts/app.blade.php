<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale() ?? 'en') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevTrack')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/build/assets/app-D05hqmaw.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#3525cd",
                        "primary-container": "#4f46e5",
                        "on-primary": "#ffffff",
                        "secondary": "#006c49",
                        "secondary-container": "#6cf8bb",
                        "on-secondary": "#ffffff",
                        "tertiary": "#7e3000",
                        "tertiary-container": "#a44100",
                        "on-tertiary": "#ffffff",
                        "surface": "#f9f9ff",
                        "on-surface": "#151c27",
                        "background": "#f9f9ff",
                        "on-background": "#151c27",
                        "outline": "#777587",
                        "outline-variant": "#c7c4d8",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "surface-container": "#e7eefe",
                        "surface-container-high": "#e2e8f8",
                        "surface-container-highest": "#dce2f3",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="bg-background text-on-surface min-h-screen flex font-sans">
    
    <!-- Navigation Drawer (Sidebar) - Fixed -->
    <aside class="hidden md:flex flex-col fixed top-0 left-0 h-screen w-64 p-4 gap-2 bg-white border-r border-outline-variant font-sans text-sm font-medium z-50">
        <div class="flex items-center gap-3 mb-8 px-2">
            <span class="material-symbols-outlined text-primary text-2xl">terminal</span>
            <span class="text-primary font-black text-xl tracking-tight">DevTrack</span>
        </div>

        <div class="flex items-center gap-3 px-2 py-4 mb-4 bg-surface-container-low rounded-xl">
            @auth
            @php $user = auth()->user(); @endphp
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                 alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
            <div>
                <div class="text-on-surface font-bold text-sm">{{ $user->name }}</div>
                <div class="text-outline text-xs">{{ $user->email }}</div>
            </div>
            @endauth
        </div>

        @auth
<nav class="flex-1 space-y-1 overflow-y-auto">
            @php
                $navLinks = [
                    ['href' => '/dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                    ['href' => '/projects', 'icon' => 'folder_open', 'label' => 'Projects'],
                    ['href' => '/tasks', 'icon' => 'checklist', 'label' => 'Tasks'],
                    ['href' => '/team', 'icon' => 'group', 'label' => 'Team'],
                    ['href' => '/archives', 'icon' => 'inventory_2', 'label' => 'Archives'],
                ];
            @endphp

            @foreach($navLinks as $link)
                @php
                    $isActive = request()->is(trim($link['href'], '/')) || (request()->is(trim($link['href'], '/') . '/*'));
                @endphp
                <a href="{{ $link['href'] }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all transform {{ $isActive ? 'bg-primary text-white shadow-sm' : 'text-outline hover:bg-surface-container hover:text-primary hover:translate-x-1' }}">
                    <span class="material-symbols-outlined text-xl">{{ $link['icon'] }}</span>
                    <span class="font-bold">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="pt-4 border-t border-outline-variant space-y-1">
            <a href="/settings" class="flex items-center gap-3 px-3 py-2.5 text-outline hover:bg-surface-container hover:text-primary rounded-lg transition-all transform hover:translate-x-1">
                <span class="material-symbols-outlined text-xl">settings</span>
                <span class="font-bold">Settings</span>
            </a>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-error hover:bg-error-container/20 rounded-lg transition-all transform hover:translate-x-1">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    <span class="font-bold">Sign Out</span>
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden md:ml-64">
        <!-- Top Bar - Fixed -->
        <header class="sticky top-0 z-40 flex justify-between items-center w-full px-6 h-16 bg-white border-b border-outline-variant shadow-sm">
            <div class="flex items-center gap-4">
                <button class="md:hidden p-2 hover:bg-surface-container transition-colors rounded-full">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="text-xl font-bold tracking-tight text-on-surface">@yield('page-title')</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden md:flex bg-surface-container-low rounded-full px-4 py-2 items-center gap-2 border border-outline-variant focus-within:border-primary transition-all">
                    <span class="material-symbols-outlined text-outline text-lg">search</span>
                    <input type="text" placeholder="Search..." class="bg-transparent border-none focus:ring-0 text-sm w-64 outline-none">
                </div>
                <button class="p-2 text-outline hover:text-primary relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                </button>
                @auth
                @php $user = auth()->user(); @endphp
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                     alt="{{ $user->name }}" class="w-8 h-8 rounded-full border border-outline-variant object-cover">
                @endauth
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-10 bg-surface">
            @if(session('success'))
                <div class="mb-4 p-4 bg-secondary/10 text-secondary rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-error/10 text-error rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">error</span>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 bg-error/10 text-error rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- Mobile Nav -->
        <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 py-3 pb-safe bg-white/80 backdrop-blur-md border-t border-outline-variant">
            <a href="/dashboard" class="flex flex-col items-center gap-1 text-outline hover:text-primary transition-all {{ request()->is('dashboard') ? 'text-primary' : '' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-[10px] font-bold">Dash</span>
            </a>
            <a href="/projects" class="flex flex-col items-center gap-1 text-outline hover:text-primary transition-all {{ request()->is('projects*') || request()->is('project*') ? 'text-primary' : '' }}">
                <span class="material-symbols-outlined">folder</span>
                <span class="text-[10px] font-bold">Proj</span>
            </a>
            <a href="/tasks" class="flex flex-col items-center gap-1 text-outline hover:text-primary transition-all {{ request()->is('tasks') ? 'text-primary' : '' }}">
                <span class="material-symbols-outlined">checklist</span>
                <span class="text-[10px] font-bold">Tasks</span>
            </a>
            <a href="/project/new" class="flex flex-col items-center gap-1 text-primary hover:text-primary transition-all">
                <span class="material-symbols-outlined">add_circle</span>
                <span class="text-[10px] font-bold">New</span>
            </a>
            <a href="/archives" class="flex flex-col items-center gap-1 text-outline hover:text-primary transition-all {{ request()->is('archives') ? 'text-primary' : '' }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-[10px] font-bold">Arch</span>
            </a>
        </nav>
    </div>

    @stack('scripts')
</body>
</html>
