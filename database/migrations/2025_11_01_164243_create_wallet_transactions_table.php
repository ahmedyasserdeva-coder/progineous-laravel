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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['deposit', 'withdrawal', 'refund'])->default('deposit');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_provider')->nullable(); // fawaterak, bank_transfer, etc.
            $table->string('fawaterak_invoice_id')->nullable();
            $table->string('fawaterak_invoice_key')->nullable();
            $table->string('fawaterak_reference_id')->nullable();
            $table->string('transaction_reference')->unique()->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional payment data
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('client_id');
            $table->index('status');
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
