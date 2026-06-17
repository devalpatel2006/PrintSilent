<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->string('public_key')->unique()->after('organization_id');
            $table->text('secret')->nullable()->after('name');
            $table->text('allowed_ips')->nullable()->after('abilities');
            $table->unsignedInteger('rate_limit_per_minute')->default(120)->after('allowed_ips');
            $table->timestamp('last_used_at')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->dropColumn(['public_key', 'secret', 'allowed_ips', 'rate_limit_per_minute', 'last_used_at']);
        });
    }
};
