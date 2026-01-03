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
        Schema::create('predefined_replies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content');
            $table->foreignId('department_id')->nullable()->constrained('ticket_departments')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predefined_replies');
    }
};
