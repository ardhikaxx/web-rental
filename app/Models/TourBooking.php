<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourBooking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'tour_package_id', 'tour_schedule_id', 'user_id',
        'customer_name', 'customer_phone', 'customer_email',
        'participants', 'total_price', 'status', 'created_by', 'updated_by',
    ];

    protected $casts = ['participants' => 'integer', 'total_price' => 'decimal:2'];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }

    public function schedule()
    {
        return $this->belongsTo(TourSchedule::class, 'tour_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}