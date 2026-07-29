<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniversityComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'user_id',
        'parent_id',
        'body',
        'rating',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating'      => 'integer',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(__CLASS__, 'parent_id')
            ->where('is_approved', true)
            ->with('user')
            ->latest();
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
