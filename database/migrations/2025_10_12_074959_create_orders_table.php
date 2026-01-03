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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('domain_name')->nullable(); // For hosting/domain orders
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled', 'completed']);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one_time']);
            $table->timestamp('next_due_date')->nullable();
            $table->json('order_details')->nullable(); // Store additional order info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
