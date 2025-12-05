<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
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



}
