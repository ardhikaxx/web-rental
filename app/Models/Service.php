<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'content', 'featured_image',
        'meta_title', 'meta_description', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getImageAttribute(): string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }
}