<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;

class CourseBookController extends Controller
{
    protected CourseBook $courseBook;

    public function __construct(CourseBook $courseBook)
    {
        $this->courseBook = $courseBook;
    }

    /**
     * Get all books (pivot rows) for a given course
     */
    public function getByCourse(int $courseId)
    {
        return response()->json(
            $this->courseBook->getBooksByCourseId($courseId)
        );
    }
}
