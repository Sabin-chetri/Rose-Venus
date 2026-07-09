<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::with('user', 'product')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Review approved.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
