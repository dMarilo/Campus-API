<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes for the Professor model.
     * Represents personal, academic, and administrative information
     * related to a university professor.
     */
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

    /**
     * Defines the many-to-many relationship between professors and course classes.
     *
     * This relationship is mediated through the course_class_professor pivot table,
     * which stores additional metadata such as teaching role, workload,
     * and assignment status.
     */
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

    /**
     * Retrieves a professor by their unique identifier.
     * Throws an exception if the professor does not exist.
     *
     * @param int $id
     * @return Professor
     */
    public function findById(int $id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * Retrieves a professor by their ISBN identifier.
     * Throws an exception if the professor does not exist.
     *
     * @param string $isbn
     * @return Professor
     */
    public function findByIsbn(string $isbn)
    {
        return $this->newQuery()
            ->where('isbn', $isbn)
            ->firstOrFail();
    }

    /**
     * Retrieves all professors from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return $this->newQuery()->get();
    }

    /**
     * Retrieves all professors belonging to a specific department.
     *
     * @param string $department
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByDepartment(string $department)
    {
        return $this->newQuery()
            ->where('department', $department)
            ->get();
    }

    /**
     * Creates and stores a new professor record in the database.
     *
     * @param array $data
     * @return Professor
     */
    public function createProfessor(array $data): Professor
    {
        return $this->newQuery()->create($data);
    }

    /**
     * Updates an existing professor with new data.
     *
     * @param int $id
     * @param array $data
     * @return Professor
     */
    public function updateProfessor(int $id, array $data): Professor
    {
        $professor = $this->findById($id);
        $professor->update($data);

        return $professor;
    }

    /**
     * Deletes a professor record from the database.
     * This operation permanently removes the professor.
     *
     * @param int $id
     * @return void
     */
    public function deleteProfessor(int $id): void
    {
        $professor = $this->findById($id);
        $professor->delete();
    }
}
