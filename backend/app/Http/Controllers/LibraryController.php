<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\BorrowedBook;
use Illuminate\Support\Carbon;


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

    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'student_code' => 'required|string|exists:students,student_code',
            'book_id'      => 'required|exists:books,id',
        ]);

        $student = Student::where('student_code', $validated['student_code'])->first();

        return DB::transaction(function () use ($validated, $student) {
            $book = Book::where('id', $validated['book_id'])->lockForUpdate()->first();

            $title = Title::where('title', $book->title)
                ->where('author', $book->author)
                ->lockForUpdate()
                ->firstOrFail();

            if ($title->count <= 0) {
                return response()->json(['message' => 'No copies available for this book'], 400);
            }

            $title->decrement('count');

            $borrow = BorrowedBook::create([
                'student_id'  => $student->id,
                'book_id'     => $book->id,
                'borrowed_at' => Carbon::now(),
                'due_at'      => Carbon::now()->addYear(),
            ]);

            return response()->json([
                'message' => 'Book borrowed successfully',
                'borrow'  => $borrow,
            ], 201);
        });
    }

    public function returnBook(Request $request)
    {
        $validated = $request->validate([
            'student_code' => 'required|string|exists:students,student_code',
            'isbn'         => 'required|string|exists:books,isbn',
        ]);

        $student = Student::where('student_code', $validated['student_code'])->first();

        return DB::transaction(function () use ($validated, $student) {
            // Find the book by ISBN
            $book = Book::where('isbn', $validated['isbn'])->lockForUpdate()->firstOrFail();

            // Make sure the student actually borrowed this book
            $borrow = BorrowedBook::where('student_id', $student->id)
                ->where('book_id', $book->id)
                ->whereNull('returned_at') // optional: only if you want to track active borrows
                ->first();

            if (!$borrow) {
                return response()->json(['message' => 'This book was not borrowed by the student'], 400);
            }

            // Find the corresponding title by title + author
            $title = Title::where('title', $book->title)
                ->where('author', $book->author)
                ->lockForUpdate()
                ->firstOrFail();

            // Increase available copies
            $title->increment('count');

            // Mark borrow as returned (but keep it in the table)
            $borrow->update([
                'returned_at' => Carbon::now(),
            ]);

            return response()->json([
                'message' => 'Book returned successfully',
                'borrow'  => $borrow,
            ], 200);
        });
    }

}
