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


}
