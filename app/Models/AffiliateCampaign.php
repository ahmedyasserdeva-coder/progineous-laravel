<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AffiliateCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'name',
        'slug',
        'source',
        'description',
        'destination_url',
        'clicks',
        'referrals',
        'conversions',
        'earnings',
        'status',
        'last_click_at',
    ];

    protected $casts = [
        'clicks' => 'integer',
        'referrals' => 'integer',
        'conversions' => 'integer',
        'earnings' => 'decimal:2',
        'last_click_at' => 'datetime',
    ];

    /**
     * Available source platforms
     */
    public const SOURCES = [
        'facebook' => ['name' => 'Facebook', 'icon' => 'facebook', 'color' => 'blue'],
        'twitter' => ['name' => 'Twitter/X', 'icon' => 'twitter', 'color' => 'sky'],
        'instagram' => ['name' => 'Instagram', 'icon' => 'instagram', 'color' => 'pink'],
        'youtube' => ['name' => 'YouTube', 'icon' => 'youtube', 'color' => 'red'],
        'tiktok' => ['name' => 'TikTok', 'icon' => 'tiktok', 'color' => 'gray'],
        'linkedin' => ['name' => 'LinkedIn', 'icon' => 'linkedin', 'color' => 'blue'],
        'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'whatsapp', 'color' => 'green'],
        'telegram' => ['name' => 'Telegram', 'icon' => 'telegram', 'color' => 'sky'],
        'email' => ['name' => 'Email', 'icon' => 'email', 'color' => 'gray'],
        'website' => ['name' => 'Website', 'icon' => 'website', 'color' => 'indigo'],
        'other' => ['name' => 'Other', 'icon' => 'link', 'color' => 'gray'],
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = self::generateUniqueSlug($campaign->name);
            }
        });
    }

    /**
     * Generate a unique slug for the campaign
     */
    public static function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug . '-' . Str::random(6);
        
        while (self::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::random(6);
        }
        
        return $slug;
    }

    /**
     * Get the affiliate that owns this campaign
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Get referrals from this campaign
     */
    public function campaignReferrals(): HasMany
    {
        return $this->hasMany(AffiliateReferral::class, 'campaign_id');
    }

    /**
     * Get visitors from this campaign
     */
    public function visitors(): HasMany
    {
        return $this->hasMany(AffiliateVisitor::class, 'campaign_id');
    }

    /**
     * Get the full campaign tracking link
     */
    public function getTrackingLinkAttribute(): string
    {
        $baseUrl = config('app.url');
        $affiliateCode = $this->affiliate->referral_code;
        return "{$baseUrl}?ref={$affiliateCode}&campaign={$this->slug}";
    }

    /**
     * Get QR code URL for this campaign
     */
    public function getQrCodeUrlAttribute(): string
    {
        $link = urlencode($this->tracking_link);
        // Using QR Server API for QR code generation (free and reliable)
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$link}";
    }

    /**
     * Get source info
     */
    public function getSourceInfoAttribute(): array
    {
        return self::SOURCES[$this->source] ?? self::SOURCES['other'];
    }

    /**
     * Get conversion rate
     */
    public function getConversionRateAttribute(): float
    {
        if ($this->clicks == 0) {
            return 0;
        }
        return round(($this->referrals / $this->clicks) * 100, 2);
    }

    /**
     * Increment click count
     */
    public function incrementClicks(): void
    {
        $this->increment('clicks');
        $this->update(['last_click_at' => now()]);
    }

    /**
     * Increment referral count
     */
    public function incrementReferrals(): void
    {
        $this->increment('referrals');
    }

    /**
     * Increment conversion count and add earnings
     */
    public function recordConversion(float $amount): void
    {
        $this->increment('conversions');
        $this->increment('earnings', $amount);
    }

    /**
     * Scope for active campaigns
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for campaigns by source
     */
    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }
}
