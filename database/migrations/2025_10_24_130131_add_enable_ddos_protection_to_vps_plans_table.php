<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vps_plans', function (Blueprint $table) {
            $table->boolean('enable_ddos_protection')->default(false)->after('enable_backups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vps_plans', function (Blueprint $table) {
            $table->dropColumn('enable_ddos_protection');
        });
    }
};
