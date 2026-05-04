<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('user_name');
            $table->string('device_info')->nullable()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'device_info']);
        });
    }
};
