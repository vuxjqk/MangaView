<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'comic_id',
        'title',
        'chapter_number',
        'views',
        'is_premium',
        'is_approved',
        'uploaded_by',
    ];
}
