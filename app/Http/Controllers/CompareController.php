<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class CompareController extends Controller
{
    public function index()
    {
        return view('compare.index');
    }

    public function products(Request $request)
    {
        $ids = explode(',', $request->query('ids', ''));
        $products = Product::with('category')
            ->whereIn('id', $ids)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price_text,
                    'image' => $product->first_image, // Uses accessor
                    'category' => $product->category ? $product->category->name : '',
                    'url' => route('products.show', $product->slug),
                    'amazon_url' => $product->amazon_affiliate_url,
                    'rating' => 4 . '.' . rand(5, 9), // Simulating rating for consistency
                    'short_description' => $product->short_description,
                ];
            });

        return response()->json($products);
    }
}
