<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('shop.index') }}" class="hover:text-gray-600 transition-colors">Shop</a>
                <span>/</span>
                <a href="{{ route('shop.category', $product->category) }}" class="hover:text-gray-600 transition-colors">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-12">
                {{-- Image --}}
                <div class="aspect-[4/5] rounded-3xl bg-gradient-to-br from-rose-50 via-white to-rose-50/80 overflow-hidden shadow-lg relative">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-32 h-44 rounded-full bg-gradient-to-b from-rose-200 via-rose-300 to-rose-400/60 shadow-inner"></div>
                        </div>
                    @endif
                    @if ($product->hasSale())
                        <span class="absolute top-6 left-6 px-3 py-1.5 bg-rose-500 text-white text-sm font-medium rounded-full">Sale</span>
                    @endif
                </div>

                {{-- Details --}}
                <div class="space-y-6">
                    <div>
                        <p class="text-sm text-gray-400 mb-2">{{ $product->category->name }}</p>
                        <h1 class="font-[Playfair_Display] text-4xl text-gray-900 leading-tight">{{ $product->name }}</h1>
                    </div>

                    <div class="flex items-baseline gap-3">
                        @if ($product->hasSale())
                            <span class="text-3xl font-bold text-rose-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    @if ($product->ingredients)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Ingredients</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->ingredients }}</p>
                        </div>
                    @endif

                    <div class="flex items-center gap-4 pt-2">
                        <span class="text-sm text-gray-500">Stock: <span class="font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}</span></span>
                    </div>

                    @auth
                        <div class="flex items-center gap-3">
                            <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="w-full sm:w-auto px-8 py-4 bg-stone-900 hover:bg-stone-800 text-white font-medium rounded-full transition-all duration-300 shadow-lg hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0" {{ $product->stock === 0 ? 'disabled' : '' }}>
                                    {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                </button>
                            </form>
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                @csrf
                                <button class="p-4 border border-gray-200 rounded-full hover:bg-rose-50 hover:border-rose-200 transition-all duration-300 group">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-stone-900 hover:bg-stone-800 text-white font-medium rounded-full transition-all duration-300 shadow-lg">
                            Sign in to Purchase
                        </a>
                    @endauth

                    {{-- Reviews --}}
                    @auth
                        <div class="pt-8 border-t border-gray-100">
                            <h3 class="font-semibold text-gray-900 mb-4">Write a Review</h3>
                            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center gap-1" x-data="{ rating: 0 }">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                                <svg class="w-8 h-8 transition-colors" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </button>
                                        @endfor
                                        <input type="hidden" name="rating" x-model="rating">
                                    </div>
                                    @error('rating') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                                    <textarea name="comment" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all" placeholder="Share your thoughts...">{{ old('comment') }}</textarea>
                                </div>
                                <button type="submit" class="px-6 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">Submit Review</button>
                            </form>
                        </div>
                    @endauth

                    {{-- Existing Reviews --}}
                    @php $approvedReviews = $product->approvedReviews()->with('user')->latest()->get(); @endphp
                    @if ($approvedReviews->isNotEmpty())
                        <div class="pt-8 border-t border-gray-100">
                            <h3 class="font-semibold text-gray-900 mb-4">Reviews ({{ $approvedReviews->count() }})</h3>
                            <div class="space-y-4">
                                @foreach ($approvedReviews as $review)
                                    <div class="bg-gray-50/50 rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-xs font-medium text-rose-700">{{ substr($review->user->name, 0, 1) }}</div>
                                                <span class="text-sm font-medium text-gray-900">{{ $review->user->name }}</span>
                                            </div>
                                            <div class="flex items-center gap-0.5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($review->comment)
                                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Related Products --}}
            @if ($related->isNotEmpty())
                <section class="mt-16 pt-16 border-t border-gray-100">
                    <h2 class="font-[Playfair_Display] text-2xl text-gray-900 mb-8">You may also like</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($related as $item)
                            <a href="{{ route('shop.show', $item) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                <div class="aspect-[4/3] bg-gradient-to-br from-rose-50 via-white to-rose-50/80 relative overflow-hidden">
                                    @if ($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-12 h-16 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-400 mb-1">{{ $item->category->name }}</p>
                                    <h3 class="font-medium text-sm text-gray-900 group-hover:text-rose-700 transition-colors">{{ $item->name }}</h3>
                                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $item->displayPrice() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    @push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-app-layout>
