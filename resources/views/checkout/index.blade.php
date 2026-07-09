<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Checkout</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="grid lg:grid-cols-5 gap-8">
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Shipping Details</h3>
                        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-400">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all @error('phone') border-red-300 @enderror" placeholder="08xx-xxxx-xxxx">
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Address <span class="text-red-400">*</span></label>
                                <textarea name="shipping_address" rows="3" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all @error('shipping_address') border-red-300 @enderror" placeholder="Street, city, province, postal code">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes (optional)</label>
                                <textarea name="notes" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all" placeholder="Special instructions">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="w-full px-6 py-3.5 bg-rose-800 hover:bg-rose-900 text-white font-medium rounded-full transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                                Place Order — Rp {{ number_format($total, 0, ',', '.') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-rose-50 to-rose-100 flex-shrink-0 overflow-hidden">
                                        @if ($item->product->image)
                                            <img src="{{ Storage::url($item->product->image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="w-5 h-7 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if ($discount > 0)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-green-600">Discount</span>
                                    <span class="font-medium text-green-600">-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-rose-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Coupon --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Coupon Code</h3>
                        @if (session('coupon_id'))
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-600 font-medium">Discount applied!</span>
                                <form action="{{ route('coupon.remove') }}" method="POST">
                                    @csrf
                                    <button class="text-xs text-red-500 hover:text-red-600">Remove</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('coupon.apply') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="Enter coupon code" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                                <button type="submit" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white text-sm font-medium rounded-lg transition-colors">Apply</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
