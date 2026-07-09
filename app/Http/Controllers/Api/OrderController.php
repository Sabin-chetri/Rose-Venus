<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $order->load('items.product', 'coupon');

        return response()->json($order);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        $discount = 0;
        $couponId = null;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', $data['coupon_code'])->first();

            if (!$coupon || !$coupon->isValid()) {
                return response()->json(['message' => 'Invalid coupon.'], 422);
            }

            $subtotal = $cartItems->sum(fn ($item) => $item->subtotal());
            if ($subtotal < $coupon->min_order) {
                return response()->json(['message' => 'Minimum order not met.'], 422);
            }

            $discount = $coupon->calculateDiscount($subtotal);
            $couponId = $coupon->id;
        }

        $order = DB::transaction(function () use ($cartItems, $data, $discount, $couponId) {
            $subtotal = $cartItems->sum(fn ($item) => $item->subtotal());
            $total = max(0, $subtotal - $discount);

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => Order::STATUS_PENDING,
                'total' => $total,
                'shipping_address' => $data['shipping_address'],
                'phone' => $data['phone'],
                'notes' => $data['notes'] ?? null,
                'coupon_id' => $couponId,
                'discount' => $discount,
            ]);

            foreach ($cartItems as $item) {
                $price = $item->product->sale_price ?? $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'subtotal' => $price * $item->quantity,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used_count');
            }

            Cart::where('user_id', auth()->id())->delete();

            return $order;
        });

        $order->load('items');

        return response()->json(['message' => 'Order placed.', 'order' => $order], 201);
    }
}
