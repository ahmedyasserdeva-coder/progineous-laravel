<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ClientAuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }
        
        return view('frontend.auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $isAjax = $request->expectsJson();
        
        // Validate Cloudflare Turnstile (skip for AJAX requests from checkout)
        if (!$isAjax && !$this->validateTurnstile($request)) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar' 
                        ? 'فشل التحقق الأمني. يرجى المحاولة مرة أخرى.' 
                        : 'Security verification failed. Please try again.',
                ], 422);
            }
            throw ValidationException::withMessages([
                'email' => app()->getLocale() == 'ar' 
                    ? 'فشل التحقق الأمني. يرجى المحاولة مرة أخرى.' 
                    : 'Security verification failed. Please try again.',
            ]);
        }

        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'email.required' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني أو اسم المستخدم مطلوب' : 'Email or username is required',
            'password.required' => app()->getLocale() == 'ar' ? 'كلمة المرور مطلوبة' : 'Password is required',
        ]);

        // Determine if the input is an email or username
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->email,
            'password' => $request->password,
        ];

        // Get the identifier for tracking failed attempts (use email or username)
        $identifier = $request->email;

        // Check if user is blocked due to too many failed attempts
        $blockedCheck = $this->checkIfBlocked($identifier, $request->ip());
        if ($blockedCheck) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $blockedCheck,
                ], 429);
            }
            throw ValidationException::withMessages([
                'email' => $blockedCheck,
            ]);
        }

        // Check remember me - works for both form and JSON requests
        $remember = $request->filled('remember') || $request->boolean('remember');

        // Attempt to login using web guard (clients table)
        if (Auth::guard('client')->attempt($credentials, $remember)) {
            $user = Auth::guard('client')->user();
            
            // Check if 2FA is enabled
            if ($user->google2fa_enabled) {
                // Store user ID in session for 2FA verification
                session([
                    '2fa_user_id' => $user->id,
                    '2fa_remember' => $remember,
                    '2fa_method' => $user->two_factor_method ?? 'authenticator'
                ]);
                
                // Logout temporarily until 2FA is verified
                Auth::guard('client')->logout();
                
                // If method is email, send verification code
                if ($user->two_factor_method === 'email') {
                    $this->send2FACodeEmail($user);
                }
                
                // Handle AJAX request with 2FA
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'requires_2fa' => true,
                        'redirect' => route('2fa.verify.show'),
                        'message' => app()->getLocale() == 'ar' 
                            ? 'يرجى إكمال التحقق بخطوتين' 
                            : 'Please complete 2FA verification',
                    ]);
                }
                
                // Redirect to 2FA verification page
                return redirect()->route('2fa.verify.show');
            }
            
            // Clear failed attempts on successful login
            $this->clearFailedAttempts($identifier, $request->ip());
            $request->session()->regenerate();
            
            // Update last login time and IP
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
            
            // Set user's preferred language
            if ($user->preferred_language) {
                app()->setLocale($user->preferred_language);
                session()->put('locale', $user->preferred_language);
            }
            
            // Log successful login
            Log::info('Client logged in', [
                'client_id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'login_field' => $loginField,
                'ip' => $request->ip(),
            ]);
            
            // Handle AJAX request
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => app()->getLocale() == 'ar' ? 'تم تسجيل الدخول بنجاح' : 'Login successful',
                    'redirect' => route('client.dashboard'),
                ]);
            }
            
            return redirect()->intended(route('client.dashboard'));
        }

        // Login failed - increment failed attempts
        $this->incrementFailedAttempts($identifier, $request->ip());
        
        // Get remaining attempts
        $remainingAttempts = $this->getRemainingAttempts($identifier, $request->ip());
        
        $errorMessage = app()->getLocale() == 'ar' 
            ? 'البريد الإلكتروني/اسم المستخدم أو كلمة المرور غير صحيحة.' 
            : 'The provided credentials do not match our records.';
        
        if ($remainingAttempts > 0) {
            $errorMessage .= ' ' . (app()->getLocale() == 'ar' 
                ? "محاولات متبقية: {$remainingAttempts}" 
                : "Remaining attempts: {$remainingAttempts}");
        }
        
        // Handle AJAX request
        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 401);
        }
        
        // Login failed
        throw ValidationException::withMessages([
            'email' => $errorMessage,
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Log logout
        Log::info('Client logged out', [
            'client_id' => Auth::guard('client')->id(),
            'email' => Auth::guard('client')->user()->email,
        ]);
        
        Auth::guard('client')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', app()->getLocale() == 'ar' 
            ? 'تم تسجيل الخروج بنجاح' 
            : 'Logged out successfully');
    }

    /**
     * Validate Cloudflare Turnstile
     */
    private function validateTurnstile(Request $request): bool
    {
        $token = $request->input('cf-turnstile-response');
        
        if (!$token) {
            return false;
        }

        $secretKey = config('services.turnstile.secret_key');
        
        // Skip validation if using test key
        if ($secretKey === '1x0000000000000000000000000000000AA') {
            return true;
        }

        // Configure HTTP client with SSL certificate
        $http = \Illuminate\Support\Facades\Http::asForm();
        
        // In local environment, use local certificate if available
        if (app()->environment('local')) {
            $laravelCertPath = base_path('../etc/ssl/cacert.pem');
            if (file_exists($laravelCertPath)) {
                $http = $http->withOptions(['verify' => $laravelCertPath]);
            }
        }

        $response = $http->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (isset($result['success']) && $result['success']) {
            Log::info('Turnstile verification successful', [
                'ip' => $request->ip(),
                'hostname' => $result['hostname'] ?? null,
            ]);
            return true;
        }

        Log::warning('Turnstile verification failed', [
            'ip' => $request->ip(),
            'error_codes' => $result['error-codes'] ?? [],
        ]);

        return false;
    }

    /**
     * Check if user/IP is blocked due to too many failed attempts
     */
    private function checkIfBlocked(string $email, string $ip): ?string
    {
        $attempt = LoginAttempt::where('email', $email)
            ->where('ip_address', $ip)
            ->first();

        if ($attempt && $attempt->isBlocked()) {
            $minutes = $attempt->getRemainingBlockTime();
            return app()->getLocale() == 'ar'
                ? "تم حظر حسابك مؤقتاً بسبب محاولات فاشلة متعددة. يرجى المحاولة بعد {$minutes} دقيقة."
                : "Your account has been temporarily blocked due to multiple failed attempts. Please try again after {$minutes} minutes.";
        }

        return null;
    }

    /**
     * Increment failed login attempts
     */
    private function incrementFailedAttempts(string $email, string $ip): void
    {
        $maxAttempts = 5;
        $blockDuration = 15; // minutes

        $attempt = LoginAttempt::firstOrCreate(
            ['email' => $email, 'ip_address' => $ip],
            ['attempts' => 0]
        );

        $attempt->attempts++;

        if ($attempt->attempts >= $maxAttempts) {
            $attempt->blocked_until = now()->addMinutes($blockDuration);
            Log::warning('User blocked due to too many failed attempts', [
                'email' => $email,
                'ip' => $ip,
                'attempts' => $attempt->attempts,
            ]);
        }

        $attempt->save();
    }

    /**
     * Get remaining attempts before block
     */
    private function getRemainingAttempts(string $email, string $ip): int
    {
        $maxAttempts = 5;
        
        $attempt = LoginAttempt::where('email', $email)
            ->where('ip_address', $ip)
            ->first();

        if (!$attempt) {
            return $maxAttempts;
        }

        return max(0, $maxAttempts - $attempt->attempts);
    }

    /**
     * Clear failed attempts on successful login
     */
    private function clearFailedAttempts(string $email, string $ip): void
    {
        LoginAttempt::where('email', $email)
            ->where('ip_address', $ip)
            ->delete();
    }

    /**
     * Send 2FA code via email
     */
    private function send2FACodeEmail($user): void
    {
        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in session with 10 minute expiry
        session([
            '2fa_login_code' => $code,
            '2fa_login_code_expires' => now()->addMinutes(10)
        ]);

        // Send email
        Mail::raw(
            app()->getLocale() == 'ar' 
                ? "رمز التحقق لتسجيل الدخول هو: {$code}\n\nهذا الرمز صالح لمدة 10 دقائق."
                : "Your login verification code is: {$code}\n\nThis code is valid for 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(app()->getLocale() == 'ar' ? 'رمز التحقق لتسجيل الدخول' : 'Login Verification Code');
            }
        );
    }

    /**
     * Show 2FA verification page
     */
    public function show2FAForm()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('frontend.auth.2fa-verify');
    }

    /**
     * Verify 2FA code
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $userId = session('2fa_user_id');
        $method = session('2fa_method', 'authenticator');

        if (!$userId) {
            return back()->withErrors(['code' => app()->getLocale() == 'ar' ? 'جلسة غير صالحة' : 'Invalid session']);
        }

        $user = \App\Models\Client::find($userId);

        if (!$user) {
            return back()->withErrors(['code' => app()->getLocale() == 'ar' ? 'مستخدم غير موجود' : 'User not found']);
        }

        $valid = false;

        // Verify based on method
        if ($method === 'email') {
            $storedCode = session('2fa_login_code');
            $expiresAt = session('2fa_login_code_expires');

            if (!$storedCode || !$expiresAt) {
                return back()->withErrors(['code' => app()->getLocale() == 'ar' ? 'لم يتم إرسال رمز التحقق' : 'No verification code sent']);
            }

            if (now()->greaterThan($expiresAt)) {
                session()->forget(['2fa_login_code', '2fa_login_code_expires']);
                return back()->withErrors(['code' => app()->getLocale() == 'ar' ? 'انتهت صلاحية رمز التحقق' : 'Verification code expired']);
            }

            $valid = $request->code === $storedCode;
            
            if ($valid) {
                session()->forget(['2fa_login_code', '2fa_login_code_expires']);
            }
        } else {
            // Authenticator method
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $secret = decrypt($user->google2fa_secret);
            $valid = $google2fa->verifyKey($secret, $request->code);
        }

        if ($valid) {
            // Login the user
            Auth::guard('client')->login($user, session('2fa_remember', false));
            
            // Clear 2FA session
            session()->forget(['2fa_user_id', '2fa_remember', '2fa_method', '2fa_oauth_login']);
            
            $request->session()->regenerate();
            
            // Update last login time and IP
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
            
            // Set user's preferred language
            if ($user->preferred_language) {
                app()->setLocale($user->preferred_language);
                session()->put('locale', $user->preferred_language);
            }
            
            // Log successful login
            Log::info('Client logged in with 2FA', [
                'client_id' => $user->id,
                'email' => $user->email,
                'method' => $method,
                'ip' => $request->ip(),
            ]);
            
            return redirect()->intended(route('client.dashboard'));
        }

        return back()->withErrors(['code' => app()->getLocale() == 'ar' ? 'رمز التحقق غير صحيح' : 'Invalid verification code']);
    }
}
