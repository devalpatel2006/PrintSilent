<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->timestamp('last_rotated_at')->nullable()->after('last_used_at');
            $table->string('token_algorithm')->default('HS256')->after('last_rotated_at');
            $table->integer('token_expiry_seconds')->default(3600)->after('token_algorithm');
            $table->boolean('jwt_enabled')->default(false)->after('token_expiry_seconds');
        });
    }

    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->dropColumn([
                'last_rotated_at',
                'token_algorithm',
                'token_expiry_seconds',
                'jwt_enabled',
            ]);
        });
    }
};
