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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // hosting, domain, email
            $table->string('category'); // shared_hosting, cloud_hosting, vps, dedicated, professional_email, etc.
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one_time']);
            $table->json('features')->nullable(); // JSON array of features
            $table->boolean('is_active')->default(true);
            $table->string('api_product_id')->nullable(); // For cPanel packages or Dynadot TLDs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
