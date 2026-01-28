@extends('layouts.app')

@section('title', $deal->title . ' - ' . config('app.name'))
@section('meta_description', strip_tags($deal->description ?? 'View all products in this special deal collection'))

@section('content')
    {{-- Deal Header --}}
    <section class="bg-gradient-to-br from-red-50 to-amber-accent-50/30 py-12 lg:py-16">
        <div class="container-main">
            <div class="flex items-start gap-6">
                @if($deal->banner_image)
                    <div class="hidden md:block w-24 h-24 flex-shrink-0 rounded-2xl overflow-hidden bg-white shadow-lg">
                        <img src="{{ Voyager::image($deal->banner_image) }}" alt="{{ $deal->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold uppercase">
                            🔥 Hot Deal
                        </span>
                        @if($deal->end_date)
                            <span class="text-sm text-warm-gray-600">
                                Ends {{ $deal->end_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900 mb-4">
                        {{ $deal->title }}
                    </h1>

                    @if($deal->description)
                        <div class="prose prose-warm-gray max-w-none">
                            {!! $deal->description !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Deal Products --}}
    @if($deal->publishedProducts->count() > 0)
        <section class="section bg-white">
            <div class="container-main">
                <h2 class="section-heading mb-8">Products in this Deal</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($deal->publishedProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @else
        {{-- Empty State --}}
        <section class="section bg-white">
            <div class="container-main text-center py-16">
                <svg class="w-24 h-24 mx-auto text-warm-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                    </path>
                </svg>
                <h2 class="text-2xl font-bold text-warm-gray-900 mb-2">No Products Available</h2>
                <p class="text-warm-gray-500 max-w-md mx-auto">
                    This deal doesn't have any products yet. Check back soon!
                </p>
                <a href="{{ route('deals.index') }}" class="btn btn-primary mt-6">
                    Browse All Deals
                </a>
            </div>
        </section>
    @endif

    {{-- Related Deals --}}
    <section class="section bg-warm-gray-50">
        <div class="container-main">
            <div class="flex items-center justify-between mb-8">
                <h2 class="section-heading mb-0">More Deals</h2>
                <a href="{{ route('deals.index') }}"
                    class="text-amber-accent-600 hover:text-amber-accent-700 font-medium text-sm transition-colors">
                    View All →
                </a>
            </div>

            <div class="text-center text-warm-gray-500">
                <a href="{{ route('deals.index') }}" class="btn btn-secondary">
                    Explore All Deals
                </a>
            </div>
        </div>
    </section>
@endsection