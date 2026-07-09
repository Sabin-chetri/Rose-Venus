<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <p class="text-sm text-gray-400 mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0 space-y-6">

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pending Reviews</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingReviews }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Low Stock</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $lowStockProducts }}</p>
                        </div>
                    </div>
                </div>

                {{-- Charts Row --}}
                <div class="grid lg:grid-cols-2 gap-6">

                    {{-- Orders by Status --}}
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Orders by Status
                        </h3>
                        <div class="space-y-3">
                            @forelse ($revenueByStatus as $stat)
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2.5 h-2.5 rounded-full
                                            @switch($stat->status)
                                                @case('pending') bg-yellow-400 @break
                                                @case('processing') bg-blue-400 @break
                                                @case('shipped') bg-purple-400 @break
                                                @case('delivered') bg-green-400 @break
                                                @case('cancelled') bg-red-400 @break
                                                @default bg-gray-400
                                            @endswitch
                                        "></span>
                                        <span class="text-sm font-medium capitalize text-gray-700">{{ $stat->status }}</span>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">{{ $stat->count }}</p>
                                        <p class="text-xs text-gray-400">Rp {{ number_format($stat->revenue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 py-4 text-center">No orders yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Monthly Revenue --}}
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-semibold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Monthly Revenue
                        </h3>
                        @if ($monthlyRevenue->isNotEmpty())
                            <div class="space-y-4">
                                @foreach ($monthlyRevenue as $month)
                                    @php
                                        $maxRevenue = $monthlyRevenue->max('revenue');
                                        $width = $maxRevenue > 0 ? max(4, ($month->revenue / $maxRevenue) * 100) : 0;
                                    @endphp
                                    <div>
                                        <div class="flex items-center justify-between text-sm mb-1.5">
                                            <span class="text-gray-500 font-medium">{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</span>
                                            <span class="font-semibold text-gray-900">Rp {{ number_format($month->revenue, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-rose-600 transition-all duration-500" style="width: {{ $width }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $month->orders }} orders</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                <p class="text-sm">No revenue data yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Recent Orders
                        </h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">View All &rarr;</a>
                    </div>
                    @if ($recentOrders->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th class="text-left px-6 py-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Order</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Customer</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Total</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Status</th>
                                        <th class="text-right px-6 py-3 font-medium text-gray-400 text-xs uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($recentOrders as $order)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-3.5 font-medium text-gray-900">#{{ $order->id }}</td>
                                            <td class="px-6 py-3.5">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-7 h-7 rounded-full bg-rose-100 flex items-center justify-center text-xs font-medium text-rose-700">{{ substr($order->user->name, 0, 1) }}</div>
                                                    <div>
                                                        <p class="text-gray-900">{{ $order->user->name }}</p>
                                                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-3.5 font-medium text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                            <td class="px-6 py-3.5">
                                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full
                                                    @switch($order->status)
                                                        @case('pending') bg-yellow-50 text-yellow-700 @break
                                                        @case('processing') bg-blue-50 text-blue-700 @break
                                                        @case('shipped') bg-purple-50 text-purple-700 @break
                                                        @case('delivered') bg-green-50 text-green-700 @break
                                                        @case('cancelled') bg-red-50 text-red-700 @break
                                                        @default bg-gray-50 text-gray-600
                                                    @endswitch
                                                ">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td class="px-6 py-3.5 text-right text-gray-400 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <p class="text-sm">No orders yet.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
