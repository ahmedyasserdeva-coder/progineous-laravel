<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCpanelTier extends Model
{
    protected $fillable = [
        'product_id',
        'tier',
        'monthly_price',
        'quarterly_price',
        'semi_annually_price',
        'annually_price',
        'biennially_price',
        'triennially_price',
    ];

    protected $casts = [
        'tier' => 'integer',
        'monthly_price' => 'decimal:2',
        'quarterly_price' => 'decimal:2',
        'semi_annually_price' => 'decimal:2',
        'annually_price' => 'decimal:2',
        'biennially_price' => 'decimal:2',
        'triennially_price' => 'decimal:2',
    ];

    /**
     * Get the product that owns the cPanel tier
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get price for a specific billing cycle
     */
    public function getPriceForCycle(string $cycle): float
    {
        return match($cycle) {
            'monthly' => $this->monthly_price,
            'quarterly' => $this->quarterly_price,
            'semi_annually' => $this->semi_annually_price,
            'annually' => $this->annually_price,
            'biennially' => $this->biennially_price,
            'triennially' => $this->triennially_price,
            default => 0,
        };
    }
}
