<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rose Venus — Timeless Beauty</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:300,400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-[Inter] antialiased bg-white text-stone-800 overflow-x-hidden">

    {{-- NAV --}}
    <nav x-data="{ mobileOpen: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)" class="fixed top-0 inset-x-0 z-50 transition-all duration-500" :class="scrolled ? 'bg-white/90 backdrop-blur-xl shadow-sm' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 lg:h-24">
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-2xl lg:text-3xl font-[Playfair_Display] font-bold tracking-tight text-rose-900">Rose</span>
                    <span class="text-2xl lg:text-3xl font-[Playfair_Display] font-light tracking-wider text-stone-700">Venus</span>
                </a>
                <div class="hidden lg:flex items-center gap-10">
                    <a href="#collections" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Collections</a>
                    <a href="#about" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Our Story</a>
                    <a href="#featured" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Featured</a>
                    <a href="#contact" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <div class="hidden lg:flex items-center gap-3">
                                <a href="{{ route('shop.index') }}" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Shop</a>
                                @if (Auth::user()->isAdmin() || Auth::user()->isStaff())
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Admin</a>
                                @endif
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center gap-2 px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white text-sm font-medium rounded-full transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                                            <span>{{ Auth::user()->name }}</span>
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="hidden lg:inline-flex text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700 transition-colors duration-300">Sign In</a>
                            <a href="{{ route('register') }}" class="hidden lg:inline-flex items-center gap-2 px-6 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm tracking-wider uppercase rounded-full transition-all duration-300 shadow-lg shadow-rose-900/20 hover:shadow-rose-900/30">
                                Get Started
                            </a>
                        @endauth
                    @endif
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden relative w-8 h-8 flex items-center justify-center">
                        <span class="block w-5 h-0.5 bg-stone-700 rounded-full transition-all duration-300" :class="mobileOpen ? 'rotate-45 translate-y-0.5' : '-translate-y-1'"></span>
                        <span class="block w-5 h-0.5 bg-stone-700 rounded-full transition-all duration-300" :class="mobileOpen ? 'opacity-0' : ''"></span>
                        <span class="block w-5 h-0.5 bg-stone-700 rounded-full transition-all duration-300" :class="mobileOpen ? '-rotate-45 -translate-y-0.5' : 'translate-y-1'"></span>
                    </button>
                </div>
            </div>
        </div>
        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" @click.outside="mobileOpen = false" class="lg:hidden bg-white/95 backdrop-blur-xl border-t border-stone-100 shadow-xl">
            <div class="px-6 py-8 space-y-6">
                <a @click="mobileOpen = false" href="#collections" class="block text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700">Collections</a>
                <a @click="mobileOpen = false" href="#about" class="block text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700">Our Story</a>
                <a @click="mobileOpen = false" href="#featured" class="block text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700">Featured</a>
                <a @click="mobileOpen = false" href="#contact" class="block text-sm tracking-widest uppercase text-stone-600 hover:text-rose-700">Contact</a>
                <div class="pt-4 border-t border-stone-100">
                    @if (Route::has('login'))
                        @auth
                            <p class="text-sm font-medium text-stone-900 mb-3">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-stone-400 mb-4">{{ Auth::user()->email }}</p>
                            <a href="{{ route('shop.index') }}" @click="mobileOpen = false" class="block w-full text-center px-6 py-3 bg-stone-900 text-white text-sm tracking-wider uppercase rounded-full mb-2">Shop</a>
                            @if (Auth::user()->isAdmin() || Auth::user()->isStaff())
                                <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false" class="block w-full text-center px-6 py-3 bg-rose-800 text-white text-sm tracking-wider uppercase rounded-full mb-2">Admin</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" class="block w-full text-center px-6 py-3 border border-stone-200 text-stone-700 text-sm tracking-wider uppercase rounded-full mb-2">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-center px-6 py-3 border border-stone-200 text-stone-700 text-sm tracking-wider uppercase rounded-full">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 border border-stone-200 text-stone-700 text-sm tracking-wider uppercase rounded-full mb-3">Sign In</a>
                            <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 bg-rose-800 text-white text-sm tracking-wider uppercase rounded-full">Get Started</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-rose-50 via-white to-rose-100/60 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-gradient-to-br from-rose-200/40 to-rose-300/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-amber-200/30 to-rose-200/20 blur-3xl"></div>
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-r from-rose-100/10 via-rose-200/10 to-transparent blur-3xl"></div>
        </div>

        {{-- Floating decorative circles --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[15%] left-[8%] w-3 h-3 rounded-full bg-rose-300/40 animate-pulse" style="animation-duration: 4s;"></div>
            <div class="absolute top-[25%] right-[12%] w-5 h-5 rounded-full bg-amber-300/30 animate-pulse" style="animation-duration: 5s;"></div>
            <div class="absolute bottom-[30%] left-[15%] w-4 h-4 rounded-full bg-rose-400/20 animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-[20%] right-[8%] w-6 h-6 rounded-full bg-pink-300/25 animate-pulse" style="animation-duration: 4.5s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-20 lg:pt-40 lg:pb-32">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="space-y-8 lg:space-y-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/70 backdrop-blur-sm rounded-full border border-rose-200/50 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        <span class="text-xs tracking-widest uppercase text-rose-700 font-medium">New Spring Collection 2026</span>
                    </div>

                    <h1 class="font-[Playfair_Display] text-5xl sm:text-6xl lg:text-7xl xl:text-8xl leading-[1.1] tracking-tight text-stone-900">
                        <span class="block">Timeless</span>
                        <span class="block bg-gradient-to-r from-rose-800 via-rose-600 to-rose-700 bg-clip-text text-transparent">Elegance</span>
                        <span class="block text-3xl sm:text-4xl lg:text-5xl font-light text-stone-500 mt-2">meets modern beauty</span>
                    </h1>

                    <p class="text-lg lg:text-xl text-stone-500 leading-relaxed max-w-lg font-light">
                        Discover our curated collection of premium cosmetics crafted to celebrate your unique radiance. Where luxury meets conscience.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white font-medium tracking-wider uppercase text-sm rounded-full transition-all duration-500 shadow-xl shadow-rose-900/25 hover:shadow-rose-900/40 hover:-translate-y-0.5">
                            Explore Collection
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#collections" class="inline-flex items-center justify-center gap-3 px-8 py-4 border border-stone-200 hover:border-rose-300 text-stone-700 hover:text-rose-800 font-medium tracking-wider uppercase text-sm rounded-full transition-all duration-300">
                            Learn More
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-200 to-amber-400 border-2 border-white shadow-sm"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-rose-200 to-rose-400 border-2 border-white shadow-sm"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-stone-200 to-stone-400 border-2 border-white shadow-sm"></div>
                            </div>
                            <span class="text-sm text-stone-500">Join <span class="font-semibold text-stone-800">12k+</span> happy customers</span>
                        </div>
                        <div class="hidden sm:flex items-center gap-1 text-amber-400">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm text-stone-500 ml-1">4.9<span class="text-stone-400">/5</span></span>
                        </div>
                    </div>
                </div>

                {{-- Hero Visual --}}
                <div class="relative lg:h-[600px] flex items-center justify-center">
                    <div class="relative w-full max-w-md lg:max-w-none">
                        <div class="relative aspect-[3/4] rounded-3xl overflow-hidden shadow-2xl shadow-rose-900/20">
                            <div class="absolute inset-0 bg-gradient-to-br from-rose-100 via-rose-200/80 to-amber-100/60">
                                <div class="absolute inset-0" style="background: radial-gradient(ellipse at 30% 20%, rgba(251, 207, 232, 0.6) 0%, transparent 60%), radial-gradient(ellipse at 70% 80%, rgba(245, 208, 200, 0.4) 0%, transparent 50%);"></div>
                            </div>
                            {{-- Product Mockups --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="relative w-4/5 h-4/5">
                                    {{-- Main product bottle --}}
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-56 sm:w-48 sm:h-64 lg:w-56 lg:h-72">
                                        <div class="w-full h-full relative">
                                            <div class="absolute inset-0 bg-gradient-to-b from-rose-200/80 via-rose-300/60 to-rose-400/40 rounded-full blur-xl"></div>
                                            <div class="absolute inset-2 bg-gradient-to-b from-rose-100/90 via-white/80 to-rose-200/70 rounded-full border border-white/60 backdrop-blur-sm shadow-inner"></div>
                                            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-16 h-24 sm:w-20 sm:h-28 bg-gradient-to-b from-rose-300 via-rose-400 to-rose-500 rounded-full shadow-lg"></div>
                                            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 w-10 h-3 bg-rose-800/30 rounded-full blur-sm"></div>
                                            <div class="absolute top-3 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-rose-300/80"></div>
                                        </div>
                                    </div>
                                    {{-- Floating product 1 --}}
                                    <div class="absolute -top-4 -right-4 w-24 h-24 sm:w-28 sm:h-28 animate-float" style="animation: float 6s ease-in-out infinite;">
                                        <div class="w-full h-full rounded-2xl bg-gradient-to-br from-amber-100 via-amber-200/60 to-rose-200/40 border border-white/50 shadow-lg backdrop-blur-sm flex items-center justify-center">
                                            <div class="w-12 h-16 sm:w-14 sm:h-20 bg-gradient-to-b from-amber-300 via-amber-400 to-amber-500 rounded-lg shadow-inner"></div>
                                        </div>
                                    </div>
                                    {{-- Floating product 2 --}}
                                    <div class="absolute -bottom-2 -left-6 w-20 h-20 sm:w-24 sm:h-24 animate-float" style="animation: float 6s ease-in-out infinite; animation-delay: -2s;">
                                        <div class="w-full h-full rounded-2xl bg-gradient-to-br from-rose-100 via-pink-200/60 to-rose-300/40 border border-white/50 shadow-lg backdrop-blur-sm flex items-center justify-center">
                                            <div class="w-10 h-14 sm:w-12 sm:h-16 bg-gradient-to-b from-pink-300 via-pink-400 to-pink-500 rounded-full shadow-inner"></div>
                                        </div>
                                    </div>
                                    {{-- Sparkles --}}
                                    <div class="absolute top-1/4 right-0 w-3 h-3 rounded-full bg-amber-300/60 animate-ping" style="animation-duration: 3s;"></div>
                                    <div class="absolute bottom-1/3 left-2 w-2 h-2 rounded-full bg-rose-300/60 animate-ping" style="animation-duration: 4s;"></div>
                                </div>
                            </div>
                        </div>
                        {{-- Badge --}}
                        <div class="absolute -bottom-4 -left-4 bg-white/90 backdrop-blur-sm rounded-2xl px-5 py-4 shadow-xl border border-stone-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-stone-800">100% Natural</p>
                                    <p class="text-xs text-stone-500">Cruelty-free</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BRANDS BAR --}}
    <section class="py-16 lg:py-20 bg-stone-50/80 border-y border-stone-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-xs tracking-[0.3em] uppercase text-stone-400 mb-10">Trusted by leading beauty brands</p>
            <div class="grid grid-cols-3 md:grid-cols-5 gap-8 lg:gap-12 items-center justify-items-center opacity-50">
                <span class="font-[Playfair_Display] text-2xl lg:text-3xl text-stone-400 italic">Luminous</span>
                <span class="font-[Playfair_Display] text-2xl lg:text-3xl text-stone-400 italic">Velvet</span>
                <span class="font-[Playfair_Display] text-2xl lg:text-3xl text-stone-400 italic">Bloom</span>
                <span class="font-[Playfair_Display] text-2xl lg:text-3xl text-stone-400 italic">Glaze</span>
                <span class="font-[Playfair_Display] text-2xl lg:text-3xl text-stone-400 italic">Petra</span>
            </div>
        </div>
    </section>

    {{-- COLLECTIONS --}}
    <section id="collections" class="py-20 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
                <span class="text-xs tracking-[0.3em] uppercase text-rose-600 font-medium">Curated for you</span>
                <h2 class="mt-4 font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-stone-900 leading-tight">Our Collections</h2>
                <p class="mt-4 text-stone-500 text-lg font-light">Each product is a masterpiece of nature and science, designed to enhance your natural beauty.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                {{-- Collection 1 --}}
                <a href="#" class="group relative aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-rose-50 to-rose-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-rose-900/80 via-rose-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="w-24 h-32 bg-gradient-to-b from-rose-300 via-rose-400 to-rose-500 rounded-full shadow-xl shadow-rose-900/20 group-hover:scale-110 transition-transform duration-500"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-6 lg:p-8">
                        <span class="text-xs tracking-[0.2em] uppercase text-rose-200">Skincare</span>
                        <h3 class="mt-2 text-xl font-semibold text-white">Radiance<br>Serum</h3>
                    </div>
                </a>
                {{-- Collection 2 --}}
                <a href="#" class="group relative aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-amber-50 to-amber-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-900/80 via-amber-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="w-28 h-20 bg-gradient-to-br from-amber-200 via-amber-300 to-amber-400 rounded-2xl shadow-xl shadow-amber-900/20 group-hover:scale-110 transition-transform duration-500"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-6 lg:p-8">
                        <span class="text-xs tracking-[0.2em] uppercase text-amber-200">Makeup</span>
                        <h3 class="mt-2 text-xl font-semibold text-white">Velvet<br>Matte</h3>
                    </div>
                </a>
                {{-- Collection 3 --}}
                <a href="#" class="group relative aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-stone-50 to-stone-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-900/80 via-stone-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="w-20 h-28 bg-gradient-to-b from-stone-300 via-stone-400 to-stone-500 rounded-full shadow-xl shadow-stone-900/20 group-hover:scale-110 transition-transform duration-500"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-6 lg:p-8">
                        <span class="text-xs tracking-[0.2em] uppercase text-stone-200">Fragrance</span>
                        <h3 class="mt-2 text-xl font-semibold text-white">Midnight<br>Bloom</h3>
                    </div>
                </a>
                {{-- Collection 4 --}}
                <a href="#" class="group relative aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-green-50 to-green-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-900/80 via-green-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="w-16 h-24 bg-gradient-to-b from-green-200 via-green-300 to-green-400 rounded-full shadow-xl shadow-green-900/20 group-hover:scale-110 transition-transform duration-500"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-6 lg:p-8">
                        <span class="text-xs tracking-[0.2em] uppercase text-green-200">Body Care</span>
                        <h3 class="mt-2 text-xl font-semibold text-white">Botanical<br>Mist</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- FEATURED PRODUCT --}}
    <section id="featured" class="py-20 lg:py-32 bg-gradient-to-br from-rose-50 via-white to-rose-50/80">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="relative aspect-square rounded-3xl overflow-hidden shadow-2xl shadow-rose-900/20">
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-100 via-rose-200/80 to-amber-100/60">
                            <div class="absolute inset-0" style="background: radial-gradient(ellipse at 50% 40%, rgba(251, 207, 232, 0.5) 0%, transparent 60%), radial-gradient(ellipse at 30% 70%, rgba(245, 208, 200, 0.3) 0%, transparent 50%);"></div>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-40 h-56 sm:w-48 sm:h-64 lg:w-56 lg:h-72 relative">
                                <div class="absolute inset-0 bg-gradient-to-b from-rose-200/80 via-rose-300/60 to-rose-400/40 rounded-full blur-xl"></div>
                                <div class="absolute inset-2 bg-gradient-to-b from-rose-100/90 via-white/80 to-rose-200/70 rounded-full border border-white/60 backdrop-blur-sm shadow-inner"></div>
                                <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-20 h-32 lg:w-24 lg:h-36 bg-gradient-to-b from-rose-300 via-rose-400 to-rose-600 rounded-full shadow-lg"></div>
                                <div class="absolute top-3 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-amber-300/80"></div>
                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-full px-6 text-center">
                                    <span class="text-xs text-white/90 font-medium tracking-wider uppercase drop-shadow-sm">Rose Venus</span>
                                </div>
                            </div>
                        </div>
                        {{-- Tag --}}
                        <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
                            <span class="text-xs font-bold text-rose-700 tracking-wider">NEW</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 lg:space-y-8 order-1 lg:order-2">
                    <span class="text-xs tracking-[0.3em] uppercase text-rose-600 font-medium">Featured Product</span>
                    <h2 class="font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-stone-900 leading-tight">Rose Petal<br>Elixir</h2>
                    <p class="text-lg text-stone-500 leading-relaxed font-light">
                        A luxurious lightweight serum infused with Damascus rose extract and hyaluronic acid. Unveil a complexion that radiates youth and vitality.
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <span class="text-sm text-stone-600">Natural Ingredients</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span class="text-sm text-stone-600">Dermatologist Tested</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-sm text-stone-600">Cruelty Free</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 pt-2">
                        <span class="font-[Playfair_Display] text-4xl text-stone-900">$68</span>
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-stone-900 hover:bg-stone-800 text-white font-medium tracking-wider uppercase text-sm rounded-full transition-all duration-300 shadow-xl hover:-translate-y-0.5">
                            Shop Now
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT / STORY --}}
    <section id="about" class="py-20 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="space-y-6 lg:space-y-8">
                    <span class="text-xs tracking-[0.3em] uppercase text-rose-600 font-medium">Our Story</span>
                    <h2 class="font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-stone-900 leading-tight">Beauty born<br>from nature</h2>
                    <div class="space-y-4 text-stone-500 leading-relaxed font-light">
                        <p>Rose Venus was born from a simple belief: that true beauty is a reflection of nature's finest gifts. Every product in our collection is thoughtfully crafted using sustainably sourced ingredients from around the world.</p>
                        <p>We partner with women-led cooperatives in Morocco, family farms in Provence, and ethical producers in Japan to bring you the purest formulations — because you deserve nothing less than the best nature has to offer.</p>
                    </div>
                    <div class="grid grid-cols-3 gap-8 pt-4">
                        <div>
                            <span class="font-[Playfair_Display] text-3xl lg:text-4xl text-rose-700">15+</span>
                            <p class="text-sm text-stone-500 mt-1">Years of Craft</p>
                        </div>
                        <div>
                            <span class="font-[Playfair_Display] text-3xl lg:text-4xl text-rose-700">200+</span>
                            <p class="text-sm text-stone-500 mt-1">Natural Products</p>
                        </div>
                        <div>
                            <span class="font-[Playfair_Display] text-3xl lg:text-4xl text-rose-700">50k</span>
                            <p class="text-sm text-stone-500 mt-1">Happy Clients</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-50 via-rose-100/80 to-amber-50/60">
                            <div class="absolute inset-0" style="background: radial-gradient(ellipse at 60% 30%, rgba(251, 207, 232, 0.4) 0%, transparent 50%), radial-gradient(ellipse at 40% 80%, rgba(245, 208, 200, 0.3) 0%, transparent 50%);"></div>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center p-12">
                            <div class="text-center">
                                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-rose-200 to-rose-300 flex items-center justify-center shadow-xl mb-6">
                                    <svg class="w-10 h-10 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3.5l.01.01M12 2a1 1 0 110 2 1 1 0 010-2zM21 12h.01M21 12a1 1 0 110 2 1 1 0 010-2zM3.5 12h.01M3.5 12a1 1 0 110 2 1 1 0 010-2zM19.07 4.93l.01.01M19.07 4.93a1 1 0 010 1.41 1 1 0 01-1.41 0M4.93 19.07l.01.01M4.93 19.07a1 1 0 010-1.41 1 1 0 011.41 0"/></svg>
                                </div>
                                <p class="text-stone-600 italic font-light max-w-xs mx-auto">"Every woman deserves to feel beautiful in her own skin. We're here to help her discover that radiance."</p>
                                <p class="mt-4 text-sm font-medium text-stone-800">— Elena Vasquez</p>
                                <p class="text-xs text-stone-400">Founder, Rose Venus</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-3xl bg-gradient-to-br from-amber-100 to-rose-100 -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="py-20 lg:py-32 bg-stone-50/80">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs tracking-[0.3em] uppercase text-rose-600 font-medium">Testimonials</span>
                <h2 class="mt-4 font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-stone-900 leading-tight">What our customers say</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-stone-100">
                    <div class="flex gap-1 text-amber-400 mb-4">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-stone-600 leading-relaxed font-light mb-6">"The Rose Petal Elixir transformed my skincare routine. My skin has never looked this radiant. Absolutely obsessed!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-200 to-rose-300"></div>
                        <div>
                            <p class="text-sm font-semibold text-stone-800">Sarah Mitchell</p>
                            <p class="text-xs text-stone-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-stone-100">
                    <div class="flex gap-1 text-amber-400 mb-4">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-stone-600 leading-relaxed font-light mb-6">"I've tried countless moisturizers but nothing compares to the Velvet Matte collection. It feels weightless yet incredibly hydrating."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-200 to-amber-300"></div>
                        <div>
                            <p class="text-sm font-semibold text-stone-800">Jessica Chen</p>
                            <p class="text-xs text-stone-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-stone-100">
                    <div class="flex gap-1 text-amber-400 mb-4">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-stone-600 leading-relaxed font-light mb-6">"The Midnight Bloom fragrance is absolutely divine. It's subtle, elegant, and lasts all day. I get compliments everywhere I go."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-stone-200 to-stone-300"></div>
                        <div>
                            <p class="text-sm font-semibold text-stone-800">Amara Okafor</p>
                            <p class="text-xs text-stone-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA / NEWSLETTER --}}
    <section id="contact" class="relative py-20 lg:py-32 bg-gradient-to-br from-rose-900 via-rose-800 to-rose-900 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-rose-700/30 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] rounded-full bg-amber-500/10 blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-2 h-2 rounded-full bg-rose-300/40 animate-ping" style="animation-duration: 3s;"></div>
        </div>
        <div class="relative max-w-2xl mx-auto px-6 lg:px-8 text-center">
            <span class="text-xs tracking-[0.3em] uppercase text-rose-200 font-medium">Stay Connected</span>
            <h2 class="mt-4 font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-white leading-tight">Join the Rose Venus family</h2>
            <p class="mt-4 text-rose-200 text-lg font-light">Subscribe for exclusive access to new collections, beauty tips, and 15% off your first order.</p>
            <form class="mt-10 flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-4 bg-white/10 border border-rose-400/30 rounded-full text-white placeholder-rose-300/60 focus:outline-none focus:border-rose-300 focus:ring-1 focus:ring-rose-300 transition-all duration-300 text-sm">
                <button type="submit" class="px-8 py-4 bg-white hover:bg-rose-50 text-rose-900 font-medium tracking-wider uppercase text-sm rounded-full transition-all duration-300 shadow-xl hover:-translate-y-0.5 whitespace-nowrap">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-stone-900 text-stone-400">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
                <div class="sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-[Playfair_Display] font-bold text-white">Rose</span>
                        <span class="text-xl font-[Playfair_Display] font-light text-stone-400">Venus</span>
                    </div>
                    <p class="text-sm leading-relaxed text-stone-500 font-light">Timeless elegance meets modern beauty. Discover the art of radiant living.</p>
                </div>
                <div>
                    <h4 class="text-xs tracking-[0.2em] uppercase text-white font-medium mb-6">Shop</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Skincare</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Makeup</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Fragrance</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Body Care</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs tracking-[0.2em] uppercase text-white font-medium mb-6">Company</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Our Story</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Press</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs tracking-[0.2em] uppercase text-white font-medium mb-6">Support</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Shipping</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">Returns</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-300">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-stone-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-stone-600">&copy; {{ date('Y') }} Rose Venus. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-stone-500 hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-stone-500 hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="text-stone-500 hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        [x-cloak] { display: none !important; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</body>
</html>
