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
        Schema::create('product_cpanel_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('tier')->comment('Number of cPanel accounts: 50, 100, 200, 300');
            $table->decimal('monthly_price', 10, 2)->default(0);
            $table->decimal('quarterly_price', 10, 2)->default(0);
            $table->decimal('semi_annually_price', 10, 2)->default(0);
            $table->decimal('annually_price', 10, 2)->default(0);
            $table->decimal('biennially_price', 10, 2)->default(0);
            $table->decimal('triennially_price', 10, 2)->default(0);
            $table->timestamps();

            // Index for faster queries
            $table->index(['product_id', 'tier']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_cpanel_tiers');
    }
};
