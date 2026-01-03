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
        Schema::create('hosting_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('cpanel_username')->unique();
            $table->string('cpanel_password'); // Encrypted
            $table->string('domain_name');
            $table->string('server_ip')->nullable();
            $table->string('package_name');
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated']);
            $table->integer('disk_usage')->default(0); // in MB
            $table->integer('disk_limit')->default(0); // in MB, 0 = unlimited
            $table->integer('bandwidth_usage')->default(0); // in MB
            $table->integer('bandwidth_limit')->default(0); // in MB, 0 = unlimited
            $table->timestamp('suspension_date')->nullable();
            $table->text('suspension_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_accounts');
    }
};
