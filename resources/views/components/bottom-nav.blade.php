<div
    class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] lg:hidden z-50">
    <div class="grid grid-cols-4 h-16">
        <a href="{{ route('home') }}"
            class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('home') ? 'text-amber-600' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        <a href="{{ route('shop.index') }}"
            class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('shop.*') ? 'text-amber-600' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span class="text-[10px] font-medium">Shop</span>
        </a>

        <a href="{{ route('trends.index') }}"
            class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('trends.*') ? 'text-amber-600' : 'text-gray-400 hover:text-gray-600' }}">
            <div class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                @if(request()->routeIs('trends.*'))
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                @endif
            </div>
            <span class="text-[10px] font-medium">Trends</span>
        </a>

        <a href="{{ route('categories.index') }}"
            class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('categories.*') ? 'text-amber-600' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Categories</span>
        </a>
    </div>
</div>