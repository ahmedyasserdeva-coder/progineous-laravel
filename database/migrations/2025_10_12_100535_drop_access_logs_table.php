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
        Schema::dropIfExists('access_logs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('access_status')->default('pending');
            $table->timestamp('access_requested_at');
            $table->timestamp('access_granted_at')->nullable();
            $table->string('session_id')->nullable();
            $table->json('request_headers')->nullable();
            $table->timestamps();
            
            $table->index(['ip_address', 'access_status']);
            $table->index('access_requested_at');
        });
    }
};
