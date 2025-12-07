<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\CourseClass;

class CourseClassSeeder extends Seeder
{
    public function run(): void
    {
        // Get the current academic year (from AcademicYearSeeder)
        $year = AcademicYear::where('is_active', true)->first();

        if (!$year) {
            throw new \Exception("No active academic year found. Seed AcademicYearSeeder first.");
        }

        // Get the Winter & Summer semesters for this year
        $winter = Semester::where('academic_year_id', $year->id)
                          ->where('code', 'W')
                          ->first();

        $summer = Semester::where('academic_year_id', $year->id)
                          ->where('code', 'S')
                          ->first();

        if (!$winter || !$summer) {
            throw new \Exception("Winter or Summer semesters not found. Seed SemesterSeeder first.");
        }

        // Fetch example courses by course code
        $algorithms = Course::where('code', 'CS101')->first();
        $os = Course::where('code', 'CS205')->first();
        $dsp = Course::where('code', 'EE301')->first();

        if (!$algorithms || !$os || !$dsp) {
            throw new \Exception("Some example courses (CS101, CS205, EE301) were not found. Seed CourseSeeder first.");
        }

        CourseClass::insert([
            // Algorithms - Winter
            [
                'course_id' => $algorithms->id,
                'academic_year_id' => $year->id,
                'semester_id' => $winter->id,
                'year_of_study' => 2,
                'group' => 'A',
                'capacity' => 60,
                'status' => 'active',
            ],
            [
                'course_id' => $algorithms->id,
                'academic_year_id' => $year->id,
                'semester_id' => $winter->id,
                'year_of_study' => 2,
                'group' => 'B',
                'capacity' => 60,
                'status' => 'active',
            ],

            // Operating Systems - Summer
            [
                'course_id' => $os->id,
                'academic_year_id' => $year->id,
                'semester_id' => $summer->id,
                'year_of_study' => 3,
                'group' => 'A',
                'capacity' => 50,
                'status' => 'planned',
            ],

            // DSP - Summer
            [
                'course_id' => $dsp->id,
                'academic_year_id' => $year->id,
                'semester_id' => $summer->id,
                'year_of_study' => 4,
                'group' => 'A',
                'capacity' => 45,
                'status' => 'planned',
            ],
        ]);
    }
}
