<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_playlist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_playlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('media_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->unique(['media_playlist_id', 'media_id']);
            $table->index(['media_playlist_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_playlist_items');
    }
};
