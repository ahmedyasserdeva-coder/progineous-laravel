<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Client $client;
    public string $recipientType;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, Client $client, string $recipientType = 'client')
    {
        $this->ticket = $ticket;
        $this->client = $client;
        $this->recipientType = $recipientType;
        
        // Set locale based on client's preferred language
        $this->locale = $client->preferred_language ?? config('app.fallback_locale', 'en');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'client'
            ? __('tickets.email.created_subject_client', ['ticket_number' => $this->ticket->ticket_number], $this->locale)
            : __('tickets.email.created_subject_admin', ['ticket_number' => $this->ticket->ticket_number], $this->locale);

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
            markdown: 'emails.tickets.created',
            with: [
                'ticket' => $this->ticket,
                'client' => $this->client,
                'recipientType' => $this->recipientType,
                'locale' => $this->locale,
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
