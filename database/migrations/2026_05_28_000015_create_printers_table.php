<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('printer_group_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('identifier');
            $table->boolean('is_default')->default(false);
            $table->enum('health_status', ['healthy', 'degraded', 'offline'])->default('offline');
            $table->unsignedTinyInteger('health_score')->default(0);
            $table->timestamp('last_heartbeat_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'identifier']);
            $table->index(['organization_id', 'is_default']);
            $table->index(['organization_id', 'health_status']);
            $table->index(['printer_group_id', 'health_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
