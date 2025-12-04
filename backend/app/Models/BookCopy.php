<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    // ISBN IS PRIMARY KEY
    protected $primaryKey = 'isbn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'isbn',
        'book_id',
        'status'
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
