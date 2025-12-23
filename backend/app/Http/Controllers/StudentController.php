<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\CourseClass;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Retrieves all students.
     *
     * This endpoint returns a complete list of students
     * regardless of their status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllStudents()
    {
        $students = (new Student)->getAllStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Retrieves a student by their unique identifier.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentById($id)
    {
        $student = (new Student)->getAStudentById($id);

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    /**
     * Retrieves a student by their student index number.
     *
     * @param string $index
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentByIndex($index)
    {
        $student = Student::where('student_index', $index)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    /**
     * Retrieves students belonging to a specific department.
     *
     * The department is provided as a short code which is internally
     * mapped to a full department name.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentsByDepartment($code)
    {
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

        $students = (new Student)->getStudentsByDepartment($department);

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Retrieves students by their year of study.
     *
     * @param int $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentsByYear($year)
    {
        $students = (new Student)->getStudentsByYear((int)$year);

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Retrieves all students who are currently marked as active.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActiveStudents()
    {
        $students = (new Student)->getActiveStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Retrieves all students who are not currently active.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInactiveStudents()
    {
        $students = (new Student)->getInactiveStudents();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Creates a new student record.
     *
     * The request data is validated and passed to the Student model.
     * Password hashing is handled automatically at the model level.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Updates an existing student record.
     *
     * Only the provided fields are updated.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Deletes a student record.
     *
     * This operation permanently removes the student from the system.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteStudent($id)
    {
        $result = (new Student)->deleteStudentById((int)$id);

        return response()->json([
            'success' => true,
            'message' => 'Student successfully deleted.'
        ]);
    }

        /**
         * Returns all students listening to a specific course class.
         *
         * @param int $classId
         * @return JsonResponse
         */
        public function getStudentsByClass(int $classId): JsonResponse
        {
            $class = CourseClass::findOrFail($classId);

            $students = $class->getListeningStudents();

            return response()->json([
                'data' => $students,
            ]);
        }
}
