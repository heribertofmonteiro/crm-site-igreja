<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Rate limit key
            $table->string('identifier')->nullable(); // IP address or token
            $table->integer('max_attempts')->default(60);
            $table->integer('decay_minutes')->default(60);
            $table->integer('attempts')->default(0);
            $table->timestamp('reset_at')->nullable();
            $table->timestamps();
            
            $table->index(['key', 'identifier']);
            $table->index('reset_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_rate_limits');
    }
};
