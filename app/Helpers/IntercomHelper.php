<?php

namespace App\Helpers;

class IntercomHelper
{
    /**
     * Generate user hash for Intercom identity verification
     * This ensures that users cannot impersonate other users
     * 
     * @param int|string $userId
     * @return string
     */
    public static function generateUserHash($userId)
    {
        $secretKey = config('intercom.identity_verification.secret_key');
        
        if (empty($secretKey)) {
            return '';
        }
        
        return hash_hmac('sha256', $userId, $secretKey);
    }

    /**
     * Check if Intercom is enabled
     * 
     * @return bool
     */
    public static function isEnabled()
    {
        return config('intercom.enabled', false);
    }

    /**
     * Get Intercom App ID
     * 
     * @return string
     */
    public static function getAppId()
    {
        return config('intercom.app_id', '');
    }

    /**
     * Check if identity verification is enabled
     * 
     * @return bool
     */
    public static function isIdentityVerificationEnabled()
    {
        return config('intercom.identity_verification.enabled', false);
    }

    /**
     * Get user data for Intercom with identity verification
     * 
     * @param \App\Models\User $user
     * @return array
     */
    public static function getUserData($user)
    {
        if (!$user) {
            return [];
        }

        $data = [
            'user_id' => (string) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->timestamp,
        ];

        // Add user hash for identity verification
        if (self::isIdentityVerificationEnabled()) {
            $data['user_hash'] = self::generateUserHash($user->id);
        }

        return $data;
    }

    /**
     * Get Intercom configuration for frontend
     * 
     * @return array
     */
    public static function getConfig()
    {
        return [
            'app_id' => self::getAppId(),
            'enabled' => self::isEnabled(),
            'identity_verification' => self::isIdentityVerificationEnabled(),
            'alignment' => config('intercom.messenger.alignment', 'right'),
            'horizontal_padding' => config('intercom.messenger.horizontal_padding', 20),
            'vertical_padding' => config('intercom.messenger.vertical_padding', 20),
            'hide_default_launcher' => config('intercom.messenger.hide_default_launcher', false),
        ];
    }
}
