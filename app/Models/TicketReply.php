<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'client_id',
        'admin_id',
        'message',
        'is_internal',
        'rating',
        'rated_at',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'rated_at' => 'datetime',
    ];

    /**
     * Get the ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the client who made the reply
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the admin who made the reply
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get attachments for this reply
     */
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class, 'reply_id');
    }

    /**
     * Check if reply is from client
     */
    public function isFromClient(): bool
    {
        return !is_null($this->client_id);
    }

    /**
     * Check if reply is from admin
     */
    public function isFromAdmin(): bool
    {
        return !is_null($this->admin_id);
    }

    /**
     * Get the author name
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->isFromClient() && $this->client) {
            return $this->client->first_name . ' ' . $this->client->last_name;
        }
        
        if ($this->isFromAdmin() && $this->admin) {
            return $this->admin->name;
        }

        return app()->getLocale() === 'ar' ? 'غير معروف' : 'Unknown';
    }

    /**
     * Get the author type label
     */
    public function getAuthorTypeAttribute(): string
    {
        if ($this->is_internal) {
            return app()->getLocale() === 'ar' ? 'ملاحظة داخلية' : 'Internal Note';
        }
        
        if ($this->isFromClient()) {
            return app()->getLocale() === 'ar' ? 'العميل' : 'Client';
        }

        return app()->getLocale() === 'ar' ? 'الدعم الفني' : 'Support';
    }

    /**
     * Scope to exclude internal notes (for client view)
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Scope to get only internal notes
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }
}
