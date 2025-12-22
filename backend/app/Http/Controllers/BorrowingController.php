<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Handles the borrowing of a book copy by a student.
     *
     * This endpoint:
     *  - Validates the student and book copy identifiers
     *  - Delegates borrowing logic to the Borrowing model
     *  - Returns a success response if the borrowing is completed
     *  - Returns an error response if business rules are violated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'student_isbn' => 'required|string|exists:students,isbn',
            'book_isbn'    => 'required|string|exists:book_copies,isbn',
        ]);

        try {
            $borrowing = (new Borrowing)->borrowBook(
                $validated['student_isbn'],
                $validated['book_isbn']
            );

            return response()->json([
                'success' => true,
                'message' => 'Book successfully borrowed.',
                'data' => $borrowing
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Handles the return of a previously borrowed book copy.
     *
     * This endpoint:
     *  - Validates the student and book copy identifiers
     *  - Delegates return logic to the Borrowing model
     *  - Updates borrowing status and availability information
     *  - Returns a success response upon completion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function return(Request $request)
    {
        $validated = $request->validate([
            'student_isbn' => 'required|string|exists:students,isbn',
            'book_isbn'    => 'required|string|exists:book_copies,isbn',
        ]);

        try {
            $borrowing = (new Borrowing)->returnBook(
                $validated['student_isbn'],
                $validated['book_isbn']
            );

            return response()->json([
                'success' => true,
                'message' => 'Book successfully returned.',
                'data' => $borrowing
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Retrieves borrowing information for a specific student.
     *
     * Depending on the provided type parameter, this endpoint returns:
     *  - The full borrowing history of the student
     *  - Or only the currently borrowed books
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentBorrowings(Request $request)
    {
        $validated = $request->validate([
            'student_isbn' => 'required|string|exists:students,isbn',
            'type'         => 'nullable|string|in:all,current'
        ]);

        $borrowing = new Borrowing;

        if (($validated['type'] ?? null) === 'current') {
            $data = $borrowing->getCurrentBorrowed($validated['student_isbn']);
            $msg  = "Current borrowed books retrieved.";
        } else {
            $data = $borrowing->getHistory($validated['student_isbn']);
            $msg  = "Borrowing history retrieved.";
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data,
        ]);
    }

    /**
     * Retrieves all currently borrowed books across the system.
     *
     * This endpoint is intended for administrative or librarian use
     * and includes student and book information for each borrowing.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allBorrowed()
    {
        $borrowings = (new Borrowing)->getAllBorrowedWithStudents();

        return response()->json([
            'success' => true,
            'message' => 'List of all currently borrowed books.',
            'data' => $borrowings
        ]);
    }
}
