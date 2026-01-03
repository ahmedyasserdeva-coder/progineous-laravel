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
        Schema::table('domains', function (Blueprint $table) {
            // Order type: register or transfer
            $table->string('order_type')->default('register')->after('order_id');
            
            // Registrar name (e.g., Dynadot)
            $table->string('registrar')->nullable()->after('order_type');
            
            // Payment amounts
            $table->decimal('first_payment_amount', 10, 2)->default(0)->after('registrar');
            $table->decimal('recurring_amount', 10, 2)->default(0)->after('first_payment_amount');
            
            // Registration period in years
            $table->integer('registration_period')->default(1)->after('recurring_amount');
            
            // Next due date for renewal
            $table->timestamp('next_due_date')->nullable()->after('expiry_date');
            
            // Payment method used
            $table->string('payment_method')->nullable()->after('next_due_date');
            
            // Promotion/Coupon code if used
            $table->string('promotion_code')->nullable()->after('payment_method');
            
            // Registrar lock status
            $table->boolean('registrar_lock')->default(true)->after('auto_renew');
            
            // ID Protection status
            $table->boolean('id_protection')->default(false)->after('registrar_lock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn([
                'order_type',
                'registrar',
                'first_payment_amount',
                'recurring_amount',
                'registration_period',
                'next_due_date',
                'payment_method',
                'promotion_code',
                'registrar_lock',
                'id_protection',
            ]);
        });
    }
};
