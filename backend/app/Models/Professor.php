<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'first_name',
        'last_name',
        'email',
        'phone',
        'academic_title',
        'department',
        'employment_type',
        'status',
        'office_location',
        'office_hours',
    ];

    public function courseClasses()
    {
        return $this->belongsToMany(
            CourseClass::class,
            'course_class_professor',
            'professor_id',
            'course_class_id'
        )->withPivot([
            'role',
            'hours_per_week',
            'status'
        ])->withTimestamps();
    }

        /* =============================
     | Query methods (non-static)
     |============================= */

    public function findById(int $id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function findByIsbn(string $isbn)
    {
        return $this->newQuery()
            ->where('isbn', $isbn)
            ->firstOrFail();
    }

    public function findAll()
    {
        return $this->newQuery()->get();
    }

    public function findByDepartment(string $department)
    {
        return $this->newQuery()
            ->where('department', $department)
            ->get();
    }

        /* =============================
     | Write methods
     |============================= */

    public function createProfessor(array $data): Professor
    {
        return $this->newQuery()->create($data);
    }

    public function updateProfessor(int $id, array $data): Professor
    {
        $professor = $this->findById($id);
        $professor->update($data);

        return $professor;
    }

    public function deleteProfessor(int $id): void
    {
        $professor = $this->findById($id);
        $professor->delete();
    }
}
