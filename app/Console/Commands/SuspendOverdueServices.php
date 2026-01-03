<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Service;
use App\Services\CpanelService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceSuspendedMail;

class SuspendOverdueServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:suspend-overdue 
                            {--days=7 : Days overdue before suspension}
                            {--terminate-days=30 : Days overdue before termination (0 to disable)}
                            {--dry-run : Preview without suspending}
                            {--type=all : Service type (hosting, vps, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspend services with overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueDays = (int) $this->option('days');
        $terminateDays = (int) $this->option('terminate-days');
        $dryRun = $this->option('dry-run');
        $type = $this->option('type');

        $this->info("🔒 Processing overdue services (>{$overdueDays} days overdue)...");
        
        if ($dryRun) {
            $this->warn("⚠️  DRY RUN MODE - No services will be modified");
        }

        $suspendedCount = 0;
        $terminatedCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        // Get active services with overdue invoices
        $services = Service::with(['client', 'order.invoice', 'server'])
            ->where('status', 'active')
            ->when($type !== 'all', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->get();

        $this->info("Checking {$services->count()} active services...\n");

        foreach ($services as $service) {
            try {
                // Find unpaid invoices for this service
                $overdueInvoice = Invoice::where('order_id', $service->order_id)
                    ->whereIn('status', ['unpaid', 'partially_paid'])
                    ->whereDate('due_date', '<', now())
                    ->orderBy('due_date', 'asc')
                    ->first();

                if (!$overdueInvoice) {
                    continue;
                }

                $daysOverdue = now()->diffInDays($overdueInvoice->due_date);

                // Skip if not overdue enough
                if ($daysOverdue < $overdueDays) {
                    continue;
                }

                // Check for termination
                if ($terminateDays > 0 && $daysOverdue >= $terminateDays) {
                    if ($dryRun) {
                        $this->line("  🗑️  Would terminate: {$service->service_name} ({$daysOverdue} days overdue)");
                        $terminatedCount++;
                        continue;
                    }

                    $this->terminateService($service, $overdueInvoice, $daysOverdue);
                    $this->warn("  🗑️  Terminated: {$service->service_name} ({$daysOverdue} days overdue)");
                    $terminatedCount++;
                    continue;
                }

                // Suspend the service
                if ($dryRun) {
                    $this->line("  🔒 Would suspend: {$service->service_name} ({$daysOverdue} days overdue, Invoice #{$overdueInvoice->invoice_number})");
                    $suspendedCount++;
                    continue;
                }

                $this->suspendService($service, $overdueInvoice, $daysOverdue);
                $this->info("  🔒 Suspended: {$service->service_name} ({$daysOverdue} days overdue)");
                $suspendedCount++;

            } catch (\Exception $e) {
                $this->error("  ❌ Error: {$service->service_name} - {$e->getMessage()}");
                Log::error('Suspend Overdue Service Error', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage(),
                ]);
                $errorCount++;
            }
        }

        // Also check suspended services for termination
        if ($terminateDays > 0) {
            $this->info("\n🗑️  Checking suspended services for termination (>{$terminateDays} days overdue)...");
            
            $suspendedServices = Service::with(['client', 'order.invoice'])
                ->where('status', 'suspended')
                ->when($type !== 'all', function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->get();

            foreach ($suspendedServices as $service) {
                try {
                    $overdueInvoice = Invoice::where('order_id', $service->order_id)
                        ->whereIn('status', ['unpaid', 'partially_paid'])
                        ->whereDate('due_date', '<', now())
                        ->orderBy('due_date', 'asc')
                        ->first();

                    if (!$overdueInvoice) {
                        continue;
                    }

                    $daysOverdue = now()->diffInDays($overdueInvoice->due_date);

                    if ($daysOverdue >= $terminateDays) {
                        if ($dryRun) {
                            $this->line("  🗑️  Would terminate: {$service->service_name} ({$daysOverdue} days overdue)");
                            $terminatedCount++;
                            continue;
                        }

                        $this->terminateService($service, $overdueInvoice, $daysOverdue);
                        $this->warn("  🗑️  Terminated: {$service->service_name} ({$daysOverdue} days overdue)");
                        $terminatedCount++;
                    }

                } catch (\Exception $e) {
                    $this->error("  ❌ Error: {$service->service_name} - {$e->getMessage()}");
                    $errorCount++;
                }
            }
        }

        // Summary
        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("   🔒 Suspended: {$suspendedCount}");
        $this->info("   🗑️  Terminated: {$terminatedCount}");
        $this->info("   ❌ Errors: {$errorCount}");

        Log::info('Overdue Services Processing Completed', [
            'suspended' => $suspendedCount,
            'terminated' => $terminatedCount,
            'errors' => $errorCount,
            'overdue_days' => $overdueDays,
            'terminate_days' => $terminateDays,
            'dry_run' => $dryRun,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Suspend a service
     */
    private function suspendService(Service $service, Invoice $invoice, int $daysOverdue): void
    {
        // Suspend on WHM/cPanel if applicable
        if ($service->type === 'hosting' && $service->username && $service->server) {
            try {
                $cpanelService = app(CpanelService::class);
                $cpanelService->suspendAccount($service->server, $service->username, 'Overdue payment - Auto suspended');
            } catch (\Exception $e) {
                Log::warning('Failed to suspend cPanel account', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Update service status
        $service->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'notes' => ($service->notes ? $service->notes . "\n\n" : '') . 
                      "[" . now() . "] Auto-suspended: Invoice #{$invoice->invoice_number} overdue by {$daysOverdue} days",
        ]);

        // Send notification
        if ($service->client && $service->client->email) {
            try {
                Mail::to($service->client->email)->queue(new ServiceSuspendedMail($service, 'Overdue payment'));
            } catch (\Exception $e) {
                Log::error('Failed to send suspension email', ['error' => $e->getMessage()]);
            }
        }

        Log::info('Service Auto-Suspended', [
            'service_id' => $service->id,
            'service_name' => $service->service_name,
            'invoice_number' => $invoice->invoice_number,
            'days_overdue' => $daysOverdue,
        ]);
    }

    /**
     * Terminate a service
     */
    private function terminateService(Service $service, Invoice $invoice, int $daysOverdue): void
    {
        // Terminate on WHM/cPanel if applicable
        if ($service->type === 'hosting' && $service->username && $service->server) {
            try {
                $cpanelService = app(CpanelService::class);
                $cpanelService->terminateAccount($service->server, $service->username);
            } catch (\Exception $e) {
                Log::warning('Failed to terminate cPanel account', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Update service status
        $service->update([
            'status' => 'terminated',
            'terminated_at' => now(),
            'notes' => ($service->notes ? $service->notes . "\n\n" : '') . 
                      "[" . now() . "] Auto-terminated: Invoice #{$invoice->invoice_number} overdue by {$daysOverdue} days",
        ]);

        // Cancel the invoice
        $invoice->update(['status' => 'cancelled']);

        Log::info('Service Auto-Terminated', [
            'service_id' => $service->id,
            'service_name' => $service->service_name,
            'invoice_number' => $invoice->invoice_number,
            'days_overdue' => $daysOverdue,
        ]);
    }
}
