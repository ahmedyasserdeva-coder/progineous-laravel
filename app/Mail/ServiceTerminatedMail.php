<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceTerminatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Service $service;
    public Client $client;
    public string $emailLocale;

    /**
     * Create a new message instance.
     */
    public function __construct(Service $service, Client $client)
    {
        $this->service = $service;
        $this->client = $client;
        $this->emailLocale = $client->preferred_language ?? 'en';
        
        // Set locale for RTL support in layout
        session(['mail_locale' => $this->emailLocale]);
        app()->setLocale($this->emailLocale);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->emailLocale === 'ar' 
            ? 'إشعار إنهاء الخدمة' 
            : 'Service Termination Notice';
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.service-terminated',
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
