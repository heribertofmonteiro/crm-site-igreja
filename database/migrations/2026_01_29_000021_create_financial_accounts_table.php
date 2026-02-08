<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_type'); // checking, savings, investment, credit_card
            $table->string('bank_name')->nullable();
            $table->string('agency_number')->nullable();
            $table->string('account_number')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->string('currency')->default('BRL');
            $table->foreignId('responsible_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['account_type', 'is_active']);
            $table->index('responsible_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_accounts');
    }
};
