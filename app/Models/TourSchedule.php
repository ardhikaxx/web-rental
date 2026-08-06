<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    protected $fillable = ['tour_package_id', 'departure_date', 'quota', 'booked', 'status'];

    protected $casts = ['departure_date' => 'date'];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }

    public function bookings()
    {
        return $this->hasMany(TourBooking::class, 'tour_schedule_id');
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota - $this->booked);
    }
}