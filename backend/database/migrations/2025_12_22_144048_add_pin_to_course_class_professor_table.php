<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('course_class_professor', function (Blueprint $table) {
            $table->string('pin')
                  ->after('professor_id')
                  ->comment('Unique pin for professor-course assignment');
        });
    }

    public function down(): void
    {
        Schema::table('course_class_professor', function (Blueprint $table) {
            $table->dropColumn('pin');
        });
    }
};

