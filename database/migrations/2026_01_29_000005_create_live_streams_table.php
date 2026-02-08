<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('stream_key')->unique();
            $table->string('platform'); // youtube, facebook, custom
            $table->string('stream_url')->nullable();
            $table->string('embed_url')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, live, ended, cancelled
            $table->integer('viewer_count')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['status', 'scheduled_at']);
            $table->index('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_streams');
    }
};
