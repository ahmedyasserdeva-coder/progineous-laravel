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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('support_pin', 6)->nullable()->after('admin_notes');
        });
        
        // Generate support PIN for existing clients
        $clients = \App\Models\Client::whereNull('support_pin')->get();
        foreach ($clients as $client) {
            $client->support_pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $client->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('support_pin');
        });
    }
};
