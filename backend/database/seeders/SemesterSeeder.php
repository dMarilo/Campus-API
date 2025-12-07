<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        Semester::insert([
            [
                'name' => 'Winter',
                'code' => 'W',
                'order' => 1,
            ],
            [
                'name' => 'Summer',
                'code' => 'S',
                'order' => 2,
            ],
        ]);
    }
}
