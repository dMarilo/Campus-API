<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::insert([
            [
                'code' => 'CS101',
                'name' => 'Algorithms and Data Structures',
                'description' => 'Fundamental algorithms and data structures.',
                'ects' => 7,
                'department' => 'Computer Science',
                'level' => 'bachelor',
                'mandatory' => true,
                'status' => 'active',
            ],
            [
                'code' => 'CS205',
                'name' => 'Operating Systems',
                'description' => 'Process management, memory, file systems.',
                'ects' => 6,
                'department' => 'Computer Science',
                'level' => 'bachelor',
                'mandatory' => true,
                'status' => 'active',
            ],
            [
                'code' => 'EE301',
                'name' => 'Digital Signal Processing',
                'description' => null,
                'ects' => 6,
                'department' => 'Electrical Engineering',
                'level' => 'master',
                'mandatory' => false,
                'status' => 'active',
            ],
        ]);
    }
}
