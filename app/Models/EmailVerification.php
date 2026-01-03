<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'verified',
        'expires_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate and send OTP to email
     */
    public static function sendOTP($email)
    {
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete old OTPs for this email
        self::where('email', $email)->delete();
        
        // Create new OTP record
        $verification = self::create([
            'email' => $email,
            'otp' => $otp,
            'verified' => false,
            'expires_at' => Carbon::now()->addMinutes(10), // OTP valid for 10 minutes
        ]);

        // Send email with OTP
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email)
                        ->subject(__('crm.email_verification_otp'));
            });
            
            return ['success' => true, 'message' => __('crm.otp_sent_successfully')];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => __('crm.otp_send_failed')];
        }
    }

    /**
     * Verify OTP
     */
    public static function verifyOTP($email, $otp)
    {
        $verification = self::where('email', $email)
                            ->where('otp', $otp)
                            ->where('verified', false)
                            ->where('expires_at', '>', Carbon::now())
                            ->first();

        if ($verification) {
            $verification->update(['verified' => true]);
            return ['success' => true, 'message' => __('crm.email_verified_successfully')];
        }

        return ['success' => false, 'message' => __('crm.invalid_or_expired_otp')];
    }

    /**
     * Check if email is verified
     */
    public static function isVerified($email)
    {
        return self::where('email', $email)
                   ->where('verified', true)
                   ->where('expires_at', '>', Carbon::now())
                   ->exists();
    }
}
