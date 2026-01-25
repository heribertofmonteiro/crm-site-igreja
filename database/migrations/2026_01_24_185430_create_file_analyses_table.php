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
        Schema::create('file_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->enum('grade', ['A', 'B', 'C', 'D', 'F']);
            $table->integer('complexity');
            $table->integer('lines_of_code');
            $table->integer('issues_count');
            $table->decimal('maintainability_index', 5, 2);
            $table->json('issues')->nullable(); // List of issues
            $table->timestamp('last_analyzed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_analyses');
    }
};
