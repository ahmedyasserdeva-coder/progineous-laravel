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
        // Add preferred_language to admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->string('preferred_language', 10)->default('ar')->after('email');
        });

        // Add preferred_language to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_language', 10)->default('ar')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('preferred_language');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('preferred_language');
        });
    }
};
