<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetPhoto extends Model
{
    protected $fillable = ['fleet_id', 'path', 'caption', 'is_primary'];

    protected $casts = ['is_primary' => 'boolean'];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}