<?php

namespace App\Console\Commands;

use App\Models\WalletTransaction;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CancelExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:cancel-expired {--hours=1 : Hours after which pending transactions expire}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending wallet transactions that are older than specified hours (default: 1)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = (int) $this->option('hours');
        $expiryDate = Carbon::now()->subHours($hours);
        
        $this->info("Cancelling pending transactions older than {$hours} hours (before {$expiryDate})...");
        
        // Find expired pending transactions
        $expiredTransactions = WalletTransaction::where('status', 'pending')
            ->where('created_at', '<', $expiryDate)
            ->get();
        
        if ($expiredTransactions->isEmpty()) {
            $this->info('No expired transactions found.');
            return Command::SUCCESS;
        }
        
        $count = 0;
        foreach ($expiredTransactions as $transaction) {
            $transaction->update([
                'status' => 'cancelled',
                'notes' => "Automatically cancelled after {$hours} hours of inactivity",
            ]);
            
            // Create cancellation notification
            \App\Models\Notification::createDepositNotification(
                $transaction->client_id,
                'cancelled',
                $transaction->amount,
                $transaction->transaction_reference,
                $transaction->payment_method
            );
            
            $count++;
            
            $this->line("Cancelled: Transaction #{$transaction->id} - \${$transaction->amount} - {$transaction->transaction_reference}");
        }
        
        $this->info("✓ Successfully cancelled {$count} expired transaction(s).");
        
        return Command::SUCCESS;
    }
}
