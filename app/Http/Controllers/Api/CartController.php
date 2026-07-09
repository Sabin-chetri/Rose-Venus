<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = Cart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $items->sum(fn ($item) => $item->subtotal());

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            return response()->json(['message' => 'Not enough stock.'], 422);
        }

        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $data['product_id']],
            ['quantity' => \Illuminate\Support\Facades\DB::raw('quantity + ' . $data['quantity'])]
        );

        $cart->load('product.category');

        return response()->json(['message' => 'Added to cart.', 'item' => $cart], 201);
    }

    public function update(Request $request, Cart $cart): JsonResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $data = $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        if ($cart->product->stock < $data['quantity']) {
            return response()->json(['message' => 'Not enough stock.'], 422);
        }

        $cart->update($data);

        return response()->json(['message' => 'Cart updated.', 'item' => $cart]);
    }

    public function destroy(Request $request, Cart $cart): JsonResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Item removed from cart.']);
    }
}
