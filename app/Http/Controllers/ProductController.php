<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a specific product.
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with('category')
            ->firstOrFail();

        // Get related products from the same category
        $relatedProducts = Product::published()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with('category')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
