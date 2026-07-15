<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Shopping Cart</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            @if ($cartItems->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <p class="text-lg font-medium text-gray-900 mb-1">Your cart is empty</p>
                    <p class="text-sm text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-3 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-full transition-colors">Browse Products</a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="divide-y divide-gray-100">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-4 p-6">
                                <a href="{{ route('shop.show', $item->product) }}" class="w-20 h-20 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100 flex-shrink-0 overflow-hidden">
                                    @if ($item->product->image)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="w-8 h-10 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                        </div>
                                    @endif
                                </a>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('shop.show', $item->product) }}" class="font-medium text-gray-900 hover:text-rose-700 transition-colors">{{ $item->product->name }}</a>
                                    <p class="text-sm text-gray-400">{{ $item->product->category->name }}</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        Rp {{ number_format($item->product->sale_price ?? $item->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <button type="button" onclick="this.nextElementSibling.stepDown(); this.closest('form').submit();" class="w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-50 flex items-center justify-center text-gray-500 transition-colors">−</button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-12 text-center text-sm border-0 bg-gray-50 rounded-lg py-1.5 [&::-webkit-inner-spin-button]:appearance-none" readonly>
                                    <button type="button" onclick="this.previousElementSibling.stepUp(); this.closest('form').submit();" class="w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-50 flex items-center justify-center text-gray-500 transition-colors">+</button>
                                </form>
                                <div class="text-right w-24">
                                    <p class="font-medium text-gray-900">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-5 bg-gray-50/80 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-rose-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3.5 bg-stone-900 hover:bg-stone-800 text-white font-medium rounded-full transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
