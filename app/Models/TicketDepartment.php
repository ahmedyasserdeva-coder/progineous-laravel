<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description',
        'email',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the localized name based on current locale
     */
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get all tickets in this department
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'department_id');
    }

    /**
     * Scope to get only active departments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
