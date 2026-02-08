<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // email, sms, push, system
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->string('subject')->nullable();
            $table->text('content');
            $table->json('variables')->nullable(); // Template variables
            $table->json('styles')->nullable(); // Styling options
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
