<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereNotIn('status', ['cancelled'])->sum('total');
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', User::ROLE_CUSTOMER)->count();
        $pendingReviews = Review::where('is_approved', false)->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        $revenueByStatus = Order::select('status', DB::raw('count(*) as count'), DB::raw('sum(total) as revenue'))
            ->groupBy('status')
            ->get();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('sum(total) as revenue'),
            DB::raw('count(*) as orders')
        )
            ->whereNotIn('status', ['cancelled'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'totalCustomers',
            'pendingReviews', 'lowStockProducts', 'revenueByStatus',
            'recentOrders', 'monthlyRevenue'
        ));
    }
}
