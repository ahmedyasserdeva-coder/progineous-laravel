<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $user = Auth::guard('client')->user();
        
        // Get active sessions for this client
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
                    'is_current' => $session->id === session()->getId(),
                ];
            });
        
        // Check connected social accounts
        $connectedAccounts = [
            'google' => !empty($user->google_id),
            'github' => !empty($user->github_id),
            'linkedin' => !empty($user->linkedin_id),
        ];
        
        return view('frontend.client.settings', compact('user', 'sessions', 'connectedAccounts'));
    }

    /**
     * Update the user's settings (password, security, preferences).
     */
    public function update(Request $request)
    {
        $user = Auth::guard('client')->user();

        if ($request->has('current_password')) {
            // Password change
            $validated = $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', Password::min(8)->letters()->numbers(), 'confirmed'],
            ]);

            // Verify current password
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' ? 'كلمة المرور الحالية غير صحيحة' : 'Current password is incorrect'
                ], 422);
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' ? 'تم تغيير كلمة المرور بنجاح' : 'Password changed successfully'
            ]);
        }

        // Other settings (notifications, language, etc.)
        $validated = $request->validate([
            'language' => ['nullable', 'in:en,ar'],
            'notifications_enabled' => ['nullable', 'boolean'],
            'email_notifications' => ['nullable', 'boolean'],
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم تحديث الإعدادات بنجاح' : 'Settings updated successfully'
        ]);
    }

    /**
     * Verify the current password in real-time.
     */
    public function verifyCurrentPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string']
        ]);

        $user = Auth::guard('client')->user();
        $isValid = Hash::check($request->current_password, $user->password);

        return response()->json([
            'valid' => $isValid
        ]);
    }

    /**
     * Enable Two-Factor Authentication
     */
    public function sendEnableCode(Request $request)
    {
        $user = Auth::guard('client')->user();

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in session with 10 minute expiry
        session([
            '2fa_enable_code' => $code,
            '2fa_enable_code_expires' => now()->addMinutes(10)
        ]);

        // Send email
        Mail::raw(
            app()->getLocale() == 'ar' 
                ? "رمز التحقق لتفعيل المصادقة الثنائية هو: {$code}\n\nهذا الرمز صالح لمدة 10 دقائق."
                : "Your verification code to enable two-factor authentication is: {$code}\n\nThis code is valid for 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(app()->getLocale() == 'ar' ? 'رمز تفعيل المصادقة الثنائية' : 'Enable 2FA Verification Code');
            }
        );

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني' : 'Verification code sent to your email'
        ]);
    }

    /**
     * Enable Two-Factor Authentication after email verification
     */
    public function enable2FA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'method' => ['required', 'string', 'in:authenticator,email']
        ]);

        $user = Auth::guard('client')->user();

        // Verify code
        $storedCode = session('2fa_enable_code');
        $expiresAt = session('2fa_enable_code_expires');

        if (!$storedCode || !$expiresAt) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'لم يتم إرسال رمز التحقق' : 'No verification code sent'
            ], 422);
        }

        if (now()->greaterThan($expiresAt)) {
            session()->forget(['2fa_enable_code', '2fa_enable_code_expires']);
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'انتهت صلاحية رمز التحقق' : 'Verification code has expired'
            ], 422);
        }

        if ($request->code !== $storedCode) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'رمز التحقق غير صحيح' : 'Incorrect verification code'
            ], 422);
        }

        // Clear session
        session()->forget(['2fa_enable_code', '2fa_enable_code_expires']);

        // Store two factor method
        $user->update([
            'two_factor_method' => $request->method
        ]);

        // If method is email, enable 2FA immediately without QR code
        if ($request->method === 'email') {
            $user->update([
                'google2fa_enabled' => true,
                'google2fa_secret' => null,
                'backup_codes' => null,
            ]);

            return response()->json([
                'success' => true,
                'method' => 'email',
                'message' => app()->getLocale() == 'ar' ? 'تم تفعيل المصادقة الثنائية عبر البريد الإلكتروني بنجاح' : 'Two-Factor Authentication via email enabled successfully'
            ]);
        }

        // For authenticator method
        $google2fa = new Google2FA();

        // Generate secret key
        $secret = $google2fa->generateSecretKey();
        
        // Generate backup codes (8 codes)
        $backupCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $backupCodes[] = strtoupper(Str::random(8));
        }

        // Store secret and backup codes
        $user->update([
            'google2fa_secret' => encrypt($secret),
            'backup_codes' => $backupCodes,
        ]);

        // Generate QR Code URL for authenticator apps
        $companyName = urlencode(config('app.name'));
        $userEmail = urlencode($user->email);
        $qrCodeUrl = "otpauth://totp/{$companyName}:{$userEmail}?secret={$secret}&issuer={$companyName}";

        return response()->json([
            'success' => true,
            'method' => 'authenticator',
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $secret,
            'backupCodes' => $backupCodes,
            'message' => app()->getLocale() == 'ar' ? 'امسح رمز QR باستخدام تطبيق Google Authenticator' : 'Scan QR code with Google Authenticator'
        ]);
    }

    /**
     * Verify and activate Two-Factor Authentication
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = Auth::guard('client')->user();
        $google2fa = new Google2FA();
        $secret = decrypt($user->google2fa_secret);

        $valid = $google2fa->verifyKey($secret, $request->code);

        if ($valid) {
            $user->update(['google2fa_enabled' => true]);

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' ? 'تم تفعيل المصادقة الثنائية بنجاح' : 'Two-Factor Authentication enabled successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => app()->getLocale() == 'ar' ? 'الرمز غير صحيح' : 'Invalid code'
        ], 422);
    }

    /**
     * Send email code to disable 2FA
     */
    public function sendDisableCode(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string']
        ]);

        $user = Auth::guard('client')->user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'كلمة المرور غير صحيحة' : 'Incorrect password'
            ], 422);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in session with 10 minute expiry
        session([
            '2fa_disable_code' => $code,
            '2fa_disable_code_expires' => now()->addMinutes(10)
        ]);

        // Send email
        Mail::raw(
            app()->getLocale() == 'ar' 
                ? "رمز التحقق لتعطيل المصادقة الثنائية هو: {$code}\n\nهذا الرمز صالح لمدة 10 دقائق."
                : "Your verification code to disable two-factor authentication is: {$code}\n\nThis code is valid for 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(app()->getLocale() == 'ar' ? 'رمز تعطيل المصادقة الثنائية' : 'Disable 2FA Verification Code');
            }
        );

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني' : 'Verification code sent to your email'
        ]);
    }

    /**
     * Disable Two-Factor Authentication
     */
    public function disable2FA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = Auth::guard('client')->user();

        // Verify code
        $storedCode = session('2fa_disable_code');
        $expiresAt = session('2fa_disable_code_expires');

        if (!$storedCode || !$expiresAt) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'لم يتم إرسال رمز التحقق' : 'No verification code sent'
            ], 422);
        }

        if (now()->greaterThan($expiresAt)) {
            session()->forget(['2fa_disable_code', '2fa_disable_code_expires']);
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'انتهت صلاحية رمز التحقق' : 'Verification code has expired'
            ], 422);
        }

        if ($request->code !== $storedCode) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'رمز التحقق غير صحيح' : 'Incorrect verification code'
            ], 422);
        }

        // Clear session
        session()->forget(['2fa_disable_code', '2fa_disable_code_expires']);

        $user->update([
            'google2fa_enabled' => false,
            'google2fa_secret' => null,
            'backup_codes' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم تعطيل المصادقة الثنائية' : 'Two-Factor Authentication disabled'
        ]);
    }

    /**
     * Send email code to regenerate backup codes
     */
    public function sendRegenerateCode(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string']
        ]);

        $user = Auth::guard('client')->user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'كلمة المرور غير صحيحة' : 'Incorrect password'
            ], 422);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in session with 10 minute expiry
        session([
            '2fa_regenerate_code' => $code,
            '2fa_regenerate_code_expires' => now()->addMinutes(10)
        ]);

        // Send email
        Mail::raw(
            app()->getLocale() == 'ar' 
                ? "رمز التحقق لإعادة إنشاء رموز النسخ الاحتياطي هو: {$code}\n\nهذا الرمز صالح لمدة 10 دقائق."
                : "Your verification code to regenerate backup codes is: {$code}\n\nThis code is valid for 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(app()->getLocale() == 'ar' ? 'رمز إعادة إنشاء رموز النسخ الاحتياطي' : 'Regenerate Backup Codes Verification Code');
            }
        );

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني' : 'Verification code sent to your email'
        ]);
    }

    /**
     * Regenerate backup codes
     */
    public function regenerateBackupCodes(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = Auth::guard('client')->user();

        // Verify code
        $storedCode = session('2fa_regenerate_code');
        $expiresAt = session('2fa_regenerate_code_expires');

        if (!$storedCode || !$expiresAt) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'لم يتم إرسال رمز التحقق' : 'No verification code sent'
            ], 422);
        }

        if (now()->greaterThan($expiresAt)) {
            session()->forget(['2fa_regenerate_code', '2fa_regenerate_code_expires']);
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'انتهت صلاحية رمز التحقق' : 'Verification code has expired'
            ], 422);
        }

        if ($request->code !== $storedCode) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'رمز التحقق غير صحيح' : 'Incorrect verification code'
            ], 422);
        }

        // Clear session
        session()->forget(['2fa_regenerate_code', '2fa_regenerate_code_expires']);

        // Generate new backup codes
        $backupCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $backupCodes[] = strtoupper(Str::random(8));
        }

        $user->update(['backup_codes' => $backupCodes]);

        return response()->json([
            'success' => true,
            'backupCodes' => $backupCodes,
            'message' => app()->getLocale() == 'ar' ? 'تم إنشاء رموز احتياطية جديدة' : 'New backup codes generated'
        ]);
    }

    /**
     * Delete a specific session (logout from another device)
     */
    public function deleteSession($sessionId)
    {
        try {
            $user = Auth::guard('client')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' ? 'يجب تسجيل الدخول' : 'Authentication required'
                ], 401);
            }
            
            $currentSessionId = session()->getId();

            // Prevent deleting current session
            if ($sessionId === $currentSessionId) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' ? 'لا يمكنك تسجيل الخروج من الجلسة الحالية' : 'You cannot logout from the current session'
                ], 422);
            }

            // Verify session belongs to current user and delete
            $deleted = DB::table('sessions')
                ->where('id', $sessionId)
                ->where('user_id', $user->id)
                ->delete();

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' ? 'الجلسة غير موجودة' : 'Session not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' ? 'تم تسجيل الخروج من الجلسة بنجاح' : 'Successfully logged out from session'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete session error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'حدث خطأ أثناء تسجيل الخروج' : 'An error occurred while logging out'
            ], 500);
        }
    }

    /**
     * Update user's preferred language
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:ar,en'
        ]);

        $user = Auth::guard('client')->user();
        $user->preferred_language = $request->language;
        $user->save();

        // Set the locale for current session
        app()->setLocale($request->language);
        session()->put('locale', $request->language);

        return response()->json([
            'success' => true,
            'message' => $request->language == 'ar' ? 'تم تحديث اللغة بنجاح' : 'Language updated successfully'
        ]);
    }

    /**
     * Disconnect Google account
     */
    public function disconnectGoogle()
    {
        $user = Auth::guard('client')->user();
        
        if ($user->google_id) {
            $user->google_id = null;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم إلغاء ربط حساب Google بنجاح' 
                    : 'Google account disconnected successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => app()->getLocale() == 'ar' 
                ? 'حساب Google غير مرتبط' 
                : 'Google account is not connected'
        ], 400);
    }

    /**
     * Disconnect GitHub account
     */
    public function disconnectGithub()
    {
        $user = Auth::guard('client')->user();
        
        if ($user->github_id) {
            $user->github_id = null;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم إلغاء ربط حساب GitHub بنجاح' 
                    : 'GitHub account disconnected successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => app()->getLocale() == 'ar' 
                ? 'حساب GitHub غير مرتبط' 
                : 'GitHub account is not connected'
        ], 400);
    }

    /**
     * Disconnect LinkedIn account
     */
    public function disconnectLinkedin()
    {
        $user = Auth::guard('client')->user();
        
        if ($user->linkedin_id) {
            $user->linkedin_id = null;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم إلغاء ربط حساب LinkedIn بنجاح' 
                    : 'LinkedIn account disconnected successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => app()->getLocale() == 'ar' 
                ? 'حساب LinkedIn غير مرتبط' 
                : 'LinkedIn account is not connected'
        ], 400);
    }
}

