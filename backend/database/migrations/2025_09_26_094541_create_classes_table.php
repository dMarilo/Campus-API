<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_code')->unique();   // unique identifier (e.g. CS101)
            $table->string('name');                   // class name (e.g. Introduction to Programming)
            $table->text('description')->nullable();  // optional description
            $table->unsignedBigInteger('professor_id')->nullable(); // who teaches it
            $table->integer('year');                  // which study year (1, 2, 3, 4...)
            $table->integer('semester');              // semester number
            $table->timestamps();

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
