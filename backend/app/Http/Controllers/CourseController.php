<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    // READ

    public function index()
    {
        return response()->json(
            $this->course->findAll()
        );
    }

    public function showById(int $id)
    {
        return response()->json(
            $this->course->findById($id)
        );
    }

    public function showByCode(string $code)
    {
        return response()->json(
            $this->course->findByCode($code)
        );
    }

    public function showByDepartment(string $department)
    {
        return response()->json(
            $this->course->findByDepartment($department)
        );
    }

    public function active()
    {
        return response()->json(
            $this->course->findActive()
        );
    }

    // WRITE

    public function store(Request $request)
    {
        $course = $this->course->create(
            $request->only($this->course->getFillable())
        );

        return response()->json($course, 201);
    }

    public function update(Request $request, int $id)
    {
        $course = $this->course->findById($id);
        $course->update(
            $request->only($this->course->getFillable())
        );

        return response()->json($course);
    }

    public function destroy(int $id)
    {
        $course = $this->course->findById($id);
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully'
        ]);
    }
}
