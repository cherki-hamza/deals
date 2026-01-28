{{-- Category Card Component --}}
@props([
    'category',
    'showCount' => true,
    'size' => 'default' // default, small, large
])

@php
    $sizeClasses = [
        'small' => 'p-4',
        'default' => 'p-6',
        'large' => 'p-8',
    ];
    $iconSizes = [
        'small' => 'w-10 h-10',
        'default' => 'w-14 h-14',
        'large' => 'w-16 h-16',
    ];
@endphp

<a href="{{ route('categories.show', $category->slug) }}" class="category-card group {{ $sizeClasses[$size] ?? 'p-6' }}">
    {{-- Category Icon/Image --}}
    <div class="mb-4 flex justify-center">
        @if($category->image)
            <div class="{{ $iconSizes[$size] ?? 'w-14 h-14' }} rounded-2xl overflow-hidden">
                <img 
                    src="{{ Voyager::image($category->image) }}" 
                    alt="{{ $category->name }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>
        @else
            <div class="{{ $iconSizes[$size] ?? 'w-14 h-14' }} rounded-2xl bg-gradient-to-br from-amber-accent-100 to-amber-accent-50 flex items-center justify-center group-hover:from-amber-accent-200 group-hover:to-amber-accent-100 transition-colors">
                @if($category->icon)
                    <span class="text-2xl">{{ $category->icon }}</span>
                @else
                    <svg class="w-7 h-7 text-amber-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                @endif
            </div>
        @endif
    </div>
    
    {{-- Category Name --}}
    <h3 class="font-semibold text-warm-gray-900 text-center group-hover:text-amber-accent-600 transition-colors">
        {{ $category->name }}
    </h3>
    
    {{-- Product Count --}}
    @if($showCount)
        <p class="mt-1 text-sm text-warm-gray-400 text-center">
            {{ $category->products_count ?? $category->publishedProducts()->count() }} products
        </p>
    @endif
    
    {{-- Description (for large size) --}}
    @if($size === 'large' && $category->description)
        <p class="mt-3 text-sm text-warm-gray-500 text-center line-clamp-2">
            {{ $category->description }}
        </p>
    @endif
</a>
