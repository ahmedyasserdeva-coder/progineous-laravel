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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('type'); // transfer_sent, transfer_received, deposit, withdrawal, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data (amount, username, reference, etc.)
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['client_id', 'read', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
