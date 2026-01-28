@extends('layouts.app')

@section('title', $category->name . ' - ' . config('app.name'))
@section('meta_description', $category->description ?: 'Browse the best ' . $category->name . ' products with expert reviews and recommendations.')

@section('content')
    {{-- Category Header --}}
    <section class="bg-gradient-to-br from-warm-gray-50 to-amber-accent-50/30 py-12 lg:py-16">
        <div class="container-main">
            <nav class="mb-4">
                <ol class="flex items-center gap-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-warm-gray-500 hover:text-warm-gray-700">Home</a></li>
                    <li class="text-warm-gray-400">/</li>
                    <li><a href="{{ route('categories.index') }}"
                            class="text-warm-gray-500 hover:text-warm-gray-700">Categories</a></li>
                    <li class="text-warm-gray-400">/</li>
                    <li class="text-warm-gray-900 font-medium">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="flex items-center gap-4">
                @if($category->image)
                    <div class="w-16 h-16 rounded-2xl overflow-hidden">
                        <img src="{{ Voyager::image($category->image) }}" alt="{{ $category->name }}"
                            class="w-full h-full object-cover">
                    </div>
                @elseif($category->icon)
                    <div class="w-16 h-16 rounded-2xl bg-amber-accent-100 flex items-center justify-center">
                        <span class="text-3xl">{{ $category->icon }}</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900">
                        {{ $category->name }}
                    </h1>
                    <p class="mt-1 text-warm-gray-600">{{ $products->total() }} products</p>
                </div>
            </div>

            @if($category->description)
                <p class="mt-4 text-warm-gray-600 max-w-2xl">
                    {{ $category->description }}
                </p>
            @endif
        </div>
    </section>

    {{-- Filters & Products --}}
    <section class="section bg-white">
        <div class="container-main">
            {{-- Filter Bar --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-warm-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-warm-gray-500">Filter:</span>
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="badge {{ !request('filter') ? 'badge-featured' : 'bg-warm-gray-100 text-warm-gray-600 hover:bg-warm-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('categories.show', ['slug' => $category->slug, 'filter' => 'featured']) }}"
                        class="badge {{ request('filter') === 'featured' ? 'badge-featured' : 'bg-warm-gray-100 text-warm-gray-600 hover:bg-warm-gray-200' }}">
                        Featured
                    </a>
                    <a href="{{ route('categories.show', ['slug' => $category->slug, 'filter' => 'deals']) }}"
                        class="badge {{ request('filter') === 'deals' ? 'badge-deal' : 'bg-warm-gray-100 text-warm-gray-600 hover:bg-warm-gray-200' }}">
                        Deals
                    </a>
                </div>

                <div class="text-sm text-warm-gray-500">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                    products
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    @include('components.product-card', ['product' => $product, 'showCategory' => false])
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-warm-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <p class="text-warm-gray-500">No products found in this category.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- Trust Badge --}}
    <section class="py-8 bg-warm-gray-50">
        <div class="container-main">
            @include('components.trust-badge')
        </div>
    </section>
@endsection