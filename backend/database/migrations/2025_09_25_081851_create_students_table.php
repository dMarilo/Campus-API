<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('faculty'); // e.g. "Electrical Engineering"
            $table->unsignedSmallInteger('year_of_study'); // 1, 2, 3, 4
            $table->unsignedTinyInteger('semester');       // 1-8
            $table->year('start_year'); // the year the student started studies
            $table->string('student_code')->unique(); // card code
            $table->string('dorm_room')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
