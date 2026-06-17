<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->string('session_token')->unique();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('authenticated_at');
            $table->timestamp('expires_at');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->index('device_id');
            $table->index('session_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_sessions');
    }
};
