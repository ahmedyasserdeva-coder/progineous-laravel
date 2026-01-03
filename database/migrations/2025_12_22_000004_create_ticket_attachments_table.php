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
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('reply_id')->nullable()->constrained('ticket_replies')->onDelete('cascade');
            $table->string('filename'); // Original filename
            $table->string('path'); // Storage path
            $table->string('disk')->default('local'); // Storage disk
            $table->bigInteger('size'); // File size in bytes
            $table->string('mime_type');
            $table->foreignId('uploaded_by_client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('uploaded_by_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index('ticket_id');
            $table->index('reply_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_attachments');
    }
};
