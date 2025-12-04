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

    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }





    public function getAllBooks()
    {
        return $this->all();
    }

    public function searchByTitle(string $query)
    {
        $keywords = explode(' ', trim($query));

        return $this->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->where('title', 'LIKE', '%' . $word . '%');
            }
        })->get();
    }

    public function getBookByIsbn(string $isbn)
    {
        return $this->where('isbn', $isbn)->firstOrFail();
    }

    public function loadBook(array $data)
    {
        return $this->create($data);
    }

    public function decreaseAvailableCopies(string $isbn)
    {
        $book = $this->where('isbn', $isbn)->firstOrFail();

        if ($book->available_copies <= 0) {
            return false;
        }

        $book->available_copies -= 1;
        $book->save();

        return $book;
    }

    public function increaseAvailableCopies(string $isbn)
    {
        $book = $this->where('isbn', $isbn)->firstOrFail();

        if ($book->available_copies < $book->total_copies) {
            $book->available_copies += 1;
            $book->save();
        }

        return $book;
    }

    public function getAvailableBooks()
    {
        return $this->where('available_copies', '>', 0)->get();
    }

    public function deleteBook(string $isbn)
    {
        $book = $this->where('isbn', $isbn)->firstOrFail();
        return $book->delete();
    }







}
