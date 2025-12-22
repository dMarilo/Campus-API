<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Professor;
use App\Models\CourseClass;

class CourseClassProfessor extends Model
{
    protected $table = 'course_class_professor';

    protected $fillable = [
        'course_class_id',
        'professor_id',
        'pin',
        'role',
        'hours_per_week',
        'status',
    ];

    public function getProfessorsByCourseClassId(int $courseClassId): Collection
    {
        $professorIds = $this->newQuery()
            ->where('course_class_id', $courseClassId)
            ->where('status', 'active')
            ->pluck('professor_id');

        return Professor::whereIn('id', $professorIds)->get();
    }

    public function resolveClassByIsbnAndPin(string $isbn, string $pin): CourseClass
    {
        $professor = Professor::where('isbn', $isbn)->firstOrFail();

        $assignment = $this->newQuery()
            ->where('professor_id', $professor->id)
            ->where('pin', $pin)
            ->where('status', 'active')
            ->firstOrFail();

        return CourseClass::with('course')->findOrFail($assignment->course_class_id);
    }
}

