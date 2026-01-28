<?php

namespace App\Observers;

use App\Models\Deal;
use App\Models\Notification;

class DealObserver
{
    /**
     * Handle the Deal "created" event.
     */
    public function created(Deal $deal): void
    {
        // Only create notification if deal is active
        if ($deal->active) {
            // Get first product image from the deal
            $firstProduct = $deal->products()->first();

            // Strip HTML tags from description and limit to 100 characters
            $description = $deal->description ? strip_tags($deal->description) : null;
            if ($description && strlen($description) > 100) {
                $description = substr($description, 0, 100) . '...';
            }

            Notification::create([
                'type' => 'new_deal',
                'product_id' => $firstProduct?->id,
                'title' => '🔥 New Deal Available!',
                'message' => $deal->title,
                'data' => [
                    'slug' => $deal->slug,
                    'image' => $deal->banner_image ?? ($firstProduct->images_array[0] ?? null),
                    'price' => null,
                    'discount' => $description,
                    'deal_id' => $deal->id,
                ],
            ]);
        }
    }

    /**
     * Handle the Deal "updated" event.
     */
    public function updated(Deal $deal): void
    {
        // Check if deal was just activated
        if ($deal->isDirty('active') && $deal->active === 1) {
            $firstProduct = $deal->products()->first();

            // Strip HTML tags from description and limit to 100 characters
            $description = $deal->description ? strip_tags($deal->description) : null;
            if ($description && strlen($description) > 100) {
                $description = substr($description, 0, 100) . '...';
            }

            Notification::create([
                'type' => 'new_deal',
                'product_id' => $firstProduct?->id,
                'title' => '🔥 Deal Activated!',
                'message' => $deal->title,
                'data' => [
                    'slug' => $deal->slug,
                    'image' => $deal->banner_image ?? ($firstProduct->images_array[0] ?? null),
                    'price' => null,
                    'discount' => $description,
                    'deal_id' => $deal->id,
                ],
            ]);
            return; // Don't send another notification if this is an activation
        }

        // Send notification for significant deal updates (title, dates, or description changed)
        if (
            $deal->active && (
                $deal->isDirty('title') ||
                $deal->isDirty('description') ||
                $deal->isDirty('end_date') ||
                $deal->isDirty('banner_image')
            )
        ) {
            $firstProduct = $deal->products()->first();

            // Strip HTML tags from description and limit to 100 characters
            $description = $deal->description ? strip_tags($deal->description) : null;
            if ($description && strlen($description) > 100) {
                $description = substr($description, 0, 100) . '...';
            }

            Notification::create([
                'type' => 'new_deal',
                'product_id' => $firstProduct?->id,
                'title' => '🔄 Deal Updated!',
                'message' => $deal->title,
                'data' => [
                    'slug' => $deal->slug,
                    'image' => $deal->banner_image ?? ($firstProduct->images_array[0] ?? null),
                    'price' => null,
                    'discount' => $description,
                    'deal_id' => $deal->id,
                ],
            ]);
        }
    }
}
