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
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('ip_address', 45);
            $table->integer('attempts')->default(1);
            $table->timestamp('blocked_until')->nullable();
            $table->timestamps();
            
            // Index for faster lookups
            $table->index(['email', 'ip_address']);
            $table->index('blocked_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};
