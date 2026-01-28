@extends('layouts.app')

@section('title', $post->seo_title ? $post->seo_title : $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->meta_description)
@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $post->excerpt)
@if($post->image)
@section('og_image', Voyager::image($post->image))
@endif

@section('content')
    {{-- Breadcrumb --}}
    <section class="bg-warm-gray-50 py-4 border-b border-warm-gray-100">
        <div class="container-main">
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-warm-gray-500 hover:text-warm-gray-700">Home</a></li>
                    <li class="text-warm-gray-400">/</li>
                    <li><a href="{{ route('blog.index') }}" class="text-warm-gray-500 hover:text-warm-gray-700">Blog</a>
                    </li>
                    <li class="text-warm-gray-400">/</li>
                    <li class="text-warm-gray-900 font-medium line-clamp-1">{{ $post->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <article class="py-12 bg-white">
        <div class="container-main">
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Main Content --}}
                <div class="w-full lg:w-2/3">
                    {{-- Header --}}
                    <header class="mb-10 text-center lg:text-left">
                        <div
                            class="flex items-center justify-center lg:justify-start gap-4 text-sm text-warm-gray-500 mb-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $post->created_at->format('F d, Y') }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-warm-gray-300"></span>
                            <span>By Admin</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-bold font-heading text-warm-gray-900 mb-6 leading-tight">
                            {{ $post->title }}
                        </h1>

                        @if($post->image)
                            <div class="aspect-video rounded-2xl overflow-hidden shadow-lg mb-8">
                                <img src="{{ Voyager::image($post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif
                    </header>

                    {{-- Content --}}
                    <div
                        class="prose prose-lg prose-warm-gray max-w-none prose-headings:font-heading prose-a:text-amber-600 hover:prose-a:text-amber-700 prose-img:rounded-xl">
                        {!! $post->body !!}
                    </div>

                    {{-- Disqus Comments --}}
                    <div class="mt-12 pt-12 border-t border-warm-gray-200">
                        <h3 class="text-2xl font-bold font-heading text-warm-gray-900 mb-8">Comments</h3>
                        <div id="disqus_thread"></div>
                        <script>
                            var disqus_config = function () {
                                this.page.url = "{{ route('blog.show', $post->slug) }}";
                                this.page.identifier = "post-{{ $post->id }}";
                            };
                            (function () { // DON'T EDIT BELOW THIS LINE
                                var d = document, s = d.createElement('script');
                                s.src = 'https://dailyusedeals.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments
                                powered by Disqus.</a></noscript>
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="w-full lg:w-1/3 space-y-8">
                    {{-- Sticky Container --}}
                    <div class="sticky top-24">
                        <div class="bg-warm-gray-50 rounded-2xl p-6 border border-warm-gray-100">
                            <h3 class="text-xl font-bold font-heading text-warm-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Trending Products
                            </h3>

                            <div class="space-y-5">
                                @forelse($sidebarProducts as $product)
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="flex gap-4 group bg-white p-3 rounded-xl shadow-sm hover:shadow-md transition-all border border-transparent hover:border-amber-100">
                                        {{-- Image --}}
                                        <div
                                            class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 p-1">
                                            @if($product->images_array && count($product->images_array) > 0)
                                                <img src="{{ Voyager::image($product->images_array[0]) }}"
                                                    alt="{{ $product->title }}"
                                                    class="w-full h-full object-contain mix-blend-multiply transition-transform group-hover:scale-105">
                                            @endif
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                                            <h4
                                                class="text-sm font-bold text-warm-gray-900 line-clamp-2 leading-snug group-hover:text-amber-600 transition-colors mb-1">
                                                {{ $product->title }}
                                            </h4>
                                            @if($product->price_text)
                                                <div class="text-amber-600 font-bold text-sm">
                                                    {{ $product->price_text }}
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-sm text-warm-gray-500 text-center py-4">No products found.</p>
                                @endforelse
                            </div>

                            <div class="mt-6 pt-6 border-t border-warm-gray-200 text-center">
                                <a href="{{ route('shop.index') }}" class="btn btn-primary w-full text-sm">
                                    View All Products
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>

    {{-- Related Posts --}}
    @if($relatedPosts->count() > 0)
        <section class="py-16 bg-warm-gray-50 border-t border-warm-gray-100">
            <div class="container-main">
                <h2 class="text-2xl font-bold font-heading text-warm-gray-900 mb-8 text-center">More to Read</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}"
                            class="group block bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                            <div class="aspect-video relative overflow-hidden bg-gray-100">
                                @if($related->image)
                                    <img src="{{ Voyager::image($related->image) }}" alt="{{ $related->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-warm-gray-500 mb-2">{{ $related->created_at->format('M d, Y') }}</div>
                                <h3 class="font-bold text-warm-gray-900 line-clamp-2 group-hover:text-amber-600 transition-colors">
                                    {{ $related->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection