<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'package_id',
        'invitation_id',
        'transaction_code',
        'amount',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'status',
        'payment_method',
        'payment_channel',
        'payment_code',
        'payment_expiry',
        'paid_at',
        'payment_notes',
        'customer_notes',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_expiry' => 'datetime',
        'paid_at' => 'datetime',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method untuk generate transaction code otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->transaction_code)) {
                $model->transaction_code = 'TRX-' . date('Ymd') . '-' . Str::random(8);
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
     * Relationship dengan invitation
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Scope untuk transaksi berhasil
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope untuk transaksi pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk transaksi yang akan kadaluarsa
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('status', 'pending')
            ->where('payment_expiry', '<=', now()->addHours(2))
            ->where('payment_expiry', '>', now());
    }

    /**
     * Mark transaction as paid
     */
    public function markAsPaid($paymentData = [])
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_notes' => $paymentData['notes'] ?? null,
            'metadata' => array_merge($this->metadata ?? [], ['payment_data' => $paymentData])
        ]);
    }

    /**
     * Check if transaction is expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->status === 'pending' && $this->payment_expiry && $this->payment_expiry < now();
    }

    /**
     * Check if transaction is successful
     */
    public function getIsSuccessfulAttribute()
    {
        return $this->status === 'paid';
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
