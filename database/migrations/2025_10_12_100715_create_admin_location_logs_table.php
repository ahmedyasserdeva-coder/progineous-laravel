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
        Schema::create('admin_location_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->string('ip_address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->float('accuracy')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('action')->default('location_granted'); // location_granted, admin_login
            $table->timestamp('logged_at');
            $table->json('additional_data')->nullable();
            $table->timestamps();
            
            $table->index(['admin_id', 'logged_at']);
            $table->index('ip_address');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_location_logs');
    }
};
