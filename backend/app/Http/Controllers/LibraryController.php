<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Retrieves all books stored in the library.
     *
     * This endpoint returns a complete list of books,
     * regardless of their availability status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBooks()
    {
        $books = (new Book)->getAllBooks();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    /**
     * Searches books by title using partial string matching.
     *
     * This endpoint is intended for user-facing search functionality
     * within the library system.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchBooks(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:1',
        ]);

        $searchTerm = $request->query('title');

        $books = (new Book)->searchByTitle($searchTerm);

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    /**
     * Retrieves a single book by its ISBN identifier.
     *
     * If the book does not exist, an exception is thrown
     * by the underlying model method.
     *
     * @param string $isbn
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookByIsbn($isbn)
    {
        $bookModel = new Book();

        $book = $bookModel->getBookByIsbn($isbn);

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    /**
     * Creates and stores a new book record in the library.
     *
     * The request data is validated and passed to the Book model,
     * which handles persistence.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'nullable|string|unique:books,isbn',
            'publisher' => 'nullable|string',
            'published_year' => 'nullable|integer',
            'edition' => 'nullable|string',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'cover_image_url' => 'nullable|string',
        ]);

        $book = (new Book)->loadBook($validated);

        return response()->json([
            'success' => true,
            'message' => 'Book successfully loaded into the library.',
            'data' => $book
        ], 201);
    }

    /**
     * Retrieves all books that currently have at least one available copy.
     *
     * This endpoint is useful for displaying books
     * that can be borrowed by students.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableBooks()
    {
        $books = (new Book)->getAvailableBooks();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    /**
     * Deletes a book from the library by its ISBN.
     *
     * This operation permanently removes the book record
     * and should be used with caution.
     *
     * @param string $isbn
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBook($isbn)
    {
        $bookModel = new Book();

        $bookModel->deleteBook($isbn);

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully.'
        ]);
    }
}
