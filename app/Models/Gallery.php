<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'image', 'category'];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}