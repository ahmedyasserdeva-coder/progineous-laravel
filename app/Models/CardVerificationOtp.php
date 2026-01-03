<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CardVerificationOtp extends Model
{
    protected $fillable = [
        'client_id',
        'otp_code',
        'expires_at',
        'used',
        'used_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Get the client that owns the OTP
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Check if OTP is valid
     */
    public function isValid(): bool
    {
        return !$this->used && Carbon::parse($this->expires_at)->isFuture();
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed(): void
    {
        $this->update([
            'used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Generate random 6-digit OTP code
     */
    public static function generateCode(): string
    {
        return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create new OTP for client
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
            'expires_at' => now()->addMinutes(5), // Valid for 5 minutes
            'ip_address' => $ipAddress,
        ]);
    }
}
