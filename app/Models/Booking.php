<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'invoice_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'service_type',
        'fleet_id',
        'driver_id',
        'with_driver',
        'start_date',
        'end_date',
        'pickup_location',
        'dropoff_location',
        'special_notes',
        'duration_days',
        'base_price',
        'driver_fee',
        'extra_cost',
        'discount',
        'promo_code_discount',
        'tax',
        'total_price',
        'dp_amount',
        'dp_percent',
        'promo_id',
        'voucher_code',
        'status',
        'pickup_status',
        'return_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'with_driver' => 'boolean',
        'base_price' => 'decimal:2',
        'driver_fee' => 'decimal:2',
        'extra_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'promo_code_discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_price' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'dp_percent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->total_price - $this->paid_amount);
    }

    public function getPaidAmountAttribute(): float
    {
        return (float) $this->payments()->whereIn('status', ['verified'])->sum('amount');
    }

    public function getPaidPercentAttribute(): float
    {
        if ($this->total_price <= 0) {
            return 0;
        }
        return round($this->paid_amount / $this->total_price * 100);
    }

    public static function statuses(): array
    {
        return [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'pembayaran_diterima' => 'Pembayaran Diterima',
            'dijadwalkan' => 'Dijadwalkan',
            'berjalan' => 'Perjalanan Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            'refund' => 'Refund',
            'arsip' => 'Arsip',
        ];
    }

    public static function serviceTypes(): array
    {
        return [
            'rental' => 'Rental Mobil',
            'tour' => 'Paket Wisata',
            'travel' => 'Travel Antar Kota',
            'wedding' => 'Wedding Car',
            'airport' => 'Antar Jemput Bandara',
        ];
    }
}