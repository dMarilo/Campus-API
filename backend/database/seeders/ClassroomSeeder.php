<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        Classroom::insert([
            [
                'building_id' => 1,
                'name' => 'Room 101',
                'code' => 'R101',
                'floor' => 1,
                'capacity' => 30,
                'type' => 'lecture',
                'description' => 'Standard lecture classroom',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_id' => 1,
                'name' => 'Room 102',
                'code' => 'R102',
                'floor' => 1,
                'capacity' => 25,
                'type' => 'seminar',
                'description' => 'Seminar classroom',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_id' => 1,
                'name' => 'Lecture Hall A',
                'code' => 'LH-A',
                'floor' => 0,
                'capacity' => 120,
                'type' => 'lecture',
                'description' => 'Large lecture hall',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_id' => 1,
                'name' => 'Computer Lab 1',
                'code' => 'LAB-1',
                'floor' => 2,
                'capacity' => 40,
                'type' => 'lab',
                'description' => 'Computer laboratory',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

