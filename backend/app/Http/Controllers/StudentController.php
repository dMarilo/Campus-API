<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // ------------------------------------------------
    // GET ALL STUDENTS
    // ------------------------------------------------
    public function getAllStudents()
    {
        $students = (new Student)->getAllStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

        // ------------------------------------------------
    // GET STUDENT BY ID
    // ------------------------------------------------
    public function getStudentById($id)
    {
        $student = (new Student)->getAStudentById($id);

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    // ------------------------------------------------
    // GET STUDENT BY INDEX
    // ------------------------------------------------
    public function getStudentByIndex($index)
    {
        $student = Student::where('student_index', $index)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    public function getStudentsByDepartment($code)
    {
        // Map short codes → full department names
        $departments = [
            'e'  => 'Elektrotehnika',
            'ri' => 'Računarstvo i informatika',
        ];

        if (!isset($departments[$code])) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown department code.'
            ], 400);
        }

        $department = $departments[$code];

        // Fetch students
        $students = (new Student)->getStudentsByDepartment($department);

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    // ------------------------------------------------
    // GET STUDENTS BY YEAR OF STUDY
    // ------------------------------------------------
    public function getStudentsByYear($year)
    {
        $students = (new Student)->getStudentsByYear((int)$year);

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    // ------------------------------------------------
    // GET ACTIVE STUDENTS
    // ------------------------------------------------
    public function getActiveStudents()
    {
        $students = (new Student)->getActiveStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    // ------------------------------------------------
    // GET INACTIVE STUDENTS
    // ------------------------------------------------
    public function getInactiveStudents()
    {
        $students = (new Student)->getInactiveStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function createStudent(Request $request)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:students,email',
            'phone'             => 'nullable|string|max:20',
            'date_of_birth'     => 'nullable|date',
            'gender'            => 'nullable|string',
            'student_index'     => 'required|string|unique:students,student_index',
            'year_of_study'     => 'required|integer|min:1|max:6',
            'department'        => 'required|string',
            'status'            => 'required|string',
            'password'          => 'required|string|min:6',
            'role'              => 'nullable|string',
            'profile_image_url' => 'nullable|string',
        ]);

        $student = (new Student)->createStudent($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student successfully created.',
            'data' => $student
        ], 201);
    }

    public function updateStudent(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name'        => 'sometimes|string|max:255',
            'last_name'         => 'sometimes|string|max:255',
            'email'             => 'sometimes|email|unique:students,email,' . $id,
            'phone'             => 'sometimes|string|max:20',
            'date_of_birth'     => 'sometimes|date',
            'gender'            => 'sometimes|string',
            'student_index'     => 'sometimes|string|unique:students,student_index,' . $id,
            'year_of_study'     => 'sometimes|integer|min:1|max:6',
            'department'        => 'sometimes|string',
            'status'            => 'sometimes|string',
            'password'          => 'sometimes|string|min:6',
            'role'              => 'sometimes|string',
            'profile_image_url' => 'sometimes|string',
        ]);

        $student = (new Student)->updateStudentById($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Student successfully updated.',
            'data' => $student
        ]);
    }

    public function deleteStudent($id)
    {
        $result = (new Student)->deleteStudentById((int)$id);

        return response()->json([
            'success' => true,
            'message' => 'Student successfully deleted.'
        ]);
    }




}
