<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('print_jobs', function (Blueprint $table) {
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete()->after('api_key_id');
            $table->string('priority')->default('default')->after('payload');
            $table->integer('retry_count')->default(0)->after('priority');
            $table->timestamp('started_at')->nullable()->after('response_data');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->text('error_message')->nullable()->after('completed_at');

            $table->index(['organization_id', 'status']);
            $table->index('device_id');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('print_jobs', function (Blueprint $table) {
            $table->dropForeignIdFor('Device');
            $table->dropColumn([
                'device_id',
                'priority',
                'retry_count',
                'started_at',
                'completed_at',
                'error_message',
            ]);
            $table->dropIndex(['organization_id', 'status']);
            $table->dropIndex('device_id');
            $table->dropIndex(['status', 'created_at']);
        });
    }
};
