<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('fingerprint')->unique();
            $table->string('device_token')->unique();
            $table->string('device_type')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['online', 'offline'])->default('offline');
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status']);
            $table->index('fingerprint');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
