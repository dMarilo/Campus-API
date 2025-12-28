<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('class_student', function (Blueprint $table) {

            // Attempts & history (informational only)
            if (!Schema::hasColumn('class_student', 'attempt')) {
                $table->unsignedTinyInteger('attempt')
                      ->default(1)
                      ->after('student_id');
            }

            if (!Schema::hasColumn('class_student', 'first_attempt_year')) {
                $table->unsignedSmallInteger('first_attempt_year')
                      ->nullable()
                      ->after('attempt');
            }

            // Results
            if (!Schema::hasColumn('class_student', 'passed')) {
                $table->boolean('passed')
                      ->default(false)
                      ->after('first_attempt_year');
            }

            if (!Schema::hasColumn('class_student', 'grade')) {
                $table->unsignedTinyInteger('grade')
                      ->nullable()
                      ->after('passed');
            }

            if (!Schema::hasColumn('class_student', 'final_exam_passed_at')) {
                $table->date('final_exam_passed_at')
                      ->nullable()
                      ->after('grade');
            }

            // Obligations
            if (!Schema::hasColumn('class_student', 'attendance_percentage')) {
                $table->decimal('attendance_percentage', 5, 2)
                      ->nullable()
                      ->after('final_exam_passed_at');
            }

            if (!Schema::hasColumn('class_student', 'coursework_completed')) {
                $table->boolean('coursework_completed')
                      ->default(false)
                      ->after('attendance_percentage');
            }

            if (!Schema::hasColumn('class_student', 'eligible_for_exam')) {
                $table->boolean('eligible_for_exam')
                      ->default(false)
                      ->after('coursework_completed');
            }

            // Dates & notes
            if (!Schema::hasColumn('class_student', 'enrolled_at')) {
                $table->date('enrolled_at')
                      ->nullable()
                      ->after('eligible_for_exam');
            }

            if (!Schema::hasColumn('class_student', 'notes')) {
                $table->text('notes')
                      ->nullable()
                      ->after('enrolled_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('class_student', function (Blueprint $table) {
            $table->dropColumn([
                'attempt',
                'first_attempt_year',
                'passed',
                'grade',
                'final_exam_passed_at',
                'attendance_percentage',
                'coursework_completed',
                'eligible_for_exam',
                'enrolled_at',
                'notes',
            ]);
        });
    }
};
