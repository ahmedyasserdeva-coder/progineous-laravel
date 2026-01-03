<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Service;
use App\Models\Domain;
use App\Mail\RenewalInvoiceMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateRenewalInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:generate-renewals 
                            {--days=14 : Days before due date to generate invoice}
                            {--type=all : Type of services (hosting, vps, domain, all)}
                            {--dry-run : Preview without creating invoices}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate renewal invoices for services approaching their due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $type = $this->option('type');
        $dryRun = $this->option('dry-run');

        $this->info("🔄 Generating renewal invoices for services due within {$days} days...");
        
        if ($dryRun) {
            $this->warn("⚠️  DRY RUN MODE - No invoices will be created");
        }

        $targetDate = now()->addDays($days);
        $createdCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        // Process Services (Hosting, VPS, etc.)
        if ($type === 'all' || in_array($type, ['hosting', 'vps', 'dedicated'])) {
            $this->info("\n📦 Processing Services...");
            
            $services = Service::with(['client', 'order'])
                ->where('status', 'active')
                ->whereNotNull('next_due_date')
                ->whereNotNull('recurring_amount')
                ->where('recurring_amount', '>', 0)
                ->whereDate('next_due_date', '<=', $targetDate)
                ->whereDate('next_due_date', '>=', now())
                ->when($type !== 'all', function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->get();

            $this->info("Found {$services->count()} services due for renewal");

            foreach ($services as $service) {
                try {
                    // Check if renewal invoice already exists
                    $existingInvoice = $this->findExistingRenewalInvoice($service);
                    
                    if ($existingInvoice) {
                        $this->line("  ⏭️  Skipped: {$service->service_name} (Invoice #{$existingInvoice->invoice_number} exists)");
                        $skippedCount++;
                        continue;
                    }

                    if ($dryRun) {
                        $this->line("  📝 Would create: {$service->service_name} - \${$service->recurring_amount} (Due: {$service->next_due_date->format('Y-m-d')})");
                        $createdCount++;
                        continue;
                    }

                    // Create renewal invoice
                    $invoice = $this->createServiceRenewalInvoice($service);
                    
                    if ($invoice) {
                        $this->info("  ✅ Created: {$service->service_name} - Invoice #{$invoice->invoice_number}");
                        $createdCount++;

                        // Send email notification
                        $this->sendRenewalNotification($service->client, $invoice, $service);
                    }

                } catch (\Exception $e) {
                    $this->error("  ❌ Error: {$service->service_name} - {$e->getMessage()}");
                    Log::error('Renewal Invoice Generation Error', [
                        'service_id' => $service->id,
                        'error' => $e->getMessage(),
                    ]);
                    $errorCount++;
                }
            }
        }

        // Process Domains
        if ($type === 'all' || $type === 'domain') {
            $this->info("\n🌐 Processing Domains...");
            
            $domains = Domain::with('client')
                ->where('status', 'active')
                ->whereNotNull('expiry_date')
                ->whereNotNull('recurring_amount')
                ->where('recurring_amount', '>', 0)
                ->whereDate('expiry_date', '<=', $targetDate)
                ->whereDate('expiry_date', '>=', now())
                ->get();

            $this->info("Found {$domains->count()} domains due for renewal");

            foreach ($domains as $domain) {
                try {
                    // Check if renewal invoice already exists
                    $existingInvoice = $this->findExistingDomainRenewalInvoice($domain);
                    
                    if ($existingInvoice) {
                        $this->line("  ⏭️  Skipped: {$domain->domain} (Invoice #{$existingInvoice->invoice_number} exists)");
                        $skippedCount++;
                        continue;
                    }

                    if ($dryRun) {
                        $this->line("  📝 Would create: {$domain->domain} - \${$domain->recurring_amount} (Expires: {$domain->expiry_date->format('Y-m-d')})");
                        $createdCount++;
                        continue;
                    }

                    // Create renewal invoice
                    $invoice = $this->createDomainRenewalInvoice($domain);
                    
                    if ($invoice) {
                        $this->info("  ✅ Created: {$domain->domain} - Invoice #{$invoice->invoice_number}");
                        $createdCount++;

                        // Send email notification
                        $this->sendRenewalNotification($domain->client, $invoice, null, $domain);
                    }

                } catch (\Exception $e) {
                    $this->error("  ❌ Error: {$domain->domain} - {$e->getMessage()}");
                    Log::error('Domain Renewal Invoice Generation Error', [
                        'domain_id' => $domain->id,
                        'error' => $e->getMessage(),
                    ]);
                    $errorCount++;
                }
            }
        }

        // Summary
        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("   ✅ Created: {$createdCount}");
        $this->info("   ⏭️  Skipped: {$skippedCount}");
        $this->info("   ❌ Errors: {$errorCount}");

        Log::info('Renewal Invoices Generation Completed', [
            'created' => $createdCount,
            'skipped' => $skippedCount,
            'errors' => $errorCount,
            'days_ahead' => $days,
            'type' => $type,
            'dry_run' => $dryRun,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Find existing renewal invoice for a service
     */
    private function findExistingRenewalInvoice(Service $service): ?Invoice
    {
        // Check for unpaid invoices related to this service's order
        // that were created for the current billing period
        return Invoice::where('order_id', $service->order_id)
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->where('notes', 'LIKE', '%Renewal%')
            ->where('created_at', '>=', now()->subDays(30))
            ->first();
    }

    /**
     * Find existing renewal invoice for a domain
     */
    private function findExistingDomainRenewalInvoice(Domain $domain): ?Invoice
    {
        return Invoice::where('client_id', $domain->client_id)
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->where('notes', 'LIKE', '%' . $domain->domain . '%Renewal%')
            ->where('created_at', '>=', now()->subDays(30))
            ->first();
    }

    /**
     * Create renewal invoice for a service
     */
    private function createServiceRenewalInvoice(Service $service): ?Invoice
    {
        return DB::transaction(function () use ($service) {
            // Generate invoice number
            $lastInvoice = Invoice::orderBy('id', 'desc')->first();
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 6, '0', STR_PAD_LEFT);

            $billingCycleText = $this->getBillingCycleText($service->billing_cycle);

            $invoice = Invoice::create([
                'order_id' => $service->order_id,
                'client_id' => $service->client_id,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => now(),
                'due_date' => $service->next_due_date,
                'subtotal' => $service->recurring_amount,
                'tax' => 0,
                'discount' => 0,
                'total' => $service->recurring_amount,
                'paid_amount' => 0,
                'balance' => $service->recurring_amount,
                'currency' => 'USD',
                'status' => 'unpaid',
                'notes' => "Renewal Invoice for {$service->service_name}\n" .
                          "Service Type: " . ucfirst($service->type) . "\n" .
                          "Billing Cycle: {$billingCycleText}\n" .
                          "Period: {$service->next_due_date->format('M d, Y')} - " . 
                          $this->getNextDueDate($service->next_due_date, $service->billing_cycle)->format('M d, Y'),
            ]);

            return $invoice;
        });
    }

    /**
     * Create renewal invoice for a domain
     */
    private function createDomainRenewalInvoice(Domain $domain): ?Invoice
    {
        return DB::transaction(function () use ($domain) {
            // Generate invoice number
            $lastInvoice = Invoice::orderBy('id', 'desc')->first();
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 6, '0', STR_PAD_LEFT);

            // For domains, we need to create without order_id or find associated order
            $invoice = Invoice::create([
                'order_id' => $domain->order_id ?? 1, // Use domain's order_id or default
                'client_id' => $domain->client_id,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => now(),
                'due_date' => $domain->expiry_date,
                'subtotal' => $domain->recurring_amount,
                'tax' => 0,
                'discount' => 0,
                'total' => $domain->recurring_amount,
                'paid_amount' => 0,
                'balance' => $domain->recurring_amount,
                'currency' => 'USD',
                'status' => 'unpaid',
                'notes' => "Domain Renewal Invoice for {$domain->domain}\n" .
                          "Registration Period: " . ($domain->registration_period ?? 1) . " year(s)\n" .
                          "Expiry Date: {$domain->expiry_date->format('M d, Y')}",
            ]);

            return $invoice;
        });
    }

    /**
     * Send renewal notification email
     */
    private function sendRenewalNotification($client, Invoice $invoice, ?Service $service = null, ?Domain $domain = null): void
    {
        try {
            if ($client && $client->email) {
                // You can create a dedicated RenewalInvoiceMail class
                // For now, we'll log the notification
                Log::info('Renewal Invoice Notification Sent', [
                    'client_id' => $client->id,
                    'client_email' => $client->email,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->total,
                    'service' => $service?->service_name,
                    'domain' => $domain?->domain,
                ]);

                // Uncomment when RenewalInvoiceMail is created:
                // Mail::to($client->email)->queue(new RenewalInvoiceMail($client, $invoice, $service, $domain));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send renewal notification', [
                'error' => $e->getMessage(),
                'invoice_id' => $invoice->id,
            ]);
        }
    }

    /**
     * Get billing cycle text
     */
    private function getBillingCycleText(?string $cycle): string
    {
        return match (strtolower($cycle ?? '')) {
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly (3 Months)',
            'semi_annually', 'semiannually' => 'Semi-Annually (6 Months)',
            'annually' => 'Annually (1 Year)',
            'biennially' => 'Biennially (2 Years)',
            'triennially' => 'Triennially (3 Years)',
            default => ucfirst($cycle ?? 'N/A'),
        };
    }

    /**
     * Calculate next due date based on billing cycle
     */
    private function getNextDueDate($currentDueDate, ?string $cycle)
    {
        $date = \Carbon\Carbon::parse($currentDueDate);
        
        return match (strtolower($cycle ?? '')) {
            'monthly' => $date->addMonth(),
            'quarterly' => $date->addMonths(3),
            'semi_annually', 'semiannually' => $date->addMonths(6),
            'annually' => $date->addYear(),
            'biennially' => $date->addYears(2),
            'triennially' => $date->addYears(3),
            default => $date->addMonth(),
        };
    }
}
