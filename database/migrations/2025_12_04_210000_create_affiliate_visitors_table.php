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
        Schema::create('affiliate_visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referral_code')->index();
            $table->string('landing_page')->nullable();
            $table->boolean('visited_checkout')->default(false);
            $table->timestamp('checkout_visited_at')->nullable();
            $table->boolean('is_converted')->default(false);
            $table->foreignId('converted_client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            // Unique constraint for session
            $table->unique(['affiliate_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_visitors');
    }
};
