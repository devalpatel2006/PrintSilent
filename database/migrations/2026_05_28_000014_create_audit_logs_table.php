<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained('api_keys')->nullOnDelete();
            $table->string('action');
            $table->string('resource_type')->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('method');
            $table->string('path');
            $table->string('ip_address');
            $table->integer('status_code');
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('success')->default(true);
            $table->text('error_message')->nullable();
            $table->float('response_time_ms')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'created_at']);
            $table->index(['api_key_id', 'created_at']);
            $table->index('action');
            $table->index('resource_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
