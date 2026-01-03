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
        Schema::create('domain_registrars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // namecheap, godaddy, resellerclub, enom, cloudflare, dynadot, custom
            $table->text('api_key'); // Encrypted
            $table->text('api_secret')->nullable(); // Encrypted
            $table->boolean('test_mode')->default(true);
            $table->json('settings')->nullable(); // Additional settings specific to each registrar
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_registrars');
    }
};
