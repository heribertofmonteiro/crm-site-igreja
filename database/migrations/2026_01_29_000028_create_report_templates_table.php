<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type'); // financial, members, events, worship, custom
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->json('template_config')->nullable(); // Template configuration
            $table->json('fields')->nullable(); // Report fields definition
            $table->text('header_template')->nullable(); // Header template
            $table->text('footer_template')->nullable(); // Footer template
            $table->text('content_template')->nullable(); // Content template
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
