<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order #{{ $order->id }}</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                {{-- Status Update --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-gray-50/50">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-4">
                        @csrf @method('PATCH')
                        <label class="text-sm font-medium text-gray-700">Update Status:</label>
                        <select name="status" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="processing" @selected($order->status === 'processing')>Processing</option>
                            <option value="shipped" @selected($order->status === 'shipped')>Shipped</option>
                            <option value="delivered" @selected($order->status === 'delivered')>Delivered</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">Update</button>
                    </form>
                </div>

                {{-- Customer Info --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 grid sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Customer</p>
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Date</p>
                        <p class="font-medium text-gray-900">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        <p class="text-sm text-gray-500">Status: <span class="font-medium">{{ ucfirst($order->status) }}</span></p>
                    </div>
                </div>

                {{-- Items --}}
                <div class="p-6 lg:p-8 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900 mb-4">Items</h3>
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between py-2">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                </div>
                                <p class="font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total --}}
                <div class="p-6 lg:p-8 bg-gray-50/50 flex items-center justify-between">
                    <span class="text-lg font-semibold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-rose-700">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                {{-- Shipping --}}
                @if ($order->shipping_address)
                    <div class="p-6 lg:p-8 border-t border-gray-100">
                        <h3 class="font-semibold text-gray-900 mb-2">Shipping Address</h3>
                        <p class="text-gray-600">{{ $order->shipping_address }}</p>
                        @if ($order->phone) <p class="text-gray-600 mt-1">Phone: {{ $order->phone }}</p> @endif
                        @if ($order->notes) <p class="text-gray-500 mt-2 text-sm">Notes: {{ $order->notes }}</p> @endif
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
