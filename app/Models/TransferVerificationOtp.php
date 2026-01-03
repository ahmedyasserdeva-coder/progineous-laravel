<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferVerificationOtp extends Model
{
    protected $fillable = [
        'client_id',
        'otp_code',
        'expires_at',
        'used',
        'ip_address'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean'
    ];

    /**
     * Generate a 6-digit OTP code
     */
    public static function generateCode(): string
    {
        return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create OTP for client
     */
    public static function createForClient(int $clientId, string $ipAddress = null): self
    {
        // Invalidate old unused OTPs
        self::where('client_id', $clientId)
            ->where('used', false)
            ->update(['used' => true]);

        return self::create([
            'client_id' => $clientId,
            'otp_code' => self::generateCode(),
            'expires_at' => now()->addMinutes(5),
            'used' => false,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Check if OTP is valid
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Client relationship
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
