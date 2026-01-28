<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Notification;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Only create notification if product is published
        if ($product->status === 'published') {
            Notification::create([
                'type' => 'new_product',
                'product_id' => $product->id,
                'title' => '🔥 New Product Deal!',
                'message' => $product->title,
                'data' => [
                    'slug' => $product->slug,
                    'image' => $product->images_array[0] ?? null,
                    'price' => $product->price_text,
                    'category' => $product->category?->name,
                ],
            ]);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Check if product was just marked as deal_of_the_day
        if ($product->isDirty('deal_of_the_day') && $product->deal_of_the_day === 1) {
            Notification::create([
                'type' => 'new_deal',
                'product_id' => $product->id,
                'title' => '🔥 New Hot Deal!',
                'message' => $product->title,
                'data' => [
                    'slug' => $product->slug,
                    'image' => $product->images_array[0] ?? null,
                    'price' => $product->price_text,
                    'discount' => $product->discount_text,
                ],
            ]);
            return; // Don't send another notification if this is a deal update
        }

        // Send notification for significant product updates (title, price, or images changed)
        if (
            $product->status === 'published' && (
                $product->isDirty('title') ||
                $product->isDirty('price') ||
                $product->isDirty('images')
            )
        ) {
            Notification::create([
                'type' => 'new_product',
                'product_id' => $product->id,
                'title' => '✨ Product Updated!',
                'message' => $product->title,
                'data' => [
                    'slug' => $product->slug,
                    'image' => $product->images_array[0] ?? null,
                    'price' => $product->price_text,
                    'category' => $product->category?->name,
                ],
            ]);
        }
    }
}
