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
        Schema::create('mission_support', function (Blueprint $table) {
            $table->id();
            $table->foreignId('missionary_id')->constrained('missionaries')->onDelete('cascade');
            $table->foreignId('supporter_id')->constrained('members')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('frequency', ['monthly', 'yearly', 'one_time'])->default('monthly');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_support');
    }
};
