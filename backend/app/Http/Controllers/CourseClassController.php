<?php

namespace App\Http\Controllers;
use App\Models\CourseClassProfessor;
use Illuminate\Http\JsonResponse;

class CourseClassController extends Controller
{
    protected CourseClassProfessor $pivot;

    public function __construct(CourseClassProfessor $pivot)
    {
        $this->pivot = $pivot;
    }

    public function professors(int $classId): JsonResponse
    {
        $professors = $this->pivot->getProfessorsByCourseClassId($classId);

        return response()->json($professors);
    }
}


