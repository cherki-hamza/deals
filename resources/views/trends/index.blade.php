@extends('layouts.app')

@section('title', 'Trending Now - Top Viral Products')
@section('description', 'Discover the hottest products trending right now.')

@section('content')
    <div class="bg-warm-gray-50 min-h-screen pt-8 pb-16">
        <div class="container-main">

            {{-- Header --}}
            <div class="text-center mb-12">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-red-100 text-red-600 text-sm font-bold mb-4 animate-pulse">
                    🔥 Trending Now
                </span>
                <h1 class="text-4xl md:text-5xl font-bold font-heading text-warm-gray-900 mb-4">
                    What everyone's buying
                </h1>
                <p class="text-lg text-warm-gray-600 max-w-2xl mx-auto">
                    The most viral, loved, and talked-about products of the week. Updated hourly.
                </p>
            </div>

            {{-- Product Grid - 4 per row on desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $index => $product)
                    @php
                        $type = 'image';
                        if ($product->video_url) {
                            $type = 'video';
                        } elseif (count($product->images_array) > 1) {
                            $type = 'slider';
                        }
                    @endphp

                    <div class="break-inside-avoid">
                        <div
                            class="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 group relative">

                            {{-- Media Container --}}
                            <div class="relative aspect-[4/5] overflow-hidden bg-gray-100">

                                @if($type == 'slider')
                                    {{-- Slider Type --}}
                                    <div x-data="{ active: 0, images: {{ json_encode($product->images_array) }} }"
                                        class="h-full w-full relative">
                                        <template x-for="(image, i) in images" :key="i">
                                            <img :src="'/storage/' + image"
                                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                                                :class="{ 'opacity-100': active === i, 'opacity-0': active !== i }"
                                                alt="{{ $product->title }}">
                                        </template>

                                        {{-- Slider Indicators --}}
                                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-1.5 z-10">
                                            <template x-for="(image, i) in images">
                                                <button @click.stop="active = i" class="w-1.5 h-1.5 rounded-full transition-all"
                                                    :class="active === i ? 'bg-white w-3' : 'bg-white/50 hover:bg-white/80'"></button>
                                            </template>
                                        </div>

                                        {{-- Auto slide on hover --}}
                                        <div class="absolute inset-0 z-0"
                                            @mouseenter="interval = setInterval(() => { active = (active + 1) % images.length }, 1500)"
                                            @mouseleave="clearInterval(interval)"></div>

                                        <div
                                            class="absolute top-3 left-3 bg-black/50 backdrop-blur-md text-white text-xs font-bold px-2 py-1 rounded-lg z-20">
                                            <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Gallery
                                        </div>
                                    </div>

                                @elseif($type == 'video')
                                    {{-- Video Type --}}
                                    <div class="h-full w-full relative group">
                                        @if(Str::contains($product->video_url, ['youtube.com', 'youtu.be']))
                                            {{-- YouTube Embed --}}
                                            @php
                                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $product->video_url, $matches);
                                                $videoId = $matches[1] ?? null;
                                            @endphp
                                            @if($videoId)
                                                <iframe 
                                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=0&controls=0&mute=1&loop=1&playlist={{ $videoId }}" 
                                                    class="w-full h-full object-cover pointer-events-none" 
                                                    frameborder="0" 
                                                    allow="autoplay; encrypted-media"
                                                ></iframe>
                                            @else
                                                <img src="{{ Voyager::image($product->images_array[0] ?? '') }}" class="w-full h-full object-cover">
                                            @endif
                                        @else
                                            {{-- Direct Video File --}}
                                            <video 
                                                src="{{ $product->video_url }}" 
                                                class="w-full h-full object-cover" 
                                                muted 
                                                loop 
                                                playsinline
                                                onmouseover="this.play()" 
                                                onmouseout="this.pause(); this.currentTime = 0;"
                                                poster="{{ Voyager::image($product->images_array[0] ?? '') }}"
                                            ></video>
                                        @endif

                                        <div class="absolute inset-0 pointer-events-none bg-black/10 flex items-center justify-center group-hover:opacity-0 transition-opacity">
                                            <div class="w-12 h-12 rounded-full bg-white/90 text-amber-500 flex items-center justify-center pl-1 shadow-lg">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                        <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-lg animate-pulse z-10">
                                            VIDEO
                                        </div>
                                    </div>

                                @else
                                    {{-- Standard Image --}}
                                    <img src="{{ Voyager::image($product->images_array[0] ?? '') }}" alt="{{ $product->title }}"
                                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                @endif

                                {{-- Compare Button --}}
                                <button @click.prevent="$store.compare.toggle({{ $product->id }})" 
                                    class="absolute top-3 right-3 z-30 w-9 h-9 rounded-full flex items-center justify-center transition-all bg-white shadow-md border border-gray-200 text-gray-600 hover:text-amber-600 hover:border-amber-200"
                                    :class="$store.compare.has({{ $product->id }}) ? '!bg-amber-500 !text-white !border-amber-500' : ''"
                                    title="Compare Product">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </button>

                                {{-- Badges --}}
                                @if($product->discount_text)
                                    <div
                                        class="absolute top-14 right-3 bg-amber-400 text-white text-xs font-bold px-2 py-1 rounded-lg z-20">
                                        {{ $product->discount_text }}
                                    </div>
                                @endif

                                {{-- Quick Add / Action Overlay --}}
                                <div
                                    class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-between">
                                    <p class="text-white font-bold">{{ $product->price_text }}</p>
                                    <a href="{{ $product->amazon_affiliate_url }}" target="_blank"
                                        class="bg-white text-warm-gray-900 text-xs font-bold px-3 py-1.5 rounded-full hover:bg-amber-400 transition-colors">
                                        Buy Now
                                    </a>
                                </div>
                            </div>

                            {{-- Content Info --}}
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($product->category)
                                        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
                                            class="text-xs font-medium text-amber-600 hover:text-amber-700 uppercase tracking-wider">
                                            {{ $product->category->name }}
                                        </a>
                                    @else
                                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">No Category</span>
                                    @endif
                                    <span class="text-warm-gray-300">•</span>
                                    <span class="text-xs text-warm-gray-500 font-medium flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        4.{{ rand(5, 9) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-warm-gray-900 leading-tight mb-2">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="hover:text-amber-600 transition-colors">
                                        {{ $product->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-2 mt-4">
                                    <div class="flex -space-x-2 overflow-hidden">
                                        @for($i = 0; $i < 3; $i++)
                                            <div
                                                class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-gray-200 flex items-center justify-center text-[10px] text-gray-500 font-bold overflow-hidden">
                                                <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=random" alt="">
                                            </div>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-warm-gray-500 font-medium">+{{ rand(12, 85) }} others bought
                                        this</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16 flex justify-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection