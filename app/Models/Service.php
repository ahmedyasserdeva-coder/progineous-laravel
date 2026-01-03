<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'order_id',
        'order_item_id',
        'type',
        'service_name',
        'domain',
        'username',
        'password',
        'cpanel_username',
        'cpanel_password',
        'server_id',
        'server_data',
        'package_name',
        'whm_account_domain',
        'domain_registration_id',
        'registration_date',
        'expiry_date',
        'domain_action',
        'epp_code',
        'ip_address',
        'root_password',
        'server_specs',
        'next_due_date',
        'recurring_amount',
        'billing_cycle',
        'status',
        'activated_at',
        'suspended_at',
        'terminated_at',
        'cancellation_requested_at',
        'cancellation_reason',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'server_specs' => 'array',
        'server_data' => 'array',
        'metadata' => 'array',
        'registration_date' => 'date',
        'expiry_date' => 'date',
        'next_due_date' => 'date',
        'recurring_amount' => 'decimal:2',
        'activated_at' => 'datetime',
        'suspended_at' => 'datetime',
        'terminated_at' => 'datetime',
        'cancellation_requested_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'cpanel_password',
        'root_password',
        'epp_code',
    ];

    /**
     * Get the decrypted cPanel password
     * The password is stored encrypted in the 'password' field
     */
    public function getDecryptedPasswordAttribute(): ?string
    {
        $password = $this->attributes['password'] ?? null;
        
        if (empty($password)) {
            return null;
        }
        
        try {
            return decrypt($password);
        } catch (\Exception $e) {
            // If decryption fails, return the raw value (might be plain text)
            return $password;
        }
    }

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
    
    /**
     * Get the domain registration record for this service
     * Used when type = 'domain'
     */
    public function domainRegistration()
    {
        return $this->belongsTo(Domain::class, 'domain_registration_id');
    }
    
    /**
     * Check if this is a domain registration service
     */
    public function isDomainService(): bool
    {
        return $this->type === 'domain';
    }
    
    /**
     * Get the domain name for this service
     * For domain services, gets from domains table via relationship
     * For hosting services, returns the domain field directly
     */
    public function getDomainName(): ?string
    {
        if ($this->isDomainService() && $this->domainRegistration) {
            return $this->domainRegistration->domain_name;
        }
        return $this->domain;
    }
    
    /**
     * Get domain status from the domains table (for domain services)
     */
    public function getDomainStatusAttribute(): ?string
    {
        if ($this->isDomainService() && $this->domainRegistration) {
            return $this->domainRegistration->status;
        }
        return null;
    }
    
    /**
     * Get domain expiry from the domains table (for domain services)
     */
    public function getDomainExpiryAttribute(): ?\Carbon\Carbon
    {
        if ($this->isDomainService() && $this->domainRegistration) {
            return $this->domainRegistration->expiry_date;
        }
        return $this->expiry_date;
    }

    // Helper Methods
    public function activate()
    {
        $this->status = 'active';
        $this->activated_at = now();
        $this->save();
    }

    public function suspend()
    {
        $this->status = 'suspended';
        $this->suspended_at = now();
        $this->save();
    }

    public function terminate()
    {
        $this->status = 'terminated';
        $this->terminated_at = now();
        $this->save();
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    /**
     * Get the URL to view this service based on its type
     */
    public function getViewUrl(): string
    {
        return match($this->type) {
            'hosting' => route('client.hosting.show', $this->id),
            'cloud_hosting' => route('client.hosting.cloud.show', $this->id),
            'reseller' => route('client.hosting.reseller.show', $this->id),
            'dedicated' => route('client.hosting.dedicated.show', $this->id),
            'vps' => route('client.hosting.vps.show', $this->id),
            'domain' => route('client.domains.show', $this->domain_registration_id ?? $this->id),
            default => route('client.hosting.show', $this->id),
        };
    }
}
