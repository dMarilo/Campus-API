<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseClass extends Model
{
    use HasFactory;

    /**
     * Explicitly defines the database table name.
     * This model represents a concrete instance of a course
     * held in a specific academic year and semester.
     */
    protected $table = 'classes';

    /**
     * Mass-assignable attributes for the CourseClass model.
     * Represents the organizational and academic properties
     * of a course instance.
     */
    protected $fillable = [
        'course_id',
        'academic_year_id',
        'semester_id',
        'year_of_study',
        'group',
        'capacity',
        'status',
    ];

    /**
     * Defines the many-to-many relationship between a course class
     * and the professors teaching it.
     *
     * This relationship is mediated through the course_class_professor
     * pivot table, which also stores additional teaching metadata
     * such as role, teaching load, and assignment status.
     */
    public function professors()
    {
        return $this->belongsToMany(
            Professor::class,
            'course_class_professor',
            'course_class_id',
            'professor_id'
        )->withPivot([
            'role',
            'hours_per_week',
            'status'
        ])->withTimestamps();
    }

    /**
     * Defines the many-to-many relationship between a course class
     * and the students attending it.
     *
     * This relationship represents student enrollment into a specific
     * class instance (course + academic year + semester).
     *
     * The relationship is mediated through the class_student pivot table.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            Student::class,
            'class_student',
            'class_id',
            'student_id'
        );
    }

    /**
     * Defines the relationship between a course class and its base course.
     * A course class is a specific realization of a course
     * within a given academic year and semester.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    /**
     * Returns all students listening to this course class.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListeningStudents()
    {
        return $this->students()->get();
    }
}
