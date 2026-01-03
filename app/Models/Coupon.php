<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'max_uses',
        'used_count',
        'expires_at',
        'description',
        'apply_to_all',
        'products',
        'billing_cycles',
        'customer_type',
        'specific_customer_id',
        'once_per_order',
        'once_per_client',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'expires_at' => 'date',
        'apply_to_all' => 'boolean',
        'products' => 'array',
        'billing_cycles' => 'array',
        'once_per_order' => 'boolean',
        'once_per_client' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon can be applied to a product
     */
    public function canApplyToProduct($productType, $productId)
    {
        if ($this->apply_to_all) {
            return true;
        }

        if (!$this->products) {
            return false;
        }

        $productKey = $productType . '-' . $productId;
        return in_array($productKey, $this->products);
    }

    /**
     * Check if coupon can be applied to a billing cycle
     */
    public function canApplyToBillingCycle($billingCycle)
    {
        if (!$this->billing_cycles || empty($this->billing_cycles)) {
            return true;
        }

        return in_array($billingCycle, $this->billing_cycles);
    }

    /**
     * Increment used count
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    /**
     * Get remaining uses
     */
    public function getRemainingUsesAttribute()
    {
        if (!$this->max_uses) {
            return null; // Unlimited
        }

        return max(0, $this->max_uses - $this->used_count);
    }

    /**
     * Check if coupon has expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

        /**
     * Get the specific customer this coupon is assigned to
     */
    public function specificCustomer()
    {
        return $this->belongsTo(Client::class, 'specific_customer_id');
    }
}
