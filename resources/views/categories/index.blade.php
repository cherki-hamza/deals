@extends('layouts.app')

@section('title', 'All Categories - ' . config('app.name'))
@section('meta_description', 'Browse all product categories. Find the best deals and recommendations in each category.')

@section('content')
    {{-- Page Header --}}
    <section class="bg-gradient-to-br from-warm-gray-50 to-amber-accent-50/30 py-12 lg:py-16">
        <div class="container-main">
            <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900">
                All Categories
            </h1>
            <p class="mt-3 text-lg text-warm-gray-600">
                Browse our curated collection of product categories
            </p>
        </div>
    </section>

    {{-- Categories Grid --}}
    <section class="section bg-white">
        <div class="container-main">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    @include('components.category-card', ['category' => $category, 'size' => 'large'])
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-warm-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <p class="text-warm-gray-500">No categories found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection