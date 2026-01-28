<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Category::active()
            ->ordered()
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display a specific category with its products.
     */
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $query = $category->products()->published();

        // Apply filters
        if ($request->filter === 'featured') {
            $query->featured();
        } elseif ($request->filter === 'deals') {
            $query->where(function ($q) {
                $q->whereNotNull('discount_text')
                    ->orWhere('deal_of_the_day', true);
            });
        }

        $products = $query->orderBy('order')
            ->paginate(12)
            ->withQueryString();

        return view('categories.show', compact('category', 'products'));
    }
}
