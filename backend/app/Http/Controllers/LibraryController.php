<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{

    public function getAllBooks()
    {
        $books = (new Book)->getAllBooks();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }


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

    public function getBookByIsbn($isbn)
    {
        $bookModel = new Book();

        $book = $bookModel->getBookByIsbn($isbn);

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

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

    public function getAvailableBooks()
    {
        $books = (new Book)->getAvailableBooks();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

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
