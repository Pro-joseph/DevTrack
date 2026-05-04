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
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/app.css">

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
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "0.25rem",
                        "sm": "0.5rem",
                        "md": "1rem",
                        "lg": "1.5rem",
                        "xl": "2rem",
                        "gutter": "1rem",
                        "margin-mobile": "1rem",
                        "margin-desktop": "2.5rem"
                    },
                    "fontFamily": {
                        "sans": ["Inter", "sans-serif"],
                        "h1": ["Inter", "sans-serif"],
                        "h2": ["Inter", "sans-serif"],
                        "h3": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="font-sans text-on-background min-h-screen flex flex-col bg-background selection:bg-primary-container selection:text-white">
    
    <!-- Background Ornaments -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-[10%] w-64 h-64 bg-primary/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-40 right-[15%] w-96 h-96 bg-secondary/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <main class="flex-grow flex items-center justify-center p-margin-mobile md:p-margin-desktop">
        @yield('content')
    </main>

    <!-- Footer Ornament -->
    <footer class="p-xl opacity-30 pointer-events-none overflow-hidden h-32 relative mt-auto">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-64 bg-gradient-to-t from-primary/10 to-transparent rounded-full blur-3xl"></div>
    </footer>

    @stack('scripts')
</body>
</html>
