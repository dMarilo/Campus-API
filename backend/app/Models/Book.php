<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'published_year',
        'edition',
        'description',
        'total_copies',
        'available_copies',
        'cover_image_url',
    ];
}
