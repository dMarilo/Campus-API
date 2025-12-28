<?php

namespace App\Http\Controllers;

use App\Models\CourseClassProfessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CourseClass;

class CourseClassController extends Controller
{
    /**
     * CourseClassProfessor pivot model instance.
     * Used to resolve relationships between course classes and professors.
     */
    protected CourseClassProfessor $pivot;

    /**
     * Injects the CourseClassProfessor model into the controller.
     *
     * @param CourseClassProfessor $pivot
     */
    public function __construct(CourseClassProfessor $pivot)
    {
        $this->pivot = $pivot;
    }

    /**
     * Retrieves all active professors assigned to a specific course class.
     *
     * This endpoint resolves teaching assignments via the pivot table
     * and returns the associated Professor models.
     *
     * @param int $classId
     * @return JsonResponse
     */
    public function professors(int $classId): JsonResponse
    {
        $professors = $this->pivot->getProfessorsByCourseClassId($classId);

        return response()->json($professors);
    }

    public function registerFinalExam(int $classId,Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'final_exam_passed_at' => ['required', 'date'],
        ]);

        $class = CourseClass::findOrFail($classId);

        $class->registerFinalExamForStudent(
            $validated['student_id'],
            $validated['final_exam_passed_at']
        );

        return response()->json([
            'message' => 'Final exam date registered.',
            'class_id' => $classId,
            'student_id' => $validated['student_id'],
            'final_exam_passed_at' => $validated['final_exam_passed_at'],
        ]);
    }
}
