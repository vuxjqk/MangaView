<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComicGenre extends Model
{
    protected $fillable = [
        'comic_id',
        'genre_id',
    ];
}
