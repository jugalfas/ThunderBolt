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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->longText('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->enum('status', ['draft', 'published', 'scheduled', 'pending_review', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable(); // To handle scheduling
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
