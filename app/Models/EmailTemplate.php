<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject_ar',
        'subject_en',
        'body_ar',
        'body_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the subject based on current locale
     */
    public function getSubjectAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->subject_ar : $this->subject_en;
    }

    /**
     * Get the body based on current locale
     */
    public function getBodyAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->body_ar : $this->body_en;
    }
}
