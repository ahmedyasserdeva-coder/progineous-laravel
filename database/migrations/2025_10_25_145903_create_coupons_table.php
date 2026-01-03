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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2);
            $table->decimal('min_order', 10, 2)->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->date('expires_at')->nullable();
            $table->text('description')->nullable();
            
            // Product selection
            $table->boolean('apply_to_all')->default(true);
            $table->json('products')->nullable(); // Array of product IDs with type prefix
            
            // Billing cycles
            $table->json('billing_cycles')->nullable(); // Array of billing cycles
            
            // Customer eligibility
            $table->enum('customer_type', ['all', 'new', 'existing'])->default('all');
            
            // Usage restrictions
            $table->boolean('once_per_order')->default(false);
            $table->boolean('once_per_client')->default(false);
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
