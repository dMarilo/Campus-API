<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classrooms = [
            ['room_number' => '101', 'level' => 1, 'type' => 'normal'],
            ['room_number' => '102', 'level' => 1, 'type' => 'laboratory'],
            ['room_number' => '201', 'level' => 2, 'type' => 'normal'],
            ['room_number' => '202', 'level' => 2, 'type' => 'laboratory'],
            ['room_number' => '301', 'level' => 3, 'type' => 'normal'],
        ];

        foreach ($classrooms as $room) {
            Classroom::create($room);
        }
    }
}
