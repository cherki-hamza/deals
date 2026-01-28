<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', config('app.name') . ' - Best Deals & Product Reviews')</title>
    <meta name="description"
        content="@yield('meta_description', 'Discover the best products and deals. Expert reviews and recommendations to help you make smart purchasing decisions.')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Discover the best products and deals.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover the best products and deals.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Fonts are loaded via CSS --}}

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Additional Head Content --}}
    @stack('head')
</head>

<body class="min-h-screen flex flex-col pb-20 lg:pb-0" x-data="{ mobileMenuOpen: false }">
    {{-- Affiliate Disclosure Banner (optional) --}}
    @if(config('app.show_disclosure_banner', false))
        <div class="bg-amber-accent-50 border-b border-amber-accent-100 py-2">
            <div class="container-main text-center text-sm text-warm-gray-600">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    As an Amazon Associate, we earn from qualifying purchases. <a href="{{ route('pages.disclosure') }}"
                        class="underline hover:text-amber-accent-600">Learn more</a>
                </span>
            </div>
        </div>
    @endif

    {{-- Header --}}
    @include('components.header')

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Bottom Nav (Mobile) --}}
    @include('components.bottom-nav')

    {{-- Floating Compare Indicator --}}
    <div x-data x-show="$store.compare.count > 0" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0" class="fixed bottom-20 lg:bottom-8 right-4 lg:right-8 z-50">
        <a href="{{ route('compare.index') }}"
            class="flex items-center gap-3 bg-warm-gray-900 text-white pl-4 pr-2 py-3 rounded-full shadow-lg hover:bg-black transition-colors">
            <span class="font-medium text-sm">Compare</span>
            <span
                class="bg-amber-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center"
                x-text="$store.compare.count">0</span>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Schema.org Markup --}}
    @stack('schema')

    {{-- Additional Scripts --}}
    @stack('scripts')
</body>

</html>