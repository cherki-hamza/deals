@extends('layouts.app')

@section('title', 'Compare Products - ' . config('app.name'))

@section('content')
    <div class="bg-warm-gray-50 min-h-screen py-10" x-data="{ 
                    products: [], 
                    loading: true,
                    init() {
                        const ids = $store.compare.items.join(',');
                        if (!ids) {
                            this.loading = false;
                            return;
                        }

                        fetch(`/api/compare/products?ids=${ids}`)
                            .then(res => res.json())
                            .then(data => {
                                this.products = data;
                                this.loading = false;
                            });

                        // Watch for removals to remove form view
                        $watch('$store.compare.items', (value) => {
                             const newIds = value.join(',');
                             if(!newIds) {
                                 this.products = [];
                                 return;
                             }
                             // Filter products that are no longer in the store
                             this.products = this.products.filter(p => value.includes(p.id));
                        });
                    } 
                }">
        <div class="container-main">
            <h1 class="text-3xl font-bold font-heading text-warm-gray-900 mb-8">Compare Products</h1>

            <!-- Empty State -->
            <div x-show="!loading && products.length === 0" class="text-center py-20 bg-white rounded-2xl shadow-sm">
                <svg class="w-16 h-16 mx-auto text-warm-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <h3 class="text-xl font-medium text-warm-gray-900 mb-2">No products to compare</h3>
                <p class="text-warm-gray-500 mb-6">Add products to your comparison list to see them side-by-side.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse Products</a>
            </div>

            <!-- Comparison Table -->
            <div x-show="!loading && products.length > 0" class="overflow-x-auto pb-4 custom-scrollbar">
                <table
                    class="w-auto min-w-full bg-white rounded-2xl shadow-sm border-separate border-spacing-0 overflow-hidden text-left table-fixed">
                    <thead>
                        <tr>
                            <th
                                class="p-6 w-[200px] min-w-[200px] bg-warm-gray-50 border-b border-warm-gray-100 font-bold text-warm-gray-900 align-top">
                                Product
                            </th>
                            <template x-for="product in products" :key="product.id">
                                <th
                                    class="p-6 w-[300px] min-w-[300px] max-w-[300px] border-b border-warm-gray-100 align-top relative group">
                                    <div class="mb-4 aspect-[4/3] rounded-xl overflow-hidden bg-white border border-gray-100 p-2 flex items-center justify-center relative mx-auto group-image"
                                        style="width: 250px; min-width: 250px; max-width: 250px;">
                                        <button @click="$store.compare.remove(product.id)"
                                            class="absolute top-2 right-2 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white shadow-md hover:bg-red-600 transition-colors"
                                            title="Remove from comparison">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <img :src="product.image"
                                            class="w-full h-full object-contain transition-transform duration-300 hover:scale-105 mix-blend-multiply">
                                    </div>
                                    <a :href="product.url"
                                        class="font-bold text-lg text-warm-gray-900 hover:text-amber-600 block mb-2 line-clamp-2"
                                        x-text="product.title"></a>
                                    <div class="font-bold text-xl text-amber-600 mb-2" x-text="product.price"></div>
                                    <a :href="product.amazon_url" target="_blank"
                                        class="btn btn-sm btn-nav w-full text-xs">View on Amazon</a>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-warm-gray-100">
                        <!-- Rating -->
                        <tr>
                            <td class="p-6 font-medium text-warm-gray-500 bg-warm-gray-50">Rating</td>
                            <template x-for="product in products" :key="product.id + 'rating'">
                                <td class="p-6">
                                    <div class="flex items-center text-amber-400 text-sm">
                                        <span class="font-bold mr-1" x-text="product.rating"></span>
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                </td>
                            </template>
                        </tr>
                        <!-- Category -->
                        <tr>
                            <td class="p-6 font-medium text-warm-gray-500 bg-warm-gray-50">Category</td>
                            <template x-for="product in products" :key="product.id + 'cat'">
                                <td class="p-6 text-sm text-warm-gray-700" x-text="product.category"></td>
                            </template>
                        </tr>
                        <!-- Description -->
                        <tr>
                            <td class="p-6 font-medium text-warm-gray-500 bg-warm-gray-50">Description</td>
                            <template x-for="product in products" :key="product.id + 'desc'">
                                <td class="p-6 text-sm text-warm-gray-600 leading-relaxed"
                                    x-text="product.short_description"></td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection