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
            ->take(6)
            ->get();

        $categories = Category::whereHas('products', function ($q) {
            $q->where('is_active', true);
        })->get();

        return view('landing', compact('featuredProducts', 'categories'));
    }
}
