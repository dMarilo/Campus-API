<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Basic identity
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            // Academic info
            $table->string('student_index')->unique(); // e.g "EE-12/2021"
            $table->integer('year_of_study')->default(1);
            $table->string('department')->nullable();  // Elektrotehnika / Računarstvo
            $table->enum('status', ['active', 'graduated', 'suspended'])->default('active');

            // Authentication
            $table->string('password');
            $table->string('role')->default('student');

            // Profile
            $table->string('profile_image_url')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }


};
