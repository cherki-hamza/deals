<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Product extends Model
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
        'short_description',
        'full_description',
        'amazon_affiliate_url',
        'amazon_asin',
        'price_text',
        'original_price_text',
        'discount_text',
        'category_id',
        'images',
        'video_url',
        'highlights',
        'featured',
        'deal_of_the_day',
        'status',
        'seo_title',
        'seo_description',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'deal_of_the_day' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the deals for the product.
     */
    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_product')
            ->withPivot('order')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include deal of the day products.
     */
    public function scopeDealOfTheDay($query)
    {
        return $query->where('deal_of_the_day', true);
    }

    /**
     * Get images as array (for frontend use).
     */
    public function getImagesArrayAttribute()
    {
        $value = $this->attributes['images'] ?? null;
        if (is_null($value) || $value === '') {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Get highlights as array (for frontend use).
     */
    public function getHighlightsArrayAttribute()
    {
        $value = $this->attributes['highlights'] ?? null;
        if (is_null($value) || $value === '') {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Get the first image URL.
     */
    public function getFirstImageAttribute()
    {
        $images = $this->images_array;
        if (is_array($images) && count($images) > 0) {
            return Voyager::image($images[0]);
        }
        return asset('images/placeholder-product.jpg');
    }

    /**
     * Get SEO title or fallback to product title.
     */
    public function getSeoTitleDisplayAttribute()
    {
        return $this->seo_title ?: $this->title;
    }

    /**
     * Get SEO description or fallback to short description.
     */
    public function getSeoDescriptionDisplayAttribute()
    {
        return $this->seo_description ?: Str::limit($this->short_description, 160);
    }
}
