<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($category) ? $category->name : 'Shop' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Sidebar --}}
                <aside class="lg:w-56 flex-shrink-0">
                    <h3 class="text-xs tracking-widest uppercase text-gray-400 font-medium mb-4">Categories</h3>
                    <div class="flex lg:flex-col flex-wrap gap-2">
                        <a href="{{ route('shop.index') }}" class="px-4 py-2 text-sm rounded-lg transition-colors {{ !isset($category) ? 'bg-rose-50 text-rose-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            All Products
                        </a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('shop.category', $cat) }}" class="px-4 py-2 text-sm rounded-lg transition-colors {{ isset($category) && $category->id === $cat->id ? 'bg-rose-50 text-rose-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('shop.index') }}" class="mt-6">
                        <h3 class="text-xs tracking-widest uppercase text-gray-400 font-medium mb-3">Search</h3>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-2.5 pl-10 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('shop.index') }}" class="mt-6 space-y-4">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <h3 class="text-xs tracking-widest uppercase text-gray-400 font-medium mb-3">Price Range</h3>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">Filter</button>
                    </form>

                    {{-- Sort --}}
                    <div class="mt-6">
                        <h3 class="text-xs tracking-widest uppercase text-gray-400 font-medium mb-3">Sort By</h3>
                        <div class="space-y-1">
                            @foreach (['latest' => 'Latest', 'price_asc' => 'Price: Low to High', 'price_desc' => 'Price: High to Low', 'name' => 'Name'] as $key => $label)
                                <a href="{{ route('shop.index', array_merge(request()->query(), ['sort' => $key])) }}" class="block px-3 py-1.5 text-sm rounded-lg transition-colors {{ request('sort', 'latest') === $key ? 'bg-rose-50 text-rose-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                {{-- Products --}}
                <div class="flex-1">
                    @if (request('search'))
                        <p class="text-sm text-gray-500 mb-4">Search results for "<strong>{{ request('search') }}</strong>"</p>
                    @endif

                    @if ($products->isEmpty())
                        <div class="text-center py-16">
                            <p class="text-gray-400 text-lg">No products found.</p>
                            <a href="{{ route('shop.index') }}" class="inline-flex mt-4 px-6 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-full transition-colors">Clear Filters</a>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach ($products as $product)
                                <a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                                    <div class="h-36 bg-gradient-to-br from-rose-50 via-white to-rose-50/80 relative overflow-hidden">
                                        @if ($product->image)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-10 h-14 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                            </div>
                                        @endif
                                        @if ($product->hasSale())
                                            <span class="absolute top-2 left-2 px-2 py-0.5 bg-rose-500 text-white text-[10px] font-medium rounded-full">Sale</span>
                                        @endif
                                        @if (!$product->is_active || $product->stock === 0)
                                            <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                                                <span class="px-2.5 py-1 bg-gray-900/80 text-white text-[10px] font-medium rounded-full">Out of Stock</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <p class="text-xs text-gray-400 mb-1">{{ $product->category->name }}</p>
                                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-rose-700 transition-colors leading-snug">{{ $product->name }}</h3>
                                        <div class="mt-2 flex items-center gap-2">
                                            @if ($product->hasSale())
                                                <span class="text-sm font-bold text-rose-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                                <span class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
