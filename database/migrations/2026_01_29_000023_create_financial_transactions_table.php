<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('type'); // income, expense, transfer
            $table->foreignId('category_id')->constrained('transaction_categories')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('financial_accounts')->onDelete('cascade');
            $table->foreignId('transfer_account_id')->nullable()->constrained('financial_accounts')->onDelete('set null');
            $table->date('transaction_date');
            $table->boolean('is_reconciled')->default(false);
            $table->timestamp('reconciled_at')->nullable();
            $table->foreignId('reconciled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // Additional data like payment method, reference, etc
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['transaction_date', 'type']);
            $table->index('account_id');
            $table->index('category_id');
            $table->index('is_reconciled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
