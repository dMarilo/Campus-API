<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'class_code'   => 'CS101',
                'name'         => 'Introduction to Programming',
                'description'  => 'Covers the basics of programming using Python.',
                'professor_id' => 1,
                'year'         => 1,
                'semester'     => 1,
            ],
            [
                'class_code'   => 'CS102',
                'name'         => 'Data Structures',
                'description'  => 'Introduction to algorithms, lists, stacks, queues, trees, and graphs.',
                'professor_id' => 1,
                'year'         => 1,
                'semester'     => 2,
            ],
            [
                'class_code'   => 'MATH201',
                'name'         => 'Linear Algebra',
                'description'  => 'Matrix operations, vector spaces, and applications.',
                'professor_id' => 2,
                'year'         => 2,
                'semester'     => 1,
            ],
            [
                'class_code'   => 'MATH202',
                'name'         => 'Calculus II',
                'description'  => 'Advanced differentiation, integration, and series.',
                'professor_id' => 2,
                'year'         => 2,
                'semester'     => 2,
            ],
            [
                'class_code'   => 'CS301',
                'name'         => 'Operating Systems',
                'description'  => 'Processes, threads, scheduling, memory management, and file systems.',
                'professor_id' => 3,
                'year'         => 3,
                'semester'     => 1,
            ],
            [
                'class_code'   => 'CS302',
                'name'         => 'Databases',
                'description'  => 'Relational models, SQL, transactions, and database design.',
                'professor_id' => 3,
                'year'         => 3,
                'semester'     => 2,
            ],
            [
                'class_code'   => 'CS401',
                'name'         => 'Artificial Intelligence',
                'description'  => 'Covers search, logic, probabilistic reasoning, and machine learning basics.',
                'professor_id' => 1,
                'year'         => 4,
                'semester'     => 1,
            ],
            [
                'class_code'   => 'CS402',
                'name'         => 'Computer Networks',
                'description'  => 'Networking models, protocols, and distributed systems.',
                'professor_id' => 2,
                'year'         => 4,
                'semester'     => 2,
            ],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }
    }
}

