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
        Schema::create('verified_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_id', 12)->unique();
            $table->unsignedBigInteger('client_id');
            $table->string('document_type')->default('statement');
            $table->string('document_hash', 64); // SHA-256 hash
            $table->decimal('total_invoiced', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->json('metadata')->nullable();
            $table->timestamp('generated_at');
            $table->timestamps();
            
            $table->index('document_id');
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verified_documents');
    }
};
