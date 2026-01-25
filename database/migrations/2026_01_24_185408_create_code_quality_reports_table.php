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
        Schema::create('code_quality_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('scan_date');
            $table->integer('total_files');
            $table->decimal('average_complexity', 5, 2);
            $table->integer('technical_debt_hours');
            $table->integer('duplicated_lines');
            $table->json('metrics')->nullable(); // For additional metrics
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_quality_reports');
    }
};
