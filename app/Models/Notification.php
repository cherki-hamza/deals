<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'product_id',
        'title',
        'message',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the product that the notification belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope for new product notifications.
     */
    public function scopeNewProducts($query)
    {
        return $query->where('type', 'new_product');
    }

    /**
     * Scope for new deal notifications.
     */
    public function scopeNewDeals($query)
    {
        return $query->where('type', 'new_deal');
    }

    /**
     * Scope for recent notifications (last 7 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }
}
