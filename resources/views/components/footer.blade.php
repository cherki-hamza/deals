{{-- Footer Component --}}
<footer class="bg-warm-gray-50 border-t border-warm-gray-100">
    {{-- Main Footer --}}
    <div class="container-main py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            {{-- Brand Column --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-amber-accent-400 to-amber-accent-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-warm-gray-900 font-heading">{{ config('app.name') }}</span>
                </a>
                <p class="text-warm-gray-500 text-sm leading-relaxed mb-4">
                    Your trusted source for product reviews and recommendations. We help you find the best products at
                    the best prices.
                </p>
                {{-- Social Links --}}
                <div class="flex items-center gap-3">
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-warm-gray-100 hover:bg-amber-accent-100 flex items-center justify-center text-warm-gray-500 hover:text-amber-accent-600 transition-colors"
                        aria-label="Twitter">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                            </path>
                        </svg>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-warm-gray-100 hover:bg-amber-accent-100 flex items-center justify-center text-warm-gray-500 hover:text-amber-accent-600 transition-colors"
                        aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-warm-gray-100 hover:bg-amber-accent-100 flex items-center justify-center text-warm-gray-500 hover:text-amber-accent-600 transition-colors"
                        aria-label="Pinterest">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Categories Column --}}
            <div>
                <h3 class="font-semibold text-warm-gray-900 mb-4">Categories</h3>
                <ul class="space-y-3">
                    @php
                        $footerCategories = \App\Models\Category::active()->ordered()->take(5)->get();
                    @endphp
                    @foreach($footerCategories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Quick Links Column --}}
            <div>
                <h3 class="font-semibold text-warm-gray-900 mb-4">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('deals.index') }}"
                            class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                            Today's Deals
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.about') }}"
                            class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.contact') }}"
                            class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal Column --}}
            <div>
                <h3 class="font-semibold text-warm-gray-900 mb-4">Legal</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('pages.disclosure') }}"
                            class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                            Affiliate Disclosure
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.privacy') }}"
                            class="text-warm-gray-500 hover:text-amber-accent-600 text-sm transition-colors">
                            Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="border-t border-warm-gray-200">
        <div class="container-main py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-warm-gray-500 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>

                {{-- Amazon Affiliate Disclosure --}}
                <div class="flex items-center gap-2 text-xs text-warm-gray-400">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>As an Amazon Associate, we earn from qualifying purchases.</span>
                </div>
            </div>
        </div>
    </div>
</footer>