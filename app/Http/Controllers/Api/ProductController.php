<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->min_price) {
            $query->where(function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price)
                  ->orWhere('sale_price', '>=', $request->min_price);
            });
        }

        if ($request->max_price) {
            $query->where(function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price)
                  ->orWhere('sale_price', '<=', $request->max_price);
            });
        }

        $sortField = $request->sort ?? 'latest';
        match ($sortField) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate($request->per_page ?? 12);

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        if (!$product->is_active) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $product->load('category', 'reviews.user');
        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return response()->json([
            'product' => $product,
            'related' => $related,
        ]);
    }
}
