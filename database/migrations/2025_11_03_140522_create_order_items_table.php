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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->enum('type', ['domain', 'hosting', 'vps', 'dedicated']); // نوع المنتج
            $table->string('product_name'); // اسم المنتج
            $table->text('description')->nullable();
            $table->json('configuration'); // التفاصيل الكاملة (domain name, plan, years, dns, etc)
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled', 'completed'])->default('pending');
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
