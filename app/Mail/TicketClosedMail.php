<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketClosedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Client $client;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, Client $client)
    {
        $this->ticket = $ticket;
        $this->client = $client;
        
        // Set locale based on client's preferred language
        $this->locale = $client->preferred_language ?? config('app.fallback_locale', 'en');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('tickets.email.closed_subject', ['ticket_number' => $this->ticket->ticket_number], $this->locale),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tickets.closed',
            with: [
                'ticket' => $this->ticket,
                'client' => $this->client,
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
