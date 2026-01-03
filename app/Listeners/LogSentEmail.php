<?php

namespace App\Listeners;

use App\Models\Client;
use App\Models\SentEmail;
use Illuminate\Mail\Events\MessageSent;

class LogSentEmail
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        
        // Get the "to" addresses
        $toAddresses = $message->getTo();
        
        foreach ($toAddresses as $address) {
            $email = $address->getAddress();
            
            // Try to find client by email
            $client = Client::where('email', $email)->first();
            
            if ($client) {
                // Get subject
                $subject = $message->getSubject() ?? 'No Subject';
                
                // Try to determine template/type from subject or other metadata
                $type = $this->determineEmailType($subject);
                
                // Log the email
                SentEmail::create([
                    'client_id' => $client->id,
                    'subject' => $subject,
                    'to_email' => $email,
                    'template' => $this->extractTemplate($event),
                    'type' => $type,
                    'status' => 'sent',
                    'metadata' => [
                        'from' => $this->getFromAddress($message),
                        'headers' => $this->getHeaders($message),
                    ],
                ]);
            }
        }
    }
    
    /**
     * Determine email type based on subject
     */
    private function determineEmailType(string $subject): string
    {
        $subject = strtolower($subject);
        
        if (str_contains($subject, 'invoice') || str_contains($subject, 'فاتورة')) {
            return 'invoice';
        }
        if (str_contains($subject, 'order') || str_contains($subject, 'طلب')) {
            return 'order';
        }
        if (str_contains($subject, 'welcome') || str_contains($subject, 'مرحبا')) {
            return 'welcome';
        }
        if (str_contains($subject, 'password') || str_contains($subject, 'كلمة')) {
            return 'password_reset';
        }
        if (str_contains($subject, 'verification') || str_contains($subject, 'verify') || str_contains($subject, 'otp') || str_contains($subject, 'تحقق')) {
            return 'verification';
        }
        if (str_contains($subject, 'payment') || str_contains($subject, 'دفع')) {
            return 'payment';
        }
        if (str_contains($subject, 'cancel') || str_contains($subject, 'إلغاء')) {
            return 'cancellation';
        }
        if (str_contains($subject, 'support') || str_contains($subject, 'ticket') || str_contains($subject, 'دعم')) {
            return 'support';
        }
        
        return 'general';
    }
    
    /**
     * Try to extract template name from event data
     */
    private function extractTemplate($event): ?string
    {
        // Check if there's data attached with template info
        if (isset($event->data['__laravel_notification'])) {
            return class_basename($event->data['__laravel_notification']);
        }
        
        return null;
    }
    
    /**
     * Get from address
     */
    private function getFromAddress($message): ?string
    {
        $from = $message->getFrom();
        if (!empty($from)) {
            $firstFrom = reset($from);
            return $firstFrom ? $firstFrom->getAddress() : null;
        }
        return null;
    }
    
    /**
     * Get relevant headers
     */
    private function getHeaders($message): array
    {
        $headers = [];
        
        try {
            $headersObj = $message->getHeaders();
            if ($headersObj->has('Message-ID')) {
                $headers['message_id'] = $headersObj->get('Message-ID')->getBodyAsString();
            }
        } catch (\Exception $e) {
            // Ignore header errors
        }
        
        return $headers;
    }
}
