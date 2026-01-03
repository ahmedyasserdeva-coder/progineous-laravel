<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateVisitor extends Model
{
    protected $fillable = [
        'affiliate_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referral_code',
        'landing_page',
        'visited_checkout',
        'checkout_visited_at',
        'is_converted',
        'converted_client_id',
        'last_activity_at',
    ];

    protected $casts = [
        'visited_checkout' => 'boolean',
        'checkout_visited_at' => 'datetime',
        'is_converted' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the affiliate
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Get the converted client
     */
    public function convertedClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'converted_client_id');
    }

    /**
     * Check if visitor is currently active (within last 5 minutes)
     */
    public function isOnline(): bool
    {
        return $this->last_activity_at && $this->last_activity_at->diffInMinutes(now()) < 5;
    }

    /**
     * Scope for online visitors
     */
    public function scopeOnline($query)
    {
        return $query->where('last_activity_at', '>=', now()->subMinutes(5));
    }

    /**
     * Scope for today's visitors
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
