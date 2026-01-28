<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display all deals.
     */
    public function index()
    {
        // Get active deals with their products
        $deals = Deal::active()
            ->current()
            ->ordered()
            ->with([
                'publishedProducts' => function ($query) {
                    $query->with('category')->take(4);
                }
            ])
            ->get();

        // Get deal of the day products
        $dealOfTheDayProducts = Product::published()
            ->dealOfTheDay()
            ->with('category')
            ->get();

        // Get all discounted products
        $discountedProducts = Product::published()
            ->whereNotNull('discount_text')
            ->where('discount_text', '!=', '')
            ->with('category')
            ->paginate(12);

        return view('deals.index', compact('deals', 'dealOfTheDayProducts', 'discountedProducts'));
    }

    /**
     * Display a specific deal with all its products.
     */
    public function show(string $slug)
    {
        $deal = Deal::where('slug', $slug)
            ->where('active', true)
            ->with([
                'publishedProducts' => function ($query) {
                    $query->with('category');
                }
            ])
            ->firstOrFail();

        return view('deals.show', compact('deal'));
    }
}
