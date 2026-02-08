<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // daily, weekly, monthly, quarterly, yearly
            $table->string('report_type'); // financial, members, events, worship, etc
            $table->boolean('is_active')->default(true);
            $table->json('parameters')->nullable(); // Report parameters
            $table->string('recipients')->nullable(); // Email recipients
            $table->string('format')->default('pdf'); // pdf, excel, csv
            $table->time('scheduled_time')->default('09:00:00');
            $table->date('last_run')->nullable();
            $table->date('next_run')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('next_run');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_schedules');
    }
};
