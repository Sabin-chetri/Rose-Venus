<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->subtotal());

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $data['product_id']],
            ['quantity' => \Illuminate\Support\Facades\DB::raw('quantity + ' . $data['quantity'])]
        );

        return redirect()->route('cart.index')->with('success', 'Added to cart!');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        abort_if($cart->user_id !== auth()->id(), 403);

        if ($cart->product->stock < $data['quantity']) {
            return back()->with('error', 'Not enough stock.');
        }

        $cart->update($data);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
