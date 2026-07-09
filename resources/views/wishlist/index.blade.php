<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Wishlist</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            @if ($wishlists->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <p class="text-lg font-medium text-gray-900 mb-1">Your wishlist is empty</p>
                    <p class="text-sm text-gray-500 mb-6">Save items you love to your wishlist.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-3 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-full transition-colors">Browse Products</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($wishlists as $item)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-4">
                            <a href="{{ route('shop.show', $item->product) }}" class="w-16 h-16 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100 flex-shrink-0 overflow-hidden">
                                @if ($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="w-6 h-8 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                    </div>
                                @endif
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('shop.show', $item->product) }}" class="font-medium text-gray-900 hover:text-rose-700 transition-colors">{{ $item->product->name }}</a>
                                <p class="text-sm text-gray-400">{{ $item->product->category->name }}</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">{{ $item->product->displayPrice() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white text-sm font-medium rounded-full transition-colors">Add to Cart</button>
                                </form>
                                <form action="{{ route('wishlist.destroy', $item) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
