@extends('layouts.guest')

@section('title', 'Create Account | DevTrack')

@section('content')
<div class="w-full max-w-[480px] space-y-xl">
    <!-- Branding Header -->
    <div class="text-center space-y-sm">
        <div class="inline-flex items-center justify-center p-md bg-white rounded-xl shadow-sm border border-outline-variant mb-md">
            <span class="material-symbols-outlined text-primary text-[32px]">terminal</span>
        </div>
        <h1 class="text-3xl font-bold text-on-surface tracking-tight">DevTrack</h1>
        <p class="text-lg text-outline">Manage your development lifecycle efficiently.</p>
    </div>

    <!-- Auth Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-xl md:p-[40px] transition-all hover:shadow-md">
        <div class="mb-lg">
            <h2 class="text-2xl font-bold text-on-surface">Create your account</h2>
            <p class="text-sm text-outline mt-xs">Join thousands of developers worldwide.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-md">
            @csrf

            @if($errors->any())
            <div class="bg-error-container/50 border border-error/20 text-on-error-container px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">error</span>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <!-- Full Name -->
            <div class="space-y-xs">
                <label class="text-sm font-medium text-on-surface block" for="full_name">Full Name</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-md flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                    <input class="w-full pl-[44px] pr-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60 @error('name') border-error focus:ring-error @enderror" 
                           id="full_name" name="name" placeholder="Alex Dev" type="text" required value="{{ old('name') }}" />
                </div>
            </div>

            <!-- Email Address -->
            <div class="space-y-xs">
                <label class="text-sm font-medium text-on-surface block" for="email">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-md flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                    <input class="w-full pl-[44px] pr-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60 @error('email') border-error focus:ring-error @enderror" 
                           id="email" name="email" placeholder="alex@devtrack.com" type="email" required value="{{ old('email') }}" />
                </div>
            </div>

            <!-- Password Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label class="text-sm font-medium text-on-surface block" for="password">Password</label>
                    <input class="w-full px-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60 @error('password') border-error focus:ring-error @enderror" 
                           id="password" name="password" placeholder="••••••••" type="password" required />
                </div>
                <div class="space-y-xs">
                    <label class="text-sm font-medium text-on-surface block" for="confirm_password">Confirm Password</label>
                    <input class="w-full px-md py-md bg-white border border-outline-variant rounded-lg text-sm text-on-surface focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all placeholder:text-outline/60" 
                           id="confirm_password" name="password_confirmation" placeholder="••••••••" type="password" required />
                </div>
            </div>

            <!-- Terms -->
            <div class="flex items-start gap-sm py-xs">
                <input class="mt-1 h-4 w-4 rounded border-outline text-primary focus:ring-primary" id="terms" type="checkbox" required />
                <label class="text-sm text-on-surface-variant" for="terms">
                    I agree to the <a class="text-primary font-bold hover:underline" href="#">Terms of Service</a> and <a class="text-primary font-bold hover:underline" href="#">Privacy Policy</a>.
                </label>
            </div>

            <!-- Submit Button -->
            <button class="w-full bg-primary text-white font-medium py-md px-md rounded-lg shadow-sm hover:bg-primary-container active:scale-[0.98] transition-all flex items-center justify-center gap-sm" type="submit">
                Create Account
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </form>

        <div class="relative my-xl">
            <div class="absolute inset-0 flex items-center">
                <span class="w-full border-t border-outline-variant"></span>
            </div>
            <div class="relative flex justify-center text-[10px] uppercase">
                <span class="bg-surface-container-lowest px-md text-outline font-bold tracking-wider">Or continue with</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-md">
            <button class="flex items-center justify-center gap-sm px-md py-md border border-outline-variant rounded-lg text-sm font-medium text-on-surface hover:bg-surface-container-low transition-colors">
                <img alt="" class="w-4 h-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtNQmcog9pmMlR19aL0fegd-vPhHFWsqe4t9Wsu9_rAzQa21Co-yMH-j4WHv5KIjKn67zxaCcPH97_IoSWCGj95qEY-0qIOmD27lySKqM2wpsunJkb24gqN75j7NPVgLT2K7nRnADN0NgLMLN3ma2iL-tDgRbNfc8c_itMSvonPMR2WwmJaEk1N4mjo16pCw91e4q2h5pnOyW6_yo5HYV-vg5u77a7DhPbtVdgl5DyarqzdqT-P0YFtNMINsdrCh2pcQyPq8IcuM3P"/>
                Google
            </button>
            <button class="flex items-center justify-center gap-sm px-md py-md border border-outline-variant rounded-lg text-sm font-medium text-on-surface hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-[20px]">terminal</span>
                GitHub
            </button>
        </div>
    </div>

    <p class="text-center text-sm text-on-surface-variant">
        Already have an account? 
        <a class="text-primary font-bold hover:underline" href="/login">Log in</a>
    </p>
</div>
@endsection

@push('styles')
<style>
    /* Footer for Register might be slightly different or handled by layout */
</style>
@endpush