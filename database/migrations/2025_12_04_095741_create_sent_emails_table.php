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
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->string('to_email');
            $table->string('template')->nullable(); // email template used
            $table->string('type')->default('system'); // system, invoice, support, marketing, etc.
            $table->enum('status', ['sent', 'failed', 'pending'])->default('sent');
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // additional data like invoice_id, ticket_id, etc.
            $table->timestamps();
            
            $table->index(['client_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
