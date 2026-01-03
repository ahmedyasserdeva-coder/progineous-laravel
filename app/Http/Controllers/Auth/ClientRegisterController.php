<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\AffiliateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class ClientRegisterController extends Controller
{
    protected AffiliateService $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }
    
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }
        
        // Get referral code if exists
        $refCode = $this->affiliateService->getActiveReferralCode();
        $referrer = null;
        
        if ($refCode) {
            $affiliate = $this->affiliateService->getAffiliateByCode($refCode);
            if ($affiliate && $affiliate->client) {
                $referrer = $affiliate->client->name;
            }
        }
        
        return view('frontend.auth.register', [
            'referrer' => $referrer,
            'refCode' => $refCode,
        ]);
    }
    
    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate Cloudflare Turnstile
        if (!$this->validateTurnstile($request)) {
            return back()->withErrors([
                'turnstile' => app()->getLocale() == 'ar' 
                    ? 'فشل التحقق الأمني. يرجى المحاولة مرة أخرى.' 
                    : 'Security verification failed. Please try again.',
            ])->withInput();
        }
        
        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => app()->getLocale() == 'ar' ? 'الاسم مطلوب' : 'Name is required',
            'email.required' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني مطلوب' : 'Email is required',
            'email.email' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني غير صالح' : 'Invalid email address',
            'email.unique' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني مستخدم بالفعل' : 'Email is already registered',
            'phone.required' => app()->getLocale() == 'ar' ? 'رقم الهاتف مطلوب' : 'Phone number is required',
            'password.required' => app()->getLocale() == 'ar' ? 'كلمة المرور مطلوبة' : 'Password is required',
            'password.confirmed' => app()->getLocale() == 'ar' ? 'كلمة المرور غير متطابقة' : 'Password confirmation does not match',
            'password.min' => app()->getLocale() == 'ar' ? 'كلمة المرور يجب أن تكون 8 أحرف على الأقل' : 'Password must be at least 8 characters',
            'terms.required' => app()->getLocale() == 'ar' ? 'يجب الموافقة على الشروط والأحكام' : 'You must agree to the terms and conditions',
            'terms.accepted' => app()->getLocale() == 'ar' ? 'يجب الموافقة على الشروط والأحكام' : 'You must agree to the terms and conditions',
        ]);
        
        try {
            // Generate unique username
            $username = $this->generateUsername($validated['name']);
            
            // Create the client
            $client = Client::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $username,
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'preferred_language' => app()->getLocale(),
                'email_verified_at' => null, // Will verify via email
                'status' => 'active',
            ]);
            
            // Link to affiliate if referred
            $referral = $this->affiliateService->linkReferral($client);
            
            if ($referral) {
                Log::info('New client registered via affiliate referral', [
                    'client_id' => $client->id,
                    'affiliate_id' => $referral->affiliate_id,
                    'referral_code' => $referral->referral_code,
                ]);
            }
            
            // Log the client in
            Auth::guard('client')->login($client);
            
            // Set locale
            if ($client->preferred_language) {
                app()->setLocale($client->preferred_language);
                session()->put('locale', $client->preferred_language);
            }
            
            // Log successful registration
            Log::info('New client registered', [
                'client_id' => $client->id,
                'email' => $client->email,
                'ip' => $request->ip(),
                'referred' => $referral ? true : false,
            ]);
            
            // Redirect to dashboard with success message
            return redirect()->route('client.dashboard')->with('success', 
                app()->getLocale() == 'ar' 
                    ? 'تم إنشاء حسابك بنجاح! مرحباً بك.' 
                    : 'Your account has been created successfully! Welcome.'
            );
            
        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? null,
            ]);
            
            return back()->withErrors([
                'email' => app()->getLocale() == 'ar' 
                    ? 'حدث خطأ أثناء إنشاء الحساب. يرجى المحاولة مرة أخرى.' 
                    : 'An error occurred while creating your account. Please try again.',
            ])->withInput();
        }
    }
    
    /**
     * Generate a unique username from name
     */
    private function generateUsername(string $name): string
    {
        // Clean and convert name to username format
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        
        if (strlen($baseUsername) < 3) {
            $baseUsername = 'user' . $baseUsername;
        }
        
        $username = $baseUsername;
        $counter = 1;
        
        while (Client::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
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

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();
            return $result['success'] ?? false;
        } catch (\Exception $e) {
            Log::error('Turnstile validation failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
