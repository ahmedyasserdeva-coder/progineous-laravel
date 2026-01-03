<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'department_id',
        'created_by',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the department this reply belongs to.
     */
    public function department()
    {
        return $this->belongsTo(TicketDepartment::class, 'department_id');
    }

    /**
     * Get the admin who created this reply.
     */
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Scope for active replies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope for department filter.
     */
    public function scopeForDepartment($query, $departmentId)
    {
        return $query->where(function ($q) use ($departmentId) {
            $q->whereNull('department_id')
              ->orWhere('department_id', $departmentId);
        });
    }
}
