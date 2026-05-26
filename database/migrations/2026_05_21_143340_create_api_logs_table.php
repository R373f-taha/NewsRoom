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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->string('method',10);
            $table->string('path',255);
            $table->string('full_url')->nullable();
            $table->string('ip',45)->nullable();
            $table->text('user_agent')->nullable();
            $table->integer('status_code');
            $table->float('duration_ms');
            $table->json('request_payload')->nullable();
            $table->text('response_preview')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('method');
            $table->index('path');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
