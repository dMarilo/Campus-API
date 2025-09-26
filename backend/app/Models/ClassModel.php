<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_code',
        'name',
        'description',
        'professor_id',
        'year',
        'semester',
    ];

    // Relationships
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
