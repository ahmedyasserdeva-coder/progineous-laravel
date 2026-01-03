<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Server;
use App\Models\EmailTemplate;
use App\Models\DomainPricing;
use App\Models\DomainRegistrar;
use App\Models\VpsPlan;
use App\Models\DedicatedPlan;
use App\Models\Coupon;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SystemSettingsController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index()
    {
        return view('admin.system-settings.index');
    }

    /**
     * Show the general settings page.
     */
    public function general()
    {
        $settings = [
            'company_name' => Setting::get('company_name', ''),
            'email_address' => Setting::get('email_address', ''),
            'domain' => Setting::get('domain', ''),
            'sidebar_admin_logo' => Setting::get('sidebar_admin_logo', ''),
            'sidebar_admin_logo_collapsed' => Setting::get('sidebar_admin_logo_collapsed', ''),
            'customer_panel_logo' => Setting::get('customer_panel_logo', ''),
            'customer_panel_logo_collapsed' => Setting::get('customer_panel_logo_collapsed', ''),
            'website_logo' => Setting::get('website_logo', ''),
            'favicon' => Setting::get('favicon', ''),
            'activity_log_limit' => Setting::get('activity_log_limit', 1000),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'maintenance_message' => Setting::get('maintenance_message', ''),
            'maintenance_redirect_url' => Setting::get('maintenance_redirect_url', ''),
            'default_language' => Setting::get('default_language', 'ar'),
            'enable_language_menu' => Setting::get('enable_language_menu', true),
        ];

        return view('admin.system-settings.general', compact('settings'));
    }

    /**
     * Save the general settings.
     */
    public function saveGeneral(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email_address' => 'nullable|email|max:255',
            'domain' => 'nullable|url|max:255',
            'sidebar_admin_logo' => 'nullable|file|mimes:png,svg|max:2048',
            'sidebar_admin_logo_collapsed' => 'nullable|file|mimes:png,svg|max:2048',
            'customer_panel_logo' => 'nullable|file|mimes:png,svg|max:2048',
            'customer_panel_logo_collapsed' => 'nullable|file|mimes:png,svg|max:2048',
            'website_logo' => 'nullable|file|mimes:png,svg|max:2048',
            'favicon' => 'nullable|file|mimes:png,ico,svg|max:1024',
            'activity_log_limit' => 'nullable|integer|min:0',
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'maintenance_redirect_url' => 'nullable|url|max:255',
        ]);

        // Save text settings
        Setting::set('company_name', $request->input('company_name', ''), 'string', 'Company name for the platform');
        Setting::set('email_address', $request->input('email_address', ''), 'string', 'Official company email address');
        Setting::set('domain', $request->input('domain', ''), 'string', 'Main website domain');
        Setting::set('activity_log_limit', $request->input('activity_log_limit', 1000), 'integer', 'Maximum activity log entries');
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? 1 : 0, 'boolean', 'Maintenance mode status');
        Setting::set('maintenance_message', $request->input('maintenance_message', ''), 'string', 'Maintenance mode message');
        Setting::set('maintenance_redirect_url', $request->input('maintenance_redirect_url', ''), 'string', 'Maintenance redirect URL');

        // Handle logo uploads
        if ($request->hasFile('sidebar_admin_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('sidebar_admin_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('sidebar_admin_logo')->store('logos', 'public');
            Setting::set('sidebar_admin_logo', $path, 'string', 'Admin sidebar logo path');
        }

        if ($request->hasFile('sidebar_admin_logo_collapsed')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('sidebar_admin_logo_collapsed');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('sidebar_admin_logo_collapsed')->store('logos', 'public');
            Setting::set('sidebar_admin_logo_collapsed', $path, 'string', 'Admin sidebar collapsed logo path');
        }

        if ($request->hasFile('customer_panel_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('customer_panel_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('customer_panel_logo')->store('logos', 'public');
            Setting::set('customer_panel_logo', $path, 'string', 'Customer panel logo path');
        }

        if ($request->hasFile('customer_panel_logo_collapsed')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('customer_panel_logo_collapsed');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('customer_panel_logo_collapsed')->store('logos', 'public');
            Setting::set('customer_panel_logo_collapsed', $path, 'string', 'Customer panel collapsed logo path');
        }

        if ($request->hasFile('website_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('website_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('website_logo')->store('logos', 'public');
            Setting::set('website_logo', $path, 'string', 'Website logo path');
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $path = $request->file('favicon')->store('logos', 'public');
            Setting::set('favicon', $path, 'string', 'Website favicon path');
        }

        // Clear settings cache
        Setting::clearCache();

        return redirect()
            ->route('admin.system-settings.general')
            ->with('success', __('crm.settings_saved_successfully'));
    }

    /**
     * Save localisation settings.
     */
    public function saveLocalisation(Request $request)
    {
        $validated = $request->validate([
            'default_language' => 'required|string|in:ar,en',
            'enable_language_menu' => 'nullable|boolean',
        ]);

        // Save localisation settings
        Setting::set('default_language', $request->input('default_language', 'ar'), 'string', 'Default language for the platform');
        Setting::set('enable_language_menu', $request->has('enable_language_menu') ? 1 : 0, 'boolean', 'Enable language menu in layout');

        // Clear settings cache
        Setting::clearCache();

        return redirect()
            ->route('admin.system-settings.general')
            ->with('success', __('crm.localisation_settings_saved_successfully'));
    }

    /**
     * Show the automation settings page.
     */
    public function automation()
    {
        return view('admin.system-settings.automation');
    }

    /**
     * Show the products/services page.
     */
    public function products()
    {
        // Get all products grouped by category
        $sharedHostingProducts = Product::where('category', 'shared_hosting')
            ->orderBy('created_at', 'desc')
            ->get();

        $cloudHostingProducts = Product::where('category', 'cloud_hosting')
            ->orderBy('created_at', 'desc')
            ->get();

        $resellerProducts = Product::where('category', 'reseller_hosting')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get VPS Plans from vps_plans table
        $vpsPlans = VpsPlan::orderBy('created_at', 'desc')->get();

        // Get Dedicated Plans from dedicated_plans table
        $dedicatedPlans = DedicatedPlan::orderBy('created_at', 'desc')->get();

        $emailProducts = Product::where('category', 'email')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.system-settings.products', compact(
            'sharedHostingProducts',
            'cloudHostingProducts',
            'resellerProducts',
            'vpsPlans',
            'dedicatedPlans',
            'emailProducts'
        ));
    }

    /**
     * Show the create shared hosting plan form.
     */
    public function createSharedHosting()
    {
        $servers = \App\Models\Server::where('status', true)
            ->orderBy('name')
            ->get();

        $emailTemplates = EmailTemplate::all();

        return view('admin.system-settings.products-shared-hosting-create', compact('servers', 'emailTemplates'));
    }

    /**
     * Store a new shared hosting plan.
     */
    public function storeSharedHosting(Request $request)
    {
        $validated = $request->validate([
            // Plan Details
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'welcome_email' => 'nullable|string',

            // Product Options
            'require_domain' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'hidden' => 'nullable|boolean',
            'allow_multiple_quantities' => 'nullable|boolean',

            // Payment & Pricing
            'payment_type' => 'required|in:free,one_time,recurring',

            // One Time pricing
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'one_time_price' => 'nullable|numeric|min:0',

            // Recurring pricing
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',

            // Server & Setup
            'server_id' => 'required|exists:servers,id',
            'whm_package_name' => 'required|string|max:255',
            'auto_setup' => 'required|in:on_order,on_payment,on_accept,manual',

            // Free Domain
            'free_domain_type' => 'nullable|string|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_terms.*' => 'string|in:one_time,monthly,quarterly,semi_annually,annually,biennially,triennially',
            'free_domain_tlds' => 'nullable|array',
            'free_domain_tlds.*' => 'string',

            // Datacenter Locations & Pricing
            'datacenter_locations' => 'nullable|array',
            'datacenter_locations.*' => 'string',
            'datacenter_price' => 'nullable|array',
            'datacenter_price.*' => 'numeric|min:0|max:9999.99',
        ]);

        // Custom validation: If require_domain is checked, free_domain_type cannot be 'none'
        if (isset($validated['require_domain']) && $validated['require_domain']) {
            $freeDomainType = $validated['free_domain_type'] ?? 'none';

            if ($freeDomainType === 'none') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'free_domain_type' => app()->getLocale() === 'ar'
                            ? 'عند تفعيل "Require Domain"، يجب عليك اختيار خيار نطاق مجاني (تسجيل نطاق جديد أو تسجيل + تجديد). لا يمكن إنشاء الخطة بدون اختيار خيار النطاق المجاني.'
                            : 'When "Require Domain" is enabled, you must select a free domain option (Registration/Transfer or Registration/Transfer + Renewal). Cannot create the plan without selecting a free domain option.'
                    ]);
            }
        }

        // Prepare pricing data - Only save pricing periods that have values
        $pricing = [
            'one_time' => [
                'setup_fee' => $validated['one_time_setup_fee'] ?? 0,
                'price' => $validated['one_time_price'] ?? 0,
            ],
            'recurring' => [],
        ];

        // Only include recurring periods that have pricing
        $recurringPeriods = ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'];
        foreach ($recurringPeriods as $period) {
            $setupFee = $validated["{$period}_setup_fee"] ?? 0;
            $price = $validated["{$period}_price"] ?? 0;

            // Only add if there's a price or setup fee
            if ($setupFee > 0 || $price > 0) {
                $pricing['recurring'][$period] = [
                    'setup_fee' => $setupFee,
                    'price' => $price,
                ];
            }
        }

        // Prepare free domain configuration
        $freeDomainConfig = null;
        if (isset($validated['free_domain_type']) && $validated['free_domain_type'] !== 'none') {
            $freeDomainConfig = [
                'type' => $validated['free_domain_type'],
                'terms' => $validated['free_domain_terms'] ?? [],
                'tlds' => $validated['free_domain_tlds'] ?? [],
            ];
        }

        // Calculate default price (use monthly if recurring, one_time if one_time payment)
        $defaultPrice = 0;
        if ($validated['payment_type'] === 'recurring') {
            $defaultPrice = $validated['monthly_price'] ?? 0;
        } elseif ($validated['payment_type'] === 'one_time') {
            $defaultPrice = $validated['one_time_price'] ?? 0;
        }

        // Create the product
        $product = Product::create([
            'name' => $validated['plan_name'],
            'tagline' => $validated['plan_tagline'],
            'type' => 'hosting',
            'category' => 'shared_hosting',
            'description' => $validated['plan_short_description'],
            'short_description' => $validated['plan_short_description'],
            'features_list' => $validated['plan_feature'],
            'features_list_ar' => $request->plan_feature_ar,
            'welcome_email' => $validated['welcome_email'],
            'price' => $defaultPrice,
            'billing_cycle' => $validated['payment_type'] === 'recurring' ? 'monthly' : 'one_time',
            'payment_type' => $validated['payment_type'],
            'pricing' => $pricing,
            'require_domain' => $validated['require_domain'] ?? false,
            'is_active' => true,
            'is_featured' => $validated['featured'] ?? false,
            'is_hidden' => $validated['hidden'] ?? false,
            'allow_multiple_quantities' => $validated['allow_multiple_quantities'] ?? false,
            'server_id' => $validated['server_id'],
            'whm_package_name' => $validated['whm_package_name'],
            'auto_setup' => $validated['auto_setup'],
            'free_domain_config' => $freeDomainConfig,
            'datacenter_locations' => $validated['datacenter_locations'] ?? [],
            'datacenter_price' => $validated['datacenter_price'] ?? [],
        ]);

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', __('crm.plan_created_successfully'))
            ->withFragment('shared_hosting');
    }

    /**
     * Get WHM packages for a specific server.
     */
    public function getWHMPackages($serverId)
    {
        try {
            $server = \App\Models\Server::findOrFail($serverId);

            // Check if server type is cPanel/WHM
            if (!in_array($server->type, ['cpanel', 'whm'])) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.server_not_whm'),
                    'packages' => []
                ]);
            }

            // Build WHM API URL
            $protocol = $server->use_ssl ? 'https' : 'http';
            $port = $server->port ?: 2087; // Default WHM port
            $hostname = $server->hostname;

            // WHM API endpoint for listing packages
            $apiUrl = "{$protocol}://{$hostname}:{$port}/json-api/listpkgs";

            // Prepare authentication
            $username = $server->username;
            $apiToken = $server->api_token;

            if (empty($apiToken)) {
                Log::warning("Server {$serverId} has no API token configured");
                return response()->json([
                    'success' => false,
                    'message' => __('crm.no_api_token_configured'),
                    'packages' => []
                ]);
            }

            // Make API request using cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: WHM {$username}:" . $apiToken
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error("WHM API Connection Error for server {$serverId}: " . $curlError);
                return response()->json([
                    'success' => false,
                    'message' => __('crm.connection_error') . ': ' . $curlError,
                    'packages' => []
                ]);
            }

            if ($httpCode !== 200) {
                Log::error("WHM API returned HTTP {$httpCode} for server {$serverId}");
                return response()->json([
                    'success' => false,
                    'message' => __('crm.whm_api_error') . " (HTTP {$httpCode})",
                    'packages' => []
                ]);
            }

            $data = json_decode($response, true);

            if (!$data || !isset($data['package'])) {
                Log::error("Invalid WHM API response for server {$serverId}: " . substr($response, 0, 200));
                return response()->json([
                    'success' => false,
                    'message' => __('crm.invalid_whm_response'),
                    'packages' => []
                ]);
            }

            // Extract package names from response
            $packages = [];
            foreach ($data['package'] as $pkg) {
                if (isset($pkg['name'])) {
                    $packages[] = [
                        'name' => $pkg['name'],
                        'disk_quota' => $pkg['QUOTA'] ?? 'unlimited',
                        'bandwidth' => $pkg['BWLIMIT'] ?? 'unlimited',
                        'max_email_accounts' => $pkg['MAXPOP'] ?? 'unlimited',
                        'max_databases' => $pkg['MAXSQL'] ?? 'unlimited',
                    ];
                }
            }

            Log::info("Successfully fetched " . count($packages) . " packages from server {$serverId}");

            return response()->json([
                'success' => true,
                'packages' => $packages
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching WHM packages: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('crm.error_fetching_packages') . ': ' . $e->getMessage(),
                'packages' => []
            ], 500);
        }
    }

    /**
     * Show the product addons page.
     */
    public function addons()
    {
        return view('admin.system-settings.addons');
    }

    /**
     * Show the promotions and coupons page.
     */
    public function promotions()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        $campaigns = Campaign::orderBy('created_at', 'desc')->get();
        return view('admin.system-settings.promotions', compact('coupons', 'campaigns'));
    }

    /**
     * Show the coupon creation form.
     */
    public function createCoupon()
    {
        // Get all products from different categories
        $sharedHosting = \App\Models\Product::where('category', 'shared_hosting')->where('is_active', true)->get();
        $cloudHosting = \App\Models\Product::where('category', 'cloud_hosting')->where('is_active', true)->get();
        $resellerHosting = \App\Models\Product::where('category', 'reseller_hosting')->where('is_active', true)->get();
        $vpsPlans = \App\Models\VpsPlan::where('is_active', true)->get();
        $dedicatedPlans = \App\Models\DedicatedPlan::where('is_active', true)->get();
        $domainPricing = \App\Models\DomainPricing::orderBy('tld')->get();
        
        // Get all customers (users)
        $customers = \App\Models\Client::where('status', 'active')
            ->select('id', 'first_name', 'last_name', 'email', 'company_name')
            ->orderBy('first_name')
            ->get()
            ->map(function($client) {
                $client->full_name = trim($client->first_name . ' ' . $client->last_name);
                if ($client->company_name) {
                    $client->full_name .= ' (' . $client->company_name . ')';
                }
                return $client;
            });
        
        return view('admin.system-settings.promotions-coupon-create', compact(
            'sharedHosting',
            'cloudHosting',
            'resellerHosting',
            'vpsPlans',
            'dedicatedPlans',
            'domainPricing',
            'customers'
        ));
    }

    /**
     * Store a new coupon.
     */
    public function storeCoupon(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'description' => 'nullable|string',
            'apply_to_all' => 'nullable|boolean',
            'products' => 'nullable|array',
            'billing_cycles' => 'nullable|array',
            'customer_type' => 'required|in:all,new,existing',
            'specific_customer_id' => 'nullable|exists:clients,id',
            'once_per_order' => 'nullable|boolean',
            'once_per_client' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Prepare data
        $data = [
            'code' => strtoupper($validated['code']),
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order' => $validated['min_order'] ?? null,
            'max_uses' => $validated['max_uses'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'description' => $validated['description'] ?? null,
            'apply_to_all' => $request->has('apply_to_all'),
            'products' => $request->has('apply_to_all') ? null : ($validated['products'] ?? []),
            'billing_cycles' => $validated['billing_cycles'] ?? [],
            'customer_type' => $validated['customer_type'],
            'specific_customer_id' => $validated['specific_customer_id'] ?? null,
            'once_per_order' => $request->has('once_per_order'),
            'once_per_client' => $request->has('once_per_client'),
            'is_active' => $request->has('is_active'),
        ];

        // Create the coupon
        \App\Models\Coupon::create($data);

        return redirect()->route('admin.system-settings.promotions')->with('success', __('crm.coupon_created'));
    }

    /**
     * Show the campaign creation form.
     */
    public function createCampaign()
    {
        // Get all products from different categories
        $sharedHosting = \App\Models\Product::where('category', 'shared_hosting')->where('is_active', true)->get();
        $cloudHosting = \App\Models\Product::where('category', 'cloud_hosting')->where('is_active', true)->get();
        $resellerHosting = \App\Models\Product::where('category', 'reseller_hosting')->where('is_active', true)->get();
        $vpsPlans = \App\Models\VpsPlan::where('is_active', true)->get();
        $dedicatedPlans = \App\Models\DedicatedPlan::where('is_active', true)->get();
        $domainPricing = \App\Models\DomainPricing::orderBy('tld')->get();
        
        return view('admin.system-settings.promotions-campaign-create', compact(
            'sharedHosting',
            'cloudHosting',
            'resellerHosting',
            'vpsPlans',
            'dedicatedPlans',
            'domainPricing'
        ));
    }

    /**
     * Store a new campaign.
     */
    public function storeCampaign(Request $request)
    {
        // Validate campaign data
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'type' => 'required|in:seasonal,product_launch,loyalty_reward',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'apply_to_all' => 'nullable|boolean',
            'products' => 'nullable|array',
            'billing_cycles' => 'nullable|array',
            'customer_type' => 'required|in:all,new,existing',
            'once_per_order' => 'nullable|boolean',
            'once_per_client' => 'nullable|boolean',
            'banner_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle apply_to_all logic
        $applyToAll = $request->has('apply_to_all') && $request->apply_to_all == '1';
        
        // Prepare campaign data
        $campaignData = [
            'name' => $validated['name_en'], // Keep for backward compatibility
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'type' => $validated['type'],
            'discount_percentage' => $validated['discount_percentage'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description_en'], // Keep for backward compatibility
            'description_en' => $validated['description_en'],
            'description_ar' => $validated['description_ar'],
            'apply_to_all' => $applyToAll,
            'products' => $applyToAll ? null : ($validated['products'] ?? null),
            'billing_cycles' => $validated['billing_cycles'] ?? null,
            'customer_type' => $validated['customer_type'],
            'once_per_order' => $request->has('once_per_order') && $request->once_per_order == '1',
            'once_per_client' => $request->has('once_per_client') && $request->once_per_client == '1',
            'banner_url' => $validated['banner_url'] ?? null,
            'is_active' => $request->has('is_active') && $request->is_active == '1',
        ];

        // Create campaign
        Campaign::create($campaignData);

        return redirect()->route('admin.system-settings.promotions')->with('success', __('crm.campaign_created'));
    }

    /**
     * Show the domain pricing page.
     */
    public function domains()
    {
        $registrars = \App\Models\DomainRegistrar::where('status', true)->get();
        return view('admin.system-settings.domain-pricing', compact('registrars'));
    }

    /**
     * List all domain pricing with Pro Gineous prices.
     */
    public function listDomainPricing(Request $request)
    {
        $currency = $request->get('currency', 'USD');

        $pricing = DomainPricing::where('currency', $currency)
            ->orderBy('tld', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'tld' => $item->tld,
                    'currency' => $item->currency,
                    'is_featured' => $item->is_featured,
                    'progineous_register' => (float) $item->progineous_register,
                    'progineous_renew' => (float) $item->progineous_renew,
                    'progineous_transfer' => (float) $item->progineous_transfer,
                    'progineous_restore' => (float) $item->progineous_restore,
                    'progineous_graceFee' => (float) $item->progineous_graceFee,
                ];
            });

        return response()->json([
            'success' => true,
            'pricing' => $pricing,
            'currency' => $currency,
            'count' => $pricing->count()
        ]);
    }

    /**
     * Toggle featured status for a domain
     */
    public function toggleFeaturedDomain(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:domain_pricing,id',
        ]);

        $domain = DomainPricing::findOrFail($request->id);
        $domain->is_featured = !$domain->is_featured;
        $domain->save();

        return response()->json([
            'success' => true,
            'is_featured' => $domain->is_featured,
            'message' => $domain->is_featured
                ? __('crm.domain_featured_success')
                : __('crm.domain_unfeatured_success')
        ]);
    }

    /**
     * Show the servers page.
     */
    public function servers()
    {
        $servers = \App\Models\Server::orderBy('created_at', 'desc')->get();
        return view('admin.system-settings.servers', compact('servers'));
    }

    /**
     * Show the create server form.
     */
    public function createServer()
    {
        return view('admin.system-settings.servers-create');
    }

    /**
     * Store a new server.
     */
    public function storeServer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'type' => 'required|string|in:cpanel,plesk,directadmin,custom',
            'monthly_cost' => 'nullable|numeric|min:0',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
            'api_token' => 'nullable|string',
            'port_override' => 'nullable|integer|min:1|max:65535',
            'use_ssl' => 'nullable|boolean',
            'port' => 'nullable|integer|min:1|max:65535',
            'max_accounts' => 'nullable|integer|min:0',
            'datacenter' => 'nullable|string|max:255',
            'assigned_ips' => 'nullable|string',
            'nameserver1' => 'nullable|string|max:255',
            'nameserver1_ip' => 'nullable|ip',
            'nameserver2' => 'nullable|string|max:255',
            'nameserver2_ip' => 'nullable|ip',
            'nameserver3' => 'nullable|string|max:255',
            'nameserver3_ip' => 'nullable|ip',
            'nameserver4' => 'nullable|string|max:255',
            'nameserver4_ip' => 'nullable|ip',
            'status' => 'required|boolean',
        ]);

        // Convert checkbox value (use_ssl defaults to true if not present)
        $validated['use_ssl'] = $request->has('use_ssl') ? true : false;

        // Create new server record
        $server = \App\Models\Server::create($validated);

        return redirect()
            ->route('admin.system-settings.servers')
            ->with('success', __('crm.server_added_successfully'));
    }

    /**
     * Show the edit server form.
     */
    public function editServer(\App\Models\Server $server)
    {
        return view('admin.system-settings.servers-edit', compact('server'));
    }

    /**
     * Update server.
     */
    public function updateServer(Request $request, \App\Models\Server $server)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'type' => 'required|in:cpanel,plesk,directadmin,custom',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string',
            'api_token' => 'nullable|string',
            'port_override' => 'nullable|integer',
            'use_ssl' => 'nullable|boolean',
            'nameserver1' => 'nullable|string|max:255',
            'nameserver1_ip' => 'nullable|ip',
            'nameserver2' => 'nullable|string|max:255',
            'nameserver2_ip' => 'nullable|ip',
            'nameserver3' => 'nullable|string|max:255',
            'nameserver3_ip' => 'nullable|ip',
            'nameserver4' => 'nullable|string|max:255',
            'nameserver4_ip' => 'nullable|ip',
            'max_accounts' => 'nullable|integer',
            'monthly_cost' => 'nullable|numeric',
            'assigned_ips' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Don't update password if empty
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $server->update($validated);

        return redirect()
            ->route('admin.system-settings.servers')
            ->with('success', 'تم تحديث السيرفر بنجاح!');
    }

    /**
     * Delete server.
     */
    public function deleteServer(\App\Models\Server $server)
    {
        $server->delete();

        return redirect()
            ->route('admin.system-settings.servers')
            ->with('success', 'تم حذف السيرفر بنجاح!');
    }

    /**
     * Test server connection.
     */
    public function testConnection(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'hostname' => 'required|string',
            'ip_address' => 'required|ip',
            'type' => 'required|string|in:cpanel,plesk,directadmin,custom',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'api_token' => 'nullable|string',
            'port_override' => 'nullable|integer',
            'use_ssl' => 'nullable|boolean',
            'server_id' => 'nullable|integer|exists:servers,id',
        ]);

        // If password and api_token are empty, try to get them from database
        if (empty($validated['password']) && empty($validated['api_token']) && !empty($validated['server_id'])) {
            $server = \App\Models\Server::find($validated['server_id']);
            if ($server) {
                $validated['password'] = $server->password;
                $validated['api_token'] = $server->api_token;
            }
        }

        // At least one authentication method is required
        if (empty($validated['password']) && empty($validated['api_token'])) {
            return response()->json([
                'success' => false,
                'message' => __('crm.password_or_api_token_required')
            ], 422);
        }

        try {
            $serverType = $validated['type'];

            // Test real API connection based on server type
            switch ($serverType) {
                case 'cpanel':
                    $result = $this->testCPanelConnection($validated);
                    break;

                case 'plesk':
                    $result = $this->testPleskConnection($validated);
                    break;

                case 'directadmin':
                    $result = $this->testDirectAdminConnection($validated);
                    break;

                default:
                    $result = $this->testBasicConnection($validated);
                    break;
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('crm.connection_error') . ': ' . $e->getMessage()
            ], 200);
        }
    }

    /**
     * Test cPanel/WHM connection using real API.
     */
    private function testCPanelConnection($credentials)
    {
        $hostname = $credentials['hostname'];
        $port = $credentials['port_override'] ?? 2087;
        $useSSL = $credentials['use_ssl'] ?? true;
        $protocol = $useSSL ? 'https' : 'http';
        $username = $credentials['username'];
        $password = $credentials['password'];
        $apiToken = $credentials['api_token'] ?? null;

        // WHM API v1 endpoint - using 'listaccts' which is available in all WHM versions
        // We'll extract version from metadata which is always present
        $apiUrl = "{$protocol}://{$hostname}:{$port}/json-api/listaccts?api.version=1";

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            // Set authentication
            if ($apiToken) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: whm {$username}:" . $apiToken
                ]);
            } else {
                curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");
            }

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            $connectTime = curl_getinfo($ch, CURLINFO_CONNECT_TIME);
            curl_close($ch);

            // Check for connection errors
            if ($curlError) {
                return [
                    'success' => false,
                    'message' => __('crm.connection_failed') . ': ' . $curlError
                ];
            }

            // Check HTTP response
            if ($httpCode == 0) {
                return [
                    'success' => false,
                    'message' => __('crm.connection_failed') . ': ' . __('crm.server_unreachable')
                ];
            }

            // Authentication failed
            if ($httpCode == 401 || $httpCode == 403) {
                return [
                    'success' => false,
                    'message' => __('crm.connection_failed') . ': ' . __('crm.authentication_failed')
                ];
            }

            // Success - parse response
            if ($httpCode == 200 && $response) {
                $data = json_decode($response, true);

                // WHM API returns HTTP 200 even on auth failures!
                // Check metadata.result: 1 = success, 0 = failure
                if (isset($data['metadata']['result']) && $data['metadata']['result'] == 0) {
                    // Authentication or API error
                    $errorMsg = $data['metadata']['reason'] ?? __('crm.api_call_failed');
                    return [
                        'success' => false,
                        'message' => __('crm.connection_failed') . ': ' . $errorMsg
                    ];
                }

                $serverInfo = [];

                // Get actual cPanel/WHM version using /json-api/version endpoint
                $versionUrl = "{$protocol}://{$hostname}:{$port}/json-api/version";
                $chVersion = curl_init($versionUrl);
                curl_setopt($chVersion, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chVersion, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($chVersion, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($chVersion, CURLOPT_TIMEOUT, 10);

                // Use same authentication as main request
                if (!empty($apiToken)) {
                    curl_setopt($chVersion, CURLOPT_HTTPHEADER, [
                        "Authorization: whm {$username}:" . $apiToken
                    ]);
                } else {
                    curl_setopt($chVersion, CURLOPT_USERPWD, "{$username}:{$password}");
                }

                $versionResponse = curl_exec($chVersion);
                $versionData = json_decode($versionResponse, true);
                curl_close($chVersion);

                // Extract version from /json-api/version response
                if (isset($versionData['version'])) {
                    $serverInfo['version'] = 'cPanel/WHM ' . $versionData['version'];
                } else {
                    // Fallback: show that we have API access but version unknown
                    $serverInfo['version'] = 'cPanel/WHM (API v' . ($data['metadata']['version'] ?? '1') . ')';
                }

                // Count cPanel accounts to verify real API connection
                $accountsCount = 0;
                if (isset($data['data']['acct']) && is_array($data['data']['acct'])) {
                    $accountsCount = count($data['data']['acct']);
                    $serverInfo['cpanel_accounts'] = $accountsCount . ' ' . __('crm.accounts');
                } else {
                    // If no accounts data, it means auth might have failed
                    $serverInfo['cpanel_accounts'] = __('crm.not_available');
                }

                // Get additional system info
                $serverInfo['response_time'] = round($connectTime * 1000) . ' ms';

                // Add connection details for debugging
                $serverInfo['api_endpoint'] = '/json-api/listaccts';

                return [
                    'success' => true,
                    'message' => __('crm.connection_successful') . ' - ' . __('crm.whm_api_connected'),
                    'server_info' => $serverInfo
                ];
            }

            // Other HTTP errors
            return [
                'success' => false,
                'message' => __('crm.connection_failed') . ": HTTP {$httpCode}"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('crm.connection_error') . ': ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test Plesk connection.
     */
    private function testPleskConnection($credentials)
    {
        return $this->testBasicConnection($credentials, 8443);
    }

    /**
     * Test DirectAdmin connection.
     */
    private function testDirectAdminConnection($credentials)
    {
        return $this->testBasicConnection($credentials, 2222);
    }

    /**
     * Test basic HTTP/HTTPS connectivity.
     */
    private function testBasicConnection($credentials, $defaultPort = null)
    {
        $hostname = $credentials['hostname'];
        $port = $credentials['port_override'] ?? $defaultPort ?? 2087;
        $useSSL = $credentials['use_ssl'] ?? true;
        $protocol = $useSSL ? 'https' : 'http';
        $url = "{$protocol}://{$hostname}:{$port}";

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FOLLOWLOCATION => true,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return [
                    'success' => false,
                    'message' => __('crm.connection_failed') . ': ' . $error
                ];
            }

            if ($httpCode == 0) {
                return [
                    'success' => false,
                    'message' => __('crm.connection_failed') . ': لا يمكن الوصول للسيرفر'
                ];
            }

            return [
                'success' => true,
                'message' => __('crm.connection_successful') . " (HTTP {$httpCode})",
                'server_info' => ['version' => 'متصل ✓']
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('crm.connection_error') . ': ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get default port for server type.
     */
    private function getDefaultPort($type)
    {
        return match($type) {
            'cpanel' => 2087,
            'plesk' => 8443,
            'directadmin' => 2222,
            default => 2087,
        };
    }

    /**
     * Get server information based on type.
     */
    private function getServerInfo($type, $credentials)
    {
        $info = [];

        try {
            switch ($type) {
                case 'cpanel':
                    $info = $this->getCPanelInfo($credentials);
                    break;

                case 'plesk':
                    $info['version'] = 'Plesk (API check not implemented)';
                    break;

                case 'directadmin':
                    $info['version'] = 'DirectAdmin (API check not implemented)';
                    break;

                default:
                    $info['version'] = 'Custom Server';
            }
        } catch (\Exception $e) {
            // If API check fails, just return basic connectivity success
        }

        return $info;
    }

    /**
     * Get cPanel/WHM server information via API.
     */
    private function getCPanelInfo($credentials)
    {
        $info = [];

        try {
            $hostname = $credentials['hostname'];
            $port = $credentials['port_override'] ?? 2087;
            $useSSL = $credentials['use_ssl'] ?? true;
            $protocol = $useSSL ? 'https' : 'http';

            // Use API Token if provided, otherwise use password
            $apiToken = $credentials['api_token'] ?? null;
            $username = $credentials['username'];
            $password = $credentials['password'];

            // WHM API endpoint to get version
            $apiUrl = "{$protocol}://{$hostname}:{$port}/json-api/version";

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            // Set authentication
            if ($apiToken) {
                // Using API Token (preferred method)
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: whm {$username}:" . $apiToken
                ]);
            } else {
                // Using username:password
                curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");
            }

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200 && $response) {
                $data = json_decode($response, true);

                if (isset($data['version'])) {
                    $info['version'] = 'cPanel/WHM ' . $data['version'];
                } else {
                    $info['version'] = 'cPanel/WHM (Connected ✓)';
                }

                // Try to get additional info
                $info['os'] = $data['metadata']['os'] ?? 'Linux';
            } else {
                // Connection successful but API failed
                $info['version'] = 'cPanel/WHM (API Auth Failed)';
            }

        } catch (\Exception $e) {
            $info['version'] = 'cPanel/WHM (Connected, API Error: ' . $e->getMessage() . ')';
        }

        return $info;
    }

    /**
     * Show the support departments page.
     */
    public function departments()
    {
        return view('admin.system-settings.departments');
    }

    /**
     * Show the email templates page.
     */
    public function emails()
    {
        return view('admin.system-settings.emails');
    }

    /**
     * Show the client groups page.
     */
    public function clientGroups()
    {
        return view('admin.system-settings.client-groups');
    }

    /**
     * Show the order statuses page.
     */
    public function orderStatuses()
    {
        return view('admin.system-settings.order-statuses');
    }

    /**
     * Show the banned IPs page.
     */
    public function bannedIps()
    {
        return view('admin.system-settings.banned-ips');
    }

    /**
     * Show the sign-in integrations page.
     */
    public function signInIntegrations()
    {
        return view('admin.system-settings.sign-in-integrations');
    }

    /**
     * Show the payment gateways page.
     */
    public function paymentGateways()
    {
        return view('admin.system-settings.payment-gateways');
    }

    /**
     * Show the domain registrars page.
     */
    public function domainRegistrars()
    {
        $registrars = \App\Models\DomainRegistrar::all();
        return view('admin.system-settings.domain-registrars', compact('registrars'));
    }

    /**
     * Show the Dynadot configuration page.
     */
    public function configureDynadot()
    {
        // Get existing Dynadot configuration
        $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->first();

        return view('admin.system-settings.domain-registrars-dynadot', compact('registrar'));
    }

    /**
     * Store Dynadot configuration.
     */
    public function storeDynadot(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'test_mode' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'preferred_coupons' => 'nullable|array',
            'preferred_coupons.*.type' => 'nullable|string|in:registration,renewal,transfer',
            'preferred_coupons.*.code' => 'nullable|string|max:100',
        ]);

        // Filter out empty coupons
        $preferredCoupons = [];
        if (isset($validated['preferred_coupons'])) {
            foreach ($validated['preferred_coupons'] as $coupon) {
                if (!empty($coupon['code'])) {
                    $preferredCoupons[] = [
                        'type' => $coupon['type'] ?? 'registration',
                        'code' => trim($coupon['code'])
                    ];
                }
            }
        }

        // Check if Dynadot registrar already exists
        $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->first();

        if ($registrar) {
            // Update existing
            $registrar->update([
                'name' => $validated['name'],
                'api_key' => $validated['api_key'],
                'api_secret' => $validated['api_secret'],
                'test_mode' => $request->has('test_mode'),
                'status' => $request->has('status'),
                'preferred_coupons' => !empty($preferredCoupons) ? json_encode($preferredCoupons) : null,
            ]);
            $message = 'Dynadot configuration updated successfully!';
        } else {
            // Create new
            \App\Models\DomainRegistrar::create([
                'name' => $validated['name'],
                'type' => 'dynadot',
                'api_key' => $validated['api_key'],
                'api_secret' => $validated['api_secret'],
                'test_mode' => $request->has('test_mode'),
                'status' => $request->has('status'),
                'preferred_coupons' => !empty($preferredCoupons) ? json_encode($preferredCoupons) : null,
            ]);
            $message = 'Dynadot configuration saved successfully!';
        }

        return redirect()->route('admin.system-settings.domain-registrars')->with('success', $message);
    }

    /**
     * Test Dynadot API connection
     */
    public function testDynadotConnection(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
        ]);

        try {
            $service = new \App\Services\DynadotService();
            $service->setCredentials(
                $validated['api_key'],
                $validated['api_secret'],
                false // Test with production API
            );

            $result = $service->testConnection();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Fetch available Dynadot coupons
     */
    public function fetchDynadotCoupons(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'coupon_type' => 'required|string|in:registration,renewal,transfer',
        ]);

        try {
            $service = new \App\Services\DynadotService();
            $service->setCredentials(
                $validated['api_key'],
                $validated['api_secret'],
                false // Use production API
            );

            $coupons = $service->listCoupons($validated['coupon_type']);

            // Log for debugging
            Log::info('Dynadot Coupons Response', [
                'type' => $validated['coupon_type'],
                'count' => count($coupons),
                'coupons' => $coupons
            ]);

            // Translate coupon type
            $typeTranslations = [
                'registration' => __('crm.registration'),
                'renewal' => __('crm.renewal'),
                'transfer' => __('crm.transfer')
            ];

            $typeName = $typeTranslations[$validated['coupon_type']] ?? $validated['coupon_type'];

            return response()->json([
                'success' => true,
                'coupons' => $coupons,
                'type' => $validated['coupon_type'],
                'count' => count($coupons),
                'message' => count($coupons) > 0
                    ? __('crm.found_coupons', ['count' => count($coupons)])
                    : __('crm.no_coupons_for_type', ['type' => $typeName])
            ]);
        } catch (\Exception $e) {
            Log::error('Dynadot Coupons Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('crm.failed_fetch_coupons') . ': ' . $e->getMessage(),
                'coupons' => []
            ]);
        }
    }

    /**
     * Show the currencies page.
     */
    public function currencies()
    {
        return view('admin.system-settings.currencies');
    }

    /**
     * Show the tax configuration page.
     */
    public function taxConfiguration()
    {
        return view('admin.system-settings.tax-configuration');
    }

    /**
     * Show the administrator users page.
     */
    public function administratorUsers()
    {
        return view('admin.system-settings.administrator-users');
    }

    /**
     * Show the administrator roles & permissions page.
     */
    public function administratorRoles()
    {
        return view('admin.system-settings.administrator-roles');
    }

    /**
     * Show the domain pricing page.
     */
    /**
     * Show the Dynadot pricing page.
     */
    public function dynadotPricing()
    {
        $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->where('status', true)->first();

        if (!$registrar) {
            return redirect()->route('admin.system-settings.domains')
                ->with('error', 'Dynadot is not configured or not active.');
        }

        return view('admin.system-settings.domain-pricing-dynadot', compact('registrar'));
    }

    /**
     * Fetch Dynadot TLD pricing from API.
     */
    public function fetchDynadotPricing(\Illuminate\Http\Request $request)
    {
        $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->where('status', true)->first();

        if (!$registrar) {
            return response()->json(['success' => false, 'message' => 'Dynadot is not configured or not active.']);
        }

        try {
            $service = new \App\Services\DynadotService($registrar);
            $currency = $request->input('currency', 'USD');
            $pricing = $service->getTLDPricing($currency);

            // Log for debugging
            Log::info('Dynadot Pricing Response', ['pricing_count' => count($pricing), 'sample' => array_slice($pricing, 0, 3, true)]);

            return response()->json([
                'success' => true,
                'pricing' => $pricing,
                'currency' => $currency
            ]);
        } catch (\Exception $e) {
            Log::error('Dynadot Pricing Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pricing: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save Dynadot pricing with Pro Gineous markup.
     */
    public function saveDynadotPricing(\Illuminate\Http\Request $request)
    {
        try {
            $validated = $request->validate([
                'pricing' => 'required|array',
                'pricing.*.tld' => 'required|string',
                'pricing.*.dynadot_register' => 'nullable|numeric|min:0',
                'pricing.*.dynadot_renew' => 'nullable|numeric|min:0',
                'pricing.*.dynadot_transfer' => 'nullable|numeric|min:0',
                'pricing.*.dynadot_restore' => 'nullable|numeric|min:0',
                'pricing.*.dynadot_graceFee' => 'nullable|numeric|min:0',
                'pricing.*.progineous_register' => 'required|numeric|min:0',
                'pricing.*.progineous_renew' => 'required|numeric|min:0',
                'pricing.*.progineous_transfer' => 'required|numeric|min:0',
                'pricing.*.progineous_restore' => 'required|numeric|min:0',
                'pricing.*.progineous_graceFee' => 'required|numeric|min:0',
                'settings' => 'nullable|array',
                'settings.currency' => 'nullable|string|in:USD,EUR,GBP',
            ]);

            // Get Dynadot registrar
            $dynadotRegistrar = DomainRegistrar::where('name', 'Dynadot')->first();

            if (!$dynadotRegistrar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dynadot registrar not found in database!'
                ], 404);
            }

            $currency = $validated['settings']['currency'] ?? 'USD';
            $savedCount = 0;

            // Save each TLD pricing
            foreach ($validated['pricing'] as $pricingData) {
                DomainPricing::updateOrCreate(
                    [
                        'tld' => $pricingData['tld'],
                        'registrar_id' => $dynadotRegistrar->id,
                        'currency' => $currency,
                    ],
                    [
                        'dynadot_register' => $pricingData['dynadot_register'] ?? 0,
                        'dynadot_renew' => $pricingData['dynadot_renew'] ?? 0,
                        'dynadot_transfer' => $pricingData['dynadot_transfer'] ?? 0,
                        'dynadot_restore' => $pricingData['dynadot_restore'] ?? 0,
                        'dynadot_graceFee' => $pricingData['dynadot_graceFee'] ?? 0,
                        'progineous_register' => $pricingData['progineous_register'],
                        'progineous_renew' => $pricingData['progineous_renew'],
                        'progineous_transfer' => $pricingData['progineous_transfer'],
                        'progineous_restore' => $pricingData['progineous_restore'],
                        'progineous_graceFee' => $pricingData['progineous_graceFee'],
                    ]
                );

                $savedCount++;
            }

            Log::info("Dynadot Pricing Saved", [
                'total_tlds' => $savedCount,
                'currency' => $currency,
                'registrar' => $dynadotRegistrar->name,
                'settings' => $validated['settings'] ?? []
            ]);

            return response()->json([
                'success' => true,
                'message' => __('crm.tlds_saved_successfully', ['count' => $savedCount]),
                'data' => [
                    'saved_count' => $savedCount,
                    'currency' => $currency
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Dynadot Pricing Validation Failed", [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_map(fn($err) => implode(', ', $err), $e->errors()))
            ], 422);

        } catch (\Exception $e) {
            Log::error("Dynadot Pricing Save Error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save pricing: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a shared hosting product details.
     */
    public function showSharedHosting(Product $product)
    {
        // Ensure the product is a shared hosting product
        if ($product->category !== 'shared_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        return view('admin.system-settings.products-shared-hosting-show', compact('product'));
    }

    /**
     * Show the form for editing a shared hosting product.
     */
    public function editSharedHosting(Product $product)
    {
        // Ensure the product is a shared hosting product
        if ($product->category !== 'shared_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $servers = \App\Models\Server::where('status', true)->get();
        $registrars = DomainRegistrar::where('status', true)->get();
        $emailTemplates = EmailTemplate::all();

        return view('admin.system-settings.products-shared-hosting-edit', compact('product', 'servers', 'registrars', 'emailTemplates'));
    }

    /**
     * Update a shared hosting product.
     */
    public function updateSharedHosting(Request $request, Product $product)
    {
        // Ensure the product is a shared hosting product
        if ($product->category !== 'shared_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $validated = $request->validate([
            // Plan Details
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'welcome_email' => 'nullable|string',

            // Product Options
            'require_domain' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'hidden' => 'nullable|boolean',
            'allow_multiple_quantities' => 'nullable|boolean',

            // Payment & Pricing
            'payment_type' => 'required|in:free,one_time,recurring',

            // One Time pricing
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'one_time_price' => 'nullable|numeric|min:0',

            // Recurring pricing
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',

            // Server & Setup
            'server_id' => 'required|exists:servers,id',
            'whm_package_name' => 'required|string|max:255',
            'auto_setup' => 'required|in:on_order,on_payment,on_accept,manual',

            // Free Domain
            'free_domain_type' => 'nullable|string|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_terms.*' => 'string|in:one_time,monthly,quarterly,semi_annually,annually,biennially,triennially',
            'free_domain_tlds' => 'nullable|array',
            'free_domain_tlds.*' => 'string',

            // Datacenter Locations & Pricing
            'datacenter_locations' => 'nullable|array',
            'datacenter_locations.*' => 'string',
            'datacenter_price' => 'nullable|array',
            'datacenter_price.*' => 'numeric|min:0|max:9999.99',
        ]);

        // Custom validation: If require_domain is checked, free_domain_type cannot be 'none'
        if (isset($validated['require_domain']) && $validated['require_domain']) {
            $freeDomainType = $validated['free_domain_type'] ?? 'none';

            if ($freeDomainType === 'none') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'free_domain_type' => app()->getLocale() === 'ar'
                            ? 'عند تفعيل "Require Domain"، يجب عليك اختيار خيار نطاق مجاني (تسجيل نطاق جديد أو تسجيل + تجديد). لا يمكن تحديث الخطة بدون اختيار خيار النطاق المجاني.'
                            : 'When "Require Domain" is enabled, you must select a free domain option (Registration/Transfer or Registration/Transfer + Renewal). Cannot update the plan without selecting a free domain option.'
                    ]);
            }
        }

        // Prepare pricing data - Only save recurring periods with actual pricing
        // This prevents database bloat from storing 6 periods with mostly zeros
        $pricing = [
            'one_time' => [
                'setup_fee' => $validated['one_time_setup_fee'] ?? 0,
                'price' => $validated['one_time_price'] ?? 0,
            ],
            'recurring' => [],
        ];

        // Only add recurring periods that have a setup fee or price
        $recurringPeriods = ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'];
        foreach ($recurringPeriods as $period) {
            $setupFee = $validated["{$period}_setup_fee"] ?? 0;
            $price = $validated["{$period}_price"] ?? 0;

            // Only add this period if there's a price or setup fee
            if ($setupFee > 0 || $price > 0) {
                $pricing['recurring'][$period] = [
                    'setup_fee' => $setupFee,
                    'price' => $price,
                ];
            }
        }

        // Prepare free domain configuration
        $freeDomainConfig = null;
        if (isset($validated['free_domain_type']) && $validated['free_domain_type'] !== 'none') {
            $freeDomainConfig = [
                'type' => $validated['free_domain_type'],
                'terms' => $validated['free_domain_terms'] ?? [],
                'tlds' => $validated['free_domain_tlds'] ?? [],
            ];
        }

        // Calculate default price
        $defaultPrice = 0;
        if ($validated['payment_type'] === 'recurring') {
            $defaultPrice = $validated['monthly_price'] ?? 0;
        } elseif ($validated['payment_type'] === 'one_time') {
            $defaultPrice = $validated['one_time_price'] ?? 0;
        }

        // Update the product
        $product->update([
            'name' => $validated['plan_name'],
            'tagline' => $validated['plan_tagline'],
            'description' => $validated['plan_short_description'],
            'short_description' => $validated['plan_short_description'],
            'features_list' => $validated['plan_feature'],
            'features_list_ar' => $request->plan_feature_ar,
            'welcome_email' => $validated['welcome_email'],
            'price' => $defaultPrice,
            'billing_cycle' => $validated['payment_type'] === 'recurring' ? 'monthly' : 'one_time',
            'payment_type' => $validated['payment_type'],
            'pricing' => $pricing,
            'require_domain' => $validated['require_domain'] ?? false,
            'is_featured' => $validated['featured'] ?? false,
            'is_hidden' => $validated['hidden'] ?? false,
            'allow_multiple_quantities' => $validated['allow_multiple_quantities'] ?? false,
            'server_id' => $validated['server_id'],
            'whm_package_name' => $validated['whm_package_name'],
            'auto_setup' => $validated['auto_setup'],
            'free_domain_config' => $freeDomainConfig,
            'datacenter_locations' => $validated['datacenter_locations'] ?? [],
            'datacenter_price' => $validated['datacenter_price'] ?? [],
        ]);

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', __('crm.plan_updated_successfully'))
            ->withFragment('shared_hosting');
    }

    /**
     * Delete a shared hosting product.
     */
    public function destroySharedHosting(Product $product)
    {
        // Ensure the product is a shared hosting product
        if ($product->category !== 'shared_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $productName = $product->name;
        $product->delete();

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar'
                ? "تم حذف الخطة \"{$productName}\" بنجاح"
                : "Plan \"{$productName}\" deleted successfully"
            );
    }

    // ==========================================
    // Cloud Hosting Plans Methods
    // ==========================================

    /**
     * Show the create cloud hosting plan form.
     */
    public function createCloudHosting()
    {
        $servers = Server::where('status', 1)->get();
        $emailTemplates = EmailTemplate::all();
        return view('admin.system-settings.products-cloud-hosting-create', compact('servers', 'emailTemplates'));
    }

    /**
     * Store a new cloud hosting plan.
     */
    public function storeCloudHosting(Request $request)
    {
        // نفس validation الـ Shared Hosting بالضبط
        $validated = $request->validate([
            // Plan Details
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'welcome_email' => 'nullable|string',

            // Product Options
            'require_domain' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'hidden' => 'nullable|boolean',
            'allow_multiple_quantities' => 'nullable|boolean',

            // Payment & Pricing
            'payment_type' => 'required|in:free,one_time,recurring',

            // One Time pricing
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'one_time_price' => 'nullable|numeric|min:0',

            // Recurring pricing
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',

            // Server & Setup
            'server_id' => 'required|exists:servers,id',
            'whm_package_name' => 'required|string|max:255',
            'auto_setup' => 'required|in:on_order,on_payment,on_accept,manual',

            // Free Domain
            'free_domain_type' => 'nullable|string|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_terms.*' => 'string|in:one_time,monthly,quarterly,semi_annually,annually,biennially,triennially',
            'free_domain_tlds' => 'nullable|array',
            'free_domain_tlds.*' => 'string',

            // Datacenter Locations & Pricing
            'datacenter_locations' => 'nullable|array',
            'datacenter_locations.*' => 'string',
            'datacenter_price' => 'nullable|array',
            'datacenter_price.*' => 'numeric|min:0|max:9999.99',
        ]);

        // Custom validation: If require_domain is checked, free_domain_type cannot be 'none'
        if (isset($validated['require_domain']) && $validated['require_domain']) {
            $freeDomainType = $validated['free_domain_type'] ?? 'none';

            if ($freeDomainType === 'none') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'free_domain_type' => app()->getLocale() === 'ar'
                            ? 'عند تفعيل "Require Domain"، يجب عليك اختيار خيار نطاق مجاني (تسجيل نطاق جديد أو تسجيل + تجديد). لا يمكن إنشاء الخطة بدون اختيار خيار النطاق المجاني.'
                            : 'When "Require Domain" is enabled, you must select a free domain option (Registration/Transfer or Registration/Transfer + Renewal). Cannot create the plan without selecting a free domain option.'
                    ]);
            }
        }

        // Prepare pricing data
        $pricing = [
            'one_time' => [
                'setup_fee' => $validated['one_time_setup_fee'] ?? 0,
                'price' => $validated['one_time_price'] ?? 0,
            ],
            'recurring' => [],
        ];

        // Only include recurring periods that have pricing
        $recurringPeriods = ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'];
        foreach ($recurringPeriods as $period) {
            $setupFee = $validated["{$period}_setup_fee"] ?? 0;
            $price = $validated["{$period}_price"] ?? 0;

            // Only add if there's a price or setup fee
            if ($setupFee > 0 || $price > 0) {
                $pricing['recurring'][$period] = [
                    'setup_fee' => $setupFee,
                    'price' => $price,
                ];
            }
        }

        // Prepare free domain configuration
        $freeDomainConfig = null;
        if (isset($validated['free_domain_type']) && $validated['free_domain_type'] !== 'none') {
            $freeDomainConfig = [
                'type' => $validated['free_domain_type'],
                'terms' => $validated['free_domain_terms'] ?? [],
                'tlds' => $validated['free_domain_tlds'] ?? [],
            ];
        }

        // Calculate default price (use monthly if recurring, one_time if one_time payment)
        $defaultPrice = 0;
        if ($validated['payment_type'] === 'recurring') {
            $defaultPrice = $validated['monthly_price'] ?? 0;
        } elseif ($validated['payment_type'] === 'one_time') {
            $defaultPrice = $validated['one_time_price'] ?? 0;
        }

        // Create the product - نفس الحقول بالضبط زي Shared Hosting
        $product = Product::create([
            'name' => $validated['plan_name'],
            'tagline' => $validated['plan_tagline'],
            'type' => 'hosting',
            'category' => 'cloud_hosting', // الفرق الوحيد!
            'description' => $validated['plan_short_description'],
            'short_description' => $validated['plan_short_description'],
            'features_list' => $validated['plan_feature'],
            'features_list_ar' => $request->plan_feature_ar,
            'welcome_email' => $validated['welcome_email'],
            'price' => $defaultPrice,
            'billing_cycle' => $validated['payment_type'] === 'recurring' ? 'monthly' : 'one_time',
            'payment_type' => $validated['payment_type'],
            'pricing' => $pricing,
            'require_domain' => $validated['require_domain'] ?? false,
            'is_active' => true,
            'is_featured' => $validated['featured'] ?? false,
            'is_hidden' => $validated['hidden'] ?? false,
            'allow_multiple_quantities' => $validated['allow_multiple_quantities'] ?? false,
            'server_id' => $validated['server_id'],
            'whm_package_name' => $validated['whm_package_name'],
            'auto_setup' => $validated['auto_setup'],
            'free_domain_config' => $freeDomainConfig,
            'datacenter_locations' => $validated['datacenter_locations'] ?? [],
            'datacenter_price' => $validated['datacenter_price'] ?? [],
        ]);

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar'
                ? "تم إنشاء خطة \"{$product->name}\" بنجاح"
                : "Plan \"{$product->name}\" created successfully"
            )
            ->withFragment('cloud_hosting');
    }

    /**
     * Show a cloud hosting product details.
     */
    public function showCloudHosting(Product $product)
    {
        if ($product->category !== 'cloud_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        return view('admin.system-settings.products-cloud-hosting-show', compact('product'));
    }

    /**
     * Show the form for editing a cloud hosting product.
     */
    public function editCloudHosting(Product $product)
    {
        if ($product->category !== 'cloud_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $servers = Server::where('status', 1)->get();
        $registrars = DomainRegistrar::where('status', 1)->get();
        $emailTemplates = EmailTemplate::all();

        return view('admin.system-settings.products-cloud-hosting-edit', compact('product', 'servers', 'registrars', 'emailTemplates'));
    }

    /**
     * Update a cloud hosting product.
     */
    public function updateCloudHosting(Request $request, Product $product)
    {
        \Illuminate\Support\Facades\Log::info('updateCloudHosting called', [
            'product_id' => $product->id,
            'request_data' => $request->all()
        ]);

        if ($product->category !== 'cloud_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'server_id' => 'nullable|exists:servers,id',
            'whm_package_name' => 'nullable|string|max:255',
            'payment_type' => 'required|in:free,one_time,recurring',
            'one_time_price' => 'nullable|numeric|min:0',
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'datacenter_locations' => 'nullable|array',
            'datacenter_price' => 'nullable|array',
            'require_domain' => 'nullable|boolean',
            'free_domain_type' => 'nullable|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_tlds' => 'nullable|array',
            'welcome_email' => 'nullable|string',
            'allow_multiple_quantities' => 'nullable|boolean',
            'auto_setup' => 'nullable|in:on_accept,on_order,on_payment,manual,disabled',
            'featured' => 'nullable|boolean',
            'hidden' => 'nullable|boolean',
        ]);

        \Illuminate\Support\Facades\Log::info('Validation passed', ['validated' => $validated]);

        // Build pricing structure
        $pricing = [
            'one_time' => [
                'price' => $request->one_time_price ?? 0,
                'setup_fee' => $request->one_time_setup_fee ?? 0,
            ],
            'recurring' => [
                'monthly' => [
                    'price' => $request->monthly_price ?? 0,
                    'setup_fee' => $request->monthly_setup_fee ?? 0,
                ],
                'quarterly' => [
                    'price' => $request->quarterly_price ?? 0,
                    'setup_fee' => $request->quarterly_setup_fee ?? 0,
                ],
                'semi_annually' => [
                    'price' => $request->semi_annually_price ?? 0,
                    'setup_fee' => $request->semi_annually_setup_fee ?? 0,
                ],
                'annually' => [
                    'price' => $request->annually_price ?? 0,
                    'setup_fee' => $request->annually_setup_fee ?? 0,
                ],
                'biennially' => [
                    'price' => $request->biennially_price ?? 0,
                    'setup_fee' => $request->biennially_setup_fee ?? 0,
                ],
                'triennially' => [
                    'price' => $request->triennially_price ?? 0,
                    'setup_fee' => $request->triennially_setup_fee ?? 0,
                ],
            ],
        ];

        // Determine default price based on payment type
        $defaultPrice = 0;
        if ($request->payment_type === 'one_time') {
            $defaultPrice = $request->one_time_price ?? 0;
        } elseif ($request->payment_type === 'recurring') {
            $defaultPrice = $request->monthly_price ?? 0;
        }

        // Build free domain config
        $freeDomainConfig = null;
        if ($request->free_domain_type && $request->free_domain_type !== 'none') {
            $freeDomainConfig = [
                'type' => $request->free_domain_type,
                'terms' => $request->free_domain_terms ?? [],
                'tlds' => $request->free_domain_tlds ?? [],
            ];
        }

        // Build datacenter price mapping
        $datacenterPrice = [];
        if ($request->datacenter_locations && is_array($request->datacenter_locations)) {
            foreach ($request->datacenter_locations as $location) {
                $datacenterPrice[$location] = $request->input("datacenter_price.{$location}", 0);
            }
        }

        // Update product
        $product->update([
            'name' => $request->plan_name,
            'tagline' => $request->plan_tagline,
            'description' => $request->plan_short_description,
            'features_list' => $request->plan_feature,
            'features_list_ar' => $request->plan_feature_ar,
            'server_id' => $request->server_id,
            'whm_package_name' => $request->whm_package_name,
            'payment_type' => $request->payment_type,
            'pricing' => $pricing,
            'datacenter_locations' => $request->datacenter_locations ?? [],
            'datacenter_price' => $datacenterPrice,
            'require_domain' => $request->require_domain ?? false,
            'free_domain_config' => $freeDomainConfig,
            'welcome_email' => $request->welcome_email,
            'allow_multiple_quantities' => $request->allow_multiple_quantities ?? false,
            'auto_setup' => $request->auto_setup ?? 'disabled',
            'is_featured' => $request->featured ?? false,
            'is_hidden' => $request->hidden ?? false,
        ]);

        \Illuminate\Support\Facades\Log::info('Product updated successfully', ['product_id' => $product->id]);

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar'
                ? "تم تحديث الخطة \"{$product->name}\" بنجاح"
                : "Plan \"{$product->name}\" updated successfully"
            )
            ->withFragment('cloud_hosting');
    }

    /**
     * Delete a cloud hosting product.
     */
    public function destroyCloudHosting(Product $product)
    {
        if ($product->category !== 'cloud_hosting') {
            return redirect()
                ->route('admin.system-settings.products')
                ->with('error', __('crm.invalid_product_type'));
        }

        $productName = $product->name;
        $product->delete();

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar'
                ? "تم حذف الخطة \"{$productName}\" بنجاح"
                : "Plan \"{$productName}\" deleted successfully"
            );
    }

    // ============================================
    // Reseller Hosting Plans Methods
    // ============================================

    public function createResellerHosting()
    {
        $servers = \App\Models\Server::where('status', true)
            ->orderBy('name')
            ->get();

        $emailTemplates = EmailTemplate::all();

        return view('admin.system-settings.products-reseller-hosting-create', compact('servers', 'emailTemplates'));
    }

    public function storeResellerHosting(Request $request)
    {
        $validated = $request->validate([
            // Plan Details
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'welcome_email' => 'nullable|string',

            // Product Options
            'require_domain' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'hidden' => 'nullable|boolean',
            'allow_multiple_quantities' => 'nullable|boolean',

            // Payment & Pricing
            'payment_type' => 'required|in:free,one_time,recurring',

            // One Time pricing
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'one_time_price' => 'nullable|numeric|min:0',

            // Recurring pricing
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',

            // cPanel Accounts
            'base_cpanel_accounts' => 'required|integer|min:0',
            'enable_cpanel_tiers' => 'nullable|boolean',
            'cpanel_50_monthly' => 'nullable|numeric|min:0',
            'cpanel_50_quarterly' => 'nullable|numeric|min:0',
            'cpanel_50_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_50_annually' => 'nullable|numeric|min:0',
            'cpanel_50_biennially' => 'nullable|numeric|min:0',
            'cpanel_50_triennially' => 'nullable|numeric|min:0',
            'cpanel_100_monthly' => 'nullable|numeric|min:0',
            'cpanel_100_quarterly' => 'nullable|numeric|min:0',
            'cpanel_100_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_100_annually' => 'nullable|numeric|min:0',
            'cpanel_100_biennially' => 'nullable|numeric|min:0',
            'cpanel_100_triennially' => 'nullable|numeric|min:0',
            'cpanel_200_monthly' => 'nullable|numeric|min:0',
            'cpanel_200_quarterly' => 'nullable|numeric|min:0',
            'cpanel_200_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_200_annually' => 'nullable|numeric|min:0',
            'cpanel_200_biennially' => 'nullable|numeric|min:0',
            'cpanel_200_triennially' => 'nullable|numeric|min:0',
            'cpanel_300_monthly' => 'nullable|numeric|min:0',
            'cpanel_300_quarterly' => 'nullable|numeric|min:0',
            'cpanel_300_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_300_annually' => 'nullable|numeric|min:0',
            'cpanel_300_biennially' => 'nullable|numeric|min:0',
            'cpanel_300_triennially' => 'nullable|numeric|min:0',

            // Datacenter Locations & Pricing
            'datacenter_locations' => 'nullable|array',
            'datacenter_locations.*' => 'string',
            'datacenter_price' => 'nullable|array',
            'datacenter_price.*' => 'numeric|min:0|max:9999.99',

            // Auto Setup
            'auto_setup' => 'required|in:on_order,on_payment,on_accept,manual',

            // Free Domain
            'free_domain_type' => 'nullable|string|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_terms.*' => 'string|in:one_time,monthly,quarterly,semi_annually,annually,biennially,triennially',
            'free_domain_tlds' => 'nullable|array',
            'free_domain_tlds.*' => 'string',
        ]);

        // Prepare pricing data
        $pricing = [
            'one_time' => [
                'setup_fee' => $validated['one_time_setup_fee'] ?? 0,
                'price' => $validated['one_time_price'] ?? 0,
            ],
            'recurring' => [],
        ];

        // Include recurring periods that have pricing
        $recurringPeriods = ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'];
        foreach ($recurringPeriods as $period) {
            $setupFee = $validated["{$period}_setup_fee"] ?? 0;
            $price = $validated["{$period}_price"] ?? 0;

            if ($setupFee > 0 || $price > 0) {
                $pricing['recurring'][$period] = [
                    'setup_fee' => $setupFee,
                    'price' => $price,
                ];
            }
        }

        // Prepare free domain configuration
        $freeDomainConfig = null;
        if (isset($validated['free_domain_type']) && $validated['free_domain_type'] !== 'none') {
            $freeDomainConfig = [
                'type' => $validated['free_domain_type'],
                'terms' => $validated['free_domain_terms'] ?? [],
                'tlds' => $validated['free_domain_tlds'] ?? [],
            ];
        }

        // Calculate default price (use monthly if recurring, one_time if one_time payment)
        $defaultPrice = 0;
        if ($validated['payment_type'] === 'recurring') {
            $defaultPrice = $validated['monthly_price'] ?? 0;
        } elseif ($validated['payment_type'] === 'one_time') {
            $defaultPrice = $validated['one_time_price'] ?? 0;
        }

        // Create the product
        $product = Product::create([
            'name' => $validated['plan_name'],
            'tagline' => $validated['plan_tagline'],
            'type' => 'hosting',
            'category' => 'reseller_hosting',
            'description' => $validated['plan_short_description'],
            'short_description' => $validated['plan_short_description'],
            'features_list' => $validated['plan_feature'],
            'features_list_ar' => $request->plan_feature_ar,
            'welcome_email' => $validated['welcome_email'],
            'price' => $defaultPrice,
            'billing_cycle' => $validated['payment_type'] === 'recurring' ? 'monthly' : 'one_time',
            'payment_type' => $validated['payment_type'],
            'pricing' => $pricing,
            'base_cpanel_accounts' => $validated['base_cpanel_accounts'],
            'enable_cpanel_tiers' => $validated['enable_cpanel_tiers'] ?? false,
            'require_domain' => $validated['require_domain'] ?? false,
            'is_active' => true,
            'is_featured' => $validated['featured'] ?? false,
            'is_hidden' => $validated['hidden'] ?? false,
            'allow_multiple_quantities' => $validated['allow_multiple_quantities'] ?? false,
            'auto_setup' => $validated['auto_setup'],
            'free_domain_config' => $freeDomainConfig,
            'datacenter_locations' => $validated['datacenter_locations'] ?? [],
            'datacenter_price' => $validated['datacenter_price'] ?? [],
        ]);

        // Create cPanel tiers in separate table (only if enabled)
        if (isset($validated['enable_cpanel_tiers']) && $validated['enable_cpanel_tiers']) {
            $cpanelTiers = [
                ['tier' => 50, 'monthly' => 'cpanel_50_monthly', 'quarterly' => 'cpanel_50_quarterly', 'semi_annually' => 'cpanel_50_semi_annually', 'annually' => 'cpanel_50_annually', 'biennially' => 'cpanel_50_biennially', 'triennially' => 'cpanel_50_triennially'],
                ['tier' => 100, 'monthly' => 'cpanel_100_monthly', 'quarterly' => 'cpanel_100_quarterly', 'semi_annually' => 'cpanel_100_semi_annually', 'annually' => 'cpanel_100_annually', 'biennially' => 'cpanel_100_biennially', 'triennially' => 'cpanel_100_triennially'],
                ['tier' => 200, 'monthly' => 'cpanel_200_monthly', 'quarterly' => 'cpanel_200_quarterly', 'semi_annually' => 'cpanel_200_semi_annually', 'annually' => 'cpanel_200_annually', 'biennially' => 'cpanel_200_biennially', 'triennially' => 'cpanel_200_triennially'],
                ['tier' => 300, 'monthly' => 'cpanel_300_monthly', 'quarterly' => 'cpanel_300_quarterly', 'semi_annually' => 'cpanel_300_semi_annually', 'annually' => 'cpanel_300_annually', 'biennially' => 'cpanel_300_biennially', 'triennially' => 'cpanel_300_triennially'],
            ];

            foreach ($cpanelTiers as $tierData) {
                $product->cpanelTiers()->create([
                    'tier' => $tierData['tier'],
                    'monthly_price' => $validated[$tierData['monthly']] ?? 0,
                    'quarterly_price' => $validated[$tierData['quarterly']] ?? 0,
                    'semi_annually_price' => $validated[$tierData['semi_annually']] ?? 0,
                    'annually_price' => $validated[$tierData['annually']] ?? 0,
                    'biennially_price' => $validated[$tierData['biennially']] ?? 0,
                    'triennially_price' => $validated[$tierData['triennially']] ?? 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar' 
                ? 'تم إنشاء خطة Reseller Hosting بنجاح!' 
                : 'Reseller Hosting plan created successfully!')
            ->withFragment('reseller_hosting');
    }

    public function showResellerHosting($id)
    {
        $product = Product::with('cpanelTiers')->findOrFail($id);
        
        return view('admin.system-settings.products-reseller-hosting-show', compact('product'));
    }

    public function editResellerHosting($id)
    {
        $product = Product::with('cpanelTiers')->findOrFail($id);
        
        // Get servers for dropdown
        $servers = \App\Models\Server::where('status', true)
            ->orderBy('name')
            ->get();

        // Get email templates
        $emailTemplates = EmailTemplate::all();

        return view('admin.system-settings.products-reseller-hosting-edit', compact('product', 'servers', 'emailTemplates'));
    }

    public function updateResellerHosting(Request $request, $id)
    {
        \Illuminate\Support\Facades\Log::info('=== UPDATE RESELLER HOSTING REQUEST ===', [
            'id' => $id,
            'method' => $request->method(),
            'all_data' => $request->all(),
        ]);
        
        $product = Product::with('cpanelTiers')->findOrFail($id);
        
        // Use same validation as store
        $validated = $request->validate([
            // Plan Details
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_feature' => 'nullable|string',
            'welcome_email' => 'nullable|string',

            // Product Options
            'require_domain' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
            'allow_multiple_quantities' => 'nullable|boolean',

            // Payment & Pricing
            'payment_type' => 'required|in:free,one_time,recurring',

            // One Time pricing
            'one_time_setup_fee' => 'nullable|numeric|min:0',
            'one_time_price' => 'nullable|numeric|min:0',

            // Recurring pricing
            'monthly_setup_fee' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'quarterly_setup_fee' => 'nullable|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_setup_fee' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_setup_fee' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'biennially_setup_fee' => 'nullable|numeric|min:0',
            'biennially_price' => 'nullable|numeric|min:0',
            'triennially_setup_fee' => 'nullable|numeric|min:0',
            'triennially_price' => 'nullable|numeric|min:0',

            // cPanel Accounts
            'base_cpanel_accounts' => 'required|integer|min:0',
            'enable_cpanel_tiers' => 'nullable|boolean',
            'cpanel_50_monthly' => 'nullable|numeric|min:0',
            'cpanel_50_quarterly' => 'nullable|numeric|min:0',
            'cpanel_50_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_50_annually' => 'nullable|numeric|min:0',
            'cpanel_50_biennially' => 'nullable|numeric|min:0',
            'cpanel_50_triennially' => 'nullable|numeric|min:0',
            'cpanel_100_monthly' => 'nullable|numeric|min:0',
            'cpanel_100_quarterly' => 'nullable|numeric|min:0',
            'cpanel_100_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_100_annually' => 'nullable|numeric|min:0',
            'cpanel_100_biennially' => 'nullable|numeric|min:0',
            'cpanel_100_triennially' => 'nullable|numeric|min:0',
            'cpanel_200_monthly' => 'nullable|numeric|min:0',
            'cpanel_200_quarterly' => 'nullable|numeric|min:0',
            'cpanel_200_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_200_annually' => 'nullable|numeric|min:0',
            'cpanel_200_biennially' => 'nullable|numeric|min:0',
            'cpanel_200_triennially' => 'nullable|numeric|min:0',
            'cpanel_300_monthly' => 'nullable|numeric|min:0',
            'cpanel_300_quarterly' => 'nullable|numeric|min:0',
            'cpanel_300_semi_annually' => 'nullable|numeric|min:0',
            'cpanel_300_annually' => 'nullable|numeric|min:0',
            'cpanel_300_biennially' => 'nullable|numeric|min:0',
            'cpanel_300_triennially' => 'nullable|numeric|min:0',

            // Datacenter Locations & Pricing
            'datacenter_locations' => 'nullable|array',
            'datacenter_locations.*' => 'string',
            'datacenter_price' => 'nullable|array',
            'datacenter_price.*' => 'numeric|min:0|max:9999.99',

            // Auto Setup
            'auto_setup' => 'required|in:on_order,on_payment,on_accept,manual',

            // Free Domain
            'free_domain_type' => 'nullable|string|in:none,reg_transfer,reg_transfer_renewal',
            'free_domain_terms' => 'nullable|array',
            'free_domain_terms.*' => 'string|in:one_time,monthly,quarterly,semi_annually,annually,biennially,triennially',
            'free_domain_tlds' => 'nullable|array',
            'free_domain_tlds.*' => 'string',
        ]);

        // Prepare pricing data
        $pricing = [
            'one_time' => [
                'setup_fee' => $validated['one_time_setup_fee'] ?? 0,
                'price' => $validated['one_time_price'] ?? 0,
            ],
            'recurring' => [],
        ];

        // Include recurring periods that have pricing
        $recurringPeriods = ['monthly', 'quarterly', 'semi_annually', 'annually', 'biennially', 'triennially'];
        foreach ($recurringPeriods as $period) {
            $setupFee = $validated["{$period}_setup_fee"] ?? 0;
            $price = $validated["{$period}_price"] ?? 0;

            if ($setupFee > 0 || $price > 0) {
                $pricing['recurring'][$period] = [
                    'setup_fee' => $setupFee,
                    'price' => $price,
                ];
            }
        }

        // Prepare free domain configuration
        $freeDomainConfig = null;
        if (isset($validated['free_domain_type']) && $validated['free_domain_type'] !== 'none') {
            $freeDomainConfig = [
                'type' => $validated['free_domain_type'],
                'terms' => $validated['free_domain_terms'] ?? [],
                'tlds' => $validated['free_domain_tlds'] ?? [],
            ];
        }

        // Calculate default price (use monthly if recurring, one_time if one_time payment)
        $defaultPrice = 0;
        if ($validated['payment_type'] === 'recurring') {
            $defaultPrice = $validated['monthly_price'] ?? 0;
        } elseif ($validated['payment_type'] === 'one_time') {
            $defaultPrice = $validated['one_time_price'] ?? 0;
        }

        // Update the product
        $product->update([
            'name' => $validated['plan_name'],
            'tagline' => $validated['plan_tagline'],
            'description' => $validated['plan_short_description'],
            'short_description' => $validated['plan_short_description'],
            'features_list' => $validated['plan_feature'],
            'features_list_ar' => $request->plan_feature_ar,
            'welcome_email' => $validated['welcome_email'],
            'price' => $defaultPrice,
            'billing_cycle' => $validated['payment_type'] === 'recurring' ? 'monthly' : 'one_time',
            'payment_type' => $validated['payment_type'],
            'pricing' => $pricing,
            'base_cpanel_accounts' => $validated['base_cpanel_accounts'],
            'enable_cpanel_tiers' => $validated['enable_cpanel_tiers'] ?? false,
            'require_domain' => $validated['require_domain'] ?? false,
            'is_featured' => $validated['is_featured'] ?? false,
            'is_hidden' => $validated['is_hidden'] ?? false,
            'allow_multiple_quantities' => $validated['allow_multiple_quantities'] ?? false,
            'auto_setup' => $validated['auto_setup'],
            'free_domain_config' => $freeDomainConfig,
            'datacenter_locations' => $validated['datacenter_locations'] ?? [],
            'datacenter_price' => $validated['datacenter_price'] ?? [],
        ]);

        // Update cPanel Tiers
        if (isset($validated['enable_cpanel_tiers']) && $validated['enable_cpanel_tiers']) {
            // Delete old tiers
            $product->cpanelTiers()->delete();
            
            // Create new tiers
            $cpanelTiers = [
                ['tier' => 50, 'monthly' => 'cpanel_50_monthly', 'quarterly' => 'cpanel_50_quarterly', 'semi_annually' => 'cpanel_50_semi_annually', 'annually' => 'cpanel_50_annually', 'biennially' => 'cpanel_50_biennially', 'triennially' => 'cpanel_50_triennially'],
                ['tier' => 100, 'monthly' => 'cpanel_100_monthly', 'quarterly' => 'cpanel_100_quarterly', 'semi_annually' => 'cpanel_100_semi_annually', 'annually' => 'cpanel_100_annually', 'biennially' => 'cpanel_100_biennially', 'triennially' => 'cpanel_100_triennially'],
                ['tier' => 200, 'monthly' => 'cpanel_200_monthly', 'quarterly' => 'cpanel_200_quarterly', 'semi_annually' => 'cpanel_200_semi_annually', 'annually' => 'cpanel_200_annually', 'biennially' => 'cpanel_200_biennially', 'triennially' => 'cpanel_200_triennially'],
                ['tier' => 300, 'monthly' => 'cpanel_300_monthly', 'quarterly' => 'cpanel_300_quarterly', 'semi_annually' => 'cpanel_300_semi_annually', 'annually' => 'cpanel_300_annually', 'biennially' => 'cpanel_300_biennially', 'triennially' => 'cpanel_300_triennially'],
            ];

            foreach ($cpanelTiers as $tierData) {
                $product->cpanelTiers()->create([
                    'tier' => $tierData['tier'],
                    'monthly_price' => $validated[$tierData['monthly']] ?? 0,
                    'quarterly_price' => $validated[$tierData['quarterly']] ?? 0,
                    'semi_annually_price' => $validated[$tierData['semi_annually']] ?? 0,
                    'annually_price' => $validated[$tierData['annually']] ?? 0,
                    'biennially_price' => $validated[$tierData['biennially']] ?? 0,
                    'triennially_price' => $validated[$tierData['triennially']] ?? 0,
                ]);
            }
        } else {
            // If disabled, delete all tiers
            $product->cpanelTiers()->delete();
        }

        \Illuminate\Support\Facades\Log::info('=== UPDATE SUCCESSFUL ===', [
            'product_id' => $product->id,
            'product_name' => $product->name,
        ]);

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', __('crm.plan_updated_successfully'))
            ->withFragment('reseller_hosting');
    }

    public function destroyResellerHosting($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete cPanel tiers first (cascade will handle this, but being explicit)
        $product->cpanelTiers()->delete();
        
        // Delete the product
        $product->delete();

        return redirect()
            ->route('admin.system-settings.products')
            ->with('success', app()->getLocale() === 'ar' 
                ? 'تم حذف خطة Reseller Hosting بنجاح!' 
                : 'Reseller Hosting plan deleted successfully!');
    }

    /**
     * Delete a coupon
     */
    public function deleteCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => __('crm.coupon_deleted_successfully')
        ]);
    }

    /**
     * Toggle coupon active status
     */
    public function toggleCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return response()->json([
            'success' => true,
            'is_active' => $coupon->is_active,
            'message' => __('crm.coupon_status_updated')
        ]);
    }

    /**
     * Edit coupon form
     */
    public function editCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        
        // Get all products from different categories
        $sharedHosting = \App\Models\Product::where('category', 'shared_hosting')->where('is_active', true)->get();
        $cloudHosting = \App\Models\Product::where('category', 'cloud_hosting')->where('is_active', true)->get();
        $resellerHosting = \App\Models\Product::where('category', 'reseller_hosting')->where('is_active', true)->get();
        $vpsPlans = \App\Models\VpsPlan::where('is_active', true)->get();
        $dedicatedPlans = \App\Models\DedicatedPlan::where('is_active', true)->get();
        $domainPricing = \App\Models\DomainPricing::orderBy('tld')->get();
        
        return view('admin.system-settings.promotions-coupon-edit', compact(
            'coupon',
            'sharedHosting',
            'cloudHosting',
            'resellerHosting',
            'vpsPlans',
            'dedicatedPlans',
            'domainPricing'
        ));
    }

    /**
     * Update coupon
     */
    public function updateCoupon(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        
        // Validate the request
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'description' => 'nullable|string',
            'customer_type' => 'required|in:all,new,existing',
            'is_active' => 'boolean',
            'apply_to_all' => 'boolean',
            'products' => 'nullable|array',
            'billing_cycles' => 'nullable|array',
        ]);

        $coupon->update($validated);

        return redirect()
            ->route('admin.system-settings.promotions')
            ->with('success', __('crm.coupon_updated_successfully'));
    }

    /**
     * Delete a campaign
     */
    public function deleteCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json([
            'success' => true,
            'message' => __('crm.campaign_deleted_successfully')
        ]);
    }

    /**
     * Toggle campaign active status
     */
    public function toggleCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->is_active = !$campaign->is_active;
        $campaign->save();

        return response()->json([
            'success' => true,
            'is_active' => $campaign->is_active,
            'message' => __('crm.campaign_status_updated')
        ]);
    }

    /**
     * Edit campaign form
     */
    public function editCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Get all products from different categories
        $sharedHosting = \App\Models\Product::where('category', 'shared_hosting')->where('is_active', true)->get();
        $cloudHosting = \App\Models\Product::where('category', 'cloud_hosting')->where('is_active', true)->get();
        $resellerHosting = \App\Models\Product::where('category', 'reseller_hosting')->where('is_active', true)->get();
        $vpsPlans = \App\Models\VpsPlan::where('is_active', true)->get();
        $dedicatedPlans = \App\Models\DedicatedPlan::where('is_active', true)->get();
        $domainPricing = \App\Models\DomainPricing::orderBy('tld')->get();
        
        return view('admin.system-settings.promotions-campaign-edit', compact(
            'campaign',
            'sharedHosting',
            'cloudHosting',
            'resellerHosting',
            'vpsPlans',
            'dedicatedPlans',
            'domainPricing'
        ));
    }

    /**
     * Update campaign
     */
    public function updateCampaign(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Validate the request
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'type' => 'required|in:seasonal,product_launch,loyalty_reward',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'customer_type' => 'required|in:all,new,existing',
            'apply_to_all' => 'boolean',
            'products' => 'nullable|array',
            'billing_cycles' => 'nullable|array',
            'once_per_order' => 'boolean',
            'once_per_client' => 'boolean',
            'banner_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        // Add backward compatibility
        $validated['name'] = $validated['name_en'];
        $validated['description'] = $validated['description_en'];

        $campaign->update($validated);

        return redirect()
            ->route('admin.system-settings.promotions')
            ->with('success', __('crm.campaign_updated_successfully'));
    }
}


