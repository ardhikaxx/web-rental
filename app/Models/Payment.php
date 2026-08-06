<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'booking_id',
        'user_id',
        'type',
        'amount',
        'payment_method',
        'bank_name',
        'account_number',
        'account_name',
        'proof_image',
        'status',
        'rejection_note',
        'paid_at',
        'verified_at',
        'verified_by',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(PaymentHistory::class);
    }

    public function getProofUrlAttribute(): string
    {
        return $this->proof_image ? asset('storage/' . $this->proof_image) : null;
    }

    public static function statuses(): array
    {
        return [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];
    }
}