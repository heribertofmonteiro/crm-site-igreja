<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fiscal_council_meetings', function (Blueprint $table) {
            $table->id();
            $table->date('meeting_date');
            $table->json('attendees')->nullable(); // Lista de participantes
            $table->text('minutes')->nullable(); // Ata da reunião
            $table->text('decisions')->nullable(); // Decisões tomadas
            $table->enum('status', ['scheduled', 'held', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_council_meetings');
    }
};
