<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->string('reference_id', 10)->unique()->nullable()->after('id');
        });
        
        // Generate reference_id for existing records
        DB::table('affiliate_commissions')->whereNull('reference_id')->orderBy('id')->each(function ($commission) {
            DB::table('affiliate_commissions')
                ->where('id', $commission->id)
                ->update(['reference_id' => $this->generateReferenceId()]);
        });
    }
    
    /**
     * Generate a unique reference ID
     */
    private function generateReferenceId(): string
    {
        do {
            $referenceId = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (DB::table('affiliate_commissions')->where('reference_id', $referenceId)->exists());
        
        return $referenceId;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->dropColumn('reference_id');
        });
    }
};
