<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:300,400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-[Inter] text-stone-800 antialiased">
        <div class="min-h-screen flex bg-gradient-to-br from-rose-50 via-white to-rose-100/60 relative overflow-hidden">
            {{-- Decorative Elements --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-gradient-to-br from-rose-200/40 to-rose-300/20 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-amber-200/30 to-rose-200/20 blur-3xl"></div>
                <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-r from-rose-100/10 via-rose-200/10 to-transparent blur-3xl"></div>
                <div class="absolute top-[20%] left-[10%] w-3 h-3 rounded-full bg-rose-300/40 animate-pulse" style="animation-duration: 4s;"></div>
                <div class="absolute top-[30%] right-[15%] w-5 h-5 rounded-full bg-amber-300/30 animate-pulse" style="animation-duration: 5s;"></div>
                <div class="absolute bottom-[30%] left-[15%] w-4 h-4 rounded-full bg-rose-400/20 animate-pulse" style="animation-duration: 6s;"></div>
            </div>

            <div class="relative w-full flex items-center justify-center px-4 py-12">
                <div class="w-full max-w-md">
                    {{-- Branding --}}
                    <div class="text-center mb-8">
                        <a href="/" class="inline-flex items-center gap-2 group">
                            <span class="text-3xl font-[Playfair_Display] font-bold tracking-tight text-rose-900">Rose</span>
                            <span class="text-3xl font-[Playfair_Display] font-light tracking-wider text-stone-700">Venus</span>
                        </a>
                        <p class="mt-2 text-sm text-stone-400 font-light">Timeless elegance meets modern beauty</p>
                    </div>

                    {{-- Card --}}
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl shadow-rose-900/10 border border-rose-100/50 px-8 py-8 sm:px-10 sm:py-10">
                        {{ $slot }}
                    </div>

                    {{-- Footer --}}
                    <p class="mt-8 text-center text-xs text-stone-400">&copy; {{ date('Y') }} Rose Venus. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
