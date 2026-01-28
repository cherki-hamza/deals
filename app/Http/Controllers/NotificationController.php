<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get latest notifications (recent 7 days, limit 10).
     */
    public function index()
    {
        $notifications = Notification::with('product')
            ->recent()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                // Determine URL based on notification data
                $url = null;
                if (isset($notification->data['deal_id'])) {
                    // Deal notification
                    $url = route('deals.show', $notification->data['slug']);
                } elseif ($notification->product) {
                    // Product notification
                    $url = route('products.show', $notification->product->slug);
                }

                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'url' => $url,
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count(),
        ]);
    }

    /**
     * Get unread notification count.
     */
    public function count()
    {
        $count = Notification::recent()->count();

        return response()->json([
            'count' => $count,
        ]);
    }
}
