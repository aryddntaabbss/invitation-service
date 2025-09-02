<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'address',
        'city',
        'province',
        'postal_code',
        'status',
        'last_login_at',
        'last_login_ip',
        'google_id',
        'facebook_id',
        'github_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
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
     * Relationship dengan guests melalui invitations
     */
    public function guests()
    {
        return $this->hasManyThrough(Guest::class, Invitation::class);
    }

    /**
     * Scope untuk customer aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk customer dengan undangan aktif
     */
    public function scopeWithActiveInvitations($query)
    {
        return $query->whereHas('invitations', function ($q) {
            $q->where('is_active', true)
                ->where('expires_at', '>', now());
        });
    }

    /**
     * Get total undangan aktif customer
     */
    public function getActiveInvitationsCountAttribute()
    {
        return $this->invitations()
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->count();
    }
}
