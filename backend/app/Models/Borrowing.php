<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes for the Borrowing model.
     * Represents a single borrowing transaction between a student and a book copy.
     */
    protected $fillable = [
        'student_isbn',
        'book_isbn',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
    ];

    /**
     * Defines the relationship between a borrowing record and a student.
     * A borrowing belongs to one student, identified by ISBN.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_isbn', 'isbn');
    }

    /**
     * Defines the relationship between a borrowing record and a specific book copy.
     * A borrowing is associated with exactly one physical book copy.
     */
    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class, 'book_isbn', 'isbn');
    }

    /**
     * Handles the borrowing of a book copy by a student.
     *
     * This method:
     *  - Validates the existence of the student and book copy
     *  - Ensures the book copy is available
     *  - Decreases the available copies of the related book
     *  - Marks the book copy as borrowed
     *  - Creates a new borrowing record with a due date
     *
     * @param string $studentIsbn
     * @param string $bookIsbn
     * @return Borrowing
     * @throws \Exception
     */
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

    /**
     * Handles the return of a borrowed book copy by a student.
     *
     * This method:
     *  - Finds the active borrowing record
     *  - Marks the book copy as available
     *  - Increases the available copies of the related book (with safety check)
     *  - Updates the borrowing record with return information
     *
     * @param string $studentIsbn
     * @param string $bookIsbn
     * @return Borrowing
     */
    public function returnBook(string $studentIsbn, string $bookIsbn)
    {
        $borrowing = Borrowing::where('student_isbn', $studentIsbn)
            ->where('book_isbn', $bookIsbn)
            ->where('status', 'borrowed')
            ->firstOrFail();

        $copy = BookCopy::where('isbn', $bookIsbn)->firstOrFail();
        $book = $copy->book;
        $copy->status = 'available';
        $copy->save();

        if ($book->available_copies < $book->total_copies) {
            $book->available_copies += 1;
            $book->save();
        }

        $borrowing->status = 'returned';
        $borrowing->returned_at = now();
        $borrowing->save();

        return $borrowing;
    }

    /**
     * Retrieves the full borrowing history for a given student.
     * Includes returned and currently borrowed books.
     *
     * @param string $studentIsbn
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHistory(string $studentIsbn)
    {
        return Borrowing::where('student_isbn', $studentIsbn)
            ->with(['bookCopy', 'bookCopy.book'])
            ->orderBy('borrowed_at', 'desc')
            ->get();
    }

    /**
     * Retrieves all currently borrowed (active) books for a given student.
     *
     * @param string $studentIsbn
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentBorrowed(string $studentIsbn)
    {
        return Borrowing::where('student_isbn', $studentIsbn)
            ->where('status', 'borrowed')
            ->with(['bookCopy', 'bookCopy.book'])
            ->orderBy('borrowed_at', 'desc')
            ->get();
    }

    /**
     * Retrieves all active borrowings across the system,
     * including student and book information.
     * Intended for administrative or librarian views.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
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
