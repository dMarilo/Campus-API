<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    public function run()
    {
        $professors = [
            [
                'professor_code' => 'P001',
                'first_name'     => 'John',
                'last_name'      => 'Doe',
                'email'          => 'johndoe@example.com',
                'phone'          => '123456789',
                'department'     => 'Computer Science',
                'faculty'        => 'Engineering',
                'office'         => 'Room 101',
                'bio'            => 'Expert in Artificial Intelligence and Machine Learning.',
            ],
            [
                'professor_code' => 'P002',
                'first_name'     => 'Anna',
                'last_name'      => 'Smith',
                'email'          => 'annasmith@example.com',
                'phone'          => '987654321',
                'department'     => 'Mathematics',
                'faculty'        => 'Science',
                'office'         => 'Room 202',
                'bio'            => 'Specialist in Applied Mathematics and Statistics.',
            ],
        ];

        foreach ($professors as $professor) {
            Professor::create($professor);
        }
    }
}
