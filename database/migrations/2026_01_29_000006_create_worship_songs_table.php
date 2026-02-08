<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worship_songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('key')->nullable(); // C, D, Em, etc
            $table->integer('bpm')->nullable();
            $table->integer('duration')->nullable(); // em segundos
            $table->text('lyrics')->nullable();
            $table->text('chords')->nullable();
            $table->string('ccli_number')->nullable(); // CCLI license number
            $table->string('youtube_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['title', 'is_active']);
            $table->index('artist');
            $table->index('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worship_songs');
    }
};
