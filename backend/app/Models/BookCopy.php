<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    /**
     * Indicates that the ISBN is used as the primary key.
     * Each physical book copy is uniquely identified by its ISBN.
     */
    protected $primaryKey = 'isbn';

    /**
     * Disables auto-incrementing since ISBN is a string-based identifier.
     */
    public $incrementing = false;

    /**
     * Specifies that the primary key is of type string.
     */
    protected $keyType = 'string';

    /**
     * Mass-assignable attributes for the BookCopy model.
     * Represents the physical copy state and its relation to a book.
     */
    protected $fillable = [
        'isbn',
        'book_id',
        'status'
    ];

    /**
     * Defines the relationship between a book copy and its parent book.
     * Each book copy belongs to a single book.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
