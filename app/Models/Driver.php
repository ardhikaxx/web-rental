<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'photo',
        'address',
        'license_number',
        'license_expired_at',
        'license_type',
        'status',
        'rating',
        'experience_trips',
        'experience',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'license_expired_at' => 'date',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function assignments()
    {
        return $this->hasMany(DriverAssignment::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        $initial = mb_strtoupper(mb_substr($this->name, 0, 1));
        return 'https://ui-avatars.com/api/?name=' . urlencode($initial) . '&background=7209b7&color=fff';
    }
}