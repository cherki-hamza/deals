@extends('layouts.app')

@section('title', config('app.name') . ' - Best Deals & Product Reviews')
@section('meta_description', 'Discover the best products and deals. Expert reviews and recommendations to help you make smart purchasing decisions.')

@section('content')
    {{-- Hero Section --}}
    @include('components.hero')

    {{-- Featured Categories --}}
    <section class="section bg-white">
        <div class="container-main">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="section-heading">Shop by Category</h2>
                    <p class="section-subheading">Browse our curated collection of product categories</p>
                </div>
                <a href="{{ route('categories.index') }}"
                    class="hidden sm:flex items-center gap-2 text-amber-accent-600 hover:text-amber-accent-700 font-medium">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    @include('components.category-card', ['category' => $category])
                @endforeach
            </div>

            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    View All Categories
                </a>
            </div>
        </div>
    </section>

    {{-- Deal of the Day --}}
    @if($dealOfTheDay)
        <section class="section bg-warm-gray-50">
            <div class="container-main">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="section-heading mb-0">Deal of the Day</h2>
                </div>

                @include('components.product-card', ['product' => $dealOfTheDay, 'size' => 'large'])
            </div>
        </section>
    @endif

    {{-- Featured Products --}}
    <section class="section bg-white">
        <div class="container-main">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="section-heading">Editor's Choice</h2>
                    <p class="section-subheading">Hand-picked products our team loves</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    {{-- Active Deal/Collection --}}
    @if($activeDeal)
        <section class="section bg-warm-gray-50">
            <div class="container-main">
                @include('components.deal-banner', ['deal' => $activeDeal, 'size' => 'large'])
            </div>
        </section>
    @endif

    {{-- Latest Products --}}
    <section class="section bg-white">
        <div class="container-main">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="section-heading">Latest Additions</h2>
                    <p class="section-subheading">Fresh finds added to our collection</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    {{-- Trust Section --}}
    <section class="py-12 bg-warm-gray-50 border-t border-warm-gray-100">
        <div class="container-main">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @include('components.trust-badge', ['variant' => 'card'])

                <div class="bg-warm-gray-50 rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-warm-gray-900 mb-2">Expert Reviews</h3>
                    <p class="text-sm text-warm-gray-500 leading-relaxed">
                        Our team thoroughly researches and tests products before recommending them to you.
                    </p>
                </div>

                <div class="bg-warm-gray-50 rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-warm-gray-900 mb-2">Updated Daily</h3>
                    <p class="text-sm text-warm-gray-500 leading-relaxed">
                        We keep our recommendations fresh with the latest deals and product updates.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection