@extends('layouts.app')

@section('title', "Today's Best Deals - " . config('app.name'))
@section('meta_description', 'Discover the best deals and limited-time offers. Save big on top products with our curated deal selections.')

@section('content')
    {{-- Page Header --}}
    <section class="bg-gradient-to-br from-red-50 to-amber-accent-50/30 py-12 lg:py-16">
        <div class="container-main">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900">
                        Today's Best Deals
                    </h1>
                </div>
            </div>
            <p class="text-lg text-warm-gray-600 max-w-2xl">
                Hot deals and limited-time offers updated daily. Don't miss out on these savings!
            </p>
        </div>
    </section>

    {{-- Active Collections/Deals --}}
    @if($deals->count() > 0)
        <section class="section bg-white">
            <div class="container-main">
                <div class="space-y-8">
                    @foreach($deals as $deal)
                        <div class="bg-warm-gray-50 rounded-3xl overflow-hidden">
                            @include('components.deal-banner', ['deal' => $deal])

                            @if($deal->publishedProducts->count() > 0)
                                <div class="p-6 lg:p-8">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                        @foreach($deal->publishedProducts->take(4) as $product)
                                            @include('components.product-card', ['product' => $product])
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Deal of the Day Products --}}
    @if($dealOfTheDayProducts->count() > 0)
        <section class="section bg-warm-gray-50">
            <div class="container-main">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-amber-accent-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-accent-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="section-heading mb-0">Deal of the Day</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($dealOfTheDayProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- All Discounted Products --}}
    @if($discountedProducts->count() > 0)
        <section class="section bg-white">
            <div class="container-main">
                <h2 class="section-heading mb-8">More Deals</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($discountedProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>

                @if($discountedProducts->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $discountedProducts->links() }}
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Empty State --}}
    @if($deals->count() === 0 && $dealOfTheDayProducts->count() === 0 && $discountedProducts->count() === 0)
        <section class="section bg-white">
            <div class="container-main text-center py-16">
                <svg class="w-24 h-24 mx-auto text-warm-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                <h2 class="text-2xl font-bold text-warm-gray-900 mb-2">No Active Deals</h2>
                <p class="text-warm-gray-500 max-w-md mx-auto">
                    Check back soon! We're constantly updating our deals with the best offers.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-6">
                    Browse All Products
                </a>
            </div>
        </section>
    @endif
@endsection