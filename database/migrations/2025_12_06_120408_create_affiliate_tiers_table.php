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
        // Affiliate Tiers (Bronze, Silver, Gold, Platinum)
        Schema::create('affiliate_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // emoji or icon class
            $table->string('color')->default('gray'); // tailwind color
            $table->decimal('commission_rate', 5, 2); // percentage
            $table->integer('min_referrals')->default(0); // minimum referrals to reach this tier
            $table->integer('min_conversions')->default(0); // minimum conversions to reach this tier
            $table->decimal('min_earnings', 10, 2)->default(0); // minimum earnings to reach this tier
            $table->text('benefits')->nullable(); // JSON array of benefits
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tier Milestones & Rewards
        Schema::create('affiliate_tier_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // referrals, conversions, earnings
            $table->integer('target_value'); // e.g., 10 referrals, 50 conversions
            $table->string('reward_type'); // bonus, commission_boost, gift
            $table->decimal('reward_value', 10, 2); // e.g., $50 bonus
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Track which rewards affiliates have earned
        Schema::create('affiliate_earned_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->foreignId('affiliate_tier_reward_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2); // actual reward amount
            $table->string('status')->default('pending'); // pending, paid, cancelled
            $table->timestamp('earned_at');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['affiliate_id', 'affiliate_tier_reward_id'], 'affiliate_reward_unique');
        });

        // Add tier_id to affiliates table
        Schema::table('affiliates', function (Blueprint $table) {
            $table->foreignId('tier_id')->nullable()->after('status')->constrained('affiliate_tiers')->nullOnDelete();
            $table->timestamp('tier_upgraded_at')->nullable()->after('tier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign(['tier_id']);
            $table->dropColumn(['tier_id', 'tier_upgraded_at']);
        });

        Schema::dropIfExists('affiliate_earned_rewards');
        Schema::dropIfExists('affiliate_tier_rewards');
        Schema::dropIfExists('affiliate_tiers');
    }
};
