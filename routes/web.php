<?php

use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::resource('coupons', AdminCouponController::class);
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/collections/{category:slug}', [ShopController::class, 'collection'])->name('shop.collection');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::resource('wishlist', WishlistController::class)->only(['index', 'destroy']);
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
});

require __DIR__.'/auth.php';
