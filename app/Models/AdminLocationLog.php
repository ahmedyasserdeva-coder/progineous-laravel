<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLocationLog extends Model
{
    protected $fillable = [
        'admin_id',
        'ip_address',
        'latitude',
        'longitude',
        'accuracy',
        'user_agent',
        'browser',
        'device',
        'action',
        'logged_at',
        'additional_data'
    ];

    protected $casts = [
        'logged_at' => 'datetime',
        'additional_data' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'accuracy' => 'float'
    ];

    /**
     * Get the admin that owns the location log
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get browser from user agent
     */
    public static function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        return 'Unknown';
    }

    /**
     * Get device from user agent
     */
    public static function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) return 'Mobile';
        if (strpos($userAgent, 'Tablet') !== false) return 'Tablet';
        return 'Desktop';
    }

    /**
     * Log location access
     */
    public static function logLocationAccess($request, $latitude, $longitude, $accuracy = null)
    {
        return self::create([
            'ip_address' => $request->ip(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
            'user_agent' => $request->userAgent(),
            'browser' => self::getBrowser($request->userAgent()),
            'device' => self::getDevice($request->userAgent()),
            'action' => 'location_granted',
            'logged_at' => now(),
            'additional_data' => [
                'timestamp' => now()->toIso8601String(),
                'session_id' => $request->session()->getId()
            ]
        ]);
    }

    /**
     * Log admin login with location
     */
    public static function logAdminLogin($adminId, $request, $latitude = null, $longitude = null)
    {
        $data = [
            'admin_id' => $adminId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => self::getBrowser($request->userAgent()),
            'device' => self::getDevice($request->userAgent()),
            'action' => 'admin_login',
            'logged_at' => now(),
            'additional_data' => [
                'login_time' => now()->toIso8601String(),
                'session_id' => $request->session()->getId()
            ]
        ];

        if ($latitude && $longitude) {
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
        }

        return self::create($data);
    }
}
