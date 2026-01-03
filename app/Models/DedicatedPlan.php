<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DedicatedPlan extends Model
{
    protected $fillable = [
        'plan_name',
        'plan_tagline',
        'plan_short_description',
        'plan_description',
        'cpu_type',
        'cpu_cores',
        'cpu_threads',
        'cpu_frequency',
        'ram_gb',
        'storage_config',
        'storage_type',
        'storage_total_gb',
        'disk_count',
        'bandwidth',
        'ipv4_count',
        'enable_ipv6',
        'hetzner_server_type',
        'hetzner_location',
        'payment_type',
        'monthly_price',
        'quarterly_price',
        'semi_annually_price',
        'annually_price',
        'setup_fee',
        'setup_time',
        'auto_setup',
        'os_options',
        'control_panel_options',
        'cpanel_price',
        'plesk_price',
        'features_list',
        'features_list_ar',
        'allow_ipmi',
        'allow_custom_os',
        'allow_raid_config',
        'require_domain',
        'is_featured',
        'is_hidden',
        'is_active',
        'requires_approval',
        'welcome_email_template_id',
        'sort_order',
    ];

    protected $casts = [
        'cpu_cores' => 'integer',
        'cpu_threads' => 'integer',
        'ram_gb' => 'integer',
        'storage_total_gb' => 'integer',
        'disk_count' => 'integer',
        'ipv4_count' => 'integer',
        'enable_ipv6' => 'boolean',
        'monthly_price' => 'decimal:2',
        'quarterly_price' => 'decimal:2',
        'semi_annually_price' => 'decimal:2',
        'annually_price' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'cpanel_price' => 'decimal:2',
        'plesk_price' => 'decimal:2',
        'os_options' => 'array',
        'control_panel_options' => 'array',
        'features_list' => 'array',
        'features_list_ar' => 'array',
        'allow_ipmi' => 'boolean',
        'allow_custom_os' => 'boolean',
        'allow_raid_config' => 'boolean',
        'require_domain' => 'boolean',
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean',
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get all dedicated instances for this plan
     */
    public function instances(): HasMany
    {
        return $this->hasMany(DedicatedInstance::class, 'dedicated_plan_id');
    }

    /**
     * Get active instances count
     */
    public function getActiveInstancesCountAttribute(): int
    {
        return $this->instances()->where('status', 'active')->count();
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured plans
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get formatted RAM display
     */
    public function getFormattedRamAttribute(): string
    {
        return $this->ram_gb . ' GB';
    }

    /**
     * Get formatted storage display
     */
    public function getFormattedStorageAttribute(): string
    {
        return $this->storage_config;
    }

    /**
     * Get price for specific billing cycle
     */
    public function getPriceForCycle(string $cycle): ?float
    {
        $priceMap = [
            'monthly' => $this->monthly_price,
            'quarterly' => $this->quarterly_price,
            'semi_annually' => $this->semi_annually_price,
            'annually' => $this->annually_price,
        ];

        return $priceMap[$cycle] ?? null;
    }
}
