<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="flex gap-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('admin._sidebar')
            <div class="flex-1 min-w-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-6">
                    @csrf @method('PATCH')

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price (Rp)</label>
                            <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                            @if ($product->image)
                                <p class="mt-1 text-xs text-gray-400">Current image: {{ basename($product->image) }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ingredients (optional)</label>
                            <textarea name="ingredients" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all">{{ old('ingredients', $product->ingredients) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                            <span class="text-sm text-gray-600">Featured product</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                            <span class="text-sm text-gray-600">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-rose-800 hover:bg-rose-900 text-white text-sm font-medium rounded-lg transition-colors">Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">Cancel</a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
