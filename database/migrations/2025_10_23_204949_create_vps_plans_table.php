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
        Schema::create('vps_plans', function (Blueprint $table) {
            $table->id();
            
            // Plan Details
            $table->string('plan_name');
            $table->string('plan_tagline')->nullable();
            $table->text('plan_short_description')->nullable();
            $table->text('plan_description')->nullable();
            
            // VPS Specifications
            $table->integer('vcpu_count'); // Number of vCPU cores
            $table->integer('ram_mb'); // RAM in MB
            $table->integer('storage_gb'); // Storage in GB
            $table->integer('bandwidth_gb'); // Bandwidth in GB per month
            $table->integer('ipv4_count')->default(1); // Number of IPv4 addresses
            $table->boolean('enable_ipv6')->default(false);
            
            // Vultr Integration
            $table->string('vultr_plan_id')->nullable(); // Vultr Plan ID (e.g., vc2-1c-1gb)
            $table->string('vultr_region')->nullable(); // Default region (can be changed on order)
            
            // Pricing
            $table->enum('payment_type', ['free', 'one_time', 'recurring'])->default('recurring');
            $table->decimal('monthly_price', 10, 2)->default(0);
            $table->decimal('quarterly_price', 10, 2)->nullable();
            $table->decimal('semi_annually_price', 10, 2)->nullable();
            $table->decimal('annually_price', 10, 2)->nullable();
            $table->decimal('setup_fee', 10, 2)->default(0);
            
            // Operating Systems (JSON array of OS IDs)
            $table->json('os_options')->nullable(); // ['ubuntu-22.04', 'centos-8', 'debian-11', etc.]
            
            // Control Panels (JSON array)
            $table->json('control_panel_options')->nullable(); // ['none', 'cpanel', 'plesk', 'webmin']
            $table->decimal('cpanel_price', 10, 2)->default(0);
            $table->decimal('plesk_price', 10, 2)->default(0);
            
            // Features & Limits
            $table->json('features_list')->nullable(); // List of features in JSON
            $table->json('features_list_ar')->nullable();
            $table->boolean('allow_ssh')->default(true);
            $table->boolean('allow_root')->default(true);
            $table->boolean('allow_backups')->default(true);
            $table->decimal('backup_price', 10, 2)->default(0);
            
            // Product Options
            $table->boolean('require_domain')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_active')->default(true);
            
            // Auto Setup
            $table->enum('auto_setup', ['instant', 'on_payment', 'manual'])->default('on_payment');
            
            // Welcome Email
            $table->unsignedBigInteger('welcome_email_template_id')->nullable();
            
            // Order & Display
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('vultr_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vps_plans');
    }
};
