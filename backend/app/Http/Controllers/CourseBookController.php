<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;

class CourseBookController extends Controller
{
    /**
     * CourseBook model instance.
     * Used to manage the relationship between courses and books.
     */
    protected CourseBook $courseBook;

    /**
     * Injects the CourseBook model into the controller.
     *
     * @param CourseBook $courseBook
     */
    public function __construct(CourseBook $courseBook)
    {
        $this->courseBook = $courseBook;
    }

    /**
     * Retrieves all books associated with a given course.
     *
     * This endpoint resolves the course–book relationship via the pivot table
     * and returns the full Book models linked to the specified course.
     *
     * @param int $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCourse(int $courseId)
    {
        return response()->json(
            $this->courseBook->getBooksByCourseId($courseId)
        );
    }
}
