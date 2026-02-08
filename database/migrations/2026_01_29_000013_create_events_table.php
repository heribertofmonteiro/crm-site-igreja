<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('event_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->nullable()->constrained('event_venues')->onDelete('set null');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->boolean('is_all_day')->default(false);
            $table->string('image')->nullable();
            $table->json('contact_info')->nullable(); // ['phone', 'email', 'website']
            $table->decimal('ticket_price', 8, 2)->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('current_participants')->default(0);
            $table->string('status')->default('planned'); // planned, ongoing, completed, cancelled
            $table->boolean('is_public')->default(true);
            $table->boolean('requires_registration')->default(false);
            $table->timestamp('registration_deadline')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['start_time', 'end_time']);
            $table->index('status');
            $table->index('event_type_id');
            $table->index('venue_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
