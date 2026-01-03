<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifiedDocument extends Model
{
    protected $fillable = [
        'document_id',
        'client_id',
        'document_type',
        'document_hash',
        'content_hash',
        'total_invoiced',
        'balance',
        'metadata',
        'generated_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'generated_at' => 'datetime',
        'total_invoiced' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Verify a document by its hash
     */
    public static function verifyByHash(string $hash): ?self
    {
        return static::where('document_hash', $hash)->first();
    }

    /**
     * Verify a document by its ID
     */
    public static function verifyById(string $documentId): ?self
    {
        return static::where('document_id', $documentId)->first();
    }
    
    /**
     * Get invoices from metadata
     */
    public function getInvoices(): array
    {
        return $this->metadata['invoices'] ?? [];
    }
    
    /**
     * Get transactions from metadata
     */
    public function getTransactions(): array
    {
        return $this->metadata['transactions'] ?? [];
    }
}
