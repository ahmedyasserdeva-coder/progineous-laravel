<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Client;
use App\Mail\InvoiceReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-reminders 
                            {--days-before=3 : Send reminder X days before due date}
                            {--days-after=1,3,7 : Send reminder X days after due date (comma separated)}
                            {--dry-run : Preview without sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for unpaid invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysBefore = (int) $this->option('days-before');
        $daysAfter = array_map('intval', explode(',', $this->option('days-after')));
        $dryRun = $this->option('dry-run');

        $this->info("📧 Sending invoice reminders...");
        
        if ($dryRun) {
            $this->warn("⚠️  DRY RUN MODE - No emails will be sent");
        }

        $sentCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        // Get all unpaid invoices
        $unpaidInvoices = Invoice::with('client')
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->whereNotNull('due_date')
            ->get();

        $this->info("Found {$unpaidInvoices->count()} unpaid invoices\n");

        foreach ($unpaidInvoices as $invoice) {
            try {
                $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                $today = now()->startOfDay();
                $daysUntilDue = $today->diffInDays($dueDate, false);

                $reminderType = $this->shouldSendReminder($daysUntilDue, $daysBefore, $daysAfter);

                if (!$reminderType) {
                    continue;
                }

                // Check if reminder was already sent today
                if ($this->wasReminderSentToday($invoice)) {
                    $this->line("  ⏭️  Skipped: Invoice #{$invoice->invoice_number} (Already reminded today)");
                    $skippedCount++;
                    continue;
                }

                $client = $invoice->client;
                if (!$client || !$client->email) {
                    $this->line("  ⏭️  Skipped: Invoice #{$invoice->invoice_number} (No client email)");
                    $skippedCount++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("  📝 Would send {$reminderType} to: {$client->email} - Invoice #{$invoice->invoice_number} (\${$invoice->balance})");
                    $sentCount++;
                    continue;
                }

                // Send reminder
                $this->sendReminder($client, $invoice, $reminderType, $daysUntilDue);
                
                $this->info("  ✅ Sent {$reminderType} to: {$client->email} - Invoice #{$invoice->invoice_number}");
                $sentCount++;

            } catch (\Exception $e) {
                $this->error("  ❌ Error: Invoice #{$invoice->invoice_number} - {$e->getMessage()}");
                Log::error('Invoice Reminder Error', [
                    'invoice_id' => $invoice->id,
                    'error' => $e->getMessage(),
                ]);
                $errorCount++;
            }
        }

        // Summary
        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("   ✅ Sent: {$sentCount}");
        $this->info("   ⏭️  Skipped: {$skippedCount}");
        $this->info("   ❌ Errors: {$errorCount}");

        Log::info('Invoice Reminders Completed', [
            'sent' => $sentCount,
            'skipped' => $skippedCount,
            'errors' => $errorCount,
            'dry_run' => $dryRun,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Determine if a reminder should be sent
     */
    private function shouldSendReminder(int $daysUntilDue, int $daysBefore, array $daysAfter): ?string
    {
        // Reminder before due date
        if ($daysUntilDue === $daysBefore) {
            return 'upcoming_reminder';
        }

        // Reminder on due date
        if ($daysUntilDue === 0) {
            return 'due_today_reminder';
        }

        // Overdue reminders
        $daysOverdue = abs($daysUntilDue);
        if ($daysUntilDue < 0 && in_array($daysOverdue, $daysAfter)) {
            return 'overdue_reminder';
        }

        return null;
    }

    /**
     * Check if reminder was already sent today
     */
    private function wasReminderSentToday(Invoice $invoice): bool
    {
        // Check notes or create a separate tracking table
        // For now, we'll use a simple check in notes
        $today = now()->format('Y-m-d');
        return str_contains($invoice->notes ?? '', "Reminder sent: {$today}");
    }

    /**
     * Send reminder email
     */
    private function sendReminder(Client $client, Invoice $invoice, string $type, int $daysUntilDue): void
    {
        $subject = match ($type) {
            'upcoming_reminder' => "Invoice #{$invoice->invoice_number} Due Soon",
            'due_today_reminder' => "Invoice #{$invoice->invoice_number} Due Today",
            'overdue_reminder' => "Invoice #{$invoice->invoice_number} Overdue - Payment Required",
            default => "Invoice #{$invoice->invoice_number} Reminder",
        };

        // Log the reminder
        Log::info('Invoice Reminder Sent', [
            'client_id' => $client->id,
            'client_email' => $client->email,
            'invoice_number' => $invoice->invoice_number,
            'type' => $type,
            'days_until_due' => $daysUntilDue,
            'amount' => $invoice->balance,
        ]);

        // Update invoice notes to track reminder
        $invoice->notes = ($invoice->notes ? $invoice->notes . "\n" : '') . 
                         "Reminder sent: " . now()->format('Y-m-d H:i') . " ({$type})";
        $invoice->save();

        // Uncomment when InvoiceReminderMail is created:
        // Mail::to($client->email)->queue(new InvoiceReminderMail($client, $invoice, $type, $daysUntilDue));
    }
}
