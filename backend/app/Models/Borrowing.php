<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_isbn',
        'book_isbn',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_isbn', 'isbn');
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class, 'book_isbn', 'isbn');
    }

    public function borrowBook(string $studentIsbn, string $bookIsbn)
    {
        $student = Student::where('isbn', $studentIsbn)->firstOrFail();
        $copy = BookCopy::where('isbn', $bookIsbn)->firstOrFail();

        if ($copy->status !== 'available') {
            throw new \Exception("Book copy is not available for borrowing.");
        }

        $book = $copy->book;

        if ($book->available_copies <= 0) {
            throw new \Exception("No available copies of this book.");
        }

        $book->available_copies -= 1;
        $book->save();

        $copy->status = 'borrowed';
        $copy->save();

        return Borrowing::create([
            'student_isbn' => $studentIsbn,
            'book_isbn'    => $bookIsbn,
            'borrowed_at'  => now(),
            'due_at'       => now()->addDays(30),
            'status'       => 'borrowed',
        ]);
    }

    public function returnBook(string $studentIsbn, string $bookIsbn)
    {
        // 1. Find active borrowing
        $borrowing = Borrowing::where('student_isbn', $studentIsbn)
            ->where('book_isbn', $bookIsbn)
            ->where('status', 'borrowed')
            ->firstOrFail();

        // 2. Fetch book copy
        $copy = BookCopy::where('isbn', $bookIsbn)->firstOrFail();

        // 3. Fetch related book
        $book = $copy->book;

        // 4. Mark book copy as available again
        $copy->status = 'available';
        $copy->save();

        // 5. Increase available copies (guarded)
        if ($book->available_copies < $book->total_copies) {
            $book->available_copies += 1;
            $book->save();
        }

        // 6. Update borrowing record
        $borrowing->status = 'returned';
        $borrowing->returned_at = now();
        $borrowing->save();

        return $borrowing;
    }


    public function getHistory(string $studentIsbn)
    {
        return Borrowing::where('student_isbn', $studentIsbn)
            ->with(['bookCopy', 'bookCopy.book'])
            ->orderBy('borrowed_at', 'desc')
            ->get();
    }


    public function getCurrentBorrowed(string $studentIsbn)
    {
        return Borrowing::where('student_isbn', $studentIsbn)
            ->where('status', 'borrowed')
            ->with(['bookCopy', 'bookCopy.book'])
            ->orderBy('borrowed_at', 'desc')
            ->get();
    }

    public function getAllBorrowedWithStudents()
    {
        return Borrowing::where('status', 'borrowed')
            ->with([
                'student',
                'bookCopy',
                'bookCopy.book'
            ])
            ->orderBy('borrowed_at', 'desc')
            ->get();
    }



}
