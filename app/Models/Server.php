<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'monthly_cost',
        'hostname',
        'ip_address',
        'port',
        'max_accounts',
        'datacenter',
        'assigned_ips',
        'username',
        'password',
        'api_token',
        'port_override',
        'use_ssl',
        'nameserver1',
        'nameserver1_ip',
        'nameserver2',
        'nameserver2_ip',
        'nameserver3',
        'nameserver3_ip',
        'nameserver4',
        'nameserver4_ip',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monthly_cost' => 'decimal:2',
        'port' => 'integer',
        'max_accounts' => 'integer',
        'port_override' => 'integer',
        'use_ssl' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token',
    ];

    /**
     * Get the password attribute (decrypt).
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Get the api_token attribute (decrypt).
     */
    protected function apiToken(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Get the assigned IPs as an array.
     */
    protected function assignedIpsArray(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->assigned_ips 
                ? array_filter(array_map('trim', explode("\n", $this->assigned_ips)))
                : [],
        );
    }

    /**
     * Scope a query to only include active servers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get products assigned to this server.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to filter by server type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the display name for the server type.
     */
    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'cpanel' => 'cPanel/WHM',
            'plesk' => 'Plesk',
            'directadmin' => 'DirectAdmin',
            'custom' => __('crm.custom'),
            default => $this->type,
        };
    }

    /**
     * Check if server has available space.
     */
    public function hasAvailableSpace($currentAccounts = 0)
    {
        if (!$this->max_accounts) {
            return true; // Unlimited
        }
        
        return $currentAccounts < $this->max_accounts;
    }
}
