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
        Schema::create('email_change_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('old_email');
            $table->string('new_email');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('client_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_change_logs');
    }
};
