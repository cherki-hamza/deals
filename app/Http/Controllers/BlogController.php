<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;

use App\Models\Product;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('status', 'PUBLISHED')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();

        $relatedPosts = Post::where('status', 'PUBLISHED')
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Fetch products for sidebar (Featured or Latest)
        $sidebarProducts = Product::where('featured', 1)
            ->take(5)
            ->inRandomOrder()
            ->get();

        // Fallback if no featured products
        if ($sidebarProducts->isEmpty()) {
            $sidebarProducts = Product::latest()->take(5)->get();
        }

        return view('blog.show', compact('post', 'relatedPosts', 'sidebarProducts'));
    }
}
