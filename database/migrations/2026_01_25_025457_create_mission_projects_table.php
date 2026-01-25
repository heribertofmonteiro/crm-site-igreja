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
        Schema::create('mission_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->foreignId('missionary_id')->constrained('missionaries')->onDelete('cascade');
            $table->enum('status', ['planning', 'active', 'completed', 'cancelled'])->default('planning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_projects');
    }
};
