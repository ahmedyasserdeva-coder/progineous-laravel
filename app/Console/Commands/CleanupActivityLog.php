<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class CleanupActivityLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activitylog:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old activity log entries based on the limit setting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the limit from settings
        $limit = Setting::get('activity_log_limit', 1000);
        
        if ($limit <= 0) {
            $this->info('Activity log cleanup is disabled (limit is 0 or negative)');
            return 0;
        }

        // Check if activity_logs table exists
        if (!DB::getSchemaBuilder()->hasTable('activity_logs')) {
            $this->warn('Activity logs table does not exist yet');
            return 0;
        }

        // Get current count
        $currentCount = DB::table('activity_logs')->count();
        
        if ($currentCount <= $limit) {
            $this->info("Activity log count ({$currentCount}) is within limit ({$limit}). No cleanup needed.");
            return 0;
        }

        // Calculate how many records to delete
        $deleteCount = $currentCount - $limit;
        
        // Get the ID of the record that marks the cutoff point
        $cutoffId = DB::table('activity_logs')
            ->orderBy('id', 'asc')
            ->skip($deleteCount)
            ->value('id');

        // Delete old records
        $deleted = DB::table('activity_logs')
            ->where('id', '<', $cutoffId)
            ->delete();

        $this->info("Successfully deleted {$deleted} old activity log entries");
        $this->info("Current count: " . DB::table('activity_logs')->count());
        
        return 0;
    }
}
