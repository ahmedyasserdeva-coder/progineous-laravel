<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user is already logged in (linking from settings)
            if (Auth::guard('client')->check()) {
                $currentUser = Auth::guard('client')->user();
                
                // Check if the Google email matches the current user's email
                if ($currentUser->email !== $googleUser->getEmail()) {
                    return redirect()->route('settings.index')->with('error', 
                        app()->getLocale() == 'ar' 
                            ? 'البريد الإلكتروني لحساب Google لا يطابق بريدك الإلكتروني المسجل.' 
                            : 'The Google account email does not match your registered email.'
                    );
                }
                
                // Link Google account
                if (!$currentUser->google_id) {
                    $currentUser->google_id = $googleUser->getId();
                    $currentUser->save();
                    
                    Log::info('Google account linked', [
                        'client_id' => $currentUser->id,
                        'email' => $currentUser->email,
                    ]);
                    
                    return redirect()->route('settings.index')->with('success', 
                        app()->getLocale() == 'ar' 
                            ? 'تم ربط حساب Google بنجاح!' 
                            : 'Google account linked successfully!'
                    );
                }
                
                return redirect()->route('settings.index')->with('info', 
                    app()->getLocale() == 'ar' 
                        ? 'حساب Google مرتبط بالفعل.' 
                        : 'Google account is already linked.'
                );
            }
            
            // Check if user already exists by email (for login)
            $client = Client::where('email', $googleUser->getEmail())->first();
            
            if ($client) {
                // Save Google ID if not already saved
                if (!$client->google_id) {
                    $client->google_id = $googleUser->getId();
                    $client->save();
                }
                
                // Check if 2FA is enabled
                if ($client->google2fa_enabled) {
                    // Store user ID in session for 2FA verification
                    session([
                        '2fa_user_id' => $client->id,
                        '2fa_remember' => true,
                        '2fa_method' => $client->two_factor_method ?? 'authenticator',
                        '2fa_oauth_login' => true // Flag to indicate OAuth login
                    ]);
                    
                    // If method is email, send verification code
                    if ($client->two_factor_method === 'email') {
                        $this->send2FACodeEmail($client);
                    }
                    
                    Log::info('Google OAuth login - 2FA required', [
                        'client_id' => $client->id,
                        'email' => $client->email,
                    ]);
                    
                    // Redirect to 2FA verification page
                    return redirect()->route('2fa.verify.show');
                }
                
                // User exists - login
                Auth::guard('client')->login($client, true);
                
                // Update last login time and IP
                $client->update([
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip(),
                ]);
                
                // Set user's preferred language
                if ($client->preferred_language) {
                    app()->setLocale($client->preferred_language);
                    session()->put('locale', $client->preferred_language);
                }
                
                Log::info('Client logged in via Google', [
                    'client_id' => $client->id,
                    'email' => $client->email,
                ]);
                
                return redirect()->intended(route('client.dashboard'));
            }
            
            // User doesn't exist - reject registration
            Log::warning('Google OAuth attempted for non-existent account', [
                'email' => $googleUser->getEmail(),
            ]);
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'لا يوجد حساب مرتبط بهذا البريد الإلكتروني. الرجاء التسجيل أولاً.' 
                    : 'No account is associated with this email. Please register first.'
            );
            
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'حدث خطأ أثناء تسجيل الدخول بواسطة Google. الرجاء المحاولة مرة أخرى.' 
                    : 'An error occurred while signing in with Google. Please try again.'
            );
        }
    }

    /**
     * Redirect to GitHub OAuth
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle GitHub OAuth callback
     */
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            // Check if user is already logged in (linking from settings)
            if (Auth::guard('client')->check()) {
                $currentUser = Auth::guard('client')->user();
                
                // Check if the GitHub email matches the current user's email
                if ($currentUser->email !== $githubUser->getEmail()) {
                    return redirect()->route('settings.index')->with('error', 
                        app()->getLocale() == 'ar' 
                            ? 'البريد الإلكتروني لحساب GitHub لا يطابق بريدك الإلكتروني المسجل.' 
                            : 'The GitHub account email does not match your registered email.'
                    );
                }
                
                // Link GitHub account
                if (!$currentUser->github_id) {
                    $currentUser->github_id = $githubUser->getId();
                    $currentUser->save();
                    
                    Log::info('GitHub account linked', [
                        'client_id' => $currentUser->id,
                        'email' => $currentUser->email,
                    ]);
                    
                    return redirect()->route('settings.index')->with('success', 
                        app()->getLocale() == 'ar' 
                            ? 'تم ربط حساب GitHub بنجاح!' 
                            : 'GitHub account linked successfully!'
                    );
                }
                
                return redirect()->route('settings.index')->with('info', 
                    app()->getLocale() == 'ar' 
                        ? 'حساب GitHub مرتبط بالفعل.' 
                        : 'GitHub account is already linked.'
                );
            }
            
            // Check if user already exists by email (for login)
            $client = Client::where('email', $githubUser->getEmail())->first();
            
            if ($client) {
                // Save GitHub ID if not already saved
                if (!$client->github_id) {
                    $client->github_id = $githubUser->getId();
                    $client->save();
                }
                
                // Check if 2FA is enabled
                if ($client->google2fa_enabled) {
                    // Store user ID in session for 2FA verification
                    session([
                        '2fa_user_id' => $client->id,
                        '2fa_remember' => true,
                        '2fa_method' => $client->two_factor_method ?? 'authenticator',
                        '2fa_oauth_login' => true // Flag to indicate OAuth login
                    ]);
                    
                    // If method is email, send verification code
                    if ($client->two_factor_method === 'email') {
                        $this->send2FACodeEmail($client);
                    }
                    
                    Log::info('GitHub OAuth login - 2FA required', [
                        'client_id' => $client->id,
                        'email' => $client->email,
                    ]);
                    
                    // Redirect to 2FA verification page
                    return redirect()->route('2fa.verify.show');
                }
                
                // User exists - login
                Auth::guard('client')->login($client, true);
                
                // Update last login time and IP
                $client->update([
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip(),
                ]);
                
                // Set user's preferred language
                if ($client->preferred_language) {
                    app()->setLocale($client->preferred_language);
                    session()->put('locale', $client->preferred_language);
                }
                
                Log::info('Client logged in via GitHub', [
                    'client_id' => $client->id,
                    'email' => $client->email,
                ]);
                
                return redirect()->intended(route('client.dashboard'));
            }
            
            // User doesn't exist - reject registration
            Log::warning('GitHub OAuth attempted for non-existent account', [
                'email' => $githubUser->getEmail(),
            ]);
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'لا يوجد حساب مرتبط بهذا البريد الإلكتروني. الرجاء التسجيل أولاً.' 
                    : 'No account is associated with this email. Please register first.'
            );
            
        } catch (\Exception $e) {
            Log::error('GitHub OAuth error: ' . $e->getMessage());
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'حدث خطأ أثناء تسجيل الدخول بواسطة GitHub. الرجاء المحاولة مرة أخرى.' 
                    : 'An error occurred while signing in with GitHub. Please try again.'
            );
        }
    }

    /**
     * Redirect to LinkedIn OAuth
     */
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin-openid')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback
     */
    public function handleLinkedinCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin-openid')->user();
            
            // Check if user is already logged in (linking from settings)
            if (Auth::guard('client')->check()) {
                $currentUser = Auth::guard('client')->user();
                
                // Check if the LinkedIn email matches the current user's email
                if ($currentUser->email !== $linkedinUser->getEmail()) {
                    return redirect()->route('settings.index')->with('error', 
                        app()->getLocale() == 'ar' 
                            ? 'البريد الإلكتروني لحساب LinkedIn لا يطابق بريدك الإلكتروني المسجل.' 
                            : 'The LinkedIn account email does not match your registered email.'
                    );
                }
                
                // Link LinkedIn account
                if (!$currentUser->linkedin_id) {
                    $currentUser->linkedin_id = $linkedinUser->getId();
                    $currentUser->save();
                    
                    Log::info('LinkedIn account linked', [
                        'client_id' => $currentUser->id,
                        'email' => $currentUser->email,
                    ]);
                    
                    return redirect()->route('settings.index')->with('success', 
                        app()->getLocale() == 'ar' 
                            ? 'تم ربط حساب LinkedIn بنجاح!' 
                            : 'LinkedIn account linked successfully!'
                    );
                }
                
                return redirect()->route('settings.index')->with('info', 
                    app()->getLocale() == 'ar' 
                        ? 'حساب LinkedIn مرتبط بالفعل.' 
                        : 'LinkedIn account is already linked.'
                );
            }
            
            // Check if user already exists by email (for login)
            $client = Client::where('email', $linkedinUser->getEmail())->first();
            
            if ($client) {
                // Save LinkedIn ID if not already saved
                if (!$client->linkedin_id) {
                    $client->linkedin_id = $linkedinUser->getId();
                    $client->save();
                }
                
                // Check if 2FA is enabled
                if ($client->google2fa_enabled) {
                    // Store user ID in session for 2FA verification
                    session([
                        '2fa_user_id' => $client->id,
                        '2fa_remember' => true,
                        '2fa_method' => $client->two_factor_method ?? 'authenticator',
                        '2fa_oauth_login' => true // Flag to indicate OAuth login
                    ]);
                    
                    // If method is email, send verification code
                    if ($client->two_factor_method === 'email') {
                        $this->send2FACodeEmail($client);
                    }
                    
                    Log::info('LinkedIn OAuth login - 2FA required', [
                        'client_id' => $client->id,
                        'email' => $client->email,
                    ]);
                    
                    // Redirect to 2FA verification page
                    return redirect()->route('2fa.verify.show');
                }
                
                // User exists - login
                Auth::guard('client')->login($client, true);
                
                // Update last login time and IP
                $client->update([
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip(),
                ]);
                
                // Set user's preferred language
                if ($client->preferred_language) {
                    app()->setLocale($client->preferred_language);
                    session()->put('locale', $client->preferred_language);
                }
                
                Log::info('Client logged in via LinkedIn', [
                    'client_id' => $client->id,
                    'email' => $client->email,
                ]);
                
                return redirect()->intended(route('client.dashboard'));
            }
            
            // User doesn't exist - reject registration
            Log::warning('LinkedIn OAuth attempted for non-existent account', [
                'email' => $linkedinUser->getEmail(),
            ]);
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'لا يوجد حساب مرتبط بهذا البريد الإلكتروني. الرجاء التسجيل أولاً.' 
                    : 'No account is associated with this email. Please register first.'
            );
            
        } catch (\Exception $e) {
            Log::error('LinkedIn OAuth error: ' . $e->getMessage());
            
            return redirect()->route('login')->with('error', 
                app()->getLocale() == 'ar' 
                    ? 'حدث خطأ أثناء تسجيل الدخول بواسطة LinkedIn. الرجاء المحاولة مرة أخرى.' 
                    : 'An error occurred while signing in with LinkedIn. Please try again.'
            );
        }
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
}

