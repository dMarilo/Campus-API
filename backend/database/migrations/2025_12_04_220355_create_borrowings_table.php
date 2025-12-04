<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {

            $table->id();

            // Student card id (ISBN)
            $table->string('student_isbn');

            // Physical book copy ISBN
            $table->string('book_isbn');

            // Timestamps
            $table->date('borrowed_at')->nullable();
            $table->date('due_at')->nullable();
            $table->date('returned_at')->nullable();

            $table->enum('status', [
                'borrowed',
                'returned',
                'overdue',
                'lost'
            ])->default('borrowed');

            $table->timestamps();

            // Foreign key constraints (STRING PRIMARY KEYS)
            $table->foreign('student_isbn')
                  ->references('isbn')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('book_isbn')
                  ->references('isbn')
                  ->on('book_copies')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowings');
    }
};
