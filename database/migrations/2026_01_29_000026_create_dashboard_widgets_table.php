<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // chart, metric, table, custom
            $table->boolean('is_active')->default(true);
            $table->string('position'); // top, sidebar, main
            $table->integer('order')->default(0);
            $table->json('config')->nullable(); // Widget configuration
            $table->json('data')->nullable(); // Widget data
            $table->string('size')->default('medium'); // small, medium, large
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['position', 'is_active']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_widgets');
    }
};
