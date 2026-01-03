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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->enum('type', ['cpanel', 'plesk', 'directadmin', 'custom']);
            $table->decimal('monthly_cost', 10, 2)->nullable();
            
            // Connection Details
            $table->string('hostname');
            $table->ipAddress('ip_address');
            $table->integer('port')->nullable();
            $table->integer('max_accounts')->nullable();
            $table->string('datacenter')->nullable();
            $table->text('assigned_ips')->nullable();
            
            // Authentication
            $table->string('username');
            $table->text('password'); // Will be encrypted
            $table->text('api_token')->nullable();
            $table->integer('port_override')->nullable();
            $table->boolean('use_ssl')->default(true);
            
            // Nameservers
            $table->string('nameserver1')->nullable();
            $table->ipAddress('nameserver1_ip')->nullable();
            $table->string('nameserver2')->nullable();
            $table->ipAddress('nameserver2_ip')->nullable();
            $table->string('nameserver3')->nullable();
            $table->ipAddress('nameserver3_ip')->nullable();
            $table->string('nameserver4')->nullable();
            $table->ipAddress('nameserver4_ip')->nullable();
            
            // Status
            $table->boolean('status')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
