<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')
                  ->constrained('buildings')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->nullable();

            $table->integer('floor')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('type')->nullable();

            $table->text('description')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};

