<x-app-layout>
    @php
        $accent = match ($category->slug) {
            'skincare' => 'rose',
            'makeup' => 'amber',
            'fragrance' => 'stone',
            'body-care' => 'green',
            default => 'rose',
        };
        $productCount = $products->total();

        $heroBg = match ($accent) {
            'rose' => 'from-rose-800/90 via-rose-900/95 to-rose-950',
            'amber' => 'from-amber-800/90 via-amber-900/95 to-amber-950',
            'stone' => 'from-stone-800/90 via-stone-900/95 to-stone-950',
            'green' => 'from-emerald-800/90 via-emerald-900/95 to-emerald-950',
            default => 'from-rose-800/90 via-rose-900/95 to-rose-950',
        };
        $badgeColor = match ($accent) {
            'rose' => 'bg-rose-100 text-rose-700',
            'amber' => 'bg-amber-100 text-amber-700',
            'stone' => 'bg-stone-100 text-stone-700',
            'green' => 'bg-emerald-100 text-emerald-700',
            default => 'bg-rose-100 text-rose-700',
        };
        $hoverText = match ($accent) {
            'rose' => 'hover:text-rose-700',
            'amber' => 'hover:text-amber-700',
            'stone' => 'hover:text-stone-700',
            'green' => 'hover:text-emerald-700',
            default => 'hover:text-rose-700',
        };

        $heroImage = match ($category->slug) {
            'skincare' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS49gH_WAaYqQ4c3jsGFPt6RcVolVV3zvyUpvKsZzCmqQ&s=10',
            'fragrance' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVEpwN1ZRsg2-EFxOR3eBn0X0r8xrOVPfqtJMsIQWYn88BOv6od2uDhek&s=10',
            'makeup' => 'https://custom-images.strikinglycdn.com/res/hrscywv4p/image/upload/c_limit,fl_lossy,h_9000,w_1200,f_auto,q_auto/8103728/183668_103785.png',
            'body-care' => 'https://img.magnific.com/premium-photo/skincare-products-isolated-white-background_621955-41920.jpg?semt=ais_hybrid&w=740&q=80',
            default => null,
        };
    @endphp

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br {{ $heroBg }}">
        @if ($heroImage)
            <img src="{{ $heroImage }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-white/5 blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-28">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur rounded-full text-xs tracking-widest uppercase text-white/70 mb-5">Collection</span>
                <h1 class="font-[Playfair_Display] text-4xl sm:text-5xl lg:text-6xl text-white leading-tight font-bold">{{ $category->name }}</h1>
                <p class="mt-3 text-base sm:text-lg text-white/60 leading-relaxed max-w-lg font-light">{{ $category->description }}</p>
                <div class="flex items-center gap-5 mt-6 text-sm text-white/50">
                    <span class="flex items-center gap-1.5">{{ $productCount }} {{ Str::plural('product', $productCount) }}</span>
                    <a href="#all-products" class="flex items-center gap-1.5 text-white/60 hover:text-white transition-colors">
                        Browse all <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pb-6">
            <div class="flex flex-wrap items-center gap-2">
                @foreach ($categories as $cat)
                    <a href="{{ route('shop.collection', $cat) }}"
                        class="px-4 py-1.5 text-sm rounded-full transition-all duration-200
                        {{ $cat->id === $category->id ? 'bg-white text-stone-900 shadow-md font-medium' : 'bg-white/10 text-white/70 hover:bg-white/20 hover:text-white' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
                <a href="{{ route('shop.index') }}" class="px-4 py-1.5 text-sm rounded-full bg-white/10 text-white/70 hover:bg-white/20 hover:text-white transition-all duration-200">All</a>
            </div>
        </div>
    </section>

    {{-- FEATURED --}}
    @if ($featured->isNotEmpty())
        <section class="py-12 lg:py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="text-xs tracking-[0.25em] uppercase {{ str_replace('hover:', 'text-', $hoverText) }} font-medium">Featured</span>
                    <h2 class="mt-2 font-[Playfair_Display] text-2xl sm:text-3xl text-stone-900">Curated for you</h2>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($featured as $product)
                        <a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-xl border border-stone-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                            <div class="h-36 bg-gradient-to-br from-stone-50 via-white to-stone-50/80 relative overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-14 rounded-full bg-gradient-to-b from-stone-200 to-stone-300"></div>
                                    </div>
                                @endif
                                @if ($product->hasSale())
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-rose-500 text-white text-[10px] font-medium rounded-full">Sale</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-stone-400 mb-1">{{ $product->category->name }}</p>
                                <h3 class="text-sm font-semibold text-stone-900 {{ $hoverText }} transition-colors leading-snug">{{ $product->name }}</h3>
                                <div class="mt-2 flex items-center gap-2">
                                    @if ($product->hasSale())
                                        <span class="text-sm font-bold text-rose-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-stone-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-bold text-stone-900">{{ $product->displayPrice() }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ALL PRODUCTS --}}
    <section id="all-products" class="py-12 lg:py-16 {{ $featured->isNotEmpty() ? 'bg-stone-50/60' : 'bg-white' }}">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs tracking-[0.25em] uppercase {{ str_replace('hover:', 'text-', $hoverText) }} font-medium">Products</span>
                    <h2 class="mt-1 font-[Playfair_Display] text-xl sm:text-2xl text-stone-900">All {{ $category->name }}</h2>
                </div>
                <a href="{{ route('shop.category', $category) }}" class="hidden sm:flex items-center gap-1.5 text-sm text-stone-400 hover:text-stone-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter & sort
                </a>
            </div>

            @if ($products->isEmpty())
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto rounded-full bg-stone-100 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-stone-400">No products found in this collection.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($products as $product)
                        <a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-xl border border-stone-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                            <div class="h-36 bg-gradient-to-br from-stone-50 via-white to-stone-50/80 relative overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-14 rounded-full bg-gradient-to-b from-stone-200 to-stone-300"></div>
                                    </div>
                                @endif
                                @if ($product->hasSale())
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-rose-500 text-white text-[10px] font-medium rounded-full">Sale</span>
                                @endif
                                @if ($product->stock === 0)
                                    <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                        <span class="px-2.5 py-1 bg-stone-900/80 text-white text-[10px] font-medium rounded-full">Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-stone-400 mb-1">{{ $product->category->name }}</p>
                                <h3 class="text-sm font-semibold text-stone-900 {{ $hoverText }} transition-colors leading-snug">{{ $product->name }}</h3>
                                <div class="mt-2 flex items-center gap-2">
                                    @if ($product->hasSale())
                                        <span class="text-sm font-bold text-rose-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-stone-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-bold text-stone-900">{{ $product->displayPrice() }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-12 lg:py-16 bg-gradient-to-br {{ $heroBg }}">
        <div class="max-w-2xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="font-[Playfair_Display] text-2xl sm:text-3xl lg:text-4xl text-white leading-tight">Explore {{ $category->name }}</h2>
            <p class="mt-2 text-white/50 font-light text-sm">Find your perfect match from our carefully curated selection.</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-white hover:bg-stone-50 text-stone-900 font-medium tracking-wider uppercase text-xs rounded-full transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                All Collections
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>
</x-app-layout>