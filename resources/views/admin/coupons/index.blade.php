<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Coupons</h2>
            <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Coupon
            </a>
        </div>
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
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Code</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Type</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Value</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Min Order</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Uses</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Status</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Expires</th>
                                <th class="text-right px-6 py-4 font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($coupons as $coupon)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $coupon->code }}</td>
                                    <td class="px-6 py-4"><span class="capitalize">{{ $coupon->type }}</span></td>
                                    <td class="px-6 py-4">
                                        @if ($coupon->type === 'percent')
                                            {{ $coupon->value }}%
                                        @else
                                            Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">Rp {{ number_format($coupon->min_order, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">{{ $coupon->used_count }}{{ $coupon->max_uses ? ' / ' . $coupon->max_uses : '' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $coupon->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500">
                                        {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Never' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50 rounded-lg transition-colors">Edit</a>
                                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                                @csrf @method('DELETE')
                                                <button class="px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">No coupons yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($coupons->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $coupons->links() }}</div>
                @endif
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
