<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'client_id',
        'department_id',
        'assigned_admin_id',
        'service_id',
        'service_type',
        'subject',
        'message',
        'priority',
        'status',
        'is_flagged',
        'flagged_by_admin_id',
        'flagged_at',
        'last_reply_at',
        'closed_at',
        'closed_by_admin_id',
        'closed_by_client_id',
    ];

    protected $casts = [
        'last_reply_at' => 'datetime',
        'closed_at' => 'datetime',
        'flagged_at' => 'datetime',
        'is_flagged' => 'boolean',
    ];

    /**
     * Priority levels with colors and labels
     */
    public const PRIORITIES = [
        'low' => [
            'label_en' => 'Low',
            'label_ar' => 'منخفضة',
            'color' => 'gray',
            'bg_class' => 'bg-gray-100 text-gray-800',
        ],
        'medium' => [
            'label_en' => 'Medium',
            'label_ar' => 'متوسطة',
            'color' => 'blue',
            'bg_class' => 'bg-blue-100 text-blue-800',
        ],
        'high' => [
            'label_en' => 'High',
            'label_ar' => 'عالية',
            'color' => 'orange',
            'bg_class' => 'bg-orange-100 text-orange-800',
        ],
        'urgent' => [
            'label_en' => 'Urgent',
            'label_ar' => 'عاجلة',
            'color' => 'red',
            'bg_class' => 'bg-red-100 text-red-800',
        ],
    ];

    /**
     * Status levels with colors and labels
     */
    public const STATUSES = [
        'open' => [
            'label_en' => 'Open',
            'label_ar' => 'مفتوحة',
            'color' => 'green',
            'bg_class' => 'bg-green-100 text-green-800',
        ],
        'answered' => [
            'label_en' => 'Answered',
            'label_ar' => 'تم الرد',
            'color' => 'blue',
            'bg_class' => 'bg-blue-100 text-blue-800',
        ],
        'customer_reply' => [
            'label_en' => 'Customer Reply',
            'label_ar' => 'رد العميل',
            'color' => 'yellow',
            'bg_class' => 'bg-yellow-100 text-yellow-800',
        ],
        'on_hold' => [
            'label_en' => 'On Hold',
            'label_ar' => 'قيد الانتظار',
            'color' => 'purple',
            'bg_class' => 'bg-purple-100 text-purple-800',
        ],
        'closed' => [
            'label_en' => 'Closed',
            'label_ar' => 'مغلقة',
            'color' => 'gray',
            'bg_class' => 'bg-gray-100 text-gray-800',
        ],
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = self::generateTicketNumber();
            }
        });
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber(): string
    {
        $date = now()->format('Ymd');
        $lastTicket = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTicket) {
            $lastNumber = (int) Str::afterLast($lastTicket->ticket_number, '-');
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'TKT-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the client that owns the ticket
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the department
     */
    public function department()
    {
        return $this->belongsTo(TicketDepartment::class, 'department_id');
    }

    /**
     * Get the assigned admin
     */
    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_admin_id');
    }

    /**
     * Get the related service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get all replies
     */
    public function replies()
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get all attachments (direct attachments on ticket)
     */
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    /**
     * Get all attachments including replies
     */
    public function allAttachments()
    {
        return TicketAttachment::where('ticket_id', $this->id)
            ->orWhereIn('reply_id', $this->replies()->pluck('id'));
    }

    /**
     * Get admin who closed the ticket
     */
    public function closedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'closed_by_admin_id');
    }

    /**
     * Get client who closed the ticket
     */
    public function closedByClient()
    {
        return $this->belongsTo(Client::class, 'closed_by_client_id');
    }

    /**
     * Get admin who flagged the ticket
     */
    public function flaggedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'flagged_by_admin_id');
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute(): string
    {
        $locale = app()->getLocale();
        $key = $locale === 'ar' ? 'label_ar' : 'label_en';
        return self::PRIORITIES[$this->priority][$key] ?? $this->priority;
    }

    /**
     * Get priority color class
     */
    public function getPriorityClassAttribute(): string
    {
        return self::PRIORITIES[$this->priority]['bg_class'] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        $locale = app()->getLocale();
        $key = $locale === 'ar' ? 'label_ar' : 'label_en';
        return self::STATUSES[$this->status][$key] ?? $this->status;
    }

    /**
     * Get status color class
     */
    public function getStatusClassAttribute(): string
    {
        return self::STATUSES[$this->status]['bg_class'] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if ticket is open
     */
    public function isOpen(): bool
    {
        return !in_array($this->status, ['closed']);
    }

    /**
     * Check if ticket is closed
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Close the ticket
     */
    public function close($adminId = null, $clientId = null): void
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
            'closed_by_admin_id' => $adminId,
            'closed_by_client_id' => $clientId,
        ]);
    }

    /**
     * Reopen the ticket
     */
    public function reopen(): void
    {
        $this->update([
            'status' => 'open',
            'closed_at' => null,
            'closed_by_admin_id' => null,
            'closed_by_client_id' => null,
        ]);
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        if ($status === 'active') {
            return $query->where('status', '!=', 'closed');
        }
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by priority
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope to filter by department
     */
    public function scopeDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope to filter by client
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope to filter by assigned admin
     */
    public function scopeAssignedTo($query, $adminId)
    {
        return $query->where('assigned_admin_id', $adminId);
    }

    /**
     * Scope to get unassigned tickets
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_admin_id');
    }
}
