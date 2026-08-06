<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'destination', 'duration_days', 'duration_nights',
        'price_per_person', 'price_per_group', 'min_group', 'max_group',
        'description', 'itinerary', 'facilities', 'terms', 'thumbnail',
        'gallery', 'status', 'meta_title', 'meta_description', 'is_active',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_days' => 'integer',
        'duration_nights' => 'integer',
    ];

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class, 'tour_package_id');
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    public function getThumbAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return 'https://placehold.co/800x500?text=' . urlencode($this->name);
    }
}