<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetDocument extends Model
{
    protected $fillable = ['fleet_id', 'type', 'label', 'path', 'expired_at'];

    protected $casts = ['expired_at' => 'date'];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}