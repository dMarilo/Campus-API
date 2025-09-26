<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Str;

class StudentController extends Controller
{
        public function index()
    {
        return response()->json(Student::all());
    }

    /**
     * GET /api/students/year/{year}
     * Retrieve all students by year of study
     */
    public function studentsByYear($year)
    {
        $students = Student::forYear($year)->get();

        if ($students->isEmpty()) {
            return response()->json(['message' => "No students found for year {$year}"], 404);
        }

        return response()->json($students);
    }
        public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email',
            'phone'         => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'faculty'       => 'required|string|max:255',
            'year_of_study' => 'required|integer|min:1|max:10',
            'semester'      => 'required|integer|min:1|max:20',
            'start_year'    => 'required|integer|min:2000|max:2100',
            'student_code'  => 'nullable|string|unique:students,student_code',
            'dorm_room'     => 'nullable|string|max:50',
        ]);

        // Auto-generate a student_code if not provided
        if (empty($validated['student_code'])) {
            $validated['student_code'] = strtoupper(Str::random(10));
        }

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student,
        ], 201);
    }

    public function upgrade($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Optional: max study years (depends on faculty, here let's assume 5 years max)
        $maxYears = 5;

        if ($student->year_of_study >= $maxYears) {
            return response()->json([
                'message' => 'Student is already in the final year and cannot be upgraded further.'
            ], 400);
        }

        $student->year_of_study += 1;
        $student->semester = ($student->year_of_study * 2) - 1; // reset semester to 1st of new year
        $student->save();

        return response()->json([
            'message' => 'Student upgraded successfully',
            'student' => $student,
        ]);
    }
}
