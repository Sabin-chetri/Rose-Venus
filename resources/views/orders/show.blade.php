<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order #{{ $order->id }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-gray-100">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Order placed</p>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full mt-1
                                @switch($order->status)
                                    @case('pending') bg-yellow-50 text-yellow-700 @break
                                    @case('processing') bg-blue-50 text-blue-700 @break
                                    @case('shipped') bg-purple-50 text-purple-700 @break
                                    @case('delivered') bg-green-50 text-green-700 @break
                                    @case('cancelled') bg-red-50 text-red-700 @break
                                    @default bg-gray-50 text-gray-600
                                @endswitch
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900 mb-4">Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100 flex-shrink-0 overflow-hidden">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="w-6 h-8 rounded-full bg-gradient-to-b from-rose-200 to-rose-300"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                </div>
                                <p class="font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 lg:p-8 bg-gray-50/50">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-rose-700">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($order->shipping_address)
                    <div class="p-6 lg:p-8 border-t border-gray-100">
                        <h3 class="font-semibold text-gray-900 mb-2">Shipping Address</h3>
                        <p class="text-gray-600">{{ $order->shipping_address }}</p>
                        @if ($order->phone)
                            <p class="text-gray-600 mt-1">Phone: {{ $order->phone }}</p>
                        @endif
                        @if ($order->notes)
                            <p class="text-gray-500 mt-2 text-sm">Notes: {{ $order->notes }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
