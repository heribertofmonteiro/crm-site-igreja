<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generated_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // financial, members, events, worship, custom
            $table->string('status')->default('pending'); // pending, generating, completed, failed
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->default('pdf');
            $table->integer('file_size')->nullable();
            $table->json('data')->nullable(); // Report data in JSON format
            $table->json('parameters')->nullable(); // Generation parameters
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('template_id')->nullable()->constrained('report_templates')->onDelete('set null');
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'status']);
            $table->index('generated_at');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_reports');
    }
};
