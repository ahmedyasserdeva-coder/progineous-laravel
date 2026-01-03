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
        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('is_flagged')->default(false)->after('status');
            $table->unsignedBigInteger('flagged_by_admin_id')->nullable()->after('is_flagged');
            $table->timestamp('flagged_at')->nullable()->after('flagged_by_admin_id');
            
            $table->foreign('flagged_by_admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['flagged_by_admin_id']);
            $table->dropColumn(['is_flagged', 'flagged_by_admin_id', 'flagged_at']);
        });
    }
};
