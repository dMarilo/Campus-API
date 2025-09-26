<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'faculty',
        'year_of_study',
        'semester',
        'start_year',
        'student_code',
        'dorm_room',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'year_of_study' => 'integer',
        'semester' => 'integer',
        'start_year' => 'integer',
    ];

    /**
     * Scope: filter students by year of study
     */
    public function scopeForYear(Builder $query, int $year): Builder
    {
        return $query->where('year_of_study', $year);
    }
}
