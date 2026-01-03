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
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('clients')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('receiver_card_number', 19);
            $table->string('reference')->unique();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['sender_id', 'created_at']);
            $table->index(['receiver_id', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transfers');
    }
};
