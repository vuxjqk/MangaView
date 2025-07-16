<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $fillable = [
        'title',
        'description',
        'author',
        'status',
        'cover_image',
        'views',
        'rating',
        'language',
        'is_approved',
        'created_by',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genres');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('created_at', 'desc');
    }
}
