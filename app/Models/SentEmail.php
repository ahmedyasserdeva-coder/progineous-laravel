<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'subject',
        'to_email',
        'template',
        'type',
        'status',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the client that owns the email.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get type badge color
     */
    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'invoice' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
            'support' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
            'marketing' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
            'security' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
            'welcome' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'],
        };
    }

    /**
     * Log a sent email
     */
    public static function log(int $clientId, string $subject, string $toEmail, string $type = 'system', ?string $template = null, array $metadata = [], string $status = 'sent', ?string $errorMessage = null)
    {
        return self::create([
            'client_id' => $clientId,
            'subject' => $subject,
            'to_email' => $toEmail,
            'type' => $type,
            'template' => $template,
            'metadata' => $metadata,
            'status' => $status,
            'error_message' => $errorMessage,
        ]);
    }
}
