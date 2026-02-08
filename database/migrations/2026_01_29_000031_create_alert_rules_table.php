<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trigger_type'); // threshold, deadline, event, custom
            $table->boolean('is_active')->default(true);
            $table->json('conditions')->nullable(); // Alert conditions
            $table->json('actions')->nullable(); // Alert actions
            $table->string('notification_channel')->default('system'); // system, email, sms, webhook
            $table->json('notification_config')->nullable(); // Notification settings
            $table->integer('cooldown_minutes')->default(60); // Cooldown period
            $table->timestamp('last_triggered')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['trigger_type', 'is_active']);
            $table->index('last_triggered');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_rules');
    }
};
