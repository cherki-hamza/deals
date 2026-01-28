<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search products via API for real-time results
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'results' => [],
                'count' => 0
            ]);
        }

        $products = Product::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhere('full_description', 'like', "%{$query}%");
            })
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $product->price_text,
                    'image' => $product->images_array && count($product->images_array) > 0
                        ? \Voyager::image($product->images_array[0])
                        : null,
                    'category' => $product->category ? $product->category->name : null,
                    'url' => route('products.show', $product->slug)
                ];
            });

        return response()->json([
            'results' => $products,
            'count' => $products->count()
        ]);
    }
}
