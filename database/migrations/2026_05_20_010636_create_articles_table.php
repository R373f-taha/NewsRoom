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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('author_id')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('status', ['draft', 'published','archived'])->default('draft');
            $table->foreignId('reviewer_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->dateTime('published_at')->nullable();   
            $table->timestamps();
            $table->index('author_id');
            $table->index('reviewer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
