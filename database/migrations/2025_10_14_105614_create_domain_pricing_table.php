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
        Schema::create('domain_pricing', function (Blueprint $table) {
            $table->id();
            $table->string('tld', 50)->index()->comment('Domain TLD (e.g., com, net, org)');
            $table->foreignId('registrar_id')->nullable()->constrained('domain_registrars')->onDelete('cascade')->comment('Reference to domain registrar');
            $table->string('currency', 3)->default('USD')->comment('Currency code (USD, EUR, GBP)');
            
            // Dynadot Base Prices
            $table->decimal('dynadot_register', 10, 2)->default(0)->comment('Dynadot registration price');
            $table->decimal('dynadot_renew', 10, 2)->default(0)->comment('Dynadot renewal price');
            $table->decimal('dynadot_transfer', 10, 2)->default(0)->comment('Dynadot transfer price');
            $table->decimal('dynadot_restore', 10, 2)->default(0)->comment('Dynadot restore price');
            $table->decimal('dynadot_graceFee', 10, 2)->default(0)->comment('Dynadot grace fee');
            
            // Pro Gineous Prices (with markup applied)
            $table->decimal('progineous_register', 10, 2)->default(0)->comment('Pro Gineous registration price');
            $table->decimal('progineous_renew', 10, 2)->default(0)->comment('Pro Gineous renewal price');
            $table->decimal('progineous_transfer', 10, 2)->default(0)->comment('Pro Gineous transfer price');
            $table->decimal('progineous_restore', 10, 2)->default(0)->comment('Pro Gineous restore price');
            $table->decimal('progineous_graceFee', 10, 2)->default(0)->comment('Pro Gineous grace fee');
            
            $table->timestamps();
            
            // Unique constraint: one pricing record per TLD per registrar per currency
            $table->unique(['tld', 'registrar_id', 'currency'], 'unique_tld_registrar_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_pricing');
    }
};
