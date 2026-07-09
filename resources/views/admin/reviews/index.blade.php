<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reviews</h2>
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
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Product</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Customer</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Rating</th>
                                <th class="text-left px-6 py-4 font-medium text-gray-500">Comment</th>
                                <th class="text-center px-6 py-4 font-medium text-gray-500">Status</th>
                                <th class="text-right px-6 py-4 font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($reviews as $review)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $review->product->name }}</td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-900">{{ $review->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $review->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $review->comment ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $review->is_approved ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if (!$review->is_approved)
                                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-50 rounded-lg transition-colors">Approve</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                                @csrf @method('DELETE')
                                                <button class="px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">No reviews yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($reviews->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $reviews->links() }}</div>
                @endif
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
