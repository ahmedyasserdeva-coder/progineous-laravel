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
        Schema::table('products', function (Blueprint $table) {
            // Plan Details
            $table->string('tagline')->nullable()->after('name');
            $table->text('short_description')->nullable()->after('description');
            $table->text('features_list')->nullable()->after('features');
            $table->text('welcome_email')->nullable()->after('features_list');
            
            // Product Options
            $table->boolean('require_domain')->default(false)->after('is_active');
            $table->boolean('is_featured')->default(false)->after('require_domain');
            $table->boolean('is_hidden')->default(false)->after('is_featured');
            $table->boolean('allow_multiple_quantities')->default(false)->after('is_hidden');
            
            // Payment Type
            $table->enum('payment_type', ['free', 'one_time', 'recurring'])->default('recurring')->after('billing_cycle');
            
            // Pricing (JSON to store all pricing tiers)
            $table->json('pricing')->nullable()->after('price')->comment('Stores one_time and recurring pricing');
            
            // Server Assignment
            $table->foreignId('server_id')->nullable()->after('api_product_id')->constrained('servers')->onDelete('set null');
            
            // Auto Setup
            $table->enum('auto_setup', ['on_order', 'on_payment', 'on_accept', 'manual'])->default('on_payment')->after('server_id');
            
            // Free Domain Configuration (JSON)
            $table->json('free_domain_config')->nullable()->after('auto_setup')->comment('Stores free domain type, terms, and TLDs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
                'short_description',
                'features_list',
                'welcome_email',
                'require_domain',
                'is_featured',
                'is_hidden',
                'allow_multiple_quantities',
                'payment_type',
                'pricing',
                'server_id',
                'auto_setup',
                'free_domain_config',
            ]);
        });
    }
};
