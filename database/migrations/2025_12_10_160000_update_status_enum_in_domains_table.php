<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change ENUM to STRING to allow any status value
        Schema::table('domains', function (Blueprint $table) {
            $table->string('status', 50)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First update any non-standard values to 'pending'
        DB::table('domains')
            ->whereNotIn('status', ['pending', 'active', 'expired', 'suspended', 'transferred'])
            ->update(['status' => 'pending']);
            
        Schema::table('domains', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'expired', 'suspended', 'transferred'])->default('pending')->change();
        });
    }
};
