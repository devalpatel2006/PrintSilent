<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('print_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('print_job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->string('previous_status')->nullable();
            $table->text('message')->nullable();
            $table->json('metadata')->nullable();
            $table->string('triggered_by')->nullable();
            $table->timestamps();

            $table->index(['print_job_id', 'created_at']);
            $table->index(['organization_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_logs');
    }
};
