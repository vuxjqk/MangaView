<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterImage extends Model
{
    protected $fillable = [
        'chapter_id',
        'image_url',
        'page_number',
        'format',
    ];
}
