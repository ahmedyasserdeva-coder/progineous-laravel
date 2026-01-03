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
        Schema::table('orders', function (Blueprint $table) {
            // Make billing_cycle nullable since orders can have multiple items with different billing cycles
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one_time'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert back to NOT NULL (but this might fail if there are null values)
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one_time'])->nullable(false)->change();
        });
    }
};
