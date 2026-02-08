<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('meeting_date');
            $table->string('meeting_location')->nullable();
            $table->json('participants')->nullable(); // Array of user IDs
            $table->boolean('is_active')->default(true);
            $table->text('content')->nullable(); // Meeting minutes content
            $table->text('decisions')->nullable(); // Key decisions made
            $table->text('action_items')->nullable(); // Action items and responsibilities
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index('meeting_date');
            $table->index('department_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_minutes');
    }
};
