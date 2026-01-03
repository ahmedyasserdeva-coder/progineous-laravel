<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class DedicatedInstance extends Model
{
    protected $fillable = [
        'dedicated_plan_id',
        'client_id',
        'order_id',
        'vultr_baremetal_id',
        'vultr_region',
        'hetzner_server_id',
        'hetzner_server_name',
        'hetzner_server_data',
        'hostname',
        'label',
        'main_ip',
        'ipv6_main',
        'os_id',
        'os_name',
        'control_panel',
        'status',
        'power_status',
        'root_password',
        'ipmi_ip',
        'ipmi_username',
        'ipmi_password',
        'hardware_info',
        'raid_config',
        'bandwidth_used_bytes',
        'bandwidth_limit_bytes',
        'backups_enabled',
        'backup_schedule',
        'requires_approval',
        'approved_at',
        'provisioned_at',
        'suspended_at',
        'terminated_at',
        'next_due_date',
        'setup_instructions',
        'admin_notes',
    ];

    protected $casts = [
        'dedicated_plan_id' => 'integer',
        'client_id' => 'integer',
        'order_id' => 'integer',
        'hetzner_server_data' => 'array',
        'os_id' => 'integer',
        'hardware_info' => 'array',
        'bandwidth_used_bytes' => 'integer',
        'bandwidth_limit_bytes' => 'integer',
        'backups_enabled' => 'boolean',
        'requires_approval' => 'boolean',
        'approved_at' => 'datetime',
        'provisioned_at' => 'datetime',
        'suspended_at' => 'datetime',
        'terminated_at' => 'datetime',
        'next_due_date' => 'date',
    ];

    protected $hidden = [
        'root_password',
        'ipmi_password',
    ];

    /**
     * Get the dedicated plan
     */
    public function dedicatedPlan(): BelongsTo
    {
        return $this->belongsTo(DedicatedPlan::class, 'dedicated_plan_id');
    }

    /**
     * Get the client (owner)
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Encrypt/Decrypt root password
     */
    protected function rootPassword(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Encrypt/Decrypt IPMI password
     */
    protected function ipmiPassword(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Scope for active instances
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for suspended instances
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope for pending approval
     */
    public function scopePendingApproval($query)
    {
        return $query->where('requires_approval', true)
                    ->whereNull('approved_at');
    }

    /**
     * Check if instance is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if instance is running
     */
    public function isRunning(): bool
    {
        return $this->power_status === 'running';
    }

    /**
     * Check if instance is approved
     */
    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    /**
     * Get formatted bandwidth usage
     */
    public function getFormattedBandwidthUsageAttribute(): string
    {
        $gb = $this->bandwidth_used_bytes / 1073741824; // Convert to GB
        return number_format($gb, 2) . ' GB';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'pending' => 'yellow',
            'provisioning' => 'blue',
            'suspended' => 'orange',
            'terminated' => 'red',
            'failed' => 'red',
            default => 'gray',
        };
    }
}
