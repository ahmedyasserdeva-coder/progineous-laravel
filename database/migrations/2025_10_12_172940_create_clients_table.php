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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            
            // Account Username
            $table->string('username', 50)->unique();
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 20);
            
            // Address Information
            $table->string('address1', 500);
            $table->string('address2', 500)->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postcode', 20);
            $table->string('country', 2); // ISO 2-letter country code
            $table->string('tax_number', 50)->nullable();
            
            // Account Settings
            $table->string('language', 5)->default('ar'); // ar, en
            $table->string('currency', 3)->default('USD'); // USD, EGP, EUR, SAR, etc.
            $table->string('payment_method')->default('credit_card');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('billing_contact')->nullable();
            $table->string('referral_source')->nullable();
            
            // Email Notifications (JSON)
            $table->json('email_notifications')->nullable();
            
            // Settings (JSON)
            $table->json('settings')->nullable();
            
            // Owner Information
            $table->enum('owner_type', ['new', 'existing'])->default('new');
            $table->unsignedBigInteger('existing_user_id')->nullable();
            
            // Admin Notes
            $table->text('admin_notes')->nullable();
            
            // Welcome Email Flag
            $table->boolean('send_welcome_email')->default(false);
            
            // Remember Token
            $table->rememberToken();
            
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('status');
            $table->index('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
