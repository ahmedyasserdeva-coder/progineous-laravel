<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request)
    {
        $query = Client::query()->withCount('services');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $clients = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'min:6', 'max:9', 'unique:clients,username', 'regex:/^[a-z0-9_-]+$/', function($attribute, $value, $fail) {
                // Check for 3 or more consecutive repeating characters
                if (preg_match('/(.)\1{2,}/', $value)) {
                    $fail(__('crm.username_no_repeating'));
                }
            }],
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:clients,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]+$/',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                function($attribute, $value, $fail) use ($request) {
                    $valueLower = strtolower($value);
                    if ($request->username && strlen($request->username) >= 3 && stripos($valueLower, strtolower($request->username)) !== false) {
                        $fail(__('crm.password_contains_username'));
                    }
                    if ($request->first_name && strlen($request->first_name) >= 3 && stripos($valueLower, strtolower($request->first_name)) !== false) {
                        $fail(__('crm.password_contains_personal_info'));
                    }
                    if ($request->last_name && strlen($request->last_name) >= 3 && stripos($valueLower, strtolower($request->last_name)) !== false) {
                        $fail(__('crm.password_contains_personal_info'));
                    }
                }
            ],
            'phone' => ['required', 'string', 'max:20', 'unique:clients,phone', function($attribute, $value, $fail) {
                try {
                    $phoneUtil = PhoneNumberUtil::getInstance();
                    $phoneNumber = $phoneUtil->parse($value, null);
                    if (!$phoneUtil->isValidNumber($phoneNumber)) {
                        $fail(__('crm.invalid_phone_format'));
                    }
                } catch (NumberParseException $e) {
                    $fail(__('crm.invalid_phone_format'));
                }
            }],
            'address1' => ['required', 'string', 'max:500', 'regex:/^[A-Za-z0-9\s\.,#\-]+$/'],
            'address2' => ['nullable', 'string', 'max:500', 'regex:/^[A-Za-z0-9\s\.,#\-]*$/'],
            'city' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s\-]+$/'],
            'state' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s\-]+$/'],
            'postcode' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\s\-]+$/'],
            'country' => 'required|string|size:2',
            'tax_number' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z0-9\s\-]*$/'],
        ], [
            'username.min' => __('crm.username_min_length'),
            'username.regex' => __('crm.username_validation'),
            'username.unique' => __('crm.username_taken'),
            'first_name.regex' => __('crm.first_name_english_only'),
            'last_name.regex' => __('crm.last_name_english_only'),
            'address1.regex' => __('crm.address1_english_only'),
            'address2.regex' => __('crm.address2_english_only'),
            'city.regex' => __('crm.city_english_only'),
            'state.regex' => __('crm.state_english_only'),
            'postcode.regex' => __('crm.postcode_english_only'),
            'tax_number.regex' => __('crm.tax_number_english_only'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if email is verified
        if (!EmailVerification::isVerified($request->email)) {
            return redirect()->back()
                ->withErrors(['email' => __('crm.email_not_verified')])
                ->withInput();
        }

        try {
            $client = new Client();
            
            // Account Username
            $client->username = $request->username;
            
            // Personal Information
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->company_name = $request->company_name;
            $client->email = $request->email;
            $client->password = Hash::make($request->password);
            $client->phone = $request->phone;
            
            // Address Information
            $client->address1 = $request->address1;
            $client->address2 = $request->address2;
            $client->city = $request->city;
            $client->state = $request->state;
            $client->postcode = $request->postcode;
            $client->country = $request->country;
            $client->tax_number = $request->tax_number;
            
            // Account Settings
            $client->preferred_language = $request->language ?? 'ar';
            $client->currency = $request->currency ?? 'USD';
            $client->payment_method = $request->payment_method ?? 'credit_card';
            $client->status = $request->status ?? 'active';
            $client->billing_contact = $request->billing_contact;
            $client->referral_source = $request->referral_source;
            
            // Email Notifications (stored as JSON)
            $client->email_notifications = json_encode([
                'general' => $request->has('email_general'),
                'invoice' => $request->has('email_invoice'),
                'support' => $request->has('email_support'),
                'product' => $request->has('email_product'),
                'domain' => $request->has('email_domain'),
                'affiliate' => $request->has('email_affiliate'),
            ]);
            
            // Settings (stored as JSON)
            $client->settings = json_encode([
                'late_fees' => $request->has('late_fees'),
                'overdue_notices' => $request->has('overdue_notices'),
                'tax_exempt' => $request->has('tax_exempt'),
                'separate_invoices' => $request->has('separate_invoices'),
                'disable_cc_processing' => $request->has('disable_cc_processing'),
                'marketing_emails_opt_in' => $request->has('marketing_emails_opt_in'),
                'status_update' => $request->has('status_update'),
                'allow_sso' => $request->has('allow_sso'),
            ]);
            
            // Owner Information
            $client->owner_type = $request->owner_type ?? 'new';
            $client->existing_user_id = $request->existing_user_id;
            
            // Admin Notes
            $client->admin_notes = $request->admin_notes;
            
            // Send Welcome Email Flag
            $client->send_welcome_email = $request->has('send_welcome_email');
            
            $client->save();
            
            // TODO: Send welcome email if requested
            if ($client->send_welcome_email) {
                // Send welcome email logic here
            }
            
            return redirect()->route('admin.clients.index')
                ->with('success', __('crm.client_created_successfully'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('crm.error_creating_client') . ': ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        // Calculate invoice statistics
        $invoiceStats = [
            'paid' => $client->invoices()->where('status', 'paid')->sum('total'),
            'draft' => $client->invoices()->where('status', 'draft')->sum('total'),
            'unpaid' => $client->invoices()->where('status', 'unpaid')->sum('total'),
            'cancelled' => $client->invoices()->where('status', 'cancelled')->sum('total'),
            'refunded' => $client->invoices()->where('status', 'refunded')->sum('total'),
        ];
        
        // Calculate income statistics
        $grossRevenue = $client->invoices()->where('status', 'paid')->sum('total');
        
        // Client expenses (e.g., refunds, credits given)
        $clientExpenses = $client->invoices()->where('status', 'refunded')->sum('total');
        
        // Net income
        $netIncome = $grossRevenue - $clientExpenses;
        
        // Calculate recurring income from active services
        $monthlyRecurring = $client->services()
            ->where('status', 'active')
            ->where('billing_cycle', 'monthly')
            ->sum('recurring_amount');
            
        $yearlyRecurring = $client->services()
            ->where('status', 'active')
            ->where('billing_cycle', 'yearly')
            ->sum('recurring_amount');
        
        // Convert yearly to monthly equivalent for total monthly
        $totalMonthlyRecurring = $monthlyRecurring + ($yearlyRecurring / 12);
        $totalYearlyRecurring = ($monthlyRecurring * 12) + $yearlyRecurring;
        
        $incomeStats = [
            'gross_revenue' => $grossRevenue,
            'expenses' => $clientExpenses,
            'net_income' => $netIncome,
            'monthly_recurring' => $totalMonthlyRecurring,
            'yearly_recurring' => $totalYearlyRecurring,
        ];
        
        // Get last 10 login activities
        $loginActivities = \DB::table('activity_logs')
            ->where('causer_type', 'App\\Models\\Client')
            ->where('causer_id', $client->id)
            ->where('description', 'like', '%login%')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                $properties = json_decode($activity->properties, true);
                return [
                    'ip' => $properties['ip'] ?? 'Unknown',
                    'user_agent' => $properties['user_agent'] ?? 'Unknown',
                    'created_at' => $activity->created_at,
                ];
            });
        
        // Get recent sent emails
        $recentEmails = $client->sentEmails()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get affiliate data if client is an affiliate
        $affiliate = null;
        if ($client->is_affiliate) {
            $affiliate = \App\Models\Affiliate::where('client_id', $client->id)
                ->with('tier')
                ->first();
        }
        
        // Get client domains
        $domains = \App\Models\Domain::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.clients.show', compact('client', 'invoiceStats', 'incomeStats', 'loginActivities', 'recentEmails', 'affiliate', 'domains'));
    }

    /**
     * Get the current support PIN for a client (AJAX).
     */
    public function getSupportPin(Client $client)
    {
        return response()->json([
            'pin' => $client->support_pin,
            'expires_at' => $client->support_pin_expires_at,
            'server_time' => time(),
        ]);
    }

    /**
     * Get the online status for a client (AJAX).
     */
    public function getOnlineStatus(Client $client)
    {
        $activeSession = \DB::table('sessions')
            ->where('user_id', $client->id)
            ->where('last_activity', '>=', now()->subMinutes(15)->timestamp)
            ->first();
        
        return response()->json([
            'is_online' => $activeSession !== null,
            'last_seen' => $client->last_login_at ? $client->last_login_at->diffForHumans() : null,
        ]);
    }

    /**
     * Get login activities for a client (AJAX).
     */
    public function getLoginActivities(Request $request, Client $client)
    {
        $timezone = $request->get('timezone', config('app.timezone'));
        
        // Validate timezone
        try {
            new \DateTimeZone($timezone);
        } catch (\Exception $e) {
            $timezone = config('app.timezone');
        }
        
        $loginActivities = \DB::table('activity_logs')
            ->where('causer_type', 'App\\Models\\Client')
            ->where('causer_id', $client->id)
            ->where('description', 'like', '%login%')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) use ($timezone) {
                $properties = json_decode($activity->properties, true);
                $ua = $properties['user_agent'] ?? 'Unknown';
                
                // Extract browser
                $browser = 'Unknown';
                if (str_contains($ua, 'Edg/')) $browser = 'Edge';
                elseif (str_contains($ua, 'Chrome/')) $browser = 'Chrome';
                elseif (str_contains($ua, 'Firefox/')) $browser = 'Firefox';
                elseif (str_contains($ua, 'Safari/')) $browser = 'Safari';
                
                // Extract OS
                $os = 'Unknown';
                if (str_contains($ua, 'Windows')) $os = 'Windows';
                elseif (str_contains($ua, 'Mac')) $os = 'macOS';
                elseif (str_contains($ua, 'Linux')) $os = 'Linux';
                elseif (str_contains($ua, 'Android')) $os = 'Android';
                elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) $os = 'iOS';
                
                $dateTime = \Carbon\Carbon::parse($activity->created_at)->timezone($timezone);
                
                return [
                    'ip' => $properties['ip'] ?? 'Unknown',
                    'browser' => $browser,
                    'os' => $os,
                    'date' => $dateTime->format('M d, Y'),
                    'time' => $dateTime->format('h:i:s A'),
                    'timezone' => $timezone,
                ];
            });
        
        return response()->json([
            'activities' => $loginActivities,
        ]);
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'min:6', 'max:9', 'unique:clients,username,' . $client->id, 'regex:/^[a-z0-9_-]+$/', function($attribute, $value, $fail) {
                // Check for 3 or more consecutive repeating characters
                if (preg_match('/(.)\1{2,}/', $value)) {
                    $fail(__('crm.username_no_repeating'));
                }
            }],
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'address1' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:2',
        ], [
            'username.min' => __('crm.username_min_length'),
            'username.regex' => __('crm.username_validation'),
            'username.unique' => __('crm.username_taken'),
            'first_name.regex' => __('crm.first_name_english_only'),
            'last_name.regex' => __('crm.last_name_english_only'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Account Username
            $client->username = $request->username;
            
            // Personal Information
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->company_name = $request->company_name;
            $client->email = $request->email;
            
            if ($request->filled('password')) {
                $client->password = Hash::make($request->password);
            }
            
            $client->phone = $request->phone;
            
            // Address Information
            $client->address1 = $request->address1;
            $client->address2 = $request->address2;
            $client->city = $request->city;
            $client->state = $request->state;
            $client->postcode = $request->postcode;
            $client->country = $request->country;
            $client->tax_number = $request->tax_number;
            
            // Account Settings
            $client->preferred_language = $request->language;
            $client->currency = $request->currency;
            $client->payment_method = $request->payment_method;
            $client->status = $request->status;
            $client->billing_contact = $request->billing_contact;
            $client->referral_source = $request->referral_source;
            
            // Email Notifications
            $client->email_notifications = json_encode([
                'general' => $request->has('email_general'),
                'invoice' => $request->has('email_invoice'),
                'support' => $request->has('email_support'),
                'product' => $request->has('email_product'),
                'domain' => $request->has('email_domain'),
                'affiliate' => $request->has('email_affiliate'),
            ]);
            
            // Settings
            $client->settings = json_encode([
                'late_fees' => $request->has('late_fees'),
                'overdue_notices' => $request->has('overdue_notices'),
                'tax_exempt' => $request->has('tax_exempt'),
                'separate_invoices' => $request->has('separate_invoices'),
                'disable_cc_processing' => $request->has('disable_cc_processing'),
                'marketing_emails_opt_in' => $request->has('marketing_emails_opt_in'),
                'status_update' => $request->has('status_update'),
                'allow_sso' => $request->has('allow_sso'),
            ]);
            
            // Admin Notes
            $client->admin_notes = $request->admin_notes;
            
            $client->save();
            
            return redirect()->route('admin.clients.show', $client)
                ->with('success', __('crm.client_updated_successfully'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('crm.error_updating_client') . ': ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        try {
            $client->delete();
            
            return redirect()->route('admin.clients.index')
                ->with('success', __('crm.client_deleted_successfully'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('crm.error_deleting_client') . ': ' . $e->getMessage());
        }
    }
    
    /**
     * Check if username is available (AJAX)
     */
    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $excludeId = $request->input('exclude_id', null);
        
        // Check minimum length
        if (strlen($username) < 6) {
            return response()->json([
                'available' => false,
                'message' => __('crm.username_min_length')
            ]);
        }
        
        // Check pattern
        if (!preg_match('/^[a-z0-9_-]+$/', $username)) {
            return response()->json([
                'available' => false,
                'message' => __('crm.username_validation')
            ]);
        }
        
        // Check for 3 or more consecutive repeating characters
        if (preg_match('/(.)\1{2,}/', $username)) {
            return response()->json([
                'available' => false,
                'message' => __('crm.username_no_repeating')
            ]);
        }
        
        // Check uniqueness
        $query = Client::where('username', $username);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? __('crm.username_taken') : __('crm.username_available')
        ]);
    }
    
    /**
     * Check if email is available (AJAX)
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json([
                'available' => false,
                'message' => __('crm.invalid_email')
            ]);
        }
        
        $exists = Client::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? __('crm.email_already_exists') : __('crm.email_available')
        ]);
    }
    
    /**
     * Check if password is compromised (AJAX)
     */
    public function checkPasswordCompromised(Request $request)
    {
        $password = $request->input('password');
        
        if (!$password || strlen($password) < 8) {
            return response()->json([
                'compromised' => false,
                'checked' => false
            ]);
        }
        
        try {
            $validator = Validator::make(['password' => $password], [
                'password' => Password::min(8)->uncompromised()
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'compromised' => true,
                    'checked' => true,
                    'message' => __('crm.password_compromised')
                ]);
            }
            
            return response()->json([
                'compromised' => false,
                'checked' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'compromised' => false,
                'checked' => false,
                'error' => true
            ]);
        }
    }
    
    /**
     * Validate and detect phone number country code (AJAX)
     */
    public function validatePhone(Request $request)
    {
        $phone = $request->input('phone');
        $countryCode = $request->input('country_code', 'EG'); // Default to Egypt
        
        if (!$phone) {
            return response()->json([
                'valid' => false,
                'message' => __('crm.invalid_phone')
            ]);
        }
        
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            
            // Try to parse the phone number
            $phoneNumber = $phoneUtil->parse($phone, $countryCode);
            
            // Check if valid
            if (!$phoneUtil->isValidNumber($phoneNumber)) {
                return response()->json([
                    'valid' => false,
                    'message' => __('crm.invalid_phone_format')
                ]);
            }
            
            // Get country code and format
            $detectedCountryCode = $phoneUtil->getRegionCodeForNumber($phoneNumber);
            $formattedNumber = $phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
            $formattedInternational = $phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL);
            
            // Check if phone already exists
            $exists = Client::where('phone', $formattedNumber)->exists();
            
            return response()->json([
                'valid' => true,
                'available' => !$exists,
                'country_code' => $detectedCountryCode,
                'formatted' => $formattedNumber,
                'formatted_display' => $formattedInternational,
                'message' => $exists ? __('crm.phone_already_exists') : __('crm.phone_available')
            ]);
            
        } catch (NumberParseException $e) {
            return response()->json([
                'valid' => false,
                'message' => __('crm.invalid_phone_format')
            ]);
        }
    }
    
    /**
     * Send OTP to email (AJAX)
     */
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('crm.invalid_email')
            ]);
        }

        $email = $request->input('email');
        
        // Check if email already exists in clients table
        $existingClient = Client::where('email', $email)->first();
        if ($existingClient) {
            return response()->json([
                'success' => false,
                'message' => __('crm.email_already_exists')
            ]);
        }

        // Check OTP cooldown (10 minutes)
        $lastOtpTime = session('otp_sent_at_' . $email);
        if ($lastOtpTime) {
            $remainingSeconds = 600 - (time() - $lastOtpTime); // 600 seconds = 10 minutes
            if ($remainingSeconds > 0) {
                $remainingMinutes = ceil($remainingSeconds / 60);
                return response()->json([
                    'success' => false,
                    'message' => __('crm.otp_cooldown', ['minutes' => $remainingMinutes]),
                    'remaining_seconds' => $remainingSeconds
                ]);
            }
        }

        $result = EmailVerification::sendOTP($email);
        
        // Store the time of OTP sending in session
        if ($result['success']) {
            session(['otp_sent_at_' . $email => time()]);
        }
        
        return response()->json($result);
    }
    
    /**
     * Verify OTP (AJAX)
     */
    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('crm.invalid_otp_data')
            ]);
        }

        $email = $request->input('email');
        $otp = $request->input('otp');

        $result = EmailVerification::verifyOTP($email, $otp);
        
        return response()->json($result);
    }

    /**
     * View account statement for a client.
     */
    public function statement(Client $client)
    {
        // Get all invoices for the client
        $invoices = \DB::table('invoices')
            ->where('client_id', $client->id)
            ->orderBy('invoice_date', 'desc')
            ->get();

        // Get all payments/transactions
        $transactions = \DB::table('payments')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.clients.statement', compact('client', 'invoices', 'transactions'));
    }

    /**
     * Export account statement as PDF.
     */
    public function statementPdf(Client $client)
    {
        // Get all invoices for the client
        $invoices = \DB::table('invoices')
            ->where('client_id', $client->id)
            ->orderBy('invoice_date', 'desc')
            ->get();

        // Get all payments/transactions
        $transactions = \DB::table('payments')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalInvoiced = $invoices->sum('total');
        $totalPaid = $invoices->where('status', 'paid')->sum('total');
        $totalUnpaid = $invoices->whereIn('status', ['unpaid', 'overdue'])->sum('total');
        $balance = $totalInvoiced - $totalPaid;

        // Generate unique document signature
        $documentId = strtoupper(substr(md5($client->id . time() . uniqid()), 0, 12));
        $generatedAt = now()->format('Y-m-d H:i:s');
        
        // Create QR Code with direct verification URL
        $verificationUrl = url('/verify/' . $documentId);
        
        // Generate QR Code as base64 image
        $qrOptions = new \chillerlan\QRCode\QROptions([
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => \chillerlan\QRCode\QRCode::ECC_M,
            'scale' => 5,
            'imageBase64' => true,
        ]);
        
        $qrCode = (new \chillerlan\QRCode\QRCode($qrOptions))->render($verificationUrl);

        $html = view('admin.clients.statement-pdf', compact(
            'client', 
            'invoices', 
            'transactions',
            'totalInvoiced',
            'totalPaid',
            'totalUnpaid',
            'balance',
            'qrCode',
            'documentId',
            'generatedAt'
        ))->render();

        $filename = 'statement_' . $client->username . '_' . date('Y-m-d') . '.pdf';
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);
        
        $mpdf->SetDirectionality(app()->getLocale() == 'ar' ? 'rtl' : 'ltr');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        
        $mpdf->WriteHTML($html);
        
        $pdfContent = $mpdf->Output($filename, 'S');
        
        // Generate document hash for verification
        $documentHash = hash('sha256', $pdfContent);
        
        // Create content hash from actual data for deep verification
        $invoicesData = $invoices->map(function($inv) {
            return [
                'invoice_number' => $inv->invoice_number,
                'total' => $inv->total,
                'status' => $inv->status,
                'date' => $inv->invoice_date,
            ];
        })->toArray();
        
        $transactionsData = $transactions->map(function($trans) {
            return [
                'transaction_id' => $trans->transaction_id ?? null,
                'amount' => $trans->amount,
                'gateway' => $trans->gateway ?? null,
                'status' => $trans->status ?? null,
            ];
        })->toArray();
        
        $contentHash = hash('sha256', json_encode([
            'document_id' => $documentId,
            'generated_at' => $generatedAt,
            'client_id' => $client->id,
            'total_invoiced' => $totalInvoiced,
            'total_paid' => $totalPaid,
            'balance' => $balance,
            'invoices' => $invoicesData,
            'transactions' => $transactionsData,
        ]));
        
        // Save document record for verification
        \App\Models\VerifiedDocument::create([
            'document_id' => $documentId,
            'client_id' => $client->id,
            'document_type' => 'statement',
            'document_hash' => $documentHash,
            'content_hash' => $contentHash,
            'total_invoiced' => $totalInvoiced,
            'balance' => $balance,
            'metadata' => [
                'client_name' => $client->first_name . ' ' . $client->last_name,
                'client_email' => $client->email,
                'invoices_count' => $invoices->count(),
                'transactions_count' => $transactions->count(),
                'total_paid' => $totalPaid,
                'total_unpaid' => $totalUnpaid,
                'invoices' => $invoicesData,
                'transactions' => $transactionsData,
            ],
            'generated_at' => now(),
        ]);
        
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Activate client as an affiliate.
     */
    public function activateAffiliate(Client $client)
    {
        try {
            // Check if client already has an affiliate account
            $existingAffiliate = \App\Models\Affiliate::where('client_id', $client->id)->first();
            
            if ($existingAffiliate) {
                // Just activate it if it exists but is inactive
                if ($existingAffiliate->status !== 'active') {
                    $existingAffiliate->update(['status' => 'active']);
                }
                
                // Update client to be an affiliate
                $client->update(['is_affiliate' => true]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.affiliate_activated_successfully')
                ]);
            }
            
            // Get the default tier (Bronze - lowest sort_order)
            $defaultTier = \App\Models\AffiliateTier::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->first();
            
            // Create the affiliate record
            $affiliate = \App\Models\Affiliate::create([
                'client_id' => $client->id,
                'referral_code' => \App\Models\Affiliate::generateReferralCode(),
                'commission_rate' => $defaultTier ? $defaultTier->commission_rate : 10.00,
                'tier_id' => $defaultTier ? $defaultTier->id : null,
                'total_earnings' => 0,
                'pending_earnings' => 0,
                'paid_earnings' => 0,
                'total_referrals' => 0,
                'active_referrals' => 0,
                'link_clicks' => 0,
                'status' => 'active',
                'minimum_payout' => 50.00,
            ]);

            // Update client to be an affiliate
            $client->update(['is_affiliate' => true]);

            return response()->json([
                'success' => true,
                'message' => __('crm.affiliate_activated_successfully')
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to activate affiliate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show affiliate details for a client.
     */
    public function affiliateDetails(Client $client)
    {
        // Get affiliate record
        $affiliate = \App\Models\Affiliate::where('client_id', $client->id)
            ->with(['tier', 'referrals.referredClient', 'commissions'])
            ->first();
        
        if (!$affiliate) {
            return redirect()->route('admin.clients.show', $client)
                ->with('error', __('crm.client_not_affiliate'));
        }
        
        // Get referrals with pagination
        $referrals = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->with('referredClient')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'referrals_page');
        
        // Get commissions with pagination
        $commissions = \App\Models\AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->with(['referral.referredClient', 'invoice'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'commissions_page');
        
        // Get payouts
        $payouts = \App\Models\AffiliatePayout::where('affiliate_id', $affiliate->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'payouts_page');
        
        // Statistics
        $stats = [
            'total_referrals' => $affiliate->total_referrals,
            'active_referrals' => $affiliate->active_referrals,
            'total_earnings' => $affiliate->total_earnings,
            'pending_earnings' => $affiliate->pending_earnings,
            'paid_earnings' => $affiliate->paid_earnings,
            'link_clicks' => $affiliate->link_clicks ?? 0,
            'conversion_rate' => $affiliate->total_referrals > 0 
                ? round(($affiliate->active_referrals / $affiliate->total_referrals) * 100, 1) 
                : 0,
        ];
        
        // Get all tiers for tier progress
        $allTiers = \App\Models\AffiliateTier::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return view('admin.clients.affiliate', compact(
            'client', 
            'affiliate', 
            'referrals', 
            'commissions', 
            'payouts', 
            'stats',
            'allTiers'
        ));
    }

    /**
     * Update affiliate tier.
     */
    public function updateAffiliateTier(Request $request, Client $client)
    {
        $request->validate([
            'tier_id' => 'required|exists:affiliate_tiers,id'
        ]);

        $affiliate = \App\Models\Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return back()->with('error', __('crm.affiliate_not_found'));
        }

        $tier = \App\Models\AffiliateTier::findOrFail($request->tier_id);
        
        $affiliate->update([
            'tier_id' => $tier->id,
            'commission_rate' => $tier->commission_rate,
            'tier_upgraded_at' => now(),
        ]);

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($affiliate)
            ->withProperties([
                'old_tier_id' => $affiliate->getOriginal('tier_id'),
                'new_tier_id' => $tier->id,
                'tier_name' => $tier->name
            ])
            ->log('Affiliate tier changed');

        return back()->with('success', __('crm.tier_updated_successfully'));
    }

    /**
     * Add balance to affiliate account.
     */
    public function addAffiliateBalance(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|in:bonus,adjustment,promotion,other',
            'notes' => 'nullable|string|max:500'
        ]);

        $affiliate = \App\Models\Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return back()->with('error', __('crm.affiliate_not_found'));
        }

        $amount = (float) $request->amount;
        $oldPendingEarnings = $affiliate->pending_earnings;
        $oldTotalEarnings = $affiliate->total_earnings;
        
        $affiliate->increment('pending_earnings', $amount);
        $affiliate->increment('total_earnings', $amount);

        // Create commission record for history
        $reasonLabels = [
            'bonus' => __('crm.bonus'),
            'adjustment' => __('crm.adjustment'),
            'promotion' => __('crm.promotion'),
            'other' => __('crm.other'),
        ];
        $description = $reasonLabels[$request->reason] ?? $request->reason;
        if ($request->notes) {
            $description .= ' - ' . $request->notes;
        }
        
        \App\Models\AffiliateCommission::create([
            'affiliate_id' => $affiliate->id,
            'referral_id' => null,
            'invoice_id' => null,
            'amount' => $amount,
            'commission_rate' => 100,
            'commission_amount' => $amount,
            'status' => 'approved',
            'description' => __('crm.manual_credit') . ': ' . $description,
        ]);

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($affiliate)
            ->withProperties([
                'amount' => $amount,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'old_pending_earnings' => $oldPendingEarnings,
                'new_pending_earnings' => $affiliate->pending_earnings,
                'old_total_earnings' => $oldTotalEarnings,
                'new_total_earnings' => $affiliate->total_earnings,
            ])
            ->log('Balance added to affiliate account');

        return back()->with('success', __('crm.balance_added_successfully', ['amount' => number_format($amount, 2)]));
    }

    /**
     * Deduct balance from affiliate account.
     */
    public function deductAffiliateBalance(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|in:correction,chargeback,refund,other',
            'notes' => 'nullable|string|max:500'
        ]);

        $affiliate = \App\Models\Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return back()->with('error', __('crm.affiliate_not_found'));
        }

        $amount = (float) $request->amount;
        
        // Check if there's enough balance to deduct
        if ($affiliate->pending_earnings < $amount) {
            return back()->with('error', __('crm.insufficient_balance'));
        }

        $oldPendingEarnings = $affiliate->pending_earnings;
        $oldTotalEarnings = $affiliate->total_earnings;
        
        $affiliate->decrement('pending_earnings', $amount);
        $affiliate->decrement('total_earnings', $amount);

        // Create commission record for history (negative amount for deduction)
        $reasonLabels = [
            'correction' => __('crm.correction'),
            'chargeback' => __('crm.chargeback'),
            'refund' => __('crm.refund'),
            'other' => __('crm.other'),
        ];
        $description = $reasonLabels[$request->reason] ?? $request->reason;
        if ($request->notes) {
            $description .= ' - ' . $request->notes;
        }
        
        \App\Models\AffiliateCommission::create([
            'affiliate_id' => $affiliate->id,
            'referral_id' => null,
            'invoice_id' => null,
            'amount' => -$amount,
            'commission_rate' => 100,
            'commission_amount' => -$amount,
            'status' => 'approved',
            'description' => __('crm.manual_debit') . ': ' . $description,
        ]);

        // Log the activity
        activity()
            ->causedBy(auth('admin')->user())
            ->performedOn($affiliate)
            ->withProperties([
                'amount' => $amount,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'old_pending_earnings' => $oldPendingEarnings,
                'new_pending_earnings' => $affiliate->pending_earnings,
                'old_total_earnings' => $oldTotalEarnings,
                'new_total_earnings' => $affiliate->total_earnings,
            ])
            ->log('Balance deducted from affiliate account');

        return back()->with('success', __('crm.balance_deducted_successfully', ['amount' => number_format($amount, 2)]));
    }

    /**
     * Close client's account (suspend).
     */
    public function closeAccount(Client $client)
    {
        try {
            // Update client status to suspended
            $client->update(['status' => 'suspended']);

            // Optionally suspend all services
            // You can add logic here to suspend hosting accounts, etc.

            // Log the activity
            activity()
                ->causedBy(auth('admin')->user())
                ->performedOn($client)
                ->withProperties(['old_status' => $client->getOriginal('status')])
                ->log('Client account closed/suspended');

            return response()->json([
                'success' => true,
                'message' => __('crm.account_closed_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update client's email address.
     */
    public function updateEmail(Request $request, Client $client)
    {
        $request->validate([
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'reset_verification' => 'boolean',
        ]);

        try {
            $oldEmail = $client->email;
            $newEmail = $request->email;

            // Update email
            $client->email = $newEmail;
            
            // Reset verification if requested
            if ($request->reset_verification) {
                $client->email_verified_at = null;
            }
            
            $client->email_last_changed_at = now();
            
            // Invalidate all sessions by changing remember token
            $client->remember_token = null;
            
            $client->save();

            // Delete all sessions for this client from database (if using database sessions)
            if (config('session.driver') === 'database') {
                \Illuminate\Support\Facades\DB::table('sessions')
                    ->where('user_id', $client->id)
                    ->delete();
            }

            // Log the activity
            activity()
                ->causedBy(auth('admin')->user())
                ->performedOn($client)
                ->withProperties([
                    'old_email' => $oldEmail,
                    'new_email' => $newEmail,
                    'reset_verification' => $request->reset_verification ?? false,
                    'sessions_invalidated' => true
                ])
                ->log('Client email updated by admin');

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم تحديث البريد الإلكتروني بنجاح وتم تسجيل خروج المستخدم'
                    : 'Email address updated successfully and user has been logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * View wallet details for a client.
     */
    public function wallet(Client $client)
    {
        // Get wallet transactions using Model
        $transactions = \App\Models\WalletTransaction::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.clients.wallet', compact('client', 'transactions'));
    }

    /**
     * View a single wallet transaction.
     */
    public function walletTransaction(Client $client, $transactionId)
    {
        $transaction = \App\Models\WalletTransaction::where('client_id', $client->id)
            ->where('id', $transactionId)
            ->firstOrFail();

        return view('admin.clients.wallet-transaction', compact('client', 'transaction'));
    }

    /**
     * Show invoice for admin.
     */
    public function showInvoice($invoiceId)
    {
        $invoice = \App\Models\Invoice::with('order', 'order.items', 'client', 'payments')
            ->findOrFail($invoiceId);
        
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Add credit to client's wallet.
     */
    public function addWalletCredit(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:100000',
            'reason' => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $reason = $request->reason;

        // Update wallet balance
        $client->increment('wallet_balance', $amount);

        // Generate reference
        $reference = 'ADJ-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();

        // Log transaction
        \DB::table('wallet_transactions')->insert([
            'client_id' => $client->id,
            'type' => 'deposit',
            'amount' => $amount,
            'status' => 'completed',
            'payment_method' => 'admin_adjustment',
            'transaction_reference' => $reference,
            'description' => $reason,
            'metadata' => json_encode([
                'description' => $reason,
                'created_by' => auth()->id(),
                'admin_name' => auth()->user()->name ?? 'Admin',
            ]),
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.clients.wallet', $client)
            ->with('success', __('crm.wallet_credit_added', ['amount' => number_format($amount, 2)]));
    }

    /**
     * Deduct credit from client's wallet.
     */
    public function deductWalletCredit(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:100000',
            'reason' => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $reason = $request->reason;

        // Check sufficient balance
        if ($client->wallet_balance < $amount) {
            return redirect()->route('admin.clients.wallet', $client)
                ->with('error', __('crm.insufficient_wallet_balance'));
        }

        // Update wallet balance
        $client->decrement('wallet_balance', $amount);

        // Generate reference
        $reference = 'ADJ-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();

        // Log transaction
        \DB::table('wallet_transactions')->insert([
            'client_id' => $client->id,
            'type' => 'deduction',
            'amount' => -$amount,
            'status' => 'completed',
            'payment_method' => 'admin_adjustment',
            'transaction_reference' => $reference,
            'description' => $reason,
            'metadata' => json_encode([
                'description' => $reason,
                'created_by' => auth()->id(),
                'admin_name' => auth()->user()->name ?? 'Admin',
            ]),
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.clients.wallet', $client)
            ->with('success', __('crm.wallet_credit_deducted', ['amount' => number_format($amount, 2)]));
    }

    /**
     * Verify a document by uploading PDF
     */
    public function verifyDocument(Request $request, Client $client)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $file = $request->file('document');
            $content = file_get_contents($file->getRealPath());
            $uploadedHash = hash('sha256', $content);

            // Find document by hash
            $document = \App\Models\VerifiedDocument::where('document_hash', $uploadedHash)
                ->where('client_id', $client->id)
                ->first();

            if ($document) {
                return response()->json([
                    'success' => true,
                    'verified' => true,
                    'message' => __('crm.document_verified_success'),
                    'document' => [
                        'document_id' => $document->document_id,
                        'generated_at' => $document->generated_at->format('Y-m-d H:i:s'),
                        'client_name' => $document->metadata['client_name'] ?? null,
                        'client_email' => $document->metadata['client_email'] ?? null,
                        'total_invoiced' => $document->total_invoiced,
                        'total_paid' => $document->metadata['total_paid'] ?? 0,
                        'total_unpaid' => $document->metadata['total_unpaid'] ?? 0,
                        'balance' => $document->balance,
                        'document_type' => $document->document_type,
                        'invoices_count' => $document->metadata['invoices_count'] ?? 0,
                        'transactions_count' => $document->metadata['transactions_count'] ?? 0,
                        'invoices' => $document->metadata['invoices'] ?? [],
                        'transactions' => $document->metadata['transactions'] ?? [],
                    ]
                ]);
            } else {
                // Check if document exists but for different client (potential fraud)
                $otherDocument = \App\Models\VerifiedDocument::where('document_hash', $uploadedHash)->first();
                
                if ($otherDocument) {
                    return response()->json([
                        'success' => true,
                        'verified' => false,
                        'warning' => true,
                        'message' => __('crm.document_belongs_to_other_client'),
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'verified' => false,
                    'message' => __('crm.document_not_verified'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify document by Document ID
     */
    public function verifyDocumentById(Request $request, Client $client)
    {
        $request->validate([
            'document_id' => 'required|string|size:12',
        ]);

        try {
            $document = \App\Models\VerifiedDocument::where('document_id', $request->document_id)
                ->where('client_id', $client->id)
                ->first();

            if ($document) {
                return response()->json([
                    'success' => true,
                    'verified' => true,
                    'message' => __('crm.document_verified_success'),
                    'document' => [
                        'document_id' => $document->document_id,
                        'generated_at' => $document->generated_at->format('Y-m-d H:i:s'),
                        'client_name' => $document->metadata['client_name'] ?? null,
                        'client_email' => $document->metadata['client_email'] ?? null,
                        'total_invoiced' => $document->total_invoiced,
                        'total_paid' => $document->metadata['total_paid'] ?? 0,
                        'total_unpaid' => $document->metadata['total_unpaid'] ?? 0,
                        'balance' => $document->balance,
                        'document_type' => $document->document_type,
                        'invoices_count' => $document->metadata['invoices_count'] ?? 0,
                        'transactions_count' => $document->metadata['transactions_count'] ?? 0,
                        'invoices' => $document->metadata['invoices'] ?? [],
                        'transactions' => $document->metadata['transactions'] ?? [],
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'verified' => false,
                    'message' => __('crm.document_id_not_found'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
