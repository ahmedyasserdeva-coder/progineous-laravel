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
        // Add Hetzner columns to vps_plans table
        if (Schema::hasTable('vps_plans')) {
            Schema::table('vps_plans', function (Blueprint $table) {
                if (!Schema::hasColumn('vps_plans', 'hetzner_server_type')) {
                    $table->string('hetzner_server_type')->nullable()->after('ram_mb');
                }
                if (!Schema::hasColumn('vps_plans', 'hetzner_location')) {
                    $table->string('hetzner_location')->nullable()->after('hetzner_server_type');
                }
            });
            
            // Add indexes after columns are created
            if (!DB::select("SHOW INDEX FROM vps_plans WHERE Key_name = 'vps_plans_hetzner_server_type_index'")) {
                Schema::table('vps_plans', function (Blueprint $table) {
                    $table->index('hetzner_server_type');
                });
            }
        }

        // Add Hetzner columns to dedicated_plans table
        if (Schema::hasTable('dedicated_plans')) {
            Schema::table('dedicated_plans', function (Blueprint $table) {
                if (!Schema::hasColumn('dedicated_plans', 'hetzner_server_type')) {
                    $table->string('hetzner_server_type')->nullable()->after('ram_gb');
                }
                if (!Schema::hasColumn('dedicated_plans', 'hetzner_location')) {
                    $table->string('hetzner_location')->nullable()->after('hetzner_server_type');
                }
            });
            
            // Add indexes after columns are created
            if (!DB::select("SHOW INDEX FROM dedicated_plans WHERE Key_name = 'dedicated_plans_hetzner_server_type_index'")) {
                Schema::table('dedicated_plans', function (Blueprint $table) {
                    $table->index('hetzner_server_type');
                });
            }
        }

        // Add Hetzner columns to vps_instances table
        if (Schema::hasTable('vps_instances')) {
            Schema::table('vps_instances', function (Blueprint $table) {
                if (!Schema::hasColumn('vps_instances', 'hetzner_server_id')) {
                    $table->unsignedBigInteger('hetzner_server_id')->nullable();
                }
                if (!Schema::hasColumn('vps_instances', 'hetzner_server_name')) {
                    $table->string('hetzner_server_name')->nullable();
                }
                if (!Schema::hasColumn('vps_instances', 'hetzner_server_data')) {
                    $table->text('hetzner_server_data')->nullable();
                }
            });
            
            // Add indexes after columns are created
            if (!DB::select("SHOW INDEX FROM vps_instances WHERE Key_name = 'vps_instances_hetzner_server_id_index'")) {
                Schema::table('vps_instances', function (Blueprint $table) {
                    $table->index('hetzner_server_id');
                });
            }
        }

        // Add Hetzner columns to dedicated_instances table
        if (Schema::hasTable('dedicated_instances')) {
            Schema::table('dedicated_instances', function (Blueprint $table) {
                if (!Schema::hasColumn('dedicated_instances', 'hetzner_server_id')) {
                    $table->unsignedBigInteger('hetzner_server_id')->nullable();
                }
                if (!Schema::hasColumn('dedicated_instances', 'hetzner_server_name')) {
                    $table->string('hetzner_server_name')->nullable();
                }
                if (!Schema::hasColumn('dedicated_instances', 'hetzner_server_data')) {
                    $table->text('hetzner_server_data')->nullable();
                }
            });
            
            // Add indexes after columns are created
            if (!DB::select("SHOW INDEX FROM dedicated_instances WHERE Key_name = 'dedicated_instances_hetzner_server_id_index'")) {
                Schema::table('dedicated_instances', function (Blueprint $table) {
                    $table->index('hetzner_server_id');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Hetzner columns from vps_plans table
        if (Schema::hasTable('vps_plans')) {
            Schema::table('vps_plans', function (Blueprint $table) {
                $table->dropIndex(['hetzner_server_type']);
                $table->dropColumn(['hetzner_server_type', 'hetzner_location']);
            });
        }

        // Remove Hetzner columns from dedicated_plans table
        if (Schema::hasTable('dedicated_plans')) {
            Schema::table('dedicated_plans', function (Blueprint $table) {
                $table->dropIndex(['hetzner_server_type']);
                $table->dropColumn(['hetzner_server_type', 'hetzner_location']);
            });
        }

        // Remove Hetzner columns from vps_instances table
        if (Schema::hasTable('vps_instances')) {
            Schema::table('vps_instances', function (Blueprint $table) {
                $table->dropIndex(['hetzner_server_id']);
                $table->dropColumn(['hetzner_server_id', 'hetzner_server_name', 'hetzner_server_data']);
            });
        }

        // Remove Hetzner columns from dedicated_instances table
        if (Schema::hasTable('dedicated_instances')) {
            Schema::table('dedicated_instances', function (Blueprint $table) {
                $table->dropIndex(['hetzner_server_id']);
                $table->dropColumn(['hetzner_server_id', 'hetzner_server_name', 'hetzner_server_data']);
            });
        }
    }
};
