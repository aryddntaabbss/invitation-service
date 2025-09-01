<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'email',
        'phone',
        'number_of_guests',
        'is_confirmed',
        'confirmed_at',
        'notes',
        'attendance_status',
        'custom_message',
        'token'
    ];

    protected $casts = [
        'is_confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
        'number_of_guests' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method untuk generate token otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->token)) {
                $model->token = Str::random(32);
            }
        });
    }

    /**
     * Relationship dengan invitation
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Scope untuk tamu yang sudah konfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('is_confirmed', true);
    }

    /**
     * Scope untuk tamu berdasarkan status kehadiran
     */
    public function scopeAttendanceStatus($query, $status)
    {
        return $query->where('attendance_status', $status);
    }

    /**
     * Konfirmasi kehadiran tamu
     */
    public function confirmAttendance($status = 'attending')
    {
        $this->update([
            'is_confirmed' => true,
            'confirmed_at' => now(),
            'attendance_status' => $status
        ]);
    }

    /**
     * Get status kehadiran dalam format yang lebih readable
     */
    public function getAttendanceStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu Konfirmasi',
            'attending' => 'Hadir',
            'not_attending' => 'Tidak Hadir'
        ];

        return $statuses[$this->attendance_status] ?? 'Tidak Diketahui';
    }
}
