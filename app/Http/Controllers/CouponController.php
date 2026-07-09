<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $coupon = Coupon::where('code', $data['code'])->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal());

        if ($subtotal < $coupon->min_order) {
            $min = 'Rp ' . number_format($coupon->min_order, 0, ',', '.');
            return back()->with('error', "Minimum order of {$min} required for this coupon.");
        }

        session(['coupon_id' => $coupon->id]);
        session(['coupon_discount' => $coupon->calculateDiscount($subtotal)]);

        return back()->with('success', "Coupon '{$coupon->code}' applied!");
    }

    public function remove(): RedirectResponse
    {
        session()->forget(['coupon_id', 'coupon_discount']);
        return back()->with('success', 'Coupon removed.');
    }
}
