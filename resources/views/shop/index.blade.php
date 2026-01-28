@extends('layouts.app')

@section('title', 'Shop - All Products')
@section('description', 'Browse our complete collection of expert-curated products.')

@section('content')
    <div class="bg-white min-h-screen pt-8 pb-16">
        <div class="container-main">

            {{-- Top Controls Section --}}
            <div class="flex flex-col gap-8 mb-10">

                {{-- Row 1: Heading & Search --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold text-warm-gray-900 font-heading tracking-tight">Shop</h1>
                        <p class="text-warm-gray-500 mt-1">Curated collection of {{ $products->total() }} premium items</p>
                    </div>

                    {{-- Minimalist Search --}}
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full md:w-80">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="w-full pl-10 pr-4 py-3 bg-warm-gray-50 border-none rounded-xl focus:ring-0 focus:bg-warm-gray-100 transition-colors text-warm-gray-900 placeholder-warm-gray-400">
                            <div
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-warm-gray-400 group-focus-within:text-amber-accent-500 transition-colors pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Row 2: Categories & Filters --}}
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-warm-gray-100">

                    {{-- Horizontal Categories --}}
                    <div
                        class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 flex-grow">
                        <a href="{{ route('shop.index', request()->except('category')) }}"
                            class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-all {{ !request('category') ? 'bg-warm-gray-900 text-white shadow-md' : 'bg-white text-warm-gray-600 border border-warm-gray-200 hover:border-warm-gray-300 hover:bg-warm-gray-50' }}">
                            All
                        </a>

                        @foreach($categories as $category)
                            <a href="{{ route('shop.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                                class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-all {{ request('category') == $category->slug ? 'bg-warm-gray-900 text-white shadow-md' : 'bg-white text-warm-gray-600 border border-warm-gray-200 hover:border-warm-gray-300 hover:bg-warm-gray-50' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Sort --}}
                    <div class="flex-shrink-0 relative group flex items-center gap-2">
                        <span class="text-sm font-medium text-warm-gray-500">Sort by</span>
                        <div class="relative">
                            <select name="sort" onchange="window.location.href=this.value"
                                class="appearance-none bg-transparent border-none text-warm-gray-900 font-semibold pr-8 py-0 focus:ring-0 cursor-pointer text-sm">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" {{ request('sort') == 'default' ? 'selected' : '' }}>Relevance</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center text-warm-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" size="default" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warm-gray-50 mb-6">
                        <svg class="w-8 h-8 text-warm-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-warm-gray-900 mb-2">No products found</h3>
                    <p class="text-warm-gray-500 mb-8 max-w-md mx-auto">We couldn't find any products matching your current
                        filters. Try checking your spelling or using different keywords.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary rounded-full px-8">
                        Clear All Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection