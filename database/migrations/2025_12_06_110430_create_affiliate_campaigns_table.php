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
        Schema::create('affiliate_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Campaign name (e.g., "Facebook Summer 2024")
            $table->string('slug')->unique(); // Unique slug for the campaign link
            $table->string('source')->nullable(); // Source platform (facebook, twitter, instagram, youtube, email, website, other)
            $table->text('description')->nullable();
            $table->string('destination_url')->nullable(); // Custom destination URL (optional)
            $table->unsignedBigInteger('clicks')->default(0);
            $table->unsignedBigInteger('referrals')->default(0);
            $table->unsignedBigInteger('conversions')->default(0);
            $table->decimal('earnings', 10, 2)->default(0);
            $table->enum('status', ['active', 'paused', 'archived'])->default('active');
            $table->timestamp('last_click_at')->nullable();
            $table->timestamps();

            $table->index(['affiliate_id', 'status']);
            $table->index('slug');
        });

        // Add campaign_id to affiliate_referrals if needed
        if (!Schema::hasColumn('affiliate_referrals', 'campaign_id')) {
            Schema::table('affiliate_referrals', function (Blueprint $table) {
                $table->foreignId('campaign_id')->nullable()->after('affiliate_id')->constrained('affiliate_campaigns')->onDelete('set null');
            });
        }

        // Add campaign_id to affiliate_visitors if the table exists
        if (Schema::hasTable('affiliate_visitors') && !Schema::hasColumn('affiliate_visitors', 'campaign_id')) {
            Schema::table('affiliate_visitors', function (Blueprint $table) {
                $table->foreignId('campaign_id')->nullable()->after('affiliate_id')->constrained('affiliate_campaigns')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove campaign_id from affiliate_referrals
        if (Schema::hasColumn('affiliate_referrals', 'campaign_id')) {
            Schema::table('affiliate_referrals', function (Blueprint $table) {
                $table->dropForeign(['campaign_id']);
                $table->dropColumn('campaign_id');
            });
        }

        // Remove campaign_id from affiliate_visitors
        if (Schema::hasTable('affiliate_visitors') && Schema::hasColumn('affiliate_visitors', 'campaign_id')) {
            Schema::table('affiliate_visitors', function (Blueprint $table) {
                $table->dropForeign(['campaign_id']);
                $table->dropColumn('campaign_id');
            });
        }

        Schema::dropIfExists('affiliate_campaigns');
    }
};
