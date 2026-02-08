<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // balance_sheet, income_statement, cash_flow, budget_report
            $table->date('period_start');
            $table->date('period_end');
            $table->json('data')->nullable(); // Report data in JSON format
            $table->string('file_path')->nullable(); // Generated report file
            $table->string('status')->default('generated'); // generated, approved, archived
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index(['type', 'status']);
            $table->index(['period_start', 'period_end']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
