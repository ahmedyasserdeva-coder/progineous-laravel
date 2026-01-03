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
        Schema::table('orders', function (Blueprint $table) {
            // إضافة client_id (معظم الطلبات من clients وليس users)
            $table->foreignId('client_id')->nullable()->after('user_id')->constrained('clients')->onDelete('cascade');
            
            // إضافة حقول الأسعار
            $table->decimal('subtotal', 10, 2)->default(0)->after('amount');
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('tax', 10, 2)->default(0)->after('discount');
            $table->decimal('total', 10, 2)->default(0)->after('tax');
            
            // إضافة العملة
            $table->string('currency', 3)->default('USD')->after('total');
            
            // إضافة حالة الدفع
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('payment_gateway_id')->nullable()->after('payment_method');
            
            // إضافة معلومات الكوبون
            $table->string('coupon_code')->nullable()->after('payment_gateway_id');
            $table->decimal('coupon_discount', 10, 2)->default(0)->after('coupon_code');
            
            // إضافة ملاحظات
            $table->text('notes')->nullable()->after('order_details');
            
            // إضافة تواريخ مهمة
            $table->timestamp('paid_at')->nullable()->after('next_due_date');
            $table->timestamp('completed_at')->nullable()->after('paid_at');
            
            // إضافة soft deletes
            $table->softDeletes()->after('updated_at');
            
            // تعديل status لدعم حالات جديدة
            $table->dropColumn('status');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])->default('pending')->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn([
                'client_id',
                'subtotal',
                'discount',
                'tax',
                'total',
                'currency',
                'payment_status',
                'payment_method',
                'payment_gateway_id',
                'coupon_code',
                'coupon_discount',
                'notes',
                'paid_at',
                'completed_at',
                'deleted_at'
            ]);
            
            $table->dropColumn('status');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled', 'completed'])->default('pending');
        });
    }
};
