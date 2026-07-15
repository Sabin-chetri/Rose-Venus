<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-[Playfair_Display] font-bold text-stone-900">Welcome Back</h1>
        <p class="mt-1.5 text-sm text-stone-400">Sign in to continue your beauty journey</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                class="w-full px-4 py-3 border border-stone-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all duration-200 placeholder-stone-300"
                placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="mt-5">
            <label for="password" class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
            <div class="relative">
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-3 pr-11 border border-stone-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all duration-200 placeholder-stone-300"
                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                <div @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center justify-center w-10 cursor-pointer text-stone-400 hover:text-stone-600 transition-colors select-none">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="mt-5 space-y-3">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-stone-300 text-rose-600 focus:ring-rose-500 focus:ring-offset-0 cursor-pointer">
                <span class="text-sm text-stone-500 group-hover:text-stone-700 transition-colors">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="inline-block text-sm text-rose-600 hover:text-rose-700 font-medium transition-colors">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="mt-7 w-full px-8 py-4 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white text-sm font-medium tracking-wider uppercase rounded-xl transition-all duration-300 shadow-lg shadow-rose-900/25 hover:shadow-rose-900/40 hover:-translate-y-0.5">
            Sign In
        </button>

        <p class="mt-6 text-center text-sm text-stone-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-700 font-medium transition-colors">Create one</a>
        </p>
    </form>
</x-guest-layout>