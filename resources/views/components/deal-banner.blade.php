{{-- Deal Banner Component --}}
@props([
    'deal',
    'size' => 'default' // default, large, hero
])

@php
    $sizeClasses = [
        'default' => 'py-8 px-6 lg:py-12 lg:px-10',
        'large' => 'py-12 px-8 lg:py-16 lg:px-12',
        'hero' => 'py-16 px-8 lg:py-24 lg:px-16',
    ];
@endphp

<div class="deal-banner {{ $sizeClasses[$size] ?? $sizeClasses['default'] }} relative overflow-hidden">
    {{-- Background Image --}}
    @if($deal->banner_image)
        <div class="absolute inset-0">
            <img 
                src="{{ Voyager::image($deal->banner_image) }}" 
                alt="{{ $deal->title }}"
                class="w-full h-full object-cover"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-amber-accent-900/80 to-amber-accent-800/60"></div>
        </div>
    @endif
    
    {{-- Content --}}
    <div class="relative z-10 {{ $deal->banner_image ? 'text-white' : 'text-warm-gray-900' }}">
        {{-- Badge --}}
        @if($deal->end_date)
            <div class="inline-flex items-center gap-2 mb-4 px-3 py-1 rounded-full {{ $deal->banner_image ? 'bg-white/20' : 'bg-amber-accent-100' }} text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Limited Time Offer
            </div>
        @endif
        
        {{-- Title --}}
        <h2 class="font-heading font-bold {{ $size === 'hero' ? 'text-3xl lg:text-5xl' : ($size === 'large' ? 'text-2xl lg:text-4xl' : 'text-xl lg:text-3xl') }} max-w-xl">
            {{ $deal->title }}
        </h2>
        
        {{-- Description --}}
        @if($deal->description)
            <p class="mt-4 {{ $deal->banner_image ? 'text-white/90' : 'text-warm-gray-600' }} max-w-lg {{ $size === 'hero' ? 'text-lg' : 'text-base' }}">
                {{ Str::limit(strip_tags($deal->description), 150) }}
            </p>
        @endif
        
        {{-- Countdown Placeholder --}}
        @if($deal->end_date && $deal->remaining_seconds > 0)
            <div class="mt-6 flex items-center gap-4" x-data="countdown()" x-init="init({{ $deal->remaining_seconds }})">
                <div class="text-center">
                    <span class="block text-2xl lg:text-3xl font-bold" x-text="days">00</span>
                    <span class="text-xs {{ $deal->banner_image ? 'text-white/70' : 'text-warm-gray-500' }}">Days</span>
                </div>
                <span class="text-xl font-bold">:</span>
                <div class="text-center">
                    <span class="block text-2xl lg:text-3xl font-bold" x-text="hours">00</span>
                    <span class="text-xs {{ $deal->banner_image ? 'text-white/70' : 'text-warm-gray-500' }}">Hours</span>
                </div>
                <span class="text-xl font-bold">:</span>
                <div class="text-center">
                    <span class="block text-2xl lg:text-3xl font-bold" x-text="minutes">00</span>
                    <span class="text-xs {{ $deal->banner_image ? 'text-white/70' : 'text-warm-gray-500' }}">Mins</span>
                </div>
                <span class="text-xl font-bold">:</span>
                <div class="text-center">
                    <span class="block text-2xl lg:text-3xl font-bold" x-text="seconds">00</span>
                    <span class="text-xs {{ $deal->banner_image ? 'text-white/70' : 'text-warm-gray-500' }}">Secs</span>
                </div>
            </div>
        @endif
        
        {{-- CTA Button --}}
        <div class="mt-6">
            <a 
                href="{{ route('deals.show', $deal->slug) }}" 
                class="btn {{ $deal->banner_image ? 'bg-white text-amber-accent-600 hover:bg-amber-accent-50' : 'btn-primary' }}"
            >
                View All Deals
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
    
    {{-- Decorative Elements --}}
    @if(!$deal->banner_image)
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-accent-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-amber-accent-100/70 rounded-full blur-2xl"></div>
    @endif
</div>
