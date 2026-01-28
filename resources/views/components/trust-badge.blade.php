{{-- Trust Badge Component --}}
@props([
    'variant' => 'inline', // inline, card
])

@if($variant === 'card')
<div class="bg-warm-gray-50 rounded-2xl p-6 text-center">
    <div class="w-12 h-12 mx-auto bg-amber-accent-100 rounded-full flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-amber-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
    </div>
    <h3 class="font-semibold text-warm-gray-900 mb-2">Amazon Affiliate</h3>
    <p class="text-sm text-warm-gray-500 leading-relaxed">
        As an Amazon Associate, we earn from qualifying purchases. This helps support our site at no extra cost to you.
    </p>
    <a href="{{ route('pages.disclosure') }}" class="inline-flex items-center gap-1 mt-3 text-sm text-amber-accent-600 hover:text-amber-accent-700 font-medium">
        Learn more
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </a>
</div>
@else
<div class="flex items-start gap-3 p-4 bg-warm-gray-50 rounded-xl">
    <div class="flex-shrink-0">
        <svg class="w-5 h-5 text-amber-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm text-warm-gray-600">
            <strong class="text-warm-gray-700">Affiliate Disclosure:</strong> 
            As an Amazon Associate, we earn from qualifying purchases. 
            <a href="{{ route('pages.disclosure') }}" class="text-amber-accent-600 hover:text-amber-accent-700 font-medium">Learn more</a>
        </p>
    </div>
</div>
@endif
