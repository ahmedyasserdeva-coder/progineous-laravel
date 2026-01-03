<?php

namespace App\Console\Commands;

use App\Services\FawaterakPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CachePaymentMethods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:cache-methods {--clear : Clear the cached payment methods}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache payment methods from Fawaterak API';

    protected $fawaterakService;

    public function __construct(FawaterakPaymentService $fawaterakService)
    {
        parent::__construct();
        $this->fawaterakService = $fawaterakService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('clear')) {
            Cache::forget('fawaterak_payment_methods');
            $this->info('Payment methods cache cleared successfully!');
            return Command::SUCCESS;
        }

        $this->info('Fetching payment methods from Fawaterak API...');

        $result = $this->fawaterakService->getPaymentMethods();

        if ($result['success'] && isset($result['methods'])) {
            Cache::put('fawaterak_payment_methods', $result['methods'], 86400); // 24 hours
            
            $this->info('Payment methods cached successfully!');
            $this->line('');
            $this->info('Available Payment Methods:');
            
            foreach ($result['methods'] as $index => $method) {
                $this->line(($index + 1) . '. ' . ($method['name_ar'] ?? $method['name_en']));
                if (isset($method['logo'])) {
                    $this->line('   Logo: ' . $method['logo']);
                }
            }
            
            return Command::SUCCESS;
        }

        $this->error('Failed to fetch payment methods from Fawaterak API');
        $this->error($result['message'] ?? 'Unknown error');
        
        return Command::FAILURE;
    }
}
