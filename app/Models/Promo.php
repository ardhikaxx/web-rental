<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'type', 'value', 'min_purchase', 'max_discount',
        'valid_from', 'valid_until', 'usage_limit', 'used_count',
        'fleet_id', 'tour_package_id', 'status', 'is_active',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function getIsValidAttribute(): bool
    {
        if (! $this->is_active || $this->status !== 'aktif') {
            return false;
        }
        if ($this->valid_from && now()->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && now()->gt($this->valid_until)) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        return true;
    }

    public function calculateDiscount($subtotal): float
    {
        if (! $this->is_valid) {
            return 0;
        }
        if ($this->type === 'nominal') {
            $discount = $this->value;
        } else { // persen
            $discount = $subtotal * $this->value / 100;
        }
        if ($this->max_discount > 0) {
            $discount = min($discount, $this->max_discount);
        }
        return min($discount, $subtotal);
    }

    public static function types(): array
    {
        return ['persen' => 'Persentase', 'nominal' => 'Nominal', 'voucher' => 'Voucher Kode'];
    }
}