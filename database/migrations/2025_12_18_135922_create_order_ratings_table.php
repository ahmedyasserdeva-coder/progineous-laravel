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
        Schema::create('order_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->text('feedback')->nullable();
            $table->string('category')->default('checkout'); // checkout, support, product
            $table->timestamps();
            
            // Unique constraint: one rating per order per category
            $table->unique(['order_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ratings');
    }
};
