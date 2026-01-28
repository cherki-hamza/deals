@extends('layouts.app')

@section('title', $product->seo_title_display . ' - ' . config('app.name'))
@section('meta_description', $product->seo_description_display)
@section('og_type', 'product')
@section('og_title', $product->title)
@section('og_description', $product->short_description)
@if($product->images_array && count($product->images_array) > 0)
@section('og_image', Voyager::image($product->images_array[0]))
@endif

@section('content')
    {{-- Breadcrumb --}}
    <section class="bg-warm-gray-50 py-2 lg:py-4 border-b border-warm-gray-100">
        <div class="container-main">
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-warm-gray-500 hover:text-warm-gray-700">Home</a></li>
                    <li class="text-warm-gray-400">/</li>
                    @if($product->category)
                        <li><a href="{{ route('categories.show', $product->category->slug) }}"
                                class="text-warm-gray-500 hover:text-warm-gray-700">{{ $product->category->name }}</a></li>
                        <li class="text-warm-gray-400">/</li>
                    @endif
                    <li class="text-warm-gray-900 font-medium line-clamp-1">{{ $product->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- Product Details --}}
    <section class="py-4 lg:py-16 bg-white">
        <div class="container-main">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-12">
                {{-- Mobile Title --}}
                <div class="lg:hidden">
                    <h1 class="text-xl lg:text-2xl font-bold font-heading text-warm-gray-900 mb-1 leading-tight">
                        {{ $product->title }}
                    </h1>
                    @if($product->category)
                        <a href="{{ route('categories.show', $product->category->slug) }}"
                            class="text-xs text-amber-accent-600 font-medium uppercase tracking-wide block mb-2">
                            {{ $product->category->name }}
                        </a>
                    @endif

                    <a href="{{ $product->amazon_affiliate_url }}" target="_blank" rel="nofollow sponsored noopener"
                        class="inline-flex items-center text-xs font-bold rounded-lg px-3 py-1.5 shadow-sm transition-all mb-3"
                        style="background: linear-gradient(to right, var(--color-amber-accent-400), var(--color-amber-accent-500)); color: #fff;">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        View on Amazon
                    </a>
                </div>

                {{-- Product Gallery --}}
                <div x-data="{ 
                                                activeMedia: 0, 
                                                media: [
                                                    @if($product->images_array)
                                                        @foreach($product->images_array as $image)
                                                            { 
                                                                type: 'image', 
                                                                url: '{{ Voyager::image($image) }}' 
                                                            },
                                                        @endforeach
                                                    @endif
                                                    @if($product->video_url)
                                                        { 
                                                            type: 'video', 
                                                            url: '{{ $product->video_url }}', 
                                                            thumb: '{{ isset($product->images_array[0]) ? Voyager::image($product->images_array[0]) : '' }}' 
                                                        },
                                                    @endif
                                                ]
                                            }">
                    {{-- Main View --}}
                    <div class="aspect-square rounded-3xl overflow-hidden bg-warm-gray-100 mb-4 relative z-0"
                        style="margin-top: -15px;">
                        <template x-for="(item, index) in media" :key="index">
                            <div x-show="activeMedia === index" class="w-full h-full"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100">

                                <template x-if="item.type === 'image'">
                                    <img :src="item.url" :alt="'{{ $product->title }}'" class="w-full h-full object-cover">
                                </template>

                                <template x-if="item.type === 'video'">
                                    <div class="w-full h-full bg-black">
                                        <template x-if="item.url.includes('youtube') || item.url.includes('youtu.be')">
                                            <iframe
                                                :src="'https://www.youtube.com/embed/' + (item.url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/\s]{11})/) ? item.url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/\s]{11})/)[1] : '') + '?autoplay=0&mute=0&controls=1'"
                                                class="w-full h-full" frameborder="0" allow="autoplay; encrypted-media"
                                                allowfullscreen></iframe>
                                        </template>

                                        <template x-if="!item.url.includes('youtube') && !item.url.includes('youtu.be')">
                                            <video :src="item.url" class="w-full h-full object-contain" controls playsinline
                                                :poster="item.thumb"></video>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="media.length === 0" class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-warm-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide" x-show="media.length > 1">
                        <template x-for="(item, index) in media" :key="index">
                            <button @click="activeMedia = index"
                                :class="activeMedia === index ? 'ring-2 ring-amber-accent-500' : 'ring-1 ring-warm-gray-200'"
                                class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden transition-all relative group">
                                <template x-if="item.type === 'image'">
                                    <img :src="item.url" class="w-full h-full object-cover">
                                </template>
                                <template x-if="item.type === 'video'">
                                    <div class="w-full h-full bg-gray-900 flex items-center justify-center relative">
                                        <img x-show="item.thumb" :src="item.thumb"
                                            class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 transition-opacity">
                                        <div
                                            class="w-8 h-8 rounded-full bg-white/90 text-amber-500 flex items-center justify-center pl-0.5 shadow-md z-10">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Product Info --}}
                <div>
                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($product->featured)
                            <span class="badge badge-featured">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                Featured
                            </span>
                        @endif
                        @if($product->discount_text)
                            <span class="badge badge-deal">{{ $product->discount_text }}</span>
                        @endif
                    </div>



                        {{-- Category --}}
                        @if($product->category)
                            <a href="{{ route('categories.show', $product->category->slug) }}"
                                class="hidden lg:block text-sm text-amber-accent-600 hover:text-amber-accent-700 font-medium uppercase tracking-wide">
                                {{ $product->category->name }}
                            </a>
                        @endif

                        {{-- Title --}}
                        <h1 class="hidden lg:block mt-2 text-2xl lg:text-3xl font-bold font-heading text-warm-gray-900">
                            {{ $product->title }}
                        </h1>

                        {{-- Short Description --}}
                        @if($product->short_description)
                            <p class="mt-4 text-warm-gray-600 leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        @endif

                        {{-- Price --}}
                        @if($product->price_text)
                            <div class="mt-6 flex items-baseline gap-3">
                                <span class="text-3xl font-bold text-warm-gray-900">{{ $product->price_text }}</span>
                                @if($product->original_price_text)
                                    <span class="text-lg text-warm-gray-400 line-through">{{ $product->original_price_text }}</span>
                                @endif
                                @if($product->discount_text)
                                    <span class="text-sm font-medium text-red-600">{{ $product->discount_text }}</span>
                                @endif
                            </div>
                        @endif

                        {{-- CTA Button --}}
                        <div class="mt-8">
                            <a href="{{ $product->amazon_affiliate_url }}" target="_blank" rel="nofollow sponsored noopener"
                                class="btn btn-amazon text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                View on Amazon
                            </a>
                        </div>

                        {{-- Trust Badge --}}
                        <div class="mt-6">
                            @include('components.trust-badge')
                        </div>

                        {{-- Highlights --}}
                        @if($product->highlights_array && count($product->highlights_array) > 0)
                            <div class="mt-8 pt-8 border-t border-warm-gray-100">
                                <h2 class="font-semibold text-warm-gray-900 mb-4">Key Features</h2>
                                <ul class="space-y-3">
                                    @foreach($product->highlights_array as $highlight)
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-warm-gray-600">{{ $highlight }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Full Description --}}
                @if($product->full_description)
                    <div class="mt-16 pt-12 border-t border-warm-gray-100">
                        <h2 class="text-xl font-bold text-warm-gray-900 mb-6">Product Description</h2>
                        <div class="prose prose-warm-gray max-w-none">
                            {!! $product->full_description !!}
                        </div>
                    </div>
                @endif

                {{-- Customer Reviews (Fake/Generated) --}}
                <div class="mt-12 pt-12 border-t border-warm-gray-100">
                    <h2 class="text-xl font-bold text-warm-gray-900 mb-6 flex items-center gap-3">
                        Customer Reviews
                        <span class="text-sm font-normal text-warm-gray-500 bg-warm-gray-100 px-2 py-0.5 rounded-full">
                            {{ rand(120, 500) }} ratings
                        </span>
                    </h2>

                    {{-- Summary --}}
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 0; $i < 5; $i++) <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg> @endfor
                        </div>
                        <span class="text-2xl font-bold text-warm-gray-900">4.{{ rand(7, 9) }}</span>
                        <span class="text-warm-gray-500">out of 5</span>
                    </div>

                    {{-- Review List --}}
                    <div class="space-y-8">
                        @php
                            $fakeReviews = [
                                ['name' => 'Sarah M.', 'title' => 'Absolutely love it!', 'text' => 'Arrived faster than expected and works perfectly. Really happy with the quality.'],
                                ['name' => 'John D.', 'title' => 'Great value', 'text' => 'For the price, you cannot beat this. I have been using it daily for a week now.'],
                                ['name' => 'Emily R.', 'title' => 'Exactly as described', 'text' => 'Matches the description perfectly. The materials feel premium and durable.'],
                                ['name' => 'Michael B.', 'title' => 'Highly recommended', 'text' => 'I was on the fence about buying this but I am glad I did. It is a game changer.'],
                                ['name' => 'Jessica T.', 'title' => 'Five stars', 'text' => 'Excellent customer service and a fantastic product. Will definitely buy again.'],
                                ['name' => 'David K.', 'title' => 'Solid purchase', 'text' => 'Does exactly what it says on the tin. Very satisfied.'],
                                ['name' => 'Amanda L.', 'title' => 'Beautiful design', 'text' => 'It looks even better in person than in the photos. Very sleek.'],
                                ['name' => 'Chris P.', 'title' => 'Fast shipping', 'text' => 'Packaging was secure and shipping was super fast. A+ seller.'],
                            ];
                            $selectedReviews = collect($fakeReviews)->shuffle()->take(3);
                        @endphp

                        @foreach($selectedReviews as $review)
                            <div class="flex gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review['name']) }}&background=random&color=fff&size=48"
                                    class="w-10 h-10 rounded-full" alt="{{ $review['name'] }}">
                                <div>
                                    <h4 class="font-bold text-warm-gray-900 text-sm">{{ $review['name'] }}</h4>
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="flex text-amber-400 text-xs">
                                            @for($i = 0; $i < 5; $i++) <svg class="w-3.5 h-3.5 fill-current"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg> @endfor
                                        </div>
                                        <span
                                            class="text-xs text-warm-gray-500 font-bold max-w-[200px] line-clamp-1">{{ $review['title'] }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400 block mb-2">Verified Purchase • Reviewed
                                        {{ rand(2, 20) }}
                                        days ago</span>
                                    <p class="text-sm text-warm-gray-700 leading-relaxed">
                                        {{ $review['text'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        <button class="text-amber-600 font-medium text-sm hover:text-amber-700 hover:underline">
                            See all {{ rand(20, 50) }} reviews >
                        </button>
                    </div>
                </div>

                {{-- Mobile Sticky CTA --}}
                <div class="fixed bottom-16 left-0 right-0 p-4 z-[60] lg:hidden pointer-events-none">
                    <a href="{{ $product->amazon_affiliate_url }}" target="_blank" rel="nofollow sponsored noopener"
                        class="btn btn-amazon text-lg w-full shadow-xl shadow-amber-500/20 flex items-center justify-center pointer-events-auto animate-bounce-subtle">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View on Amazon
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Products --}}
                @if($relatedProducts->count() > 0)
                    <section class="section bg-warm-gray-50">
                        <div class="container-main">
                            <h2 class="section-heading mb-8">Related Products</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($relatedProducts as $relatedProduct)
                                    @include('components.product-card', ['product' => $relatedProduct])
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
@endsection

            @push('schema')
                <script type="application/ld+json">
                                                    {
                                                        "@context": "https://schema.org/",
                                                        "@type": "Product",
                                                        "name": "{{ $product->title }}",
                                                        "description": "{{ $product->short_description }}",
                                                        @if($product->images_array && count($product->images_array) > 0)
                                                            "image": [
                                                                @foreach($product->images_array as $image)
                                                                    "{{ Voyager::image($image) }}"@if(!$loop->last),@endif
                                                                @endforeach
                                                            ],
                                                        @endif
                                                        @if($product->price_text)
                                                            "offers": {
                                                                "@type": "Offer",
                                                                "url": "{{ $product->amazon_affiliate_url }}",
                                                                "priceCurrency": "USD",
                                                                "availability": "https://schema.org/InStock"
                                                            },
                                                        @endif
                                                        "brand": {
                                                            "@type": "Brand",
                                                            "name": "Amazon"
                                                        }
                                                    }
                                                    </script>
            @endpush