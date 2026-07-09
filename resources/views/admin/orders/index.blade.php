<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Order</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Customer</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Items</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Total</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Status</th>
                                <th class="text-right px-6 py-4 font-medium text-gray-500">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $order->items->count() }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full
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
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
                @endif
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
