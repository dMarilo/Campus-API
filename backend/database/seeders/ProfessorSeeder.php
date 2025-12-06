<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        Professor::insert([
            [
                'first_name' => 'Marko',
                'isbn' => '123',
                'last_name' => 'Petrović',
                'email' => 'marko.petrovic@faculty.edu',
                'phone' => '061123456',
                'academic_title' => 'Prof. Dr.',
                'department' => 'Computer Science',
                'employment_type' => 'full_time',
                'status' => 'active',
                'office_location' => 'Building A, Room 203',
                'office_hours' => 'Mon 10–12, Wed 14–16',
            ],
            [
                'first_name' => 'Ivana',
                'isbn' => '456',
                'last_name' => 'Jovanović',
                'email' => 'ivana.jovanovic@faculty.edu',
                'phone' => null,
                'academic_title' => 'Assoc. Prof.',
                'department' => 'Electrical Engineering',
                'employment_type' => 'part_time',
                'status' => 'active',
                'office_location' => 'Building B, Room 115',
                'office_hours' => 'Tue 09–11',
            ],
            [
                'first_name' => 'Nikola',
                'isbn' => '789',
                'last_name' => 'Kovačević',
                'email' => 'nikola.kovacevic@faculty.edu',
                'phone' => null,
                'academic_title' => 'Assistant',
                'department' => 'Computer Science',
                'employment_type' => 'external',
                'status' => 'active',
                'office_location' => null,
                'office_hours' => null,
            ],
        ]);
    }
}
