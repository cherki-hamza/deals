<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TrendsController extends Controller
{
    /**
     * Display the trends page.
     */
    public function index()
    {
        // For trends, we'll fetch featured products and maybe random ones to simulate "trending"
        // In a real app, this would be based on views or sales.
        $products = Product::published()
            ->where('featured', true)
            ->orWhere('deal_of_the_day', true)
            ->inRandomOrder()
            ->paginate(18);

        return view('trends.index', compact('products'));
    }
}
