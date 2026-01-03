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
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->unique();
            $table->string('referral_code', 20)->unique();
            $table->decimal('commission_rate', 5, 2)->default(10.00); // Default 10%
            $table->decimal('total_earnings', 12, 2)->default(0.00);
            $table->decimal('pending_earnings', 12, 2)->default(0.00);
            $table->decimal('paid_earnings', 12, 2)->default(0.00);
            $table->integer('total_referrals')->default(0);
            $table->integer('active_referrals')->default(0);
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('payment_method')->nullable(); // paypal, bank_transfer, wallet
            $table->json('payment_details')->nullable(); // PayPal email, bank account, etc.
            $table->decimal('minimum_payout', 10, 2)->default(50.00);
            $table->timestamp('last_payout_at')->nullable();
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        // Affiliate referrals tracking
        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('referred_client_id');
            $table->string('referral_code');
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->decimal('total_spent', 12, 2)->default(0.00);
            $table->decimal('commission_earned', 12, 2)->default(0.00);
            $table->timestamps();
            
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('referred_client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        // Affiliate commissions/earnings log
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->decimal('commission_amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
        });

        // Affiliate payouts
        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->json('payment_details')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payouts');
        Schema::dropIfExists('affiliate_commissions');
        Schema::dropIfExists('affiliate_referrals');
        Schema::dropIfExists('affiliates');
    }
};