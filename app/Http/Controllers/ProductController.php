<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })->with(['products' => function ($query) {
            $query->where('is_active', true);
        }])->get();
        $products = Product::where('is_active', true)->with('category')->paginate(12);
        
        return view('shop.products', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('shop.product-detail', compact('product'));
    }

    public function filter($category)
    {
        $categories = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })->with(['products' => function ($query) {
            $query->where('is_active', true);
        }])->get();

        $products = Product::where('is_active', true)
            ->whereHas('category', fn($q) => $q->where('slug', $category))
            ->paginate(12);
        
        return view('shop.products', compact('products', 'categories'));
    }
}
