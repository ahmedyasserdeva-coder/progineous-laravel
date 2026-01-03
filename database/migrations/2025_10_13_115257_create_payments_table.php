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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Client/User Information
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            
            // Payment Gateway
            $table->enum('gateway', ['stripe', 'paypal', 'fawaterak'])->default('fawaterak');
            
            // Payment Details
            $table->string('transaction_id')->unique(); // External transaction ID from gateway
            $table->string('invoice_number')->nullable(); // Our internal invoice number
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('currency', 3)->default('EGP'); // EGP, USD, EUR, SAR, etc.
            
            // Payment Status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            
            // Gateway-Specific Data (JSON)
            $table->json('gateway_data')->nullable(); // Store gateway-specific response data
            
            // Fawaterak-Specific Fields
            $table->string('fawaterak_invoice_id')->nullable();
            $table->string('fawaterak_invoice_key')->nullable();
            $table->integer('fawaterak_payment_method_id')->nullable(); // 2=Visa/Mastercard, 3=Fawry, 4=Meeza, etc.
            $table->string('fawaterak_payment_method_name')->nullable();
            
            // Stripe-Specific Fields
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_charge_id')->nullable();
            
            // PayPal-Specific Fields
            $table->string('paypal_order_id')->nullable();
            $table->string('paypal_payer_id')->nullable();
            
            // Items Purchased (JSON)
            $table->json('items')->nullable(); // Array of products/services purchased
            
            // Customer Information (JSON)
            $table->json('customer_info')->nullable(); // Name, email, phone, address
            
            // Tax & Discount
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            
            // Payment Metadata
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Any additional data
            
            // Refund Information
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->text('refund_reason')->nullable();
            
            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('client_id');
            $table->index('gateway');
            $table->index('status');
            $table->index('transaction_id');
            $table->index('invoice_number');
            $table->index('fawaterak_invoice_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
