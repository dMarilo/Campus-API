<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_class_professor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_class_id')
                  ->constrained('classes')
                  ->cascadeOnDelete();

            $table->foreignId('professor_id')
                  ->constrained('professors')
                  ->cascadeOnDelete();

            $table->string('role')->nullable(); // lecturer, assistant, lab_assistant
            $table->unsignedInteger('hours_per_week')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();

            // business rule: same professor cannot be assigned twice to same class
            $table->unique(['course_class_id', 'professor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_class_professor');
    }
};
