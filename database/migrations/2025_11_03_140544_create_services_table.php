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
            $table->string('service_name'); // اسم الخدمة
            $table->string('domain')->nullable(); // الدومين المرتبط
            $table->json('configuration'); // تفاصيل الخدمة
            
            // For hosting services (cPanel/WHM)
            $table->string('cpanel_username')->nullable();
            $table->string('cpanel_password')->nullable(); // encrypted
            $table->string('server_id')->nullable(); // Server من WHM
            $table->string('package_name')->nullable(); // Package من WHM
            $table->string('whm_account_domain')->nullable();
            
            // For domain services (Dynadot)
            $table->string('domain_registration_id')->nullable(); // Dynadot Registration ID
            $table->date('registration_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('domain_action', ['register', 'transfer'])->nullable();
            $table->string('epp_code')->nullable(); // للنقل
            
            // Common fields
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated', 'cancelled'])->default('pending');
            $table->date('next_due_date')->nullable();
            $table->decimal('recurring_amount', 10, 2)->nullable();
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'semi-annually', 'annually', 'biennially', 'triennially'])->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('client_id');
            $table->index('order_id');
            $table->index('type');
            $table->index('status');
            $table->index('domain');
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
