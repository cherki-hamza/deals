{{-- Product Card Component --}}
@props([
    'product',
    'showCategory' => true,
    'size' => 'default' // default, small, large
])

@php
    $sizeClasses = [
        'small' => 'max-w-xs',
        'default' => '',
        'large' => 'md:flex md:gap-6',
    ];
    $imageClasses = [
        'small' => 'aspect-square',
        'default' => 'aspect-product',
        'large' => 'md:w-72 md:flex-shrink-0 aspect-product md:aspect-square',
    ];
@endphp

<article class="product-card group {{ $sizeClasses[$size] ?? '' }}">
    {{-- Product Image --}}
    {{-- Product Image Container --}}
    <div class="relative block overflow-hidden {{ $size === 'large' ? 'md:rounded-2xl' : 'rounded-t-2xl' }}">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full group">
            <div class="relative {{ $imageClasses[$size] ?? 'aspect-product' }}">
                @if($product->images_array && count($product->images_array) > 0)
                    <img 
                        src="{{ Voyager::image($product->images_array[0]) }}" 
                        alt="{{ $product->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    >
                @else
                    <div class="w-full h-full bg-warm-gray-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-warm-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </a>
            
        {{-- Compare Button --}}
        <button @click.prevent="$store.compare.toggle({{ $product->id }})" 
            class="absolute top-2 right-2 z-20 w-9 h-9 rounded-full flex items-center justify-center transition-all bg-white shadow-md border border-gray-200 text-gray-600 hover:text-amber-600 hover:border-amber-200"
            :class="$store.compare.has({{ $product->id }}) ? '!bg-amber-500 !text-white !border-amber-500' : ''"
            title="Compare Product">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {{-- Arrow right/left icon --}}
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
        </button>

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-2 pointer-events-none z-10">
            @if($product->featured)
                <span class="badge badge-featured">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Featured
                </span>
            @endif
            @if($product->discount_text)
                <span class="badge badge-deal">
                    {{ $product->discount_text }}
                </span>
            @endif
        </div>
    </div>
    
    {{-- Product Info --}}
    <div class="product-card-body {{ $size === 'large' ? 'flex flex-col justify-center' : '' }}">
        {{-- Category --}}
        @if($showCategory && $product->category)
            <a href="{{ route('categories.show', $product->category->slug) }}" class="text-xs text-amber-accent-600 font-medium uppercase tracking-wide hover:text-amber-accent-700 transition-colors">
                {{ $product->category->name }}
            </a>
        @endif
        
        {{-- Title --}}
        <h3 class="mt-2 font-semibold text-warm-gray-900 {{ $size === 'large' ? 'text-xl' : 'text-base' }} line-clamp-2 group-hover:text-amber-accent-600 transition-colors">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ $product->title }}
            </a>
        </h3>
        
        {{-- Short Description (only for large) --}}
        @if($size === 'large' && $product->short_description)
            <p class="mt-2 text-warm-gray-500 text-sm line-clamp-2">
                {{ $product->short_description }}
            </p>
        @endif
        
        {{-- Price --}}
        @if($product->price_text)
            <div class="mt-3 flex items-center gap-2">
                <span class="price-text">{{ $product->price_text }}</span>
                @if($product->original_price_text)
                    <span class="text-sm text-warm-gray-400 line-through">{{ $product->original_price_text }}</span>
                @endif
            </div>
        @endif
        
        {{-- CTA Button --}}
        <div class="mt-4">
            <a 
                href="{{ $product->amazon_affiliate_url }}" 
                target="_blank" 
                rel="nofollow sponsored noopener"
                class="btn btn-primary w-full text-sm"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                View on Amazon
            </a>
        </div>
    </div>
</article>
