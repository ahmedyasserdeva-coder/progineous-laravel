<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'type',
        'category',
        'description',
        'short_description',
        'features',
        'features_list',
        'features_list_ar',
        'welcome_email',
        'price',
        'billing_cycle',
        'payment_type',
        'pricing',
        'base_cpanel_accounts',
        'enable_cpanel_tiers',
        'require_domain',
        'is_active',
        'is_featured',
        'is_hidden',
        'allow_multiple_quantities',
        'api_product_id',
        'server_id',
        'whm_package_name',
        'auto_setup',
        'free_domain_config',
        'datacenter_locations',
        'datacenter_price',
    ];

    protected $casts = [
        'features' => 'array',
        'pricing' => 'array',
        'free_domain_config' => 'array',
        'datacenter_locations' => 'array',
        'datacenter_price' => 'array',
        'is_active' => 'boolean',
        'require_domain' => 'boolean',
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean',
        'allow_multiple_quantities' => 'boolean',
        'enable_cpanel_tiers' => 'boolean',
        'base_cpanel_accounts' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Get orders for this product
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the server that the product belongs to
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Get cPanel account tiers for this product (Reseller Hosting only)
     */
    public function cpanelTiers(): HasMany
    {
        return $this->hasMany(ProductCpanelTier::class);
    }

    /**
     * Scope for hosting products
     */
    public function scopeHosting($query)
    {
        return $query->where('type', 'hosting');
    }

    /**
     * Scope for domain products
     */
    public function scopeDomains($query)
    {
        return $query->where('type', 'domain');
    }

    /**
     * Scope for email products
     */
    public function scopeEmail($query)
    {
        return $query->where('type', 'email');
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get features_list as array
     * Converts JSON string or newline-separated string to array
     */
    public function getFeaturesListAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // First, try to decode as JSON (might be double-encoded)
        $decoded = json_decode($value, true);
        
        // If decoded is a string (double-encoded JSON), decode again
        if (is_string($decoded)) {
            $value = $decoded;
        } elseif (is_array($decoded)) {
            return $decoded;
        }

        // Split by newlines (handles \r\n, \n, \r)
        $lines = preg_split('/\r\n|\r|\n/', $value);
        return array_filter(array_map('trim', $lines)); // Remove empty lines
    }

    /**
     * Get features_list_ar as array
     * Converts JSON string or newline-separated string to array
     */
    public function getFeaturesListArAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // First, try to decode as JSON (might be double-encoded)
        $decoded = json_decode($value, true);
        
        // If decoded is a string (double-encoded JSON), decode again
        if (is_string($decoded)) {
            $value = $decoded;
        } elseif (is_array($decoded)) {
            return $decoded;
        }

        // Split by newlines (handles \r\n, \n, \r)
        $lines = preg_split('/\r\n|\r|\n/', $value);
        return array_filter(array_map('trim', $lines)); // Remove empty lines
    }
}
