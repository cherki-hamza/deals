{{-- Amazon CTA Button Component --}}
@props([
    'url',
    'text' => 'View on Amazon',
    'variant' => 'primary', // primary, secondary, outline
    'size' => 'default', // small, default, large
    'fullWidth' => false,
    'showIcon' => true,
])

@php
    $variantClasses = [
        'primary' => 'btn-amazon',
        'secondary' => 'btn-secondary',
        'outline' => 'border-2 border-amber-accent-500 text-amber-accent-600 hover:bg-amber-accent-50',
    ];
    $sizeClasses = [
        'small' => 'px-4 py-2 text-sm',
        'default' => 'px-6 py-3',
        'large' => 'px-8 py-4 text-lg',
    ];
@endphp

<a 
    href="{{ $url }}" 
    target="_blank" 
    rel="nofollow sponsored noopener"
    {{ $attributes->merge(['class' => 'btn ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['default']) . ($fullWidth ? ' w-full' : '')]) }}
>
    @if($showIcon)
        <svg class="w-5 h-5 {{ $text ? 'mr-2' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
        </svg>
    @endif
    {{ $text }}
</a>
