<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'event',
        'batch_uuid',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the subject that the activity is performed on.
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who caused the activity.
     */
    public function causer()
    {
        return $this->morphTo();
    }

    /**
     * Log a new activity.
     *
     * @param string $description
     * @param string|null $logName
     * @param mixed|null $subject
     * @param mixed|null $causer
     * @param array $properties
     * @param string|null $event
     * @return static
     */
    public static function log(
        string $description,
        ?string $logName = null,
        $subject = null,
        $causer = null,
        array $properties = [],
        ?string $event = null
    ) {
        return static::create([
            'log_name' => $logName ?? 'default',
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id ?? null,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id ?? null,
            'properties' => $properties,
            'event' => $event,
        ]);
    }
}
