<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'name_ar',
        'type',
        'discount_percentage',
        'start_date',
        'end_date',
        'description',
        'description_en',
        'description_ar',
        'apply_to_all',
        'products',
        'billing_cycles',
        'customer_type',
        'once_per_order',
        'once_per_client',
        'banner_url',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_percentage' => 'decimal:2',
        'apply_to_all' => 'boolean',
        'products' => 'array',
        'billing_cycles' => 'array',
        'once_per_order' => 'boolean',
        'once_per_client' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Check if campaign is currently active and within date range
     */
    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now()->startOfDay();
        $start = Carbon::parse($this->start_date)->startOfDay();
        $end = Carbon::parse($this->end_date)->endOfDay();

        return $now->between($start, $end);
    }

    /**
     * Check if campaign applies to a specific product
     */
    public function canApplyToProduct(string $type, int $id): bool
    {
        if ($this->apply_to_all) {
            return true;
        }

        if (empty($this->products)) {
            return false;
        }

        $productKey = "{$type}-{$id}";
        return in_array($productKey, $this->products);
    }

    /**
     * Check if campaign applies to a specific billing cycle
     */
    public function canApplyToBillingCycle(string $cycle): bool
    {
        if (empty($this->billing_cycles)) {
            return true; // If no specific cycles set, apply to all
        }

        return in_array($cycle, $this->billing_cycles);
    }

    /**
     * Check if campaign applies to a specific customer type
     */
    public function canApplyToCustomer(bool $isNewCustomer): bool
    {
        if ($this->customer_type === 'all') {
            return true;
        }

        if ($this->customer_type === 'new' && $isNewCustomer) {
            return true;
        }

        if ($this->customer_type === 'existing' && !$isNewCustomer) {
            return true;
        }

        return false;
    }

    /**
     * Get days remaining until campaign ends
     */
    public function getDaysRemainingAttribute(): int
    {
        $now = Carbon::now()->startOfDay();
        $end = Carbon::parse($this->end_date)->endOfDay();

        if ($now->greaterThan($end)) {
            return 0;
        }

        return $now->diffInDays($end);
    }

    /**
     * Check if campaign has ended
     */
    public function getHasEndedAttribute(): bool
    {
        $now = Carbon::now();
        $end = Carbon::parse($this->end_date)->endOfDay();

        return $now->greaterThan($end);
    }

    /**
     * Check if campaign has started
     */
    public function getHasStartedAttribute(): bool
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->start_date)->startOfDay();

        return $now->greaterThanOrEqualTo($start);
    }

    /**
     * Scope: Get only active campaigns
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('start_date', '<=', Carbon::now())
                     ->whereDate('end_date', '>=', Carbon::now());
    }

    /**
     * Scope: Get upcoming campaigns
     */
    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('start_date', '>', Carbon::now());
    }

    /**
     * Scope: Get expired campaigns
     */
    public function scopeExpired($query)
    {
        return $query->whereDate('end_date', '<', Carbon::now());
    }
}
