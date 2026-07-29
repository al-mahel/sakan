<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class University extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'name', 'slug', 'city', 'image',
        'description', 'type', 'website',
        'is_active', 'order',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'nearest_university', 'name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/university-placeholder.webp');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function comments()
    {
        return $this->hasMany(UniversityComment::class)
            ->approved()
            ->roots()
            ->with(['user', 'replies.user'])
            ->latest();
    }

    public function getAvgRatingAttribute(): float
    {
        return $this->hasMany(UniversityComment::class)
            ->whereNotNull('rating')
            ->avg('rating') ?? 0;
    }
}
