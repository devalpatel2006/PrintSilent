<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('secret');
            $table->json('events');
            $table->boolean('active')->default(true);
            $table->integer('retry_count')->default(3);
            $table->integer('timeout_seconds')->default(30);
            $table->text('description')->nullable();
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamp('last_successful_at')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'active']);
            $table->index('last_triggered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhooks');
    }
};
