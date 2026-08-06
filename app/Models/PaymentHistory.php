<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = ['payment_id', 'action', 'note', 'user_id'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}