<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class DomainRegistrar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'api_key',
        'api_secret',
        'test_mode',
        'settings',
        'status',
        'preferred_coupons',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'test_mode' => 'boolean',
        'status' => 'boolean',
        'preferred_coupons' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'api_key',
        'api_secret',
    ];

    /**
     * Get the api_key attribute (decrypt).
     */
    protected function apiKey(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Get the api_secret attribute (decrypt).
     */
    protected function apiSecret(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Scope a query to only include active registrars.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to filter by registrar type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the display name for the registrar type.
     */
    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'namecheap' => 'Namecheap',
            'godaddy' => 'GoDaddy',
            'resellerclub' => 'ResellerClub',
            'enom' => 'Enom',
            'cloudflare' => 'Cloudflare',
            'dynadot' => 'Dynadot',
            'custom' => __('crm.custom'),
            default => $this->type,
        };
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute()
    {
        return $this->status ? 'green' : 'gray';
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? __('crm.configured') : __('crm.not_configured');
    }

    /**
     * Test the API connection.
     */
    public function testConnection()
    {
        // This method will be implemented based on the registrar type
        // For now, return a basic structure
        return [
            'success' => false,
            'message' => 'Connection test not implemented for this registrar type.',
        ];
    }
}
