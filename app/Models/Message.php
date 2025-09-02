<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'guest_name',
        'guest_email',
        'message',
        'is_approved',
        'is_private',
        'likes',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_private' => 'boolean',
        'likes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship dengan invitation
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Scope untuk pesan yang disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope untuk pesan publik
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope untuk pesan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Like pesan
     */
    public function like()
    {
        $this->increment('likes');
    }

    /**
     * Setujui pesan
     */
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * Tolak pesan
     */
    public function reject()
    {
        $this->update(['is_approved' => false]);
    }

    /**
     * Get excerpt dari pesan
     */
    public function getExcerptAttribute($length = 100)
    {
        return Str::limit(strip_tags($this->message), $length);
    }
}
