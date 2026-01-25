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
        Schema::create('refactoring_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->string('issue_type'); // e.g., 'high_complexity', 'code_smell', 'duplication'
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refactoring_tasks');
    }
};
