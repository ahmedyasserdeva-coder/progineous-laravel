<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'country',
        'city',
        'browser',
        'device',
        'access_status',
        'access_requested_at',
        'access_granted_at',
        'session_id',
        'request_headers'
    ];

    protected $casts = [
        'access_requested_at' => 'datetime',
        'access_granted_at' => 'datetime',
        'request_headers' => 'array'
    ];

    /**
     * Check if IP address has access granted
     */
    public static function hasAccess($ipAddress)
    {
        return self::where('ip_address', $ipAddress)
                   ->where('access_status', 'granted')
                   ->exists();
    }

    /**
     * Grant access to IP address
     */
    public static function grantAccess($ipAddress)
    {
        return self::where('ip_address', $ipAddress)
                   ->where('access_status', 'pending')
                   ->update([
                       'access_status' => 'granted',
                       'access_granted_at' => now()
                   ]);
    }

    /**
     * Log access request
     */
    public static function logRequest($request)
    {
        $ipAddress = $request->ip();
        
        // Check if IP already has pending request in last hour
        $existingRequest = self::where('ip_address', $ipAddress)
                              ->where('access_status', 'pending')
                              ->where('access_requested_at', '>', now()->subHour())
                              ->first();

        if (!$existingRequest) {
            return self::create([
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'browser' => self::getBrowser($request->userAgent()),
                'device' => self::getDevice($request->userAgent()),
                'access_status' => 'pending',
                'access_requested_at' => now(),
                'session_id' => $request->session()->getId(),
                'request_headers' => $request->headers->all()
            ]);
        }

        return $existingRequest;
    }

    /**
     * Get browser from user agent
     */
    private static function getBrowser($userAgent)
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
    private static function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) return 'Mobile';
        if (strpos($userAgent, 'Tablet') !== false) return 'Tablet';
        return 'Desktop';
    }
}