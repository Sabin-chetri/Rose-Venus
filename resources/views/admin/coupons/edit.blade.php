<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.coupons.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Coupon</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="p-6 lg:p-8 space-y-6">
                    @csrf @method('PATCH')
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                            <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                            @error('code') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                                <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed (Rp)</option>
                                <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                            <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Order (Rp)</label>
                            <input type="number" name="min_order" value="{{ old('min_order', $coupon->min_order) }}" step="0.01" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Uses (optional)</label>
                            <input type="number" name="max_uses" value="{{ old('max_uses', $coupon->max_uses) }}" min="1" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expires At (optional)</label>
                            <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>
                    </div>
                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                            <span class="text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">Update Coupon</button>
                        <a href="{{ route('admin.coupons.index') }}" class="px-6 py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">Cancel</a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
