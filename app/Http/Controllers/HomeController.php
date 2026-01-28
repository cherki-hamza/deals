<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get active categories
        $categories = Category::active()
            ->ordered()
            ->take(6)
            ->get();

        // Get deal of the day
        $dealOfTheDay = Product::published()
            ->dealOfTheDay()
            ->first();

        // Get featured products
        $featuredProducts = Product::published()
            ->featured()
            ->with('category')
            ->orderBy('order')
            ->take(8)
            ->get();

        // Get active deal/collection
        $activeDeal = Deal::active()
            ->current()
            ->ordered()
            ->first();

        // Get latest products
        $latestProducts = Product::published()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact(
            'categories',
            'dealOfTheDay',
            'featuredProducts',
            'activeDeal',
            'latestProducts'
        ));
    }
}
