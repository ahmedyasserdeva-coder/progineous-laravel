<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

class Client extends Authenticatable
{
    use HasFactory;

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            // Generate a secret key for TOTP-like support PIN
            if (empty($client->support_pin)) {
                $client->support_pin = bin2hex(random_bytes(16)); // 32 char hex secret
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'username_last_changed_at',
        'first_name',
        'last_name',
        'company_name',
        'email',
        'email_last_changed_at',
        'preferred_language',
        'password',
        'country_code',
        'phone',
        'address1',
        'address_1',
        'address2',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'tax_number',
        'currency',
        'wallet_balance',
        'wallet_card_number',
        'payment_method',
        'status',
        'billing_contact',
        'referral_source',
        'email_notifications',
        'settings',
        'owner_type',
        'existing_user_id',
        'admin_notes',
        'send_welcome_email',
        'google2fa_enabled',
        'two_factor_method',
        'google2fa_secret',
        'backup_codes',
        'google_id',
        'github_id',
        'linkedin_id',
        'last_login_at',
        'last_login_ip',
        'support_pin',
        'is_affiliate',
        'terms_accepted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
        'backup_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'username_last_changed_at' => 'datetime',
        'email_last_changed_at' => 'datetime',
        'password' => 'hashed',
        'wallet_balance' => 'decimal:2',
        'email_notifications' => 'array',
        'settings' => 'array',
        'send_welcome_email' => 'boolean',
        'google2fa_enabled' => 'boolean',
        'backup_codes' => 'array',
        'last_login_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
    ];

    /**
     * Check if the client has accepted terms.
     */
    public function hasAcceptedTerms(): bool
    {
        return !is_null($this->terms_accepted_at);
    }

    /**
     * Get time-based support PIN (changes every 15 minutes)
     * Uses TOTP-like algorithm
     */
    public function getSupportPinAttribute($value)
    {
        // Ensure we have a secret
        if (empty($value)) {
            $value = bin2hex(random_bytes(16));
            // Use DB update to avoid accessor recursion
            \DB::table('clients')->where('id', $this->id)->update(['support_pin' => $value]);
            $this->attributes['support_pin'] = $value;
        }
        
        // Calculate current 15-minute window
        $timeWindow = floor(time() / 900); // 900 seconds = 15 minutes
        
        // Generate PIN using HMAC with secret and time window
        $hash = hash_hmac('sha256', $timeWindow . $this->id, $value);
        
        // Extract 6 digits from hash
        $offset = hexdec(substr($hash, -1)) % 16;
        $pin = hexdec(substr($hash, $offset * 2, 8)) % 1000000;
        
        return str_pad($pin, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the raw support PIN secret (for database storage)
     */
    public function getRawSupportPinSecret()
    {
        return $this->attributes['support_pin'] ?? null;
    }

    /**
     * Get remaining seconds until PIN changes
     * Returns consistent value based on server time
     */
    public function getSupportPinExpiresInAttribute()
    {
        $currentTime = time();
        $windowEnd = (floor($currentTime / 900) + 1) * 900;
        return $windowEnd - $currentTime;
    }

    /**
     * Get the timestamp when the current PIN window ends
     */
    public function getSupportPinExpiresAtAttribute()
    {
        $currentTime = time();
        return (floor($currentTime / 900) + 1) * 900;
    }

    /**
     * Verify a support PIN (checks current and previous window for tolerance)
     */
    public function verifySupportPin($inputPin)
    {
        $secret = $this->attributes['support_pin'] ?? null;
        if (empty($secret)) {
            return false;
        }
        
        // Check current window
        $currentWindow = floor(time() / 900);
        
        // Check current and previous window (for tolerance)
        for ($i = 0; $i <= 1; $i++) {
            $window = $currentWindow - $i;
            $hash = hash_hmac('sha256', $window . $this->id, $secret);
            $offset = hexdec(substr($hash, -1)) % 16;
            $pin = hexdec(substr($hash, $offset * 2, 8)) % 1000000;
            $expectedPin = str_pad($pin, 6, '0', STR_PAD_LEFT);
            
            if ($inputPin === $expectedPin) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the wallet transactions for the client
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get completed wallet transactions
     */
    public function completedTransactions()
    {
        return $this->walletTransactions()->completed();
    }

    /**
     * Get wallet transfers sent by this client
     */
    public function sentTransfers()
    {
        return $this->hasMany(WalletTransfer::class, 'sender_id');
    }

    /**
     * Get wallet transfers received by this client
     */
    public function receivedTransfers()
    {
        return $this->hasMany(WalletTransfer::class, 'receiver_id');
    }

    /**
     * Get client notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get email change logs
     */
    public function emailChangeLogs()
    {
        return $this->hasMany(EmailChangeLog::class);
    }

    /**
     * Get client orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get client services
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get client invoices
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get client sent emails
     */
    public function sentEmails()
    {
        return $this->hasMany(SentEmail::class);
    }

    /**
     * Add funds to wallet
     */
    public function addFunds(float $amount, string $notes = null): void
    {
        $this->increment('wallet_balance', $amount);
        
        if ($notes) {
            Log::info("Wallet funds added for client {$this->id}: \${$amount} - {$notes}");
        }
    }

    /**
     * Deduct funds from wallet
     */
    public function deductFunds(float $amount, string $notes = null): bool
    {
        if ($this->wallet_balance < $amount) {
            return false;
        }

        $this->decrement('wallet_balance', $amount);
        
        if ($notes) {
            Log::info("Wallet funds deducted for client {$this->id}: \${$amount} - {$notes}");
        }

        return true;
    }

    /**
     * Check if client has sufficient balance
     */
    public function hasSufficientBalance(float $amount): bool
    {
        return $this->wallet_balance >= $amount;
    }

    /**
     * Get formatted wallet balance
     */
    public function getFormattedBalanceAttribute(): string
    {
        return '$' . number_format($this->wallet_balance, 2);
    }

    /**
     * Get the full name of the client.
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check if a specific email notification is enabled.
     */
    public function hasEmailNotification($type)
    {
        return isset($this->email_notifications[$type]) && $this->email_notifications[$type];
    }

    /**
     * Check if a specific setting is enabled.
     */
    public function hasSetting($setting)
    {
        return isset($this->settings[$setting]) && $this->settings[$setting];
    }

    /**
     * Scope to filter active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter inactive clients.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope to filter suspended clients.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Generate and assign a unique wallet card number if not exists
     */
    public function generateWalletCardNumber(): string
    {
        if ($this->wallet_card_number) {
            return $this->wallet_card_number;
        }

        // Generate fully random card number: 5XXX-XXXX-XXXX-XXXX (Mastercard format)
        // All digits are random for security
        do {
            $part1 = '5' . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            $part2 = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $part3 = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $part4 = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT); // Fully random last 4 digits
            
            $cardNumber = $part1 . ' ' . $part2 . ' ' . $part3 . ' ' . $part4;
        } while (self::where('wallet_card_number', $cardNumber)->exists());

        $this->wallet_card_number = $cardNumber;
        $this->save();

        return $cardNumber;
    }

    /**
     * Get wallet card number (generate if not exists)
     */
    public function getWalletCardNumber(): string
    {
        return $this->wallet_card_number ?? $this->generateWalletCardNumber();
    }
}
