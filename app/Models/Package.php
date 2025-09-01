<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'duration_days',
        'max_guests',
        'max_photos',
        'custom_domain',
        'premium_support',
        'background_music',
        'photo_gallery',
        'guest_book',
        'countdown_timer',
        'google_maps',
        'qr_code',
        'template_access',
        'order',
        'is_featured',
        'is_active',
        'features'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'custom_domain' => 'boolean',
        'premium_support' => 'boolean',
        'background_music' => 'boolean',
        'photo_gallery' => 'boolean',
        'guest_book' => 'boolean',
        'countdown_timer' => 'boolean',
        'google_maps' => 'boolean',
        'qr_code' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship dengan invitations
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Relationship dengan transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope untuk package aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk package featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get harga akhir (setelah diskon)
     */
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Check apakah ada diskon
     */
    public function getHasDiscountAttribute()
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    /**
     * Get persentase diskon
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) {
            return 0;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }
}
