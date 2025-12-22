<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBook extends Model
{
    /**
     * Explicitly defines the table name for the pivot model.
     * This table represents the association between courses and books.
     */
    protected $table = 'course_book';

    /**
     * Mass-assignable attributes for the CourseBook model.
     * Stores metadata about how a book is used within a course.
     */
    protected $fillable = [
        'course_id',
        'book_id',
        'type',
        'note',
    ];

    /**
     * Retrieves all books associated with a specific course.
     *
     * This method:
     *  - Finds all book IDs linked to the given course
     *  - Returns the corresponding Book models
     *
     * @param int $courseId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBooksByCourseId(int $courseId)
    {
        return Book::whereIn(
            'id',
            $this->where('course_id', $courseId)->pluck('book_id')
        )->get();
    }
}
