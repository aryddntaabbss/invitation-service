<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'package_id',
        'template_id',
        'title',
        'slug',
        'groom_name',
        'bride_name',
        'groom_bio',
        'bride_bio',
        'groom_parents',
        'bride_parents',
        'event_date',
        'event_time',
        'event_address',
        'google_maps_link',
        'latitude',
        'longitude',
        'primary_color',
        'secondary_color',
        'font_family',
        'music_url',
        'custom_domain',
        'password',
        'status',
        'is_active',
        'view_count',
        'published_at',
        'expires_at',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'event_time' => 'datetime',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot method untuk generate slug otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }

            // Generate slug unik
            $originalSlug = $model->slug;
            $count = 1;
            while (static::where('slug', $model->slug)->exists()) {
                $model->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    /**
     * Relationship dengan customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship dengan package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Relationship dengan template
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Relationship dengan guests
     */
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    /**
     * Relationship dengan messages/ucapan
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Relationship dengan photos
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Scope untuk undangan aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('expires_at', '>', now());
    }

    /**
     * Scope untuk undangan published
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('is_active', true)
            ->where('expires_at', '>', now());
    }

    /**
     * Scope untuk undangan yang akan kadaluarsa
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('expires_at', '<=', now()->addDays($days))
            ->where('expires_at', '>', now());
    }

    /**
     * Check apakah undangan aktif
     */
    public function getIsActiveAttribute($value)
    {
        return $value && $this->expires_at > now();
    }

    /**
     * Get URL undangan
     */
    public function getUrlAttribute()
    {
        if ($this->custom_domain) {
            return 'https://' . $this->custom_domain;
        }

        return route('invitation.show', $this->slug);
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->view_count++;
        $this->save();
    }

    /**
     * Get jumlah tamu yang sudah konfirmasi
     */
    public function getConfirmedGuestsCountAttribute()
    {
        return $this->guests()->where('is_confirmed', true)->count();
    }

    /**
     * Get jumlah ucapan
     */
    public function getMessagesCountAttribute()
    {
        return $this->messages()->count();
    }
}
