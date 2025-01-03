<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes; // Include SoftDeletes trait

    // Define fillable properties for mass assignment
    protected $fillable = [
        'user_id',        // Foreign key for the author (User)
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category_id',    // Optional category (Foreign key)
        'tags',           // Comma-separated or as a separate table
        'status',         // Status of the post
        'published_at',   // For scheduled posts
    ];

    // Cast attributes to their desired data types
    protected $casts = [
        'published_at' => 'datetime', // Automatically cast to Carbon instance
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id'); // Fixing the foreign key reference
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function booting()
    {
        static::creating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }

}
