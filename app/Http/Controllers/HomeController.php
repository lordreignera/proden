<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->with('category')
            ->orderBy('category_id')
            ->get()
            ->groupBy('category.name');

        $categories = Category::whereHas('products', function ($q) {
            $q->where('is_active', true);
        })->get();

        return view('landing', compact('featuredProducts', 'categories'));
    }
}
