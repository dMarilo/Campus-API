<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BookSeeder::class,
            DormSeeder::class,
            RoomSeeder::class,
            StudentSeeder::class,
            BookCopySeeder::class,
        ]);
    }
}
