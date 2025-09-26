<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'faculty',
        'office',
        'bio',
    ];
}
