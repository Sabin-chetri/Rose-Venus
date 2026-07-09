<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal());
        $discount = session('coupon_discount', 0);
        $total = max(0, $subtotal - $discount);

        return view('checkout.index', compact('cartItems', 'subtotal', 'discount', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal());
        $discount = 0;
        $couponId = null;

        if ($couponIdSession = session('coupon_id')) {
            $coupon = Coupon::find($couponIdSession);
            if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponId = $coupon->id;
            }
        }

        $total = max(0, $subtotal - $discount);

        $order = DB::transaction(function () use ($cartItems, $data, $total, $discount, $couponId) {
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

        session()->forget(['coupon_id', 'coupon_discount']);

        try {
            Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            // Mail sent silently
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
