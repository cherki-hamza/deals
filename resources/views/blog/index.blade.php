@extends('layouts.app')

@section('title', 'Our Blog - ' . config('app.name'))
@section('description', 'Read our latest articles, guides, and reviews.')

@section('content')
    <div class="bg-warm-gray-50 min-h-screen py-10">
        <div class="container-main">
            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="inline-block py-1 px-3 rounded-full bg-amber-100 text-amber-700 text-sm font-bold mb-4">
                    📚 Our Blog
                </span>
                <h1 class="text-4xl md:text-5xl font-bold font-heading text-warm-gray-900 mb-4">
                    Latest Articles & Reviews
                </h1>
                <p class="text-lg text-warm-gray-600 max-w-2xl mx-auto">
                    Expert insights, buying guides, and in-depth reviews to help you find the best products.
                </p>
            </div>

            {{-- Posts Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article
                        class="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 group flex flex-col h-full">
                        {{-- Image --}}
                        <a href="{{ route('blog.show', $post->slug) }}" class="block relative aspect-video overflow-hidden">
                            @if($post->image)
                                <img src="{{ Voyager::image($post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-warm-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-warm-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white/90 backdrop-blur-sm text-xs font-bold px-2 py-1 rounded-lg text-warm-gray-700 shadow-sm">
                                    {{ $post->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="p-6 flex flex-col flex-1">
                            <h2 class="text-xl font-bold font-heading text-warm-gray-900 mb-3 line-clamp-2 leading-tight">
                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-amber-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-warm-gray-600 mb-4 line-clamp-3 flex-1 text-sm leading-relaxed">
                                {{ $post->excerpt }}
                            </p>
                            <div class="mt-auto pt-4 border-t border-warm-gray-100 flex items-center justify-between">
                                <a href="{{ route('blog.show', $post->slug) }}"
                                    class="text-amber-600 font-medium text-sm hover:text-amber-700 flex items-center gap-1 group/btn">
                                    Read More
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection