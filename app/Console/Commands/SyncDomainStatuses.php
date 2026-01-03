<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\DomainRegistrar;
use App\Services\DynadotService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncDomainStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domains:sync-status 
                            {--domain= : Sync a specific domain by name}
                            {--id= : Sync a specific domain by ID}
                            {--pending-only : Only sync domains with pending status}
                            {--limit=100 : Maximum number of domains to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync domain statuses from Dynadot API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting domain status synchronization...');
        
        // Get Dynadot registrar
        $registrar = DomainRegistrar::where('name', 'Dynadot')
            ->where('status', true)
            ->first();
        
        if (!$registrar) {
            $this->error('Dynadot registrar not configured or disabled');
            return 1;
        }
        
        $dynadotService = new DynadotService($registrar);
        
        // Build query
        $query = Domain::query();
        
        // Filter by specific domain
        if ($domainName = $this->option('domain')) {
            $query->where('domain_name', $domainName);
        }
        
        // Filter by ID
        if ($domainId = $this->option('id')) {
            $query->where('id', $domainId);
        }
        
        // Only pending domains
        if ($this->option('pending-only')) {
            $query->whereIn('status', [
                Domain::STATUS_PENDING,
                Domain::STATUS_PENDING_REGISTRATION,
                Domain::STATUS_PENDING_TRANSFER,
            ]);
        }
        
        // Limit
        $limit = (int) $this->option('limit');
        $domains = $query->limit($limit)->get();
        
        if ($domains->isEmpty()) {
            $this->warn('No domains found to sync');
            return 0;
        }
        
        $this->info("Found {$domains->count()} domain(s) to sync");
        
        $synced = 0;
        $failed = 0;
        $statusChanges = [];
        
        $progressBar = $this->output->createProgressBar($domains->count());
        $progressBar->start();
        
        foreach ($domains as $domain) {
            $oldStatus = $domain->status;
            
            try {
                $result = $dynadotService->syncDomainStatus($domain);
                
                if ($result) {
                    $synced++;
                    
                    // Reload to get updated status
                    $domain->refresh();
                    
                    if ($oldStatus !== $domain->status) {
                        $statusChanges[] = [
                            'domain' => $domain->domain_name,
                            'old' => $oldStatus,
                            'new' => $domain->status,
                        ];
                    }
                } else {
                    $failed++;
                }
                
            } catch (\Exception $e) {
                $failed++;
                Log::error('Domain sync failed', [
                    'domain' => $domain->domain_name,
                    'error' => $e->getMessage(),
                ]);
            }
            
            $progressBar->advance();
            
            // Add small delay to avoid API rate limiting
            usleep(200000); // 200ms
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        // Show summary
        $this->info("Sync completed:");
        $this->line("  - Synced: {$synced}");
        $this->line("  - Failed: {$failed}");
        
        // Show status changes
        if (!empty($statusChanges)) {
            $this->newLine();
            $this->info("Status changes:");
            
            $this->table(
                ['Domain', 'Old Status', 'New Status'],
                array_map(fn($change) => [
                    $change['domain'],
                    $change['old'],
                    $change['new'],
                ], $statusChanges)
            );
        }
        
        return 0;
    }
}
