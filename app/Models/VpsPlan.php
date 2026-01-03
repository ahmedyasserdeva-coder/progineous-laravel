<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VpsPlan extends Model
{
    protected $fillable = [
        'plan_name',
        'plan_tagline',
        'plan_short_description',
        'plan_description',
        'vcpu_count',
        'ram_mb',
        'storage_gb',
        'storage_type',
        'bandwidth_gb',
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
        'enable_backups',
        'enable_ddos_protection',
        'os_options',
        'control_panel_options',
        'cpanel_price',
        'plesk_price',
        'features_list',
        'features_list_ar',
        'allow_ssh',
        'allow_root',
        'allow_backups',
        'backup_price',
        'require_domain',
        'is_featured',
        'is_hidden',
        'is_active',
        'auto_setup',
        'welcome_email_template_id',
        'sort_order',
    ];

    protected $casts = [
        'vcpu_count' => 'integer',
        'ram_mb' => 'integer',
        'storage_gb' => 'integer',
        'bandwidth_gb' => 'integer',
        'ipv4_count' => 'integer',
        'enable_ipv6' => 'boolean',
        'monthly_price' => 'decimal:2',
        'quarterly_price' => 'decimal:2',
        'semi_annually_price' => 'decimal:2',
        'annually_price' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'enable_backups' => 'boolean',
        'enable_ddos_protection' => 'boolean',
        'cpanel_price' => 'decimal:2',
        'plesk_price' => 'decimal:2',
        'backup_price' => 'decimal:2',
        'os_options' => 'array',
        'control_panel_options' => 'array',
        'features_list' => 'array',
        'features_list_ar' => 'array',
        'allow_ssh' => 'boolean',
        'allow_root' => 'boolean',
        'allow_backups' => 'boolean',
        'require_domain' => 'boolean',
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get all VPS instances for this plan
     */
    public function instances(): HasMany
    {
        return $this->hasMany(VpsInstance::class, 'vps_plan_id');
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
        return $this->ram_mb >= 1024 
            ? round($this->ram_mb / 1024, 1) . ' GB' 
            : $this->ram_mb . ' MB';
    }

    /**
     * Get formatted storage display
     */
    public function getFormattedStorageAttribute(): string
    {
        return $this->storage_gb . ' GB';
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
