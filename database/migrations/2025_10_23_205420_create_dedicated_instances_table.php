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
        Schema::create('dedicated_instances', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('dedicated_plan_id')->constrained('dedicated_plans')->onDelete('restrict');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            
            // Vultr Bare Metal Details
            $table->string('vultr_baremetal_id')->unique()->nullable(); // Vultr Bare Metal ID
            $table->string('vultr_region'); // Region where deployed
            
            // Server Configuration
            $table->string('hostname');
            $table->string('label')->nullable();
            $table->string('main_ip')->nullable();
            $table->string('ipv6_main')->nullable();
            $table->integer('os_id');
            $table->string('os_name')->nullable();
            $table->string('control_panel')->default('none');
            
            // Server Status
            $table->enum('status', [
                'pending',          // Order placed, awaiting approval
                'approved',         // Approved by admin
                'provisioning',     // Being set up
                'active',           // Running
                'suspended',        // Suspended by admin
                'terminated',       // Deleted
                'failed'            // Setup failed
            ])->default('pending');
            
            $table->enum('power_status', ['running', 'stopped'])->default('running');
            
            // Authentication
            $table->text('root_password')->nullable(); // Encrypted
            $table->text('ipmi_username')->nullable();
            $table->text('ipmi_password')->nullable(); // Encrypted
            $table->string('ipmi_hostname')->nullable();
            
            // Hardware Details (from Vultr response)
            $table->string('mac_address')->nullable();
            $table->text('hardware_info')->nullable(); // JSON of hardware details
            
            // Resource Usage
            $table->bigInteger('bandwidth_used_bytes')->default(0);
            $table->bigInteger('bandwidth_limit_bytes')->nullable();
            
            // Dates
            $table->timestamp('approved_at')->nullable(); // When admin approved
            $table->timestamp('provisioned_at')->nullable(); // When server was delivered
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->date('next_due_date')->nullable();
            
            // Notes
            $table->text('admin_notes')->nullable();
            $table->text('setup_instructions')->nullable(); // Special setup instructions
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('client_id');
            $table->index('vultr_baremetal_id');
            $table->index('next_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dedicated_instances');
    }
};
