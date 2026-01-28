{{-- Hero Section Component --}}
@props([
    'title' => "Discover Today's Best Deals",
    'subtitle' => 'Expert-curated product recommendations to help you make smarter purchasing decisions.',
    'showSearch' => true,
    'backgroundImage' => null,
])

<section class="relative overflow-hidden bg-gradient-to-br from-warm-gray-50 to-amber-accent-50/30">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-30">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.05) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    {{-- Decorative Elements --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-accent-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-amber-accent-100/40 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    
    {{-- Content --}}
    <div class="container-main relative py-16 lg:py-24">
        <div class="max-w-3xl mx-auto text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-accent-100 text-amber-accent-700 text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Trusted by thousands of shoppers
            </div>
            
            {{-- Title --}}
            <h1 class="text-4xl lg:text-6xl font-bold font-heading text-warm-gray-900 leading-tight">
                {{ $title }}
            </h1>
            
            {{-- Subtitle --}}
            <p class="mt-6 text-lg lg:text-xl text-warm-gray-600 max-w-2xl mx-auto">
                {{ $subtitle }}
            </p>
            
            {{-- CTA Buttons --}}
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('deals.index') }}" class="btn btn-amazon">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Browse Deals
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Explore Categories
                </a>
            </div>
            
            {{-- Trust Indicators --}}
            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 lg:gap-10">
                <div class="flex items-center gap-2 text-warm-gray-500">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Expert Reviews</span>
                </div>
                <div class="flex items-center gap-2 text-warm-gray-500">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Updated Daily</span>
                </div>
                <div class="flex items-center gap-2 text-warm-gray-500">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Best Prices</span>
                </div>
            </div>
        </div>
    </div>
</section>
