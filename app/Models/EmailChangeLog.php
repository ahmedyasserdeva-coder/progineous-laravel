<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailChangeLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'old_email',
        'new_email',
        'ip_address',
        'user_agent',
        'status',
        'notes',
    ];

    /**
     * Get the client that owns the email change log.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
