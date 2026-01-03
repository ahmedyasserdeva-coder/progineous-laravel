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
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->text('message');
            $table->boolean('is_internal')->default(false); // Internal notes visible only to admins
            $table->timestamps();

            // Indexes
            $table->index(['ticket_id', 'created_at']);
            $table->index('client_id');
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
