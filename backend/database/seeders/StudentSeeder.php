<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = ['Electrical Engineering', 'Computer Science', 'Mechanical Engineering'];

        for ($i = 1; $i <= 20; $i++) {
            Student::create([
                'first_name'    => "Student{$i}",
                'last_name'     => "Test{$i}",
                'email'         => "student{$i}@faculty.edu",
                'phone'         => "123-456-789{$i}",
                'date_of_birth' => now()->subYears(18 + rand(0, 5))->subDays(rand(0, 365)),
                'faculty'       => $faculties[array_rand($faculties)],
                'year_of_study' => rand(1, 4),
                'semester'      => rand(1, 8),
                'start_year'    => rand(2019, 2025),
                'student_code'  => strtoupper(Str::random(10)),
                'dorm_room'     => rand(0, 1) ? "Room " . rand(100, 400) : null,
            ]);
        }
    }
}
