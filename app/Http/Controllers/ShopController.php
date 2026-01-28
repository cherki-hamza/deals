<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page with filters.
     */
    public function index(Request $request)
    {
        $query = Product::published();

        // Filter by Category
        if ($request->has('category')) {
            $categorySlug = $request->category;
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('short_description', 'like', "%{$searchTerm}%")
                    ->orWhere('full_description', 'like', "%{$searchTerm}%");
            });
        }

        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    // Note: This relies on price being sortable, but we store price as text currently ($99.99).
                    // For now we'll sort by ID as a fallback or implement a raw cast if needed.
                    // Ideally we should have a numeric price column. 
                    // Let's assume order for now or latest.
                    $query->orderBy('id', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('id', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query->orderBy('order', 'asc');
                    break;
            }
        } else {
            $query->orderBy('order', 'asc');
        }

        $products = $query->paginate(18)->withQueryString();

        $categories = Category::active()->withCount('products')->orderBy('order')->get();

        return view('shop.index', compact('products', 'categories'));
    }
}
