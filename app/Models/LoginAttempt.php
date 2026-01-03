<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'email',
        'ip_address',
        'attempts',
        'blocked_until',
    ];

    protected $casts = [
        'blocked_until' => 'datetime',
    ];

    /**
     * Check if this attempt is currently blocked
     */
    public function isBlocked(): bool
    {
        return $this->blocked_until && $this->blocked_until->isFuture();
    }

    /**
     * Get remaining block time in minutes
     */
    public function getRemainingBlockTime(): int
    {
        if (!$this->isBlocked()) {
            return 0;
        }
        
        return $this->blocked_until->diffInMinutes(now());
    }
}
