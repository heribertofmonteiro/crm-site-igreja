<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // email, sms, push, system
            $table->string('status'); // sent, failed, pending
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->json('data')->nullable(); // Additional data
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('notification_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'status']);
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
