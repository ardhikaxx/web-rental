<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function fleets()
    {
        return $this->hasMany(Fleet::class, 'category_id');
    }
}