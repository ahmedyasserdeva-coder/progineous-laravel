<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainPricing extends Model
{
    protected $table = 'domain_pricing';

    protected $fillable = [
        'tld',
        'registrar_id',
        'currency',
        'is_featured',
        'dynadot_register',
        'dynadot_renew',
        'dynadot_transfer',
        'dynadot_restore',
        'dynadot_graceFee',
        'progineous_register',
        'progineous_renew',
        'progineous_transfer',
        'progineous_restore',
        'progineous_graceFee',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'dynadot_register' => 'decimal:2',
        'dynadot_renew' => 'decimal:2',
        'dynadot_transfer' => 'decimal:2',
        'dynadot_restore' => 'decimal:2',
        'dynadot_graceFee' => 'decimal:2',
        'progineous_register' => 'decimal:2',
        'progineous_renew' => 'decimal:2',
        'progineous_transfer' => 'decimal:2',
        'progineous_restore' => 'decimal:2',
        'progineous_graceFee' => 'decimal:2',
    ];

    /**
     * Get the registrar that owns the pricing
     */
    public function registrar(): BelongsTo
    {
        return $this->belongsTo(DomainRegistrar::class, 'registrar_id');
    }
}
