<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'course_id',
        'academic_year_id',
        'semester_id',
        'year_of_study',
        'group',
        'capacity',
        'status',
    ];

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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
