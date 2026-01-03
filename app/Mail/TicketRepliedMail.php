<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketRepliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public TicketReply $reply;
    public string $recipientType;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, TicketReply $reply, string $recipientType = 'client')
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
        $this->recipientType = $recipientType;
        
        // Set locale based on client's preferred language
        $this->locale = $ticket->client->preferred_language ?? config('app.fallback_locale', 'en');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'client'
            ? __('tickets.email.replied_subject_client', ['ticket_number' => $this->ticket->ticket_number], $this->locale)
            : __('tickets.email.replied_subject_admin', ['ticket_number' => $this->ticket->ticket_number], $this->locale);

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
            markdown: 'emails.tickets.replied',
            with: [
                'ticket' => $this->ticket,
                'reply' => $this->reply,
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
