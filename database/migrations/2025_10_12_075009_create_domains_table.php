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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('domain_name')->unique();
            $table->string('tld'); // .com, .net, .org, etc.
            $table->enum('status', ['pending', 'active', 'expired', 'suspended', 'transferred']);
            $table->timestamp('registration_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->json('nameservers')->nullable(); // Array of nameservers
            $table->string('auth_code')->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->string('registrar_domain_id')->nullable(); // Dynadot domain ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
