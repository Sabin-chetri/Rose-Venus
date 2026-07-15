<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-[Playfair_Display] font-bold text-stone-900">Forgot Password</h1>
        <p class="mt-1.5 text-sm text-stone-400">No worries, we'll send you a reset link</p>
    </div>

    <div class="mb-6 text-sm text-stone-500 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>

        <p class="mt-6 text-center text-sm text-stone-400">
            <a href="{{ route('login') }}" class="text-rose-600 hover:text-rose-700 font-medium transition-colors">Back to sign in</a>
        </p>
    </form>
</x-guest-layout>