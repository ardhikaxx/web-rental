<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoUsage extends Model
{
    protected $fillable = ['promo_id', 'booking_id', 'user_id', 'discount'];

    protected $casts = ['discount' => 'decimal:2'];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}