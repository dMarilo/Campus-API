<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'ects',
        'department',
        'level',
        'mandatory',
        'status',
    ];


    public function books()
    {
        return $this->belongsToMany(Book::class, 'course_book');
    }


    /* =============================
     | Query methods
     |============================= */

    public function findAll()
    {
        return $this->newQuery()->get();
    }

    public function findById(int $id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function findByCode(string $code)
    {
        return $this->newQuery()
            ->where('code', $code)
            ->firstOrFail();
    }

    public function findByDepartment(string $department)
    {
        return $this->newQuery()
            ->where('department', $department)
            ->get();
    }

    public function findActive()
    {
        return $this->newQuery()
            ->where('status', 'active')
            ->get();
    }
}
