<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes for the Student model.
     * Represents personal, academic, and authentication-related
     * information for a student.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'student_index',
        'isbn',
        'year_of_study',
        'department',
        'status',
        'password',
        'role',
        'profile_image_url',
    ];

    /**
     * Model boot method used to automatically hash passwords.
     *
     * - Hashes the password when a student is created
     * - Re-hashes the password only if it has been modified on update
     *
     * This ensures password security without requiring
     * manual hashing in controllers or services.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if ($student->password) {
                $student->password = Hash::make($student->password);
            }
        });

        static::updating(function ($student) {
            if ($student->isDirty('password')) {
                $student->password = Hash::make($student->password);
            }
        });
    }

    /**
     * Retrieves all students from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStudents()
    {
        return $this->all();
    }

    /**
     * Retrieves a single student by their unique identifier.
     * Throws an exception if the student does not exist.
     *
     * @param int $id
     * @return Student
     */
    public function getAStudentById(int $id)
    {
        return $this->findOrFail($id);
    }

    /**
     * Retrieves a student by their student index number.
     * Throws an exception if the student does not exist.
     *
     * @param string $index
     * @return Student
     */
    public function getStudentByIndex(string $index)
    {
        return $this->where('student_index', $index)->firstOrFail();
    }

    /**
     * Retrieves all students belonging to a specific department.
     *
     * @param string $department
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsByDepartment(string $department)
    {
        return $this->where('department', $department)->get();
    }

    /**
     * Retrieves all students enrolled in a specific year of study.
     *
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudentsByYear(int $year)
    {
        return $this->where('year_of_study', $year)->get();
    }

    /**
     * Retrieves all students who are currently marked as active.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveStudents()
    {
        return $this->where('status', 'active')->get();
    }

    /**
     * Retrieves all students who are not currently active.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInactiveStudents()
    {
        return $this->where('status', '!=', 'active')->get();
    }

    /**
     * Creates and stores a new student record in the database.
     *
     * @param array $data
     * @return Student
     */
    public function createStudent(array $data)
    {
        return $this->create($data);
    }

    /**
     * Updates an existing student record by its identifier.
     * Throws an exception if the student does not exist.
     *
     * @param int $id
     * @param array $data
     * @return Student
     */
    public function updateStudentById(int $id, array $data)
    {
        $student = $this->findOrFail($id);
        $student->update($data);

        return $student;
    }

    /**
     * Deletes a student record from the database.
     * This operation permanently removes the student.
     *
     * @param int $id
     * @return bool|null
     */
    public function deleteStudentById(int $id)
    {
        $student = $this->findOrFail($id);
        return $student->delete();
    }
}
