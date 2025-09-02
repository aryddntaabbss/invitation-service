<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_image',
        'colors',
        'fonts',
        'category',
        'version',
        'author',
        'author_url',
        'price',
        'is_premium',
        'is_active',
        'download_count',
        'order',
        'settings'
    ];

    protected $casts = [
        'colors' => 'array',
        'fonts' => 'array',
        'price' => 'decimal:2',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'settings' => 'array',
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
     * Scope untuk template aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk template premium
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Scope untuk template gratis
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }

    /**
     * Get available categories
     */
    public static function getCategories()
    {
        return [
            'wedding' => 'Pernikahan',
            'birthday' => 'Ulang Tahun',
            'baby-shower' => 'Baby Shower',
            'engagement' => 'Tunangan',
            'corporate' => 'Korporat',
            'other' => 'Lainnya'
        ];
    }
}
