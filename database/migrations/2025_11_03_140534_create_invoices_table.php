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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('invoice_number')->unique(); // INV-20251103-0001
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['unpaid', 'paid', 'partially_paid', 'cancelled', 'refunded'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('invoice_number');
            $table->index('client_id');
            $table->index('order_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
