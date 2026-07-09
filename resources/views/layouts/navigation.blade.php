<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-xl border-b border-stone-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 lg:h-20">
            {{-- Left: Logo + Nav --}}
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 group">
                    <span class="text-xl lg:text-2xl font-[Playfair_Display] font-bold tracking-tight text-rose-900">Rose</span>
                    <span class="text-xl lg:text-2xl font-[Playfair_Display] font-light tracking-wider text-stone-700">Venus</span>
                </a>
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('shop.index') }}" class="text-sm tracking-widest uppercase font-medium transition-colors duration-300 {{ request()->routeIs('shop.*') ? 'text-rose-700' : 'text-stone-500 hover:text-stone-900' }}">
                        Shop
                    </a>
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-sm tracking-widest uppercase font-medium transition-colors duration-300 {{ request()->routeIs('cart.*') ? 'text-rose-700' : 'text-stone-500 hover:text-stone-900' }}">
                            Cart
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="text-sm tracking-widest uppercase font-medium transition-colors duration-300 {{ request()->routeIs('wishlist.*') ? 'text-rose-700' : 'text-stone-500 hover:text-stone-900' }}">
                            Wishlist
                        </a>
                        <a href="{{ route('orders.index') }}" class="text-sm tracking-widest uppercase font-medium transition-colors duration-300 {{ request()->routeIs('orders.*') ? 'text-rose-700' : 'text-stone-500 hover:text-stone-900' }}">
                            Orders
                        </a>
                        @if (Auth::user()->role !== App\Models\User::ROLE_CUSTOMER)
                            <a href="{{ route('admin.dashboard') }}" class="text-sm tracking-widest uppercase font-medium transition-colors duration-300 {{ request()->routeIs('admin.*') ? 'text-rose-700' : 'text-stone-500 hover:text-stone-900' }}">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Right: Auth --}}
            <div class="hidden lg:flex items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2.5 px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white text-sm font-medium rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <div class="w-5 h-5 rounded-full bg-rose-400 flex items-center justify-center text-[10px] font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-3.5 w-3.5 opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
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
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-stone-500 hover:text-stone-900 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-full transition-all duration-300 shadow-lg shadow-rose-900/20 hover:shadow-rose-900/30">Get Started</a>
                    </div>
                @endauth
            </div>

            {{-- Hamburger --}}
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-stone-400 hover:text-stone-600 hover:bg-stone-100 transition-colors">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden border-t border-stone-100 bg-white shadow-xl">
        <div class="px-4 py-6 space-y-1">
            <a href="{{ route('shop.index') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('shop.*') ? 'bg-rose-50 text-rose-700' : 'text-stone-600 hover:bg-stone-50' }}">Shop</a>
            @auth
                <a href="{{ route('cart.index') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('cart.*') ? 'bg-rose-50 text-rose-700' : 'text-stone-600 hover:bg-stone-50' }}">Cart</a>
                <a href="{{ route('wishlist.index') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('wishlist.*') ? 'bg-rose-50 text-rose-700' : 'text-stone-600 hover:bg-stone-50' }}">Wishlist</a>
                <a href="{{ route('orders.index') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('orders.*') ? 'bg-rose-50 text-rose-700' : 'text-stone-600 hover:bg-stone-50' }}">Orders</a>
                @if (Auth::user()->role !== App\Models\User::ROLE_CUSTOMER)
                    <a href="{{ route('admin.dashboard') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.*') ? 'bg-rose-50 text-rose-700' : 'text-stone-600 hover:bg-stone-50' }}">Admin</a>
                @endif
            @endauth
        </div>
        @auth
            <div class="px-4 py-4 border-t border-stone-100">
                <div class="flex items-center gap-3 px-4 mb-3">
                    <div class="w-8 h-8 rounded-full bg-rose-200 flex items-center justify-center text-sm font-bold text-rose-800">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <p class="text-sm font-medium text-stone-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-stone-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" @click="open = false" class="block px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 rounded-lg transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 rounded-lg transition-colors">Log Out</button>
                </form>
            </div>
        @else
            <div class="px-4 py-4 border-t border-stone-100 space-y-2">
                <a href="{{ route('login') }}" @click="open = false" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-stone-600 border border-stone-200 rounded-lg hover:bg-stone-50 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" @click="open = false" class="block w-full text-center px-4 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">Get Started</a>
            </div>
        @endauth
    </div>
</nav>
