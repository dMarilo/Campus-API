<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BorrowedBook extends Model
{
    protected $fillable = [
        'student_id', 'book_id', 'borrowed_at', 'due_at', 'returned_at'
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isOverdue()
    {
        return is_null($this->returned_at) && now()->gt($this->due_at);
    }
}
