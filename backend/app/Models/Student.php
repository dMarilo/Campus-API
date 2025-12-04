<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    use HasFactory;

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

    // Automatically hash password on create
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


    public function getAllStudents()
    {
        return $this->all();
    }

    public function getAStudentById(int $id)
    {
        return $this->findOrFail($id);
    }

    public function getStudentByIndex(string $index)
    {
        return $this->where('student_index', $index)->firstOrFail();
    }

    public function getStudentsByDepartment(string $department)
    {
        return $this->where('department', $department)->get();
    }

    public function getStudentsByYear(int $year)
    {
        return $this->where('year_of_study', $year)->get();
    }

        public function getActiveStudents()
    {
        return $this->where('status', 'active')->get();
    }

    public function getInactiveStudents()
    {
        return $this->where('status', '!=', 'active')->get();
    }

    public function createStudent(array $data)
    {
        return $this->create($data);
    }

    public function updateStudentById(int $id, array $data)
    {
        $student = $this->findOrFail($id);
        $student->update($data);

        return $student;
    }

    public function deleteStudentById(int $id)
    {
        $student = $this->findOrFail($id);
        return $student->delete();
    }


}
