<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('book_copies', function (Blueprint $table) {

            // ISBN as primary key
            $table->string('isbn')->primary();

            // Reference to the abstract book
            $table->unsignedBigInteger('book_id');

            // Status of the physical copy
            $table->enum('status', [
                'available',
                'borrowed',
                'lost',
                'damaged'
            ])->default('available');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_copies');
    }
};
