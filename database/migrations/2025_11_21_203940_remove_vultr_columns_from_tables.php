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
        // Remove Vultr columns from vps_plans
        Schema::table('vps_plans', function (Blueprint $table) {
            $table->dropIndex(['vultr_plan_id']); // Drop index first
            $table->dropColumn(['vultr_plan_id', 'vultr_region']);
        });

        // Remove Vultr columns from vps_instances
        Schema::table('vps_instances', function (Blueprint $table) {
            $table->dropIndex(['vultr_instance_id']); // Drop index first
            $table->dropColumn(['vultr_instance_id', 'vultr_region']);
        });

        // Remove Vultr columns from dedicated_plans
        Schema::table('dedicated_plans', function (Blueprint $table) {
            $table->dropIndex(['vultr_plan_id']); // Drop index first
            $table->dropColumn(['vultr_plan_id', 'vultr_region']);
        });

        // Remove Vultr columns from dedicated_instances
        Schema::table('dedicated_instances', function (Blueprint $table) {
            $table->dropIndex(['vultr_baremetal_id']); // Drop index first
            $table->dropColumn(['vultr_baremetal_id', 'vultr_region']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore Vultr columns to vps_plans
        Schema::table('vps_plans', function (Blueprint $table) {
            $table->string('vultr_plan_id')->nullable();
            $table->string('vultr_region')->nullable();
            $table->index('vultr_plan_id');
        });

        // Restore Vultr columns to vps_instances
        Schema::table('vps_instances', function (Blueprint $table) {
            $table->string('vultr_instance_id')->unique()->nullable();
            $table->string('vultr_region');
            $table->index('vultr_instance_id');
        });

        // Restore Vultr columns to dedicated_plans
        Schema::table('dedicated_plans', function (Blueprint $table) {
            $table->string('vultr_plan_id')->nullable();
            $table->string('vultr_region')->nullable();
            $table->index('vultr_plan_id');
        });

        // Restore Vultr columns to dedicated_instances
        Schema::table('dedicated_instances', function (Blueprint $table) {
            $table->string('vultr_baremetal_id')->unique()->nullable();
            $table->string('vultr_region');
            $table->index('vultr_baremetal_id');
        });
    }
};
