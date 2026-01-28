<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'banner_image',
        'description',
        'active',
        'start_date',
        'end_date',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deal) {
            if (empty($deal->slug)) {
                $deal->slug = Str::slug($deal->title);
            }
        });
    }

    /**
     * Get the products for the deal.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'deal_product')
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('deal_product.order');
    }

    /**
     * Get published products for the deal.
     */
    public function publishedProducts()
    {
        return $this->products()->published();
    }

    /**
     * Scope a query to only include active deals.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include current deals (within date range).
     */
    public function scopeCurrent($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('start_date')
                ->orWhere('start_date', '<=', now());
        })->where(function ($q) {
            $q->whereNull('end_date')
                ->orWhere('end_date', '>=', now());
        });
    }

    /**
     * Scope a query to order by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the banner image URL.
     */
    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image) {
            return Voyager::image($this->banner_image);
        }
        return asset('images/placeholder-deal.jpg');
    }

    /**
     * Check if deal is currently active (time-wise).
     */
    public function getIsCurrentAttribute()
    {
        $now = now();

        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return $this->active;
    }

    /**
     * Get remaining time for countdown (in seconds).
     */
    public function getRemainingSecondsAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $remaining = $this->end_date->diffInSeconds(now(), false);
        return max(0, -$remaining);
    }
}
