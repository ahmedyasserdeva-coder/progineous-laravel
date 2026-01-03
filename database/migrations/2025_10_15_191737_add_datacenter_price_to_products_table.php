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
        Schema::table('products', function (Blueprint $table) {
            // Add datacenter_locations if not exists
            if (!Schema::hasColumn('products', 'datacenter_locations')) {
                $table->json('datacenter_locations')->nullable()->after('api_product_id');
            }
            // Add datacenter_price
            $table->json('datacenter_price')->nullable()->after('datacenter_locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('datacenter_price');
            // We don't drop datacenter_locations as it might have been added by another migration
        });
    }
};
