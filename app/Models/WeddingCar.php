<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeddingCar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'fleet_id', 'area', 'rental_price', 'decoration_price',
        'driver_price', 'total_price', 'duration_hours', 'decoration_details',
        'thumbnail', 'gallery', 'status', 'is_active', 'created_by', 'updated_by',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function getThumbAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return 'https://placehold.co/800x500?text=' . urlencode($this->name);
    }
}