<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['customer_name', 'company', 'photo', 'service_type', 'rating', 'content', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'rating' => 'integer'];

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        $initial = mb_strtoupper(mb_substr($this->customer_name, 0, 1));
        return 'https://ui-avatars.com/api/?name=' . urlencode($initial) . '&background=4cc9f0&color=fff';
    }
}