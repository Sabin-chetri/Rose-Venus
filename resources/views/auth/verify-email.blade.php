<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-[Playfair_Display] font-bold text-stone-900">Verify Email</h1>
        <p class="mt-1.5 text-sm text-stone-400">Almost there! Check your inbox</p>
    </div>

    <div class="mb-6 text-sm text-stone-500 leading-relaxed">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-stone-400 hover:text-stone-700 transition-colors underline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>