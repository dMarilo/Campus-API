<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class LibraryController extends Controller
{
    /**
     * Get all books
     */
    public function books(): JsonResponse
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function search(Request $request): JsonResponse
    {
        $query = Book::query()
            ->join('titles', function ($join) {
                $join->on('books.title', '=', 'titles.title')
                    ->on('books.author', '=', 'titles.author');
            })
            ->select('books.*', 'titles.count as copies');

        if ($request->has('title')) {
            $query->where('books.title', 'like', '%' . $request->query('title') . '%');
        }

        if ($request->has('author')) {
            $query->where('books.author', 'like', '%' . $request->query('author') . '%');
        }

        if ($request->has('isbn')) {
            $query->where('books.isbn', $request->query('isbn'));
        }

        $books = $query->get();

        return response()->json($books);
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'published_year' => 'nullable|integer',
            'library_id' => 'required|exists:libraries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book = Book::create($request->only([
            'title', 'author', 'isbn', 'published_year', 'library_id'
        ]));

        // update titles table immediately
        $title = Title::where('title', $book->title)
            ->where('author', $book->author)
            ->first();

        if ($title) {
            $title->increment('count');
        } else {
            Title::create([
                'title'  => $book->title,
                'author' => $book->author,
                'count'  => 1
            ]);
        }

        return response()->json([
            'message' => 'Book added successfully',
            'book' => $book
        ], 201);
    }

    public function syncTitles(): JsonResponse
    {
        // Clear titles table to avoid duplicates
        Title::truncate();

        // Rebuild titles from books
        $titles = Book::select('title', 'author', DB::raw('COUNT(*) as total'))
            ->groupBy('title', 'author')
            ->get();

        foreach ($titles as $t) {
            Title::create([
                'title'  => $t->title,
                'author' => $t->author,
                'count'  => $t->total,
            ]);
        }

        return response()->json(['message' => 'Titles table synchronized successfully']);
    }
}
