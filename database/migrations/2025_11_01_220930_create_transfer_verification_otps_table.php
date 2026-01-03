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
        Schema::create('transfer_verification_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('otp_code', 6);
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            $table->index(['client_id', 'used', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_verification_otps');
    }
};
