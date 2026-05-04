@extends('layouts.guest')

@section('title', 'Sign In | DevTrack')

@section('content')
<div class="w-full max-w-[480px] space-y-xl">
    <!-- Branding Header -->
    <div class="text-center space-y-sm">
        <div class="inline-flex items-center justify-center p-md bg-white rounded-xl shadow-sm border border-outline-variant mb-md">
            <span class="material-symbols-outlined text-primary text-[32px]">terminal</span>
        </div>
        <h1 class="text-3xl font-bold text-on-surface tracking-tight">DevTrack</h1>
        <p class="text-lg text-outline">Manage your development workflow with precision.</p>
    </div>

    <!-- Auth Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-xl md:p-[40px] transition-all hover:shadow-md">
        <form action="/login" method="POST" class="space-y-lg">
            @csrf
            <!-- Email Field -->
            <div class="space-y-xs">
                <label class="text-sm font-medium text-on-surface" for="email">Work Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-md flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                    <input class="w-full pl-[44px] pr-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60" 
                           id="email" name="email" placeholder="name@company.com" type="email" required />
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-xs">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-medium text-on-surface" for="password">Password</label>
                    <a class="text-xs font-semibold text-primary hover:underline transition-all" href="#">Forgot Password?</a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-md flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <input class="w-full pl-[44px] pr-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60" 
                           id="password" name="password" placeholder="••••••••" type="password" required />
                </div>
            </div>

            <!-- Sign In Button -->
            <button class="w-full py-md bg-primary hover:bg-primary-container text-white font-medium rounded-lg shadow-sm active:scale-[0.98] transition-all flex items-center justify-center gap-sm" type="submit">
                Sign In to Workspace
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>

            <!-- Divider -->
            <div class="relative flex items-center py-sm">
                <div class="flex-grow border-t border-outline-variant"></div>
                <span class="flex-shrink mx-md text-[10px] text-outline uppercase tracking-widest font-bold">or continue with</span>
                <div class="flex-grow border-t border-outline-variant"></div>
            </div>

            <!-- Social Logins -->
            <div class="grid grid-cols-2 gap-md">
                <button class="flex items-center justify-center gap-sm px-md py-md border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors text-sm font-medium text-on-surface" type="button">
                    <img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-tzYyTBvlwWpoKTiAKVMv7zs2I0Bp3dVAX5dfTxQhxQ_Q1mKHhfOkrmceRCOK4X58XhxnKAsmFIHfAUWa111S6N1m1coHZp0ZK3MpAZxN9dBiANpU76KmsPK2X8nRjWBe8go7MwYKjcXilf9WbGt1j_rH0kOwecZMKNblKSSAXNUzlcHI3HaWs_KRROhpaAZdNe5WQHWWuqVw2WpqxyFMnU0jj_MFta9s0RqjBCq_5gtEfJN-ElJtmm2w7F8LZfbbBc6tph57KuTf"/>
                    Google
                </button>
                <button class="flex items-center justify-center gap-sm px-md py-md border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors text-sm font-medium text-on-surface" type="button">
                    <span class="material-symbols-outlined text-[20px]">terminal</span>
                    GitHub
                </button>
            </div>
        </form>
    </div>

    <!-- Footer Link -->
    <p class="text-center text-sm text-outline">
        New to the platform? 
        <a class="text-primary font-bold hover:underline ml-xs" href="/register">Create an account</a>
    </p>
</div>
@endsection