<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateCommission extends Model
{
    protected $fillable = [
        'affiliate_id',
        'referral_id',
        'invoice_id',
        'amount',
        'commission_rate',
        'commission_amount',
        'status',
        'description',
        'reference_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commission) {
            if (empty($commission->reference_id)) {
                $commission->reference_id = self::generateUniqueReferenceId();
            }
        });
    }

    /**
     * Generate a unique reference ID
     */
    public static function generateUniqueReferenceId(): string
    {
        do {
            $referenceId = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('reference_id', $referenceId)->exists());

        return $referenceId;
    }

    /**
     * Get the affiliate
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Get the referral
     */
    public function referral(): BelongsTo
    {
        return $this->belongsTo(AffiliateReferral::class, 'referral_id');
    }

    /**
     * Get the invoice
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
