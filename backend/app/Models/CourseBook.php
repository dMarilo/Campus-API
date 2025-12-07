<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBook extends Model
{
    protected $table = 'course_book';

    protected $fillable = [
        'course_id',
        'book_id',
        'type',
        'note',
    ];


    public function getBooksByCourseId(int $courseId)
    {
        return Book::whereIn(
            'id',
            $this->where('course_id', $courseId)->pluck('book_id')
        )->get();
    }

}
