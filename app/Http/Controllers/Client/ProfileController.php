<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\EmailChangeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::guard('client')->user();
        return view('frontend.client.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('client')->user();

        $validated = $request->validate([
            'username' => ['nullable', 'string', 'max:9', 'regex:/^[a-zA-Z0-9]+$/', 'unique:clients,username,' . $user->id],
            'first_name' => ['required', 'string', 'max:10', 'regex:/^[a-zA-Z]+$/'],
            'last_name' => ['required', 'string', 'max:10', 'regex:/^[a-zA-Z]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s\-()]+$/'],
            'company_name' => ['nullable', 'string', 'max:30', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'address1' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'address2' => ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'city' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'state' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'postcode' => ['required', 'string', 'max:10', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'country' => ['required', 'string', 'size:2'],
            'tax_number' => ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\-]+$/'],
            'billing_contact' => ['nullable', 'string', 'max:30', 'regex:/^[a-zA-Z\s]+$/'],
        ], [
            // Custom validation messages
            'username.regex' => app()->getLocale() == 'ar' 
                ? 'اسم المستخدم يجب أن يحتوي على أحرف إنجليزية وأرقام فقط (بدون مسافات أو رموز).' 
                : 'Username must contain only English letters and numbers (no spaces or special characters).',
            'username.unique' => app()->getLocale() == 'ar' 
                ? 'اسم المستخدم هذا مستخدم بالفعل من قبل مستخدم آخر. الرجاء اختيار اسم مختلف.' 
                : 'This username is already taken by another user. Please choose a different username.',
            'username.max' => app()->getLocale() == 'ar' 
                ? 'اسم المستخدم يجب ألا يتجاوز 9 أحرف.' 
                : 'Username must not exceed 9 characters.',
            'first_name.regex' => app()->getLocale() == 'ar' 
                ? 'الاسم الأول يجب أن يحتوي على أحرف إنجليزية فقط (بدون مسافات أو أرقام).' 
                : 'First name must contain only English letters (no spaces or numbers).',
            'first_name.max' => app()->getLocale() == 'ar' 
                ? 'الاسم الأول يجب ألا يتجاوز 10 أحرف.' 
                : 'First name must not exceed 10 characters.',
            'last_name.regex' => app()->getLocale() == 'ar' 
                ? 'الاسم الأخير يجب أن يحتوي على أحرف إنجليزية فقط (بدون مسافات أو أرقام).' 
                : 'Last name must contain only English letters (no spaces or numbers).',
            'last_name.max' => app()->getLocale() == 'ar' 
                ? 'الاسم الأخير يجب ألا يتجاوز 10 أحرف.' 
                : 'Last name must not exceed 10 characters.',
            'phone.regex' => app()->getLocale() == 'ar' 
                ? 'رقم الهاتف يجب أن يحتوي على أرقام فقط.' 
                : 'Phone number must contain only numbers.',
            'phone.max' => app()->getLocale() == 'ar' 
                ? 'رقم الهاتف يجب ألا يتجاوز 20 رقم.' 
                : 'Phone number must not exceed 20 digits.',
            'company_name.regex' => app()->getLocale() == 'ar' 
                ? 'اسم الشركة يجب أن يحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'Company name must contain only English letters, numbers and spaces.',
            'company_name.max' => app()->getLocale() == 'ar' 
                ? 'اسم الشركة يجب ألا يتجاوز 30 حرف.' 
                : 'Company name must not exceed 30 characters.',
            'address1.regex' => app()->getLocale() == 'ar' 
                ? 'العنوان 1 يجب أن يحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'Address Line 1 must contain only English letters, numbers and spaces.',
            'address1.max' => app()->getLocale() == 'ar' 
                ? 'العنوان 1 يجب ألا يتجاوز 50 حرف.' 
                : 'Address Line 1 must not exceed 50 characters.',
            'address2.regex' => app()->getLocale() == 'ar' 
                ? 'العنوان 2 يجب أن يحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'Address Line 2 must contain only English letters, numbers and spaces.',
            'address2.max' => app()->getLocale() == 'ar' 
                ? 'العنوان 2 يجب ألا يتجاوز 50 حرف.' 
                : 'Address Line 2 must not exceed 50 characters.',
            'city.regex' => app()->getLocale() == 'ar' 
                ? 'المدينة يجب أن تحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'City must contain only English letters, numbers and spaces.',
            'city.max' => app()->getLocale() == 'ar' 
                ? 'المدينة يجب ألا تتجاوز 20 حرف.' 
                : 'City must not exceed 20 characters.',
            'state.regex' => app()->getLocale() == 'ar' 
                ? 'المحافظة/الولاية يجب أن تحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'State/Province must contain only English letters, numbers and spaces.',
            'state.max' => app()->getLocale() == 'ar' 
                ? 'المحافظة/الولاية يجب ألا تتجاوز 20 حرف.' 
                : 'State/Province must not exceed 20 characters.',
            'postcode.regex' => app()->getLocale() == 'ar' 
                ? 'الرمز البريدي يجب أن يحتوي على أحرف إنجليزية وأرقام ومسافات فقط.' 
                : 'Postal Code must contain only English letters, numbers and spaces.',
            'postcode.max' => app()->getLocale() == 'ar' 
                ? 'الرمز البريدي يجب ألا يتجاوز 10 أحرف.' 
                : 'Postal Code must not exceed 10 characters.',
            'tax_number.regex' => app()->getLocale() == 'ar' 
                ? 'الرقم الضريبي يجب أن يحتوي على أحرف إنجليزية وأرقام وعلامة (-) فقط.' 
                : 'Tax Number must contain only English letters, numbers and hyphen (-).',
            'tax_number.max' => app()->getLocale() == 'ar' 
                ? 'الرقم الضريبي يجب ألا يتجاوز 50 حرف.' 
                : 'Tax Number must not exceed 50 characters.',
            'billing_contact.regex' => app()->getLocale() == 'ar' 
                ? 'جهة اتصال الفواتير يجب أن تحتوي على أحرف إنجليزية ومسافات فقط.' 
                : 'Billing Contact must contain only English letters and spaces.',
            'billing_contact.max' => app()->getLocale() == 'ar' 
                ? 'جهة اتصال الفواتير يجب ألا تتجاوز 30 حرف.' 
                : 'Billing Contact must not exceed 30 characters.',
            'email.unique' => app()->getLocale() == 'ar' 
                ? 'البريد الإلكتروني مستخدم بالفعل.' 
                : 'This email is already in use.',
        ]);

        // Check if username is being changed
        if ($request->filled('username') && $user->username !== $request->username) {
            // Check if 30 days have passed since last change
            if ($user->username_last_changed_at) {
                $daysSinceLastChange = (int) now()->diffInDays($user->username_last_changed_at);
                
                if ($daysSinceLastChange < 30) {
                    $daysRemaining = 30 - $daysSinceLastChange;
                    return response()->json([
                        'success' => false,
                        'message' => app()->getLocale() == 'ar' 
                            ? "لا يمكنك تغيير اسم المستخدم إلا مرة كل 30 يوم. يمكنك التغيير بعد {$daysRemaining} يوم." 
                            : "You can only change your username once every 30 days. You can change it again in {$daysRemaining} days."
                    ], 422);
                }
            }
            
            // Update username and timestamp
            $validated['username_last_changed_at'] = now();
        }

        // Check if email is being changed
        if ($request->filled('email') && $user->email !== $request->email) {
            // Check if 30 days have passed since last email change
            if ($user->email_last_changed_at) {
                $daysSinceLastChange = (int) now()->diffInDays($user->email_last_changed_at);
                
                if ($daysSinceLastChange < 30) {
                    $daysRemaining = 30 - $daysSinceLastChange;
                    return response()->json([
                        'success' => false,
                        'message' => app()->getLocale() == 'ar' 
                            ? "لا يمكنك تغيير البريد الإلكتروني إلا مرة كل 30 يوم. يمكنك التغيير بعد {$daysRemaining} يوم." 
                            : "You can only change your email once every 30 days. You can change it again in {$daysRemaining} days."
                    ], 422);
                }
            }
            
            // Verify email change was completed through two-step verification
            if (!$request->filled('email_verified') || $request->email_verified != '1') {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' 
                        ? 'يجب التحقق من البريد الإلكتروني الجديد قبل الحفظ' 
                        : 'New email must be verified before saving'
                ], 422);
            }
            
            // Verify token matches
            $sessionToken = session('email_change_token');
            $requestToken = $request->input('email_change_token');
            $confirmedEmail = session('email_change_new_email_confirmed');
            
            if (!$sessionToken || !$requestToken || $sessionToken !== $requestToken) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' 
                        ? 'فشل التحقق من تغيير البريد الإلكتروني' 
                        : 'Email change verification failed'
                ], 422);
            }
            
            if ($confirmedEmail !== $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' 
                        ? 'البريد الإلكتروني غير مطابق للبريد المحقق' 
                        : 'Email does not match verified email'
                ], 422);
            }
            
            // Clear email change session data
            session()->forget([
                'email_change_current_code',
                'email_change_current_code_expires',
                'email_change_current_verified',
                'email_change_new_code',
                'email_change_new_email',
                'email_change_new_code_expires',
                'email_change_verified',
                'email_change_token',
                'email_change_new_email_confirmed'
            ]);
            
            // Log email change
            EmailChangeLog::create([
                'client_id' => $user->id,
                'old_email' => $user->email,
                'new_email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'completed',
                'notes' => 'Email changed via two-step verification process'
            ]);
            
            // Update email and timestamp
            $validated['email_last_changed_at'] = now();
        } else {
            // Remove email from validated data if not changed
            unset($validated['email']);
        }
        
        // Remove username if not changed
        if (!$request->filled('username') || $user->username === $request->username) {
            unset($validated['username']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' ? 'تم تحديث الملف الشخصي بنجاح' : 'Profile updated successfully'
        ]);
    }

    /**
     * Check if email is available.
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $user = Auth::guard('client')->user();

        // Check if email exists (excluding current user)
        $exists = Client::where('email', $email)
            ->where('id', '!=', $user->id)
            ->exists();

        return response()->json([
            'available' => !$exists,
            'message' => !$exists 
                ? (app()->getLocale() == 'ar' ? 'البريد الإلكتروني متاح' : 'Email available')
                : (app()->getLocale() == 'ar' ? 'هذا البريد الإلكتروني مستخدم من قبل عميل آخر، لا يمكن استخدامه' : 'This email is used by another client and cannot be used')
        ]);
    }

    /**
     * Check if username is available.
     */
    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $user = Auth::guard('client')->user();
        
        // Check if username exists for another user
        $exists = \App\Models\Client::where('username', $username)
            ->where('id', '!=', $user->id)
            ->exists();
        
        return response()->json([
            'available' => !$exists
        ]);
    }

    /**
     * Generate a random unique username.
     */
    public function generateUsername(Request $request)
    {
        $user = Auth::guard('client')->user();
        $maxAttempts = 10;
        $attempt = 0;
        
        // Define character sets
        $consonants = 'bcdfghjklmnpqrstvwxyz';
        $vowels = 'aeiou';
        $numbers = '0123456789';
        
        do {
            $username = '';
            
            // Generate pattern: consonant-vowel-consonant-vowel-number-number-number (7-9 chars)
            $username .= $consonants[rand(0, strlen($consonants) - 1)];
            $username .= $vowels[rand(0, strlen($vowels) - 1)];
            $username .= $consonants[rand(0, strlen($consonants) - 1)];
            $username .= $vowels[rand(0, strlen($vowels) - 1)];
            
            // Add 3-5 random numbers
            $numCount = rand(3, 5);
            for ($i = 0; $i < $numCount; $i++) {
                $username .= $numbers[rand(0, strlen($numbers) - 1)];
            }
            
            // Check if username exists
            $exists = \App\Models\Client::where('username', $username)
                ->where('id', '!=', $user->id)
                ->exists();
            
            $attempt++;
        } while ($exists && $attempt < $maxAttempts);
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'فشل توليد اسم مستخدم فريد. الرجاء المحاولة مرة أخرى.' 
                    : 'Failed to generate unique username. Please try again.'
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'username' => $username
        ]);
    }

    /**
     * Send verification code to current email
     */
    public function sendCurrentEmailCode(Request $request)
    {
        $user = Auth::guard('client')->user();
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in session with expiry (10 minutes)
        session([
            'email_change_current_code' => $code,
            'email_change_current_code_expires' => now()->addMinutes(10)
        ]);
        
        // Send email with code
        try {
            Mail::raw(
                app()->getLocale() == 'ar' 
                    ? "كود التحقق لتغيير البريد الإلكتروني: {$code}\n\nهذا الكود صالح لمدة 10 دقائق."
                    : "Your email change verification code: {$code}\n\nThis code is valid for 10 minutes.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject(app()->getLocale() == 'ar' 
                            ? 'كود التحقق - تغيير البريد الإلكتروني'
                            : 'Verification Code - Email Change');
                }
            );
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar'
                    ? 'تم إرسال كود التحقق إلى بريدك الإلكتروني'
                    : 'Verification code sent to your email'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل إرسال البريد الإلكتروني'
                    : 'Failed to send email'
            ], 500);
        }
    }

    /**
     * Verify current email code
     */
    public function verifyCurrentEmail(Request $request)
    {
        $code = $request->input('code');
        $storedCode = session('email_change_current_code');
        $expiresAt = session('email_change_current_code_expires');
        
        if (!$storedCode || !$expiresAt) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'لم يتم إرسال كود التحقق'
                    : 'No verification code sent'
            ], 400);
        }
        
        if (now()->greaterThan($expiresAt)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'انتهت صلاحية الكود'
                    : 'Code expired'
            ], 400);
        }
        
        if ($code !== $storedCode) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'الكود غير صحيح'
                    : 'Invalid code'
            ], 400);
        }
        
        // Mark current email as verified
        session(['email_change_current_verified' => true]);
        
        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar'
                ? 'تم التحقق بنجاح من بريدك الحالي'
                : 'Current email verified successfully'
        ]);
    }

    /**
     * Send verification code to new email
     */
    public function sendNewEmailCode(Request $request)
    {
        $user = Auth::guard('client')->user();
        $newEmail = $request->input('new_email');
        
        // Check if current email is verified
        if (!session('email_change_current_verified')) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يرجى التحقق من بريدك الحالي أولاً'
                    : 'Please verify your current email first'
            ], 400);
        }
        
        // Validate new email
        $validator = Validator::make(['new_email' => $newEmail], [
            'new_email' => ['required', 'email', 'unique:clients,email,' . $user->id]
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'البريد الإلكتروني غير صالح أو مستخدم بالفعل'
                    : 'Email invalid or already in use'
            ], 400);
        }
        
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code and new email in session with expiry (10 minutes)
        session([
            'email_change_new_code' => $code,
            'email_change_new_email' => $newEmail,
            'email_change_new_code_expires' => now()->addMinutes(10)
        ]);
        
        // Send email with code
        try {
            Mail::raw(
                app()->getLocale() == 'ar' 
                    ? "كود التحقق لتأكيد البريد الإلكتروني الجديد: {$code}\n\nهذا الكود صالح لمدة 10 دقائق."
                    : "Your new email verification code: {$code}\n\nThis code is valid for 10 minutes.",
                function ($message) use ($newEmail) {
                    $message->to($newEmail)
                        ->subject(app()->getLocale() == 'ar' 
                            ? 'كود التحقق - تأكيد البريد الجديد'
                            : 'Verification Code - Confirm New Email');
                }
            );
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar'
                    ? 'تم إرسال كود التحقق إلى البريد الجديد'
                    : 'Verification code sent to new email'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل إرسال البريد الإلكتروني'
                    : 'Failed to send email'
            ], 500);
        }
    }

    /**
     * Verify new email code
     */
    public function verifyNewEmail(Request $request)
    {
        $code = $request->input('code');
        $newEmail = $request->input('new_email');
        $storedCode = session('email_change_new_code');
        $storedEmail = session('email_change_new_email');
        $expiresAt = session('email_change_new_code_expires');
        
        if (!$storedCode || !$storedEmail || !$expiresAt) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'لم يتم إرسال كود التحقق'
                    : 'No verification code sent'
            ], 400);
        }
        
        if (now()->greaterThan($expiresAt)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'انتهت صلاحية الكود'
                    : 'Code expired'
            ], 400);
        }
        
        if ($code !== $storedCode || $newEmail !== $storedEmail) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'الكود غير صحيح'
                    : 'Invalid code'
            ], 400);
        }
        
        // Generate a token for the final save
        $token = bin2hex(random_bytes(32));
        session([
            'email_change_verified' => true,
            'email_change_token' => $token,
            'email_change_new_email_confirmed' => $newEmail
        ]);
        
        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => app()->getLocale() == 'ar'
                ? 'تم التحقق بنجاح! يمكنك الآن حفظ التغييرات'
                : 'Verified successfully! You can now save changes'
        ]);
    }
}
