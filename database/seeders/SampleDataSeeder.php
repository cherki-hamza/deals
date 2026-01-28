<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update existing categories with icons and activate them
        $categoryIcons = [
            'Category 1' => ['icon' => '📱', 'name' => 'Electronics', 'description' => 'Latest gadgets and electronics'],
            'Category 2' => ['icon' => '🏠', 'name' => 'Home & Garden', 'description' => 'Everything for your home'],
        ];

        foreach (Category::all() as $category) {
            if (isset($categoryIcons[$category->name])) {
                $data = $categoryIcons[$category->name];
                $category->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                    'active' => true,
                ]);
            } else {
                $category->update(['active' => true]);
            }
        }

        // Create sample categories if not enough exist
        $sampleCategories = [
            ['name' => 'Electronics', 'icon' => '📱', 'description' => 'Latest gadgets, smartphones, and electronics'],
            ['name' => 'Home & Kitchen', 'icon' => '🏠', 'description' => 'Everything for your home and kitchen'],
            ['name' => 'Fashion', 'icon' => '👕', 'description' => 'Trending fashion and accessories'],
            ['name' => 'Sports & Outdoors', 'icon' => '⚽', 'description' => 'Gear for sports and outdoor activities'],
            ['name' => 'Books', 'icon' => '📚', 'description' => 'Best-selling books and literature'],
            ['name' => 'Health & Beauty', 'icon' => '💄', 'description' => 'Health, beauty, and personal care products'],
        ];

        foreach ($sampleCategories as $index => $data) {
            Category::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                    'active' => true,
                    'order' => $index + 1,
                ]
            );
        }

        // Get categories for products
        $categories = Category::active()->get();

        // Create sample products
        $sampleProducts = [
            [
                'title' => 'Premium Wireless Earbuds',
                'short_description' => 'High-quality wireless earbuds with active noise cancellation and 24-hour battery life.',
                'full_description' => '<p>Experience crystal-clear audio with these premium wireless earbuds. Features include:</p><ul><li>Active Noise Cancellation</li><li>24-hour total battery life</li><li>IPX5 water resistance</li><li>Touch controls</li></ul>',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE',
                'amazon_asin' => 'B09EXAMPLE1',
                'price_text' => '$79.99',
                'original_price_text' => '$129.99',
                'discount_text' => '38% OFF',
                'highlights' => ['Active Noise Cancellation', '24-hour battery', 'IPX5 water resistant', 'Touch controls'],
                'featured' => true,
                'deal_of_the_day' => true,
                'status' => 'published',
                'category' => 'Electronics',
            ],
            [
                'title' => 'Smart Home Security Camera',
                'short_description' => 'HD security camera with night vision, two-way audio, and cloud storage.',
                'full_description' => '<p>Keep your home safe with this advanced smart security camera.</p>',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE2',
                'amazon_asin' => 'B09EXAMPLE2',
                'price_text' => '$49.99',
                'original_price_text' => '$79.99',
                'discount_text' => '37% OFF',
                'highlights' => ['1080p HD Video', 'Night Vision', 'Two-way Audio', 'Cloud Storage'],
                'featured' => true,
                'status' => 'published',
                'category' => 'Electronics',
            ],
            [
                'title' => 'Professional Chef Knife Set',
                'short_description' => '8-piece premium knife set with ergonomic handles and knife block.',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE3',
                'amazon_asin' => 'B09EXAMPLE3',
                'price_text' => '$89.99',
                'highlights' => ['High-carbon stainless steel', '8-piece set', 'Ergonomic handles', 'Includes knife block'],
                'featured' => true,
                'status' => 'published',
                'category' => 'Home & Kitchen',
            ],
            [
                'title' => 'Portable Bluetooth Speaker',
                'short_description' => 'Waterproof portable speaker with 360° sound and 20-hour battery.',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE4',
                'amazon_asin' => 'B09EXAMPLE4',
                'price_text' => '$59.99',
                'original_price_text' => '$89.99',
                'discount_text' => '33% OFF',
                'highlights' => ['360° Sound', 'IPX7 Waterproof', '20-hour battery', 'Built-in microphone'],
                'featured' => true,
                'status' => 'published',
                'category' => 'Electronics',
            ],
            [
                'title' => 'Yoga Mat with Carrying Strap',
                'short_description' => 'Premium non-slip yoga mat with alignment lines and carrying strap.',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE5',
                'amazon_asin' => 'B09EXAMPLE5',
                'price_text' => '$29.99',
                'highlights' => ['Non-slip surface', 'Alignment lines', 'Eco-friendly material', 'Includes strap'],
                'status' => 'published',
                'category' => 'Sports & Outdoors',
            ],
            [
                'title' => 'Bestselling Novel Collection',
                'short_description' => 'Collection of 5 bestselling novels from award-winning authors.',
                'amazon_affiliate_url' => 'https://www.amazon.com/dp/B09EXAMPLE6',
                'amazon_asin' => 'B09EXAMPLE6',
                'price_text' => '$39.99',
                'highlights' => ['5 bestselling novels', 'Award-winning authors', 'Beautifully bound', 'Gift box included'],
                'featured' => true,
                'status' => 'published',
                'category' => 'Books',
            ],
        ];

        foreach ($sampleProducts as $index => $data) {
            $category = $categories->where('name', $data['category'])->first() ?? $categories->first();

            Product::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'short_description' => $data['short_description'] ?? null,
                    'full_description' => $data['full_description'] ?? null,
                    'amazon_affiliate_url' => $data['amazon_affiliate_url'],
                    'amazon_asin' => $data['amazon_asin'] ?? null,
                    'price_text' => $data['price_text'] ?? null,
                    'original_price_text' => $data['original_price_text'] ?? null,
                    'discount_text' => $data['discount_text'] ?? null,
                    'category_id' => $category->id,
                    'highlights' => $data['highlights'] ?? null,
                    'featured' => $data['featured'] ?? false,
                    'deal_of_the_day' => $data['deal_of_the_day'] ?? false,
                    'status' => $data['status'],
                    'order' => $index + 1,
                ]
            );
        }

        // Create a sample deal
        Deal::updateOrCreate(
            ['slug' => 'winter-sale-2024'],
            [
                'title' => 'Winter Sale - Up to 50% Off',
                'description' => '<p>Don\'t miss our biggest winter sale! Save up to 50% on selected electronics and home items.</p>',
                'active' => true,
                'order' => 1,
            ]
        );

        // Attach some products to the deal
        $deal = Deal::where('slug', 'winter-sale-2024')->first();
        $dealProducts = Product::published()->take(4)->pluck('id')->toArray();
        $deal->products()->syncWithoutDetaching($dealProducts);

        $this->command->info('Sample data seeded successfully!');
    }
}
