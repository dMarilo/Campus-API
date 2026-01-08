<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['key' => 'student', 'name' => 'Student'],
            ['key' => 'professor', 'name' => 'Professor'],
            ['key' => 'admin', 'name' => 'Administrator'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['key' => $role['key']], $role);
        }
    }
}

