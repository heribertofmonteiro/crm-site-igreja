<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worship_setlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->nullable()->constrained()->onDelete('set null');
            $table->date('date');
            $table->string('theme')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('date');
            $table->index('church_event_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worship_setlists');
    }
};
