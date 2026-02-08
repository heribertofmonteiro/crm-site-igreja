<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worship_setlist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worship_setlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('worship_song_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->text('notes')->nullable();
            $table->string('key_override')->nullable(); // Tom específico para esta execução
            $table->timestamps();
            
            $table->unique(['worship_setlist_id', 'worship_song_id']);
            $table->index(['worship_setlist_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worship_setlist_items');
    }
};
