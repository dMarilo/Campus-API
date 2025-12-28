<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Professor;
use App\Models\CourseClass;
use Illuminate\Support\Facades\DB;

class CourseClassProfessor extends Model
{
    /**
     * Explicitly defines the pivot table name.
     * This table represents teaching assignments between professors
     * and specific course class instances.
     */
    protected $table = 'course_class_professor';

    /**
     * Mass-assignable attributes for the CourseClassProfessor model.
     * Represents metadata about a professor's teaching assignment
     * for a specific course class.
     */
    protected $fillable = [
        'course_class_id',
        'professor_id',
        'pin',
        'role',
        'hours_per_week',
        'status',
    ];

    /**
     * Retrieves all active professors assigned to a specific course class.
     *
     * This method:
     *  - Finds all active teaching assignments for the given course class
     *  - Extracts professor identifiers from the pivot table
     *  - Returns the corresponding Professor models
     *
     * @param int $courseClassId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProfessorsByCourseClassId(int $courseClassId): Collection
    {
        $professorIds = $this->newQuery()
            ->where('course_class_id', $courseClassId)
            ->where('status', 'active')
            ->pluck('professor_id');

        return Professor::whereIn('id', $professorIds)->get();
    }

    /**
     * Resolves the course class being held based on a professor's ISBN
     * and a class-specific PIN.
     *
     * This method is primarily used by the classroom scanner use-case.
     * It performs the following steps:
     *  - Identifies the professor using their ISBN
     *  - Validates the teaching assignment using the provided PIN
     *  - Ensures the assignment is active
     *  - Returns the associated course class, including course details
     *
     * @param string $isbn
     * @param string $pin
     * @return CourseClass
     */
    public function resolveClassByIsbnAndPin(string $isbn, string $pin)
    {
        return DB::transaction(function () use ($isbn, $pin) {

            // 1️⃣ Resolve professor
            $professor = Professor::where('isbn', $isbn)->firstOrFail();

            // 2️⃣ Resolve active teaching assignment
            $assignment = $this->newQuery()
                ->where('professor_id', $professor->id)
                ->where('pin', $pin)
                ->where('status', 'active')
                ->firstOrFail();

            // 3️⃣ Resolve course class
            $courseClass = CourseClass::with('course')
                ->lockForUpdate()
                ->findOrFail($assignment->course_class_id);

            // 4️⃣ Increment iteration (as agreed)
            $courseClass->increment('iteration');

            // 5️⃣ Resolve attending students
            $students = $courseClass->students()->get();

            // 6️⃣ Return a neat, explicit response
            return response()->json([
                'class' => $courseClass->fresh('course'),
                'professor' => $professor,
                'students' => $students,
            ]);
        });
    }
}
