{{-- Header Component with Global Search and Notifications --}}
<header class="bg-white border-b border-warm-gray-100 sticky top-0 z-50" x-data="{ 
        searchOpen: false,
        notificationsOpen: false,
        notifications: [],
        unreadCount: 0,
        seenNotifications: JSON.parse(localStorage.getItem('seen_notifications') || '[]'),
        dismissedNotifications: JSON.parse(localStorage.getItem('dismissed_notifications') || '[]'),
        
        
        async fetchNotifications() {
            try {
                const response = await fetch('{{ route('api.notifications') }}');
                const data = await response.json();
                // Filter out dismissed notifications
                this.notifications = data.notifications.filter(n => !this.dismissedNotifications.includes(n.id));
                this.updateUnreadCount();
                console.log('Notifications fetched:', this.notifications.length, 'Unread:', this.unreadCount);
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },
        
        updateUnreadCount() {
            this.unreadCount = this.notifications.filter(n => !this.seenNotifications.includes(n.id)).length;
            console.log('Unread count updated:', this.unreadCount);
        },
        
        markAllAsSeen() {
            const allIds = this.notifications.map(n => n.id);
            this.seenNotifications = [...new Set([...this.seenNotifications, ...allIds])];
            localStorage.setItem('seen_notifications', JSON.stringify(this.seenNotifications));
            this.updateUnreadCount();
        },
        
        
        dismissNotification(id) {
            // Mark as seen
            this.seenNotifications = [...new Set([...this.seenNotifications, id])];
            localStorage.setItem('seen_notifications', JSON.stringify(this.seenNotifications));
            
            // Mark as dismissed
            this.dismissedNotifications = [...new Set([...this.dismissedNotifications, id])];
            localStorage.setItem('dismissed_notifications', JSON.stringify(this.dismissedNotifications));
            
            // Remove from list
            this.notifications = this.notifications.filter(n => n.id !== id);
            this.updateUnreadCount();
        },
        
        init() {
            this.fetchNotifications();
            // Auto-refresh every 10 seconds for faster updates
            setInterval(() => this.fetchNotifications(), 10000);
        }
    }">
    <div class="container-main">
        <nav class="flex items-center justify-between py-2">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}"
                    class="h-16 lg:h-20 w-auto object-contain">
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}"
                    class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                    Home
                </a>
                <a href="{{ route('shop.index') }}"
                    class="nav-link {{ request()->routeIs('shop.*') ? 'nav-link-active' : '' }}">
                    Shop
                </a>
                <a href="{{ route('trends.index') }}"
                    class="nav-link {{ request()->routeIs('trends.*') ? 'nav-link-active' : '' }}">
                    Trends
                </a>
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'nav-link-active' : '' }}">
                    Categories
                </a>
                <a href="{{ route('deals.index') }}"
                    class="nav-link {{ request()->routeIs('deals.*') ? 'nav-link-active' : '' }}">
                    Deals
                </a>
                <a href="{{ route('blog.index') }}"
                    class="nav-link {{ request()->routeIs('blog.*') ? 'nav-link-active' : '' }}">
                    Blog
                </a>
                <a href="{{ route('pages.about') }}"
                    class="nav-link {{ request()->routeIs('pages.about') ? 'nav-link-active' : '' }}">
                    About
                </a>
            </div>

            {{-- Search & Actions --}}
            <div class="flex items-center gap-2 lg:gap-4">
                {{-- Search Button --}}
                <button @click="searchOpen = true" type="button"
                    class="p-2 text-warm-gray-500 hover:text-warm-gray-900 transition-colors relative"
                    aria-label="Search">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                {{-- Notification Button with Dropdown --}}
                <div class="relative" @click.away="notificationsOpen = false">
                    <div class="relative inline-block">
                        <button @click="notificationsOpen = !notificationsOpen" type="button"
                            class="p-2 text-warm-gray-500 hover:text-warm-gray-900 transition-colors"
                            aria-label="Notifications">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                        <!-- Professional Unread Count Badge -->
                        <span style="color:red;" x-show="unreadCount > 0"
                            x-text="unreadCount > 99 ? '99+' : unreadCount"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 min-w-[20px] h-5 text-[11px] font-bold leading-none text-white bg-gradient-to-br from-red-500 to-red-600 rounded-full border-2 border-white shadow-md">
                        </span>
                    </div>

                    <!-- Notification Dropdown -->
                    <div x-show="notificationsOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-96 max-w-[calc(100vw-2rem)] bg-white rounded-xl shadow-2xl border border-warm-gray-100 overflow-hidden z-50">

                        <!-- Header -->
                        <div class="p-4 border-b border-warm-gray-100 bg-warm-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-warm-gray-900">Notifications</h3>
                                <span class="text-xs text-warm-gray-500"
                                    x-text="notifications.length + ' recent'"></span>
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="max-h-[400px] overflow-y-auto">
                            <template x-if="notifications.length > 0">
                                <div class="divide-y divide-warm-gray-100">
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <a :href="notification.url" @click="dismissNotification(notification.id)"
                                            class="block p-4 hover:bg-warm-gray-50 transition-colors group">
                                            <div class="flex gap-3">
                                                <!-- Product Image -->
                                                <div
                                                    class="w-16 h-16 flex-shrink-0 bg-warm-gray-100 rounded-lg overflow-hidden">
                                                    <img :src="notification.data.image ? '/storage/' + notification.data.image : ''"
                                                        :alt="notification.message"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                                </div>

                                                <!-- Content -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2 mb-1">
                                                        <span class="text-xs font-bold text-amber-600"
                                                            x-text="notification.title"></span>
                                                        <span class="text-xs text-warm-gray-400 flex-shrink-0"
                                                            x-text="notification.created_at"></span>
                                                    </div>
                                                    <p class="text-sm font-bold text-warm-gray-900 line-clamp-2 mb-1 group-hover:text-amber-600 transition-colors"
                                                        x-text="notification.message"></p>
                                                    <div class="flex items-center gap-2 text-xs text-warm-gray-500">
                                                        <span x-show="notification.data.category"
                                                            x-text="notification.data.category"></span>
                                                        <span x-show="notification.data.category">•</span>
                                                        <span class="font-bold text-amber-600"
                                                            x-text="notification.data.price"></span>
                                                        <span x-show="notification.data.discount"
                                                            class="ml-auto px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full font-bold"
                                                            x-text="notification.data.discount"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            <!-- Empty State -->
                            <template x-if="notifications.length === 0">
                                <div class="p-12 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warm-gray-50 mb-4">
                                        <svg class="w-8 h-8 text-warm-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-warm-gray-900 mb-1">No notifications</h3>
                                    <p class="text-xs text-warm-gray-500">We'll notify you when something new arrives
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    {{-- Search Modal --}}
    <div x-show="searchOpen" x-cloak @keydown.escape.window="searchOpen = false"
        class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        {{-- Backdrop --}}
        <div @click="searchOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Modal Content --}}
        <div class="relative min-h-screen flex items-start justify-center p-4 pt-20">
            <div @click.away="searchOpen = false"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden" x-data="{
                    query: '',
                    results: [],
                    loading: false,
                    searchTimeout: null,
                    async search() {
                        if (this.query.length < 2) {
                            this.results = [];
                            return;
                        }
                        
                        this.loading = true;
                        
                        try {
                            const response = await fetch(`{{ route('api.search') }}?q=${encodeURIComponent(this.query)}`);
                            const data = await response.json();
                            this.results = data.results;
                        } catch (error) {
                            console.error('Search error:', error);
                        } finally {
                            this.loading = false;
                        }
                    },
                    handleInput() {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => this.search(), 300);
                    }
                 }" x-init="$nextTick(() => $refs.searchInput.focus())">

                {{-- Search Input --}}
                <div class="p-6 border-b border-warm-gray-100">
                    <div class="relative">
                        <!-- <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-warm-gray-400 pointer-events-none" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg> -->
                        <input x-ref="searchInput" x-model="query" @input="handleInput()" type="text"
                            placeholder="Search products..."
                            class="w-full pl-14 pr-12 py-4 text-lg border-none focus:ring-0 bg-warm-gray-50 rounded-xl placeholder-warm-gray-400 text-warm-gray-900">
                        <div x-show="loading" class="absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Results --}}
                <div class="max-h-96 overflow-y-auto">
                    <template x-if="query.length >= 2 && results.length > 0">
                        <div class="p-4 space-y-2">
                            <template x-for="product in results" :key="product.id">
                                <a :href="product.url"
                                    class="flex items-center gap-4 p-3 rounded-xl hover:bg-warm-gray-50 transition-colors group">
                                    {{-- Image --}}
                                    <div class="w-16 h-16 flex-shrink-0 bg-warm-gray-100 rounded-lg overflow-hidden">
                                        <img :src="product.image" :alt="product.title"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-warm-gray-900 line-clamp-1 group-hover:text-amber-600 transition-colors"
                                            x-text="product.title"></h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span x-show="product.category" class="text-xs text-warm-gray-500"
                                                x-text="product.category"></span>
                                            <span x-show="product.category" class="text-warm-gray-300">•</span>
                                            <span class="text-sm font-bold text-amber-600"
                                                x-text="product.price"></span>
                                        </div>
                                    </div>

                                    {{-- Arrow --}}
                                    <svg class="w-5 h-5 text-warm-gray-300 group-hover:text-amber-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </template>
                        </div>
                    </template>

                    {{-- No Results --}}
                    <template x-if="query.length >= 2 && results.length === 0 && !loading">
                        <div class="p-12 text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-warm-gray-50 mb-4">
                                <svg class="w-8 h-8 text-warm-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-warm-gray-900 mb-1">No products found</h3>
                            <p class="text-warm-gray-500 text-sm">Try searching with different keywords</p>
                        </div>
                    </template>

                    {{-- Initial State --}}
                    <template x-if="query.length < 2">
                        <div class="p-12 text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-50 mb-4">
                                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-warm-gray-900 mb-1">Start typing to search</h3>
                            <p class="text-warm-gray-500 text-sm">Search across our entire product catalog</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>