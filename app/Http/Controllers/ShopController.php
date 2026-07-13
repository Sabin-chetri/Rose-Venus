<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Product::where('is_active', true)->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        $query = Product::with('category')->where('is_active', true);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($brand = request('brand')) {
            $query->where('brand', $brand);
        }

        if ($min = request('min_price')) {
            $query->where(function ($q) use ($min) {
                $q->where('price', '>=', $min)
                  ->orWhere('sale_price', '>=', $min);
            });
        }

        if ($max = request('max_price')) {
            $query->where(function ($q) use ($max) {
                $q->where('price', '<=', $max)
                  ->orWhere('sale_price', '<=', $max);
            });
        }

        $sort = request('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(10)->withQueryString();

        return view('shop.index', compact('categories', 'brands', 'products'));
    }

    public function category(Category $category): View
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Product::where('is_active', true)->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($brand = request('brand')) {
            $query->where('brand', $brand);
        }

        $sort = request('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(10)->withQueryString();

        return view('shop.index', compact('categories', 'brands', 'products', 'category'));
    }

    public function collection(Category $category): View
    {
        $categories = Category::where('is_active', true)->get();

        $featured = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();

        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('shop.collection', compact('category', 'categories', 'featured', 'products'));
    }

    public function show(Product $product): View
    {
        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}
