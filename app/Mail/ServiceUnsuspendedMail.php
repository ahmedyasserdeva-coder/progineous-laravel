<?php

namespace App\Mail;

use App\Models\Service;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceUnsuspendedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Service $service;
    public Client $client;

    /**
     * Create a new message instance.
     */
    public function __construct(Service $service, Client $client)
    {
        $this->service = $service;
        $this->client = $client;
        
        // Set locale based on client's preferred language
        $this->locale = $client->preferred_language ?? config('app.fallback_locale', 'en');
        
        // Set app locale and session for email rendering (for RTL support in layout)
        app()->setLocale($this->locale);
        session(['mail_locale' => $this->locale]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $isArabic = ($this->client->preferred_language ?? 'en') === 'ar';
        
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address'),
                config('mail.from.name')
            ),
            subject: $isArabic 
                ? 'تم إعادة تفعيل الخدمة - ' . $this->service->service_name
                : 'Service Reactivated - ' . $this->service->service_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.service-unsuspended',
            with: [
                'service' => $this->service,
                'client' => $this->client,
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
        return [];
    }
}
