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
        Schema::create('dedicated_plans', function (Blueprint $table) {
            $table->id();
            
            // Plan Details
            $table->string('plan_name');
            $table->string('plan_tagline')->nullable();
            $table->text('plan_short_description')->nullable();
            $table->text('plan_description')->nullable();
            
            // Hardware Specifications
            $table->string('cpu_type'); // e.g., "Intel Xeon E5-2670 v3"
            $table->integer('cpu_cores'); // Number of physical cores
            $table->integer('cpu_threads'); // Number of threads
            $table->string('cpu_frequency')->nullable(); // e.g., "2.3 GHz"
            $table->integer('ram_gb'); // RAM in GB
            $table->string('storage_config'); // e.g., "2x 480GB SSD RAID1"
            $table->string('storage_type'); // SSD, NVMe, HDD
            $table->integer('storage_total_gb'); // Total storage in GB
            $table->string('bandwidth'); // e.g., "10TB @ 1Gbps" or "Unmetered @ 1Gbps"
            $table->integer('ipv4_count')->default(1);
            $table->boolean('enable_ipv6')->default(false);
            
            // Vultr Integration
            $table->string('vultr_plan_id')->nullable(); // Vultr Bare Metal Plan ID
            $table->string('vultr_region')->nullable(); // Default region
            
            // Pricing
            $table->enum('payment_type', ['recurring'])->default('recurring');
            $table->decimal('monthly_price', 10, 2)->default(0);
            $table->decimal('quarterly_price', 10, 2)->nullable();
            $table->decimal('semi_annually_price', 10, 2)->nullable();
            $table->decimal('annually_price', 10, 2)->nullable();
            $table->decimal('setup_fee', 10, 2)->default(0);
            
            // Provisioning
            $table->string('setup_time')->default('24-48 hours'); // Estimated setup time
            $table->enum('auto_setup', ['manual', 'on_approval'])->default('manual');
            
            // Operating Systems
            $table->json('os_options')->nullable();
            
            // Control Panels
            $table->json('control_panel_options')->nullable();
            $table->decimal('cpanel_price', 10, 2)->default(0);
            $table->decimal('plesk_price', 10, 2)->default(0);
            
            // Features
            $table->json('features_list')->nullable();
            $table->json('features_list_ar')->nullable();
            $table->boolean('allow_ipmi')->default(true);
            $table->boolean('allow_custom_os')->default(true);
            $table->boolean('allow_raid_config')->default(true);
            
            // Product Options
            $table->boolean('require_domain')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_approval')->default(true); // Manual approval required
            
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
        Schema::dropIfExists('dedicated_plans');
    }
};
