<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Delete all existing products
        Product::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Re-run the seeder
        $this->call('ProductSeeder');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Product::truncate();
    }

    /**
     * Call seeder
     */
    private function call($seeder)
    {
        $seederClass = "Database\\Seeders\\{$seeder}";
        if (class_exists($seederClass)) {
            (new $seederClass)->run();
        }
    }
};
