<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCopy;

class BookCopySeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();

        foreach ($books as $book) {

            for ($i = 1; $i <= $book->total_copies; $i++) {

                // Generate a unique ISBN for each physical copy
                // Format: BOOKID(5 digits) + COPYNUMBER(2 digits) + RANDOM(3 digits)
                $isbn = str_pad($book->id, 5, '0', STR_PAD_LEFT)
                      . str_pad($i, 2, '0', STR_PAD_LEFT)
                      . rand(100, 999);

                BookCopy::create([
                    'isbn'     => $isbn,
                    'book_id'  => $book->id,
                    'status'   => 'available',
                ]);
            }
        }
    }
}
