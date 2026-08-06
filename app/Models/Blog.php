<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 'category',
        'author', 'status', 'meta_title', 'meta_description', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function getImageAttribute(): string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : 'https://placehold.co/800x500?text=' . urlencode($this->title);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}