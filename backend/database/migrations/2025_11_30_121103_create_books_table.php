<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('author');                 // simple string (supports multi-author text)
            $table->string('isbn')->nullable()->unique();
            $table->string('publisher')->nullable();
            $table->integer('published_year')->nullable();
            $table->string('edition')->nullable();

            $table->text('description')->nullable();

            // Inventory
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);

            $table->string('cover_image_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
