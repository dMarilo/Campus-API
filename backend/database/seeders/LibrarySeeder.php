<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Library;
use App\Models\Book;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // Create one library
        $library = Library::create([
            'name' => 'Central Campus Library',
            'location' => 'Main Building, Floor 2',
        ]);

        // Seed 10 books into that library
        $books = [
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'isbn' => '9780262033848', 'published_year' => 2009],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '9780132350884', 'published_year' => 2008],
            ['title' => 'Design Patterns', 'author' => 'Erich Gamma', 'isbn' => '9780201633610', 'published_year' => 1994],
            ['title' => 'Artificial Intelligence: A Modern Approach', 'author' => 'Stuart Russell', 'isbn' => '9780136042594', 'published_year' => 2010],
            ['title' => 'Database System Concepts', 'author' => 'Abraham Silberschatz', 'isbn' => '9780073523323', 'published_year' => 2010],
            ['title' => 'Computer Networks', 'author' => 'Andrew S. Tanenbaum', 'isbn' => '9780132126953', 'published_year' => 2010],
            ['title' => 'Operating System Concepts', 'author' => 'Abraham Silberschatz', 'isbn' => '9780470128725', 'published_year' => 2008],
            ['title' => 'The Pragmatic Programmer', 'author' => 'Andrew Hunt', 'isbn' => '9780201616224', 'published_year' => 1999],
            ['title' => 'Deep Learning', 'author' => 'Ian Goodfellow', 'isbn' => '9780262035613', 'published_year' => 2016],
            ['title' => 'Computer Organization and Design', 'author' => 'David A. Patterson', 'isbn' => '9780123744937', 'published_year' => 2009],
        ];

        foreach ($books as $book) {
            $library->books()->create($book);
        }
    }
}
