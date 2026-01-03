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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Campaign name
            $table->enum('type', ['seasonal', 'product_launch', 'loyalty_reward']); // Campaign type
            $table->decimal('discount_percentage', 5, 2); // Discount percentage (e.g., 25.50)
            $table->date('start_date'); // Campaign start date
            $table->date('end_date'); // Campaign end date
            $table->text('description')->nullable(); // Campaign description
            
            // Product Selection (same as coupons)
            $table->boolean('apply_to_all')->default(true); // Apply to all products
            $table->json('products')->nullable(); // Selected products (if not applying to all)
            
            // Billing Cycles (same as coupons)
            $table->json('billing_cycles')->nullable(); // Applicable billing cycles
            
            // Customer Eligibility (same as coupons)
            $table->enum('customer_type', ['all', 'new', 'existing'])->default('all');
            
            // Usage Restrictions (same as coupons)
            $table->boolean('once_per_order')->default(false); // Apply discount once per order
            $table->boolean('once_per_client')->default(false); // Apply discount once per client globally
            
            $table->string('banner_url')->nullable(); // Banner image URL
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('start_date');
            $table->index('end_date');
            $table->index('is_active');
            $table->index(['start_date', 'end_date', 'is_active']); // Composite index for active campaigns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
