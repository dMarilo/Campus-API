<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'student_index',
        'year_of_study',
        'department',
        'status',
        'password',
        'role',
        'profile_image_url',
    ];

    // Automatically hash password on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if ($student->password) {
                $student->password = Hash::make($student->password);
            }
        });

        static::updating(function ($student) {
            if ($student->isDirty('password')) {
                $student->password = Hash::make($student->password);
            }
        });
    }
}
