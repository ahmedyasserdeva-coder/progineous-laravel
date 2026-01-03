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
        Schema::table('services', function (Blueprint $table) {
            // Add username column (generic for all service types)
            $table->string('username')->nullable()->after('domain');
            
            // Add password column (encrypted)
            $table->text('password')->nullable()->after('username');
            
            // Add server_data column (JSON for storing additional server info)
            $table->json('server_data')->nullable()->after('server_specs');
            
            // Update status enum to include 'failed'
            $table->dropColumn('status');
        });
        
        // Add status column with updated enum
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated', 'cancelled', 'failed'])->default('pending')->after('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'server_data']);
            
            // Restore original status enum
            $table->dropColumn('status');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated', 'cancelled'])->default('pending');
        });
    }
};
