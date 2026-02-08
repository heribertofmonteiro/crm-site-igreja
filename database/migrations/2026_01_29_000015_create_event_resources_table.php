<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable(); // pdf, doc, image, video, link
            $table->string('url')->nullable(); // For external resources
            $table->integer('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->boolean('is_public')->default(true);
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['event_id', 'is_public']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_resources');
    }
};
