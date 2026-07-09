<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist!');
    }

    public function destroy(Wishlist $wishlist): RedirectResponse
    {
        abort_if($wishlist->user_id !== auth()->id(), 403);
        $wishlist->delete();
        return redirect()->route('wishlist.index')->with('success', 'Removed from wishlist.');
    }
}
