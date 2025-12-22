<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Mass-assignable attributes for the Book model.
     * Represents core bibliographic and inventory data.
     */
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

    /**
     * Defines the relationship between a book and its physical copies.
     * A single book can have multiple book copies.
     */
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

    /**
     * Retrieves all books from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBooks()
    {
        return $this->all();
    }

    /**
     * Searches for books by title using keyword-based matching.
     * The query string is split into individual words, and each word
     * must be present somewhere in the book title.
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByTitle(string $query)
    {
        $keywords = explode(' ', trim($query));

        return $this->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->where('title', 'LIKE', '%' . $word . '%');
            }
        })->get();
    }

    /**
     * Retrieves a single book by its ISBN.
     * Throws an exception if the book does not exist.
     *
     * @param string $isbn
     * @return Book
     */
    public function getBookByIsbn(string $isbn)
    {
        return $this->where('isbn', $isbn)->firstOrFail();
    }

    /**
     * Creates and stores a new book record in the database.
     *
     * @param array $data
     * @return Book
     */
    public function loadBook(array $data)
    {
        return $this->create($data);
    }

    /**
     * Decreases the number of available copies of a book by one.
     * This method is typically called when a book is borrowed.
     *
     * If no copies are available, the operation is aborted.
     *
     * @param string $isbn
     * @return Book|false
     */
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

    /**
     * Increases the number of available copies of a book by one.
     * This method is typically called when a book is returned.
     *
     * The number of available copies will not exceed the total copies.
     *
     * @param string $isbn
     * @return Book
     */
    public function increaseAvailableCopies(string $isbn)
    {
        $book = $this->where('isbn', $isbn)->firstOrFail();

        if ($book->available_copies < $book->total_copies) {
            $book->available_copies += 1;
            $book->save();
        }

        return $book;
    }

    /**
     * Retrieves all books that currently have at least one available copy.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableBooks()
    {
        return $this->where('available_copies', '>', 0)->get();
    }

    /**
     * Deletes a book from the database based on its ISBN.
     * Throws an exception if the book does not exist.
     *
     * @param string $isbn
     * @return bool|null
     */
    public function deleteBook(string $isbn)
    {
        $book = $this->where('isbn', $isbn)->firstOrFail();
        return $book->delete();
    }
}
