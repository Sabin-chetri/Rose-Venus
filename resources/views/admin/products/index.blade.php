@php use App\Models\Product; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Product</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Category</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Price</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Stock</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Status</th>
                                <th class="text-right px-6 py-4 font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-rose-200 flex-shrink-0 flex items-center justify-center text-xs text-rose-600 font-medium">
                                                @if ($product->image)
                                                    <img src="{{ Storage::url($product->image) }}" alt="" class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    {{ substr($product->name, 0, 2) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $product->slug }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $product->category->name }}</td>
                                    <td class="px-6 py-4">
                                        @if ($product->hasSale())
                                            <span class="text-gray-400 line-through text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <span class="text-rose-600 font-medium ml-1">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $product->stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $product->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50 rounded-lg transition-colors">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                @csrf @method('DELETE')
                                                <button class="px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <p class="text-lg font-medium mb-1">No products yet</p>
                                        <p class="text-sm">Get started by adding your first product.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
