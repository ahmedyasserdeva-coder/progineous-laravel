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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->enum('type', ['domain', 'hosting', 'vps', 'dedicated']);
            $table->string('service_name');
            $table->string('domain')->nullable();
            
            // حقول cPanel/WHM (للاستضافة)
            $table->string('cpanel_username')->nullable();
            $table->text('cpanel_password')->nullable(); // encrypted
            $table->foreignId('server_id')->nullable()->constrained('servers')->onDelete('set null');
            $table->string('package_name')->nullable();
            $table->string('whm_account_domain')->nullable();
            
            // حقول Domain (للدومين)
            $table->string('domain_registration_id')->nullable(); // Dynadot registration ID
            $table->date('registration_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('domain_action', ['register', 'transfer'])->nullable();
            $table->string('epp_code')->nullable(); // للترانسفير
            
            // حقول VPS/Dedicated
            $table->string('ip_address')->nullable();
            $table->string('root_password')->nullable(); // encrypted
            $table->json('server_specs')->nullable(); // CPU, RAM, Disk, etc
            
            // حقول الفواتير
            $table->date('next_due_date')->nullable();
            $table->decimal('recurring_amount', 10, 2)->default(0);
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'])->nullable();
            
            // حالة الخدمة
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated', 'cancelled'])->default('pending');
            
            // تواريخ مهمة
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
