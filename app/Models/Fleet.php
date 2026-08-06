<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fleet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'category_id',
        'brand',
        'model',
        'type',
        'year',
        'license_plate',
        'frame_number',
        'engine_number',
        'color',
        'capacity',
        'transmission',
        'fuel',
        'daily_price',
        'weekly_price',
        'monthly_price',
        'price_with_driver',
        'price_without_driver',
        'location',
        'facilities',
        'stnk_expired_at',
        'status',
        'primary_image',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'weekly_price' => 'decimal:2',
        'monthly_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(FleetCategory::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(FleetPhoto::class);
    }

    public function documents()
    {
        return $this->hasMany(FleetDocument::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return trim($this->brand . ' ' . $this->model);
    }

    public function getMainImageAttribute(): string
    {
        if ($this->primary_image) {
            return asset('storage/' . $this->primary_image);
        }
        return 'https://placehold.co/600x400?text=' . urlencode($this->display_name);
    }

    public static function bookingStatuses(): array
    {
        return ['tersedia', 'dipesan', 'berjalan', 'maintenance', 'nonaktif'];
    }
}