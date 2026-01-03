<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public Client $client;
    public Invoice $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Client $client, Invoice $invoice)
    {
        $this->order = $order;
        $this->client = $client;
        $this->invoice = $invoice;
        
        // Set locale based on client's preferred language
        $this->locale = $client->preferred_language ?? config('app.fallback_locale', 'en');
        
        // Set app locale for email rendering
        app()->setLocale($this->locale);
        session(['mail_locale' => $this->locale]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address'),
                config('mail.from.name')
            ),
            replyTo: [
                new \Illuminate\Mail\Mailables\Address(
                    config('mail.from.address'),
                    config('mail.from.name')
                ),
            ],
            subject: __('emails.order_confirmation_subject', ['order_number' => $this->order->order_number]) ?? 'Order Confirmation - #' . $this->order->order_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-confirmation',
            with: [
                'order' => $this->order,
                'client' => $this->client,
                'invoice' => $this->invoice,
                'services' => $this->order->services,
                'items' => $this->order->items,
                'locale' => $this->client->preferred_language ?? config('app.fallback_locale', 'en'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        try {
            // Load invoice with relationships
            $invoice = $this->invoice->load(['order', 'order.items', 'client', 'payments']);
            
            // Generate QR code
            $qrCode = null;
            $qrFormat = null;
            try {
                $qrCode = base64_encode(QrCode::format('svg')
                    ->size(120)
                    ->margin(0)
                    ->errorCorrection('H')
                    ->generate(route('client.invoices.show', $invoice->id)));
                $qrFormat = 'svg';
            } catch (\Exception $e) {
                // QR code generation failed, continue without it
            }
            
            // Generate PDF
            $pdf = Pdf::loadView('frontend.client.invoices.pdf', compact('invoice', 'qrCode', 'qrFormat'))
                ->setPaper('a4', 'portrait')
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isFontSubsettingEnabled', true);
            
            return [
                Attachment::fromData(fn () => $pdf->output(), 'invoice-' . $invoice->invoice_number . '.pdf')
                    ->withMime('application/pdf'),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to generate invoice PDF for email attachment', [
                'invoice_id' => $this->invoice->id ?? null,
                'error' => $e->getMessage(),
            ]);
            
            // Return empty array if PDF generation fails
            return [];
        }
    }
}
