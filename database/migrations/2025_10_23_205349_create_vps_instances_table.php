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
        Schema::create('vps_instances', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('vps_plan_id')->constrained('vps_plans')->onDelete('restrict');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            
            // Vultr Instance Details
            $table->string('vultr_instance_id')->unique()->nullable(); // Vultr Instance ID
            $table->string('vultr_region'); // Region where deployed
            
            // Instance Configuration
            $table->string('hostname');
            $table->string('label')->nullable(); // User-friendly label
            $table->string('main_ip')->nullable(); // Primary IPv4
            $table->string('ipv6_main')->nullable(); // Primary IPv6
            $table->integer('os_id'); // Operating System ID
            $table->string('os_name')->nullable(); // OS Name for display
            $table->string('control_panel')->default('none'); // none, cpanel, plesk, webmin
            
            // Instance Status
            $table->enum('status', [
                'pending',        // Waiting for payment/approval
                'provisioning',   // Being created on Vultr
                'active',         // Running
                'suspended',      // Suspended by admin
                'terminated',     // Deleted
                'failed'          // Creation failed
            ])->default('pending');
            
            $table->enum('power_status', ['running', 'stopped', 'paused'])->default('running');
            
            // Authentication
            $table->text('root_password')->nullable(); // Encrypted
            $table->text('default_password')->nullable(); // Initial password from Vultr
            
            // Resource Usage (optional, can be updated via API)
            $table->bigInteger('bandwidth_used_bytes')->default(0);
            $table->bigInteger('bandwidth_limit_bytes')->nullable();
            
            // Backup Configuration
            $table->boolean('backups_enabled')->default(false);
            $table->string('backup_schedule')->nullable(); // daily, weekly, monthly
            
            // Dates
            $table->timestamp('provisioned_at')->nullable(); // When instance was created on Vultr
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->date('next_due_date')->nullable(); // Next billing date
            
            // Notes
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('client_id');
            $table->index('vultr_instance_id');
            $table->index('next_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vps_instances');
    }
};
