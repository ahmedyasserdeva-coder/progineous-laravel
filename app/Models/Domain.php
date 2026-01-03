<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /**
     * Domain Status Constants
     */
    // Pending - Registration attempted but insufficient balance in Dynadot
    const STATUS_PENDING = 'pending';

    // Pending Registration - Domain sent to Dynadot, balance deducted, but not yet registered
    const STATUS_PENDING_REGISTRATION = 'pending_registration';

    // Pending Transfer - Customer requested transfer, still in progress at Dynadot
    const STATUS_PENDING_TRANSFER = 'pending_transfer';

    // Active - Domain is registered and working in Dynadot
    const STATUS_ACTIVE = 'active';

    // Grace Period - Domain expired, in grace period
    const STATUS_GRACE_PERIOD = 'grace_period';

    // Redemption Period - Domain expired, in redemption period
    const STATUS_REDEMPTION_PERIOD = 'redemption_period';

    // Expired - Grace and redemption periods ended, domain not renewed
    const STATUS_EXPIRED = 'expired';

    // Transferred Away - Domain transferred out of Dynadot
    const STATUS_TRANSFERRED_AWAY = 'transferred_away';

    // Cancelled - Domain registration cancelled
    const STATUS_CANCELLED = 'cancelled';

    // Fraud - Domain marked as fraud by admins
    const STATUS_FRAUD = 'fraud';

    /**
     * Order Type Constants
     */
    const ORDER_TYPE_REGISTER = 'register';
    const ORDER_TYPE_TRANSFER = 'transfer';

    /**
     * Default Nameservers
     */
    const DEFAULT_NAMESERVERS = [
        'ns1.mysecurecloudhost.com',
        'ns2.mysecurecloudhost.com',
        'ns3.mysecurecloudhost.com',
        'ns4.mysecurecloudhost.com',
    ];

    protected $fillable = [
        'client_id',
        'order_id',
        'domain_name',
        'tld',
        'status',
        'order_type',
        'registrar',
        'first_payment_amount',
        'recurring_amount',
        'registration_period',
        'registration_date',
        'expiry_date',
        'next_due_date',
        'payment_method',
        'promotion_code',
        'nameservers',
        'auth_code',
        'auto_renew',
        'registrar_lock',
        'id_protection',
        'registrar_domain_id',
        'dns_management',
        'email_forwarding',
        'cloudflare_zone_id',
    ];

    protected $casts = [
        'nameservers' => 'array',
        'registration_date' => 'datetime',
        'expiry_date' => 'datetime',
        'next_due_date' => 'datetime',
        'auto_renew' => 'boolean',
        'registrar_lock' => 'boolean',
        'id_protection' => 'boolean',
        'dns_management' => 'boolean',
        'email_forwarding' => 'boolean',
        'first_payment_amount' => 'decimal:2',
        'recurring_amount' => 'decimal:2',
        'registration_period' => 'integer',
    ];

    /**
     * Get the client that owns the domain
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the order that the domain belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service associated with this domain
     */
    public function service()
    {
        return $this->hasOne(Service::class, 'domain_registration_id');
    }

    /**
     * Get all available order types
     */
    public static function getOrderTypes(): array
    {
        return [
            self::ORDER_TYPE_REGISTER => 'Register',
            self::ORDER_TYPE_TRANSFER => 'Transfer',
        ];
    }

    /**
     * Get Arabic order type labels
     */
    public static function getOrderTypesArabic(): array
    {
        return [
            self::ORDER_TYPE_REGISTER => 'تسجيل',
            self::ORDER_TYPE_TRANSFER => 'نقل',
        ];
    }

    /**
     * Get order type label
     */
    public function getOrderTypeLabelAttribute(): string
    {
        return self::getOrderTypes()[$this->order_type] ?? $this->order_type ?? 'N/A';
    }

    /**
     * Get Arabic order type label
     */
    public function getOrderTypeLabelArAttribute(): string
    {
        return self::getOrderTypesArabic()[$this->order_type] ?? $this->order_type ?? 'غير محدد';
    }

    /**
     * Get all available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PENDING_REGISTRATION => 'Pending Registration',
            self::STATUS_PENDING_TRANSFER => 'Pending Transfer',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_GRACE_PERIOD => 'Grace Period (Expired)',
            self::STATUS_REDEMPTION_PERIOD => 'Redemption Period (Expired)',
            self::STATUS_EXPIRED => 'Expired',
            self::STATUS_TRANSFERRED_AWAY => 'Transferred Away',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_FRAUD => 'Fraud',
        ];
    }

    /**
     * Get Arabic status labels
     */
    public static function getStatusesArabic(): array
    {
        return [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_PENDING_REGISTRATION => 'قيد التسجيل',
            self::STATUS_PENDING_TRANSFER => 'قيد النقل',
            self::STATUS_ACTIVE => 'نشط',
            self::STATUS_GRACE_PERIOD => 'فترة السماح (منتهي)',
            self::STATUS_REDEMPTION_PERIOD => 'فترة الاسترداد (منتهي)',
            self::STATUS_EXPIRED => 'منتهي',
            self::STATUS_TRANSFERRED_AWAY => 'تم نقله خارجياً',
            self::STATUS_CANCELLED => 'ملغي',
            self::STATUS_FRAUD => 'احتيال',
        ];
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    /**
     * Get the Arabic status label
     */
    public function getStatusLabelArAttribute(): string
    {
        return self::getStatusesArabic()[$this->status] ?? $this->status;
    }

    /**
     * Check if domain is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if domain is pending (any pending status)
     */
    public function isPending(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_PENDING_REGISTRATION,
            self::STATUS_PENDING_TRANSFER,
        ]);
    }

    /**
     * Check if domain is expired (any expired status)
     */
    public function isExpired(): bool
    {
        return in_array($this->status, [
            self::STATUS_GRACE_PERIOD,
            self::STATUS_REDEMPTION_PERIOD,
            self::STATUS_EXPIRED,
        ]);
    }

    /**
     * Get status badge color for UI (CSS classes)
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'bg-green-100 text-green-700',
            self::STATUS_PENDING, self::STATUS_PENDING_REGISTRATION, self::STATUS_PENDING_TRANSFER => 'bg-amber-100 text-amber-700',
            self::STATUS_GRACE_PERIOD, self::STATUS_REDEMPTION_PERIOD => 'bg-orange-100 text-orange-700',
            self::STATUS_EXPIRED, self::STATUS_TRANSFERRED_AWAY, self::STATUS_CANCELLED => 'bg-red-100 text-red-700',
            self::STATUS_FRAUD => 'bg-purple-100 text-purple-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get parsed nameservers as array
     */
    public function getNameserversArrayAttribute(): array
    {
        $ns = $this->nameservers;
        if (is_string($ns)) {
            $ns = json_decode($ns, true) ?? [];
        }
        return is_array($ns) ? $ns : [];
    }

    /**
     * Get individual nameserver by index (1-5)
     */
    public function getNameserver(int $index): ?string
    {
        $ns = $this->nameservers_array;
        return $ns[$index - 1] ?? null;
    }

    /**
     * Reset nameservers to default
     */
    public function resetToDefaultNameservers(): void
    {
        $this->nameservers = self::DEFAULT_NAMESERVERS;
        $this->save();
    }

    /**
     * Check if registrar lock is enabled
     */
    public function isRegistrarLocked(): bool
    {
        return (bool) $this->registrar_lock;
    }

    /**
     * Check if ID protection is enabled
     */
    public function hasIdProtection(): bool
    {
        return (bool) $this->id_protection;
    }

    /**
     * Get registration period in years label
     */
    public function getRegistrationPeriodLabelAttribute(): string
    {
        $years = $this->registration_period ?? 1;
        return $years . ' ' . ($years == 1 ? 'Year' : 'Years');
    }

    /**
     * Get Arabic registration period label
     */
    public function getRegistrationPeriodLabelArAttribute(): string
    {
        $years = $this->registration_period ?? 1;
        if ($years == 1) {
            return 'سنة واحدة';
        } elseif ($years == 2) {
            return 'سنتان';
        } elseif ($years >= 3 && $years <= 10) {
            return $years . ' سنوات';
        }
        return $years . ' سنة';
    }

    /**
     * Check if domain is currently using Cloudflare nameservers
     * Cloudflare nameservers typically end with .ns.cloudflare.com
     */
    public function isUsingCloudflareNameservers(): bool
    {
        // Must have a cloudflare_zone_id to be considered Cloudflare
        if (empty($this->cloudflare_zone_id)) {
            return false;
        }

        $nameservers = $this->nameservers_array;

        // If no nameservers, not using Cloudflare
        if (empty($nameservers)) {
            return false;
        }

        // Check if at least one nameserver contains cloudflare
        foreach ($nameservers as $ns) {
            if (stripos($ns, 'cloudflare') !== false) {
                return true;
            }
        }

        return false;
    }
}
