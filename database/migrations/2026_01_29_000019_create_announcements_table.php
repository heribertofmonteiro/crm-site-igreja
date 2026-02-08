<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('general'); // general, urgent, event, meeting
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at');
            $table->timestamp('expires_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('priority');
            $table->index('published_at');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
