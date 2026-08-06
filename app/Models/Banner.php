<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'subtitle', 'image', 'button_text', 'button_link', 'position', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : 'https://placehold.co/1920x800?text=' . urlencode($this->title);
    }
}