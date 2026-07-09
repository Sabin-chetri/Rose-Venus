<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            @if ($orders->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <p class="text-lg font-medium text-gray-900 mb-1">No orders yet</p>
                    <p class="text-sm text-gray-500 mb-6">Start shopping to see your orders here.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-3 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-full transition-colors">Browse Products</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-gray-400">Order #{{ $order->id }}</span>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full
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
                                    <span class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</span>
                                </div>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
