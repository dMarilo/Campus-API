<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->cascadeOnDelete();

            $table->foreignId('academic_year_id')
                  ->constrained('academic_years')
                  ->cascadeOnDelete();

            $table->foreignId('semester_id')
                  ->constrained('semesters')
                  ->cascadeOnDelete();

            // Academic structure
            $table->unsignedTinyInteger('year_of_study');
            $table->string('group')->nullable();
            $table->unsignedInteger('capacity');

            // Lifecycle
            $table->enum('status', [
                'planned',
                'active',
                'finished',
                'cancelled'
            ])->default('planned');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};

