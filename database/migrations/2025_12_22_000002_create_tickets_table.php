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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained('ticket_departments')->onDelete('cascade');
            $table->foreignId('assigned_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->string('service_type')->nullable(); // hosting, domain, vps, dedicated, etc.
            $table->string('subject');
            $table->text('message'); // Initial message
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'answered', 'customer_reply', 'on_hold', 'closed'])->default('open');
            $table->timestamp('last_reply_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('closed_by_client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['client_id', 'status']);
            $table->index(['department_id', 'status']);
            $table->index(['assigned_admin_id', 'status']);
            $table->index('status');
            $table->index('priority');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
