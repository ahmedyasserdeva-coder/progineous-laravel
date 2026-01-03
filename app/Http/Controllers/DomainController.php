<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\DynadotService;
use App\Models\Product;
use App\Models\DomainPricing;
use App\Models\DomainRegistrar;

class DomainController extends Controller
{
    protected $dynadotService;

    public function __construct(DynadotService $dynadotService)
    {
        // Get Dynadot registrar and initialize service with credentials
        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', true)
            ->first();
            
        if ($registrar) {
            $dynadotService->setCredentials(
                $registrar->api_key,
                $registrar->api_secret,
                $registrar->test_mode
            );
        }
        
        $this->dynadotService = $dynadotService;
    }

    /**
     * Display domain search page
     */
    public function search(Request $request)
    {
        // Get popular extensions with ProGineous pricing for slider
        $popularExtensions = DomainPricing::whereIn('tld', [
            'com', 'net', 'org', 'io', 'co', 'me', 'online', 'app', 
            'dev', 'store', 'tech', 'shop'
        ])
        ->where('currency', 'USD')
        ->orderByRaw("FIELD(tld, 'com', 'net', 'org', 'io', 'co', 'me', 'online', 'app', 'dev', 'store', 'tech', 'shop')")
        ->get()
        ->map(function ($pricing) {
            return [
                'tld' => '.' . $pricing->tld,
                'price' => $pricing->progineous_register ?? $pricing->dynadot_register,
                'currency' => $pricing->currency,
            ];
        });

        // Get all domain pricing for the pricing table
        $allDomainPricing = DomainPricing::where('currency', 'USD')
            ->orderBy('tld', 'asc')
            ->get()
            ->map(function ($pricing) {
                return [
                    'tld' => $pricing->tld,
                    'register' => $pricing->progineous_register ?? 0,
                    'renew' => $pricing->progineous_renew ?? 0,
                    'transfer' => $pricing->progineous_transfer ?? 0,
                    'restore' => $pricing->progineous_restore ?? 0,
                    'currency' => $pricing->currency,
                ];
            });

        return view('frontend.domains.search', compact('popularExtensions', 'allDomainPricing'));
    }
    /**
     * Perform domain search using Dynadot API
     */
    protected function performSearch(string $searchTerm)
    {
        $searchTerm = strtolower(trim($searchTerm));
        
        // Remove protocol if present
        $searchTerm = preg_replace('/^https?:\/\//', '', $searchTerm);
        
        // Remove www if present
        $searchTerm = preg_replace('/^www\./', '', $searchTerm);
        
        // Convert Arabic/Unicode domain to Punycode if needed
        if (preg_match('/[^\x00-\x7F]/', $searchTerm)) {
            $searchTerm = $this->convertToPunycode($searchTerm);
            Log::info('Converted to Punycode', ['punycode' => $searchTerm]);
        }
        
        Log::info('Domain Search Started', ['searchTerm' => $searchTerm]);
        
        $results = [];
        $searchedDomains = [];
        
        try {
            // Popular extensions list (50 TLDs)
            $popularExtensions = [
                'com', 'net', 'org', 'info', 'io', 'co', 'me', 'online',
                'store', 'tech', 'site', 'website', 'space', 'live', 'today', 'world', 'life',
                'club', 'pro', 'mobi', 'name', 'us', 'uk', 'de', 'fr', 'ca', 'au',
                'app', 'dev', 'ai', 'cloud', 'digital', 'blog', 'shop', 'news', 'media', 'studio'
            ];
            
            // Track if user specified an extension (for priority sorting)
            $hasSpecificExtension = str_contains($searchTerm, '.');
            $originalSearchTerm = $searchTerm; // Store original for comparison
            
            // If no extension provided, check all 50 extensions
            if (!$hasSpecificExtension) {
                foreach ($popularExtensions as $ext) {
                    $searchedDomains[] = $searchTerm . '.' . $ext;
                }
            } else {
                // Single domain search with extension
                // Add the original domain first
                $searchedDomains[] = $searchTerm;
                
                // Extract base name and current TLD
                $baseName = explode('.', $searchTerm)[0];
                $currentTld = $this->getTld($searchTerm);
                
                // Add 50 other extensions (excluding current TLD)
                foreach ($popularExtensions as $ext) {
                    if ($ext !== $currentTld) {
                        $searchedDomains[] = $baseName . '.' . $ext;
                    }
                }
            }
            
            Log::info('Domains to Search', ['domains' => $searchedDomains]);
            
            // Search domains using Dynadot API
            $dynadotResult = $this->dynadotService->searchDomains($searchedDomains);
            
            Log::info('Dynadot API Result', ['result' => $dynadotResult]);
            
            // Get featured TLDs for priority sorting
            $featuredTlds = \App\Models\DomainPricing::where('is_featured', 1)
                ->pluck('tld')
                ->toArray();
            
            if ($dynadotResult && isset($dynadotResult['domains'])) {
                foreach ($dynadotResult['domains'] as $domainData) {
                    $domain = $domainData['domain'] ?? '';
                    
                    // Convert Punycode back to Unicode (Arabic) for display
                    $displayDomain = $this->convertFromPunycode($domain);
                    
                    $tld = $this->getTld($domain);
                    
                    // Check if this is the originally searched domain
                    $isOriginal = ($hasSpecificExtension && $domain === $originalSearchTerm);
                    
                    // Check if this TLD is featured
                    $isFeatured = in_array($tld, $featuredTlds);
                    
                    $results[] = [
                        'domain' => $displayDomain, // Display in Arabic/Unicode
                        'punycode' => $domain, // Keep Punycode for backend
                        'available' => $domainData['available'] ?? false,
                        'price' => $this->getDomainPrice($tld, 'register'),
                        'renew_price' => $this->getDomainPrice($tld, 'renew'),
                        'transfer_price' => $this->getDomainPrice($tld, 'transfer'),
                        'tld' => $tld,
                        'is_original' => $isOriginal, // Flag for sorting
                        'is_featured' => $isFeatured, // Flag for priority sorting
                    ];
                }
                
                // Sort results with priority (ignoring availability):
                // 1. Original domain (if search had extension) - available or not
                // 2. Featured TLDs - available or not
                // 3. Other TLDs - available or not
                usort($results, function($a, $b) use ($hasSpecificExtension) {
                    // Priority Level 1: Original domain always comes first
                    if ($hasSpecificExtension) {
                        if ($a['is_original'] && !$b['is_original']) return -1;
                        if (!$a['is_original'] && $b['is_original']) return 1;
                    }
                    
                    // Priority Level 2: Featured domains come before non-featured
                    // (both original and non-original featured domains)
                    if ($a['is_featured'] && !$b['is_featured']) return -1;
                    if (!$a['is_featured'] && $b['is_featured']) return 1;
                    
                    // Priority Level 3: Within same priority, keep API order
                    return 0;
                });
            }
            
            Log::info('Search Results', ['count' => count($results), 'results' => $results]);
            
            return response()->json([
                'success' => true,
                'results' => $results,
                'searchTerm' => $searchTerm
            ]);
            
        } catch (\Exception $e) {
            Log::error('Domain search error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => __('frontend.domain_search_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check domain availability
     */
    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'domain' => 'required|string|max:255'
            ]);

            // Check if Dynadot API is configured
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if (!$registrar || !$registrar->api_key) {
                return response()->json([
                    'success' => false,
                    'message' => 'Domain search service is not configured. Please contact administrator.'
                ], 500);
            }

            $domain = strtolower(trim($request->domain));
            
            // Remove protocol if present
            $domain = preg_replace('/^https?:\/\//', '', $domain);
            
            // If no extension provided, check multiple extensions
            if (!str_contains($domain, '.')) {
                // First 8 extensions (default display)
                $defaultExtensions = ['com', 'net', 'org', 'online', 'shop', 'store', 'tech', 'io'];
                
                // Additional 25 extensions (for "View More")
                $additionalExtensions = [
                    'co', 'me', 'info', 'biz', 'xyz', 'site', 'website', 'space',
                    'live', 'studio', 'email', 'host', 'club', 'pro', 'digital',
                    'world', 'link', 'blog', 'news', 'cloud', 'app', 'dev', 'ai',
                    'agency', 'company'
                ];
                
                // Combine all extensions
                $allExtensions = array_merge($defaultExtensions, $additionalExtensions);
                $results = [];
                
                foreach ($allExtensions as $index => $ext) {
                    $fullDomain = $domain . '.' . $ext;
                    $isAdditional = $index >= 8; // First 8 are default, rest are additional
                    
                    try {
                        // Use searchDomains (plural) which is the correct method name
                        $result = $this->dynadotService->searchDomains([$fullDomain]);
                        
                        if ($result && isset($result['domains'])) {
                            $domainData = $result['domains'][0] ?? null;
                            if ($domainData) {
                                $regPrice = $this->getDomainPrice($ext);
                                $renewPrice = $this->getDomainPrice($ext, 'renew');
                                $results[] = [
                                    'domain' => $fullDomain,
                                    'tld' => $ext,
                                    'available' => $domainData['available'] ?? false,
                                    'registration' => $regPrice,
                                    'renewal' => $renewPrice,
                                    'price' => $regPrice, // For compatibility with search page
                                    'renewal_price' => $renewPrice, // For compatibility with search page
                                    'is_additional' => $isAdditional
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        // Log the error for debugging
                        Log::error('Domain search API error', [
                            'domain' => $fullDomain,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        
                        // Continue to next extension instead of using mock data
                        continue;
                    }
                }
                
                // Check if we got any results
                if (empty($results)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to check domain availability. Please try again later or contact support.'
                    ], 500);
                }
                
                return response()->json([
                    'success' => true,
                    'results' => $results
                ]);
            } else {
                // Check single domain with specific extension
                $domainParts = explode('.', $domain);
                $domainName = $domainParts[0];
                $requestedExt = $this->getTld($domain);
                
                // Get alternative extensions for suggestions
                $alternativeExtensions = ['com', 'net', 'org', 'online', 'shop', 'store', 'tech', 'io'];
                
                // Remove the requested extension from alternatives
                $alternativeExtensions = array_filter($alternativeExtensions, function($ext) use ($requestedExt) {
                    return $ext !== $requestedExt;
                });
                
                $results = [];
                
                try {
                    // First, check the requested domain
                    $result = $this->dynadotService->searchDomains([$domain]);
                    $domainData = $result['domains'][0] ?? null;
                    
                    $regPrice = $this->getDomainPrice($requestedExt);
                    $renewPrice = $this->getDomainPrice($requestedExt, 'renew');
                    $results[] = [
                        'domain' => $domain,
                        'tld' => $requestedExt,
                        'available' => $domainData['available'] ?? false,
                        'registration' => $regPrice,
                        'renewal' => $renewPrice,
                        'price' => $regPrice, // For compatibility with search page
                        'renewal_price' => $renewPrice, // For compatibility with search page
                        'is_primary' => true // Mark as primary search result
                    ];
                    
                    // If the domain is NOT available, suggest alternatives
                    if (!($domainData['available'] ?? false)) {
                        foreach ($alternativeExtensions as $altExt) {
                            $altDomain = $domainName . '.' . $altExt;
                            
                            try {
                                $altResult = $this->dynadotService->searchDomains([$altDomain]);
                                $altDomainData = $altResult['domains'][0] ?? null;
                                
                                if ($altDomainData) {
                                    $altRegPrice = $this->getDomainPrice($altExt);
                                    $altRenewPrice = $this->getDomainPrice($altExt, 'renew');
                                    $results[] = [
                                        'domain' => $altDomain,
                                        'tld' => $altExt,
                                        'available' => $altDomainData['available'] ?? false,
                                        'registration' => $altRegPrice,
                                        'renewal' => $altRenewPrice,
                                        'price' => $altRegPrice, // For compatibility with search page
                                        'renewal_price' => $altRenewPrice, // For compatibility with search page
                                        'is_suggestion' => true // Mark as suggestion
                                    ];
                                }
                            } catch (\Exception $e) {
                                Log::error('Alternative domain check error', [
                                    'domain' => $altDomain,
                                    'error' => $e->getMessage()
                                ]);
                                continue;
                            }
                        }
                    }
                    
                    return response()->json([
                        'success' => true,
                        'results' => $results,
                        'has_suggestions' => count($results) > 1
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Domain search API error', [
                        'domain' => $domain,
                        'error' => $e->getMessage()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to check domain availability. Please try again later.'
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            Log::error('Domain check error: ' . $e->getMessage());
            
            // Check if it's an IP authorization error
            if (stripos($e->getMessage(), 'unauthorized ip') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Domain search service configuration error. Please contact administrator.'
                ], 503);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching for the domain.'
            ], 500);
        }
    }

    /**
     * Check if existing domain can be used for hosting
     * This checks:
     * 1. If domain is registered (via Dynadot API)
     * 2. If domain is already in use in active services (database)
     * 3. If domain exists in WHM/cPanel
     */
    public function checkExistingDomain(Request $request)
    {
        try {
            Log::info('checkExistingDomain called', ['request' => $request->all()]);
            
            $request->validate([
                'domain' => 'required|string|max:255'
            ]);

            $domain = strtolower(trim($request->domain));
            
            Log::info('Checking existing domain', ['domain' => $domain]);
            
            // Remove protocol if present
            $domain = preg_replace('/^https?:\/\//', '', $domain);
            // Remove www if present
            $domain = preg_replace('/^www\./', '', $domain);
            
            // ===== STEP 1: Check if domain is REGISTERED (not available for purchase) =====
            // This must be checked FIRST - user must own the domain
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            $isRegistered = false;
            
            if ($registrar && $registrar->api_key) {
                try {
                    $result = $this->dynadotService->searchDomains([$domain]);
                    Log::info('Dynadot registration check', [
                        'domain' => $domain,
                        'result' => $result['domains'][0] ?? null
                    ]);
                    
                    if ($result && isset($result['domains'][0])) {
                        $isRegistered = !($result['domains'][0]['available'] ?? true);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to check domain registration status', [
                        'domain' => $domain,
                        'error' => $e->getMessage()
                    ]);
                    // If we can't check, assume it's not registered for safety
                    $isRegistered = false;
                }
            }
            
            // If domain is NOT registered, reject immediately
            if (!$isRegistered) {
                Log::info('Domain is not registered', ['domain' => $domain]);
                return response()->json([
                    'success' => false,
                    'can_use' => false,
                    'reason' => 'not_registered',
                    'message' => __('frontend.domain_available_not_registered')
                ]);
            }
            
            Log::info('Domain is registered, checking WHM...', ['domain' => $domain]);
            
            // ===== STEP 2: Check WHM/cPanel for existing domains =====
            // Domain must NOT exist in WHM (main, addon, parked, or subdomain)
            try {
                $cpanelService = app(\App\Services\CpanelService::class);
                $domainCheck = $cpanelService->domainExistsInWhm($domain);
                
                Log::info('WHM domain check result', [
                    'domain' => $domain,
                    'exists' => $domainCheck['exists'] ?? false
                ]);
                
                if ($domainCheck['exists'] ?? false) {
                    Log::warning('Domain exists in WHM', ['domain' => $domain]);
                    
                    return response()->json([
                        'success' => false,
                        'can_use' => false,
                        'reason' => 'in_use_whm',
                        'message' => __('frontend.domain_already_in_use_whm', ['domain' => $domain])
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to check WHM for domain', [
                    'domain' => $domain,
                    'error' => $e->getMessage()
                ]);
                // Continue - don't block if WHM check fails
            }
            
            // ===== STEP 3: Check database for active services =====
            $existingService = \App\Models\Service::where('domain', $domain)
                ->where('status', 'active')
                ->first();
                
            if ($existingService) {
                Log::info('Domain exists in active services', ['domain' => $domain]);
                return response()->json([
                    'success' => false,
                    'can_use' => false,
                    'reason' => 'in_use_service',
                    'message' => __('frontend.domain_already_in_use_service', ['domain' => $domain])
                ]);
            }
            
            // ===== SUCCESS: Domain is registered AND not in use =====
            Log::info('Domain verified successfully', ['domain' => $domain]);
            
            return response()->json([
                'success' => true,
                'can_use' => true,
                'domain' => $domain,
                'message' => __('frontend.domain_verified_can_use')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error checking existing domain', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking the domain.'
            ], 500);
        }
    }

    /**
     * Display domain transfer page
     */
    public function transfer()
    {
        // Define popular TLDs order (most popular first)
        $popularTlds = [
            '.com', '.net', '.org', '.io', '.co', '.me', 
            '.info', '.biz', '.dev', '.app', '.tech', '.store',
            '.online', '.site', '.website', '.shop', '.xyz', '.pro'
        ];

        // Get all domain extensions with transfer prices
        $transferPrices = DomainPricing::whereNotNull('progineous_transfer')
            ->where('progineous_transfer', '>', 0)
            ->where('currency', 'USD')
            ->get()
            ->map(function($pricing) use ($popularTlds) {
                $tldName = $pricing->tld;
                
                // Calculate popularity score (lower number = more popular)
                $popularityScore = array_search($tldName, $popularTlds);
                if ($popularityScore === false) {
                    $popularityScore = 999; // Not in popular list
                }
                
                return [
                    'tld' => $tldName,
                    'price' => $pricing->progineous_transfer,
                    'currency' => $pricing->currency,
                    'popularity' => $popularityScore
                ];
            })
            ->sortBy('popularity') // Sort by popularity first
            ->values();

        return view('frontend.domains.transfer', [
            'transferPrices' => $transferPrices
        ]);
    }

    /**
     * Display new TLDs page
     */
    public function newTlds()
    {
        // Get new and trending TLDs with all pricing information
        $newTlds = DomainPricing::whereNotNull('progineous_register')
            ->where('progineous_register', '>', 0)
            ->where('currency', 'USD')
            ->get()
            ->map(function($pricing) {
                return [
                    'tld' => $pricing->tld,
                    'register_price' => $pricing->progineous_register,
                    'renew_price' => $pricing->progineous_renew ?? $pricing->progineous_register,
                    'transfer_price' => $pricing->progineous_transfer ?? $pricing->progineous_register,
                    'grace_price' => $pricing->progineous_grace ?? null,
                    'currency' => $pricing->currency,
                    'description' => $this->getTldDescription($pricing->tld)
                ];
            });

        return view('frontend.domains.new-tlds', [
            'newTlds' => $newTlds
        ]);
    }

    /**
     * Get TLD description for display
     */
    private function getTldDescription($tld)
    {
        $descriptions = [
            'com' => __('frontend.tld_desc_com'),
            'net' => __('frontend.tld_desc_net'),
            'org' => __('frontend.tld_desc_org'),
            'io' => __('frontend.tld_desc_io'),
            'co' => __('frontend.tld_desc_co'),
            'me' => __('frontend.tld_desc_me'),
            'dev' => __('frontend.tld_desc_dev'),
            'app' => __('frontend.tld_desc_app'),
            'tech' => __('frontend.tld_desc_tech'),
            'store' => __('frontend.tld_desc_store'),
            'online' => __('frontend.tld_desc_online'),
            'site' => __('frontend.tld_desc_site'),
            'ai' => __('frontend.tld_desc_ai'),
            'cloud' => __('frontend.tld_desc_cloud'),
            'digital' => __('frontend.tld_desc_digital'),
        ];

        return $descriptions[$tld] ?? __('frontend.tld_desc_premium');
    }

    /**
     * Validate domain transfer eligibility
     * Checks if domain can be transferred before proceeding
     */
    public function validateTransfer(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|max:255',
            'auth_code' => 'required|string|min:6',
        ]);

        $domain = strtolower(trim($request->domain));
        $authCode = trim($request->auth_code);

        // Remove protocol if present
        $domain = preg_replace('/^https?:\/\//', '', $domain);
        
        // Remove www if present
        $domain = preg_replace('/^www\./', '', $domain);

        // Convert Arabic/Unicode domain to Punycode if needed
        if (preg_match('/[^\x00-\x7F]/', $domain)) {
            $domain = $this->convertToPunycode($domain);
            Log::info('Converted domain to Punycode for transfer', ['punycode' => $domain]);
        }

        Log::info('Transfer Validation Started', [
            'domain' => $domain,
            'has_auth_code' => !empty($authCode)
        ]);

        try {
            // Check transfer eligibility using Dynadot API
            $result = $this->dynadotService->checkTransferEligibility($domain, $authCode);
            
            Log::info('Transfer Eligibility Result', ['result' => $result]);

            if ($result['eligible']) {
                // Convert domain back to Unicode for display
                $displayDomain = $this->convertFromPunycode($domain);
                $result['display_domain'] = $displayDomain;
                
                // Get transfer price from database
                $tld = $this->extractTld($domain);
                $pricing = DomainPricing::where('tld', $tld)
                    ->where('currency', 'USD')
                    ->first();
                
                $transferPrice = null;
                $currency = 'USD';
                
                if ($pricing) {
                    $transferPrice = $pricing->progineous_transfer ?? $pricing->dynadot_transfer;
                    $currency = $pricing->currency;
                }
                
                return response()->json([
                    'success' => true,
                    'eligible' => true,
                    'data' => $result,
                    'pricing' => [
                        'transfer' => $transferPrice,
                        'currency' => $currency,
                        'tld' => $tld
                    ],
                    'message' => $result['message'] ?? __('frontend.domain_transfer_eligible')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'eligible' => false,
                    'data' => $result,
                    'message' => $result['message'] ?? __('frontend.transfer_check_failed')
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Transfer validation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'eligible' => false,
                'message' => __('frontend.transfer_validation_error'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Register a domain
     */
    public function register(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
            'duration' => 'required|integer|min:1|max:10'
        ]);

        // Here you would handle the domain registration process
        // This includes creating an order, processing payment, etc.
        
        return response()->json([
            'success' => true,
            'message' => 'Domain registration initiated'
        ]);
    }

    /**
     * Get domain price by TLD and type
     */
    private function getDomainPrice($tld, $type = 'register')
    {
        // Remove dot from TLD if present
        $cleanTld = ltrim($tld, '.');
        
        // Get pricing from DomainPricing model
        $pricing = DomainPricing::where('tld', $cleanTld)
            ->orWhere('tld', '.' . $cleanTld)
            ->first();
        
        if ($pricing) {
            switch ($type) {
                case 'register':
                    return $pricing->progineous_register ?? $pricing->dynadot_register ?? 12.99;
                case 'renew':
                    return $pricing->progineous_renew ?? $pricing->dynadot_renew ?? 12.99;
                case 'transfer':
                    return $pricing->progineous_transfer ?? $pricing->dynadot_transfer ?? 12.99;
                default:
                    return $pricing->progineous_register ?? 12.99;
            }
        }
        
        // Fallback to Product model if DomainPricing not found
        $product = Product::domains()
            ->where('api_product_id', $tld)
            ->first();
            
        return $product ? $product->price : 12.99;
    }

    /**
     * Extract TLD from domain
     */
    private function getTld($domain)
    {
        $parts = explode('.', $domain);
        return end($parts);
    }

    /**
     * Convert Unicode domain (Arabic/IDN) to Punycode
     */
    private function convertToPunycode(string $domain): string
    {
        try {
            // Check if idn_to_ascii function exists
            if (!function_exists('idn_to_ascii')) {
                Log::warning('idn_to_ascii function not available, returning original domain');
                return $domain;
            }

            // Split domain into parts (handle both with and without extension)
            if (str_contains($domain, '.')) {
                $parts = explode('.', $domain);
                $convertedParts = [];
                
                foreach ($parts as $part) {
                    // Convert each part to punycode if it contains non-ASCII characters
                    if (preg_match('/[^\x00-\x7F]/', $part)) {
                        $converted = idn_to_ascii($part, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                        $convertedParts[] = $converted !== false ? $converted : $part;
                    } else {
                        $convertedParts[] = $part;
                    }
                }
                
                return implode('.', $convertedParts);
            } else {
                // No extension, just convert the domain name
                $converted = idn_to_ascii($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                return $converted !== false ? $converted : $domain;
            }
        } catch (\Exception $e) {
            Log::error('Punycode conversion error', ['domain' => $domain, 'error' => $e->getMessage()]);
            return $domain;
        }
    }

    /**
     * Convert Punycode domain back to Unicode (Arabic/IDN)
     */
    private function convertFromPunycode(string $domain): string
    {
        try {
            // Check if idn_to_utf8 function exists
            if (!function_exists('idn_to_utf8')) {
                Log::warning('idn_to_utf8 function not available, returning original domain');
                return $domain;
            }

            // Split domain into parts
            if (str_contains($domain, '.')) {
                $parts = explode('.', $domain);
                $convertedParts = [];
                
                foreach ($parts as $part) {
                    // Convert each part from punycode if it starts with xn--
                    if (str_starts_with($part, 'xn--')) {
                        $converted = idn_to_utf8($part, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                        $convertedParts[] = $converted !== false ? $converted : $part;
                    } else {
                        $convertedParts[] = $part;
                    }
                }
                
                return implode('.', $convertedParts);
            } else {
                // No extension, just convert if it's punycode
                if (str_starts_with($domain, 'xn--')) {
                    $converted = idn_to_utf8($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                    return $converted !== false ? $converted : $domain;
                }
                return $domain;
            }
        } catch (\Exception $e) {
            Log::error('Punycode to Unicode conversion error', ['domain' => $domain, 'error' => $e->getMessage()]);
            return $domain;
        }
    }

    /**
     * Extract TLD from domain name
     */
    private function extractTld(string $domain): string
    {
        $parts = explode('.', $domain);
        return end($parts);
    }

    /**
     * Display bulk domain search page
     */
    public function bulkSearch()
    {
        // Get all available TLDs for the dropdown
        $availableTlds = DomainPricing::where('currency', 'USD')
            ->orderBy('tld', 'asc')
            ->get()
            ->map(function ($pricing) {
                return [
                    'tld' => $pricing->tld,
                    'price' => $pricing->progineous_register ?? $pricing->dynadot_register,
                    'currency' => $pricing->currency
                ];
            });

        return view('frontend.domains.bulk-search', compact('availableTlds'));
    }

    /**
     * Display TLD List page
     */
    public function tldList()
    {
        $tlds = DomainPricing::orderBy('tld', 'asc')->get()->map(function ($pricing) {
            return [
                'tld' => $pricing->tld,
                'register' => $pricing->progineous_register ?? $pricing->dynadot_register,
                'renew' => $pricing->progineous_renew ?? $pricing->dynadot_renew,
                'transfer' => $pricing->progineous_transfer ?? $pricing->dynadot_transfer,
                'restore' => $pricing->progineous_restore ?? $pricing->dynadot_restore ?? null,
                'currency' => $pricing->currency
            ];
        });

        return view('frontend.domains.tld-list', compact('tlds'));
    }

    /**
     * Check availability of multiple domains
     */
    public function bulkCheckAvailability(Request $request)
    {
        $request->validate([
            'domains' => 'required|string',
            'extensions' => 'required|array|min:1',
            'extensions.*' => 'required|string'
        ]);

        try {
            // Parse domains from textarea (one per line)
            $domainNames = array_filter(
                array_map('trim', explode("\n", $request->domains)),
                function($domain) {
                    return !empty($domain);
                }
            );

            if (empty($domainNames)) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.no_domains_entered')
                ], 400);
            }

            // Limit to 50 domains per request
            if (count($domainNames) > 50) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.too_many_domains')
                ], 400);
            }

            $results = [];
            $extensions = $request->extensions;

            foreach ($domainNames as $baseName) {
                // Clean the base name
                $baseName = strtolower(trim($baseName));
                $baseName = preg_replace('/^(https?:\/\/)?(www\.)?/', '', $baseName);
                $baseName = preg_replace('/\.[a-z]{2,}$/', '', $baseName);

                foreach ($extensions as $extension) {
                    $fullDomain = $baseName . '.' . $extension;

                    // Convert to Punycode if needed
                    if (preg_match('/[^\x00-\x7F]/', $fullDomain)) {
                        $fullDomain = $this->convertToPunycode($fullDomain);
                    }

                    // Check availability using searchDomains
                    try {
                        $result = $this->dynadotService->searchDomains([$fullDomain]);
                        $available = false;
                        
                        if ($result && isset($result['domains'])) {
                            $domainData = $result['domains'][0] ?? null;
                            if ($domainData) {
                                $available = $domainData['available'] ?? false;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Bulk domain check error for domain', [
                            'domain' => $fullDomain,
                            'error' => $e->getMessage()
                        ]);
                        $available = false;
                    }

                    // Get pricing
                    $pricing = DomainPricing::where('tld', $extension)
                        ->where('currency', 'USD')
                        ->first();

                    $results[] = [
                        'domain' => $fullDomain,
                        'display_name' => $baseName . '.' . $extension,
                        'available' => $available,
                        'price' => $pricing ? ($pricing->progineous_register ?? $pricing->dynadot_register) : null,
                        'currency' => $pricing->currency ?? 'USD'
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'results' => $results,
                'total_checked' => count($results)
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk domain check error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('frontend.bulk_check_error')
            ], 500);
        }
    }

    /**
     * Display WHOIS lookup page
     */
    public function whois()
    {
        return view('frontend.domains.whois');
    }

    /**
     * Perform WHOIS lookup
     */
    public function whoisLookup(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|max:255'
        ]);

        try {
            $domain = strtolower(trim($request->domain));
            
            // Get WHOIS information from Dynadot
            $whoisData = $this->dynadotService->getWhoisInfo($domain);
            
            return response()->json([
                'success' => true,
                'data' => $whoisData
            ]);

        } catch (\Exception $e) {
            Log::error('WHOIS lookup error', [
                'domain' => $request->domain,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the Free DNS page
     */
    public function freeDns()
    {
        return view('frontend.domains.freedns');
    }

    /**
     * Check DNS records for a domain using WhoisXML API
     */
    public function checkDns(Request $request)
    {
        try {
            $request->validate([
                'domain' => 'required|string',
                'record_types' => 'required|array'
            ]);

            $domain = $request->domain;
            
            // Remove http://, https://, www. from domain
            $domain = preg_replace('#^https?://#', '', $domain);
            $domain = preg_replace('#^www\.#', '', $domain);
            $domain = trim($domain, '/');

            $recordTypes = $request->record_types;
            
            // Check if WhoisXML API is configured
            $apiKey = env('WHOISXML_API_KEY');
            
            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'WhoisXML API key is not configured. Please add WHOISXML_API_KEY to your .env file.'
                ], 500);
            }

            // Use WhoisXML API
            $results = $this->checkDnsWithWhoisXML($domain, $recordTypes, $apiKey);

            return response()->json([
                'success' => true,
                'records' => $results,
                'source' => 'WhoisXML API'
            ]);

        } catch (\Exception $e) {
            Log::error('DNS check error', [
                'domain' => $request->domain ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('frontend.dns_check_failed')
            ], 500);
        }
    }

    /**
     * Check DNS using WhoisXML API
     */
    private function checkDnsWithWhoisXML($domain, $recordTypes, $apiKey)
    {
        $results = [];
        
        foreach ($recordTypes as $type) {
            $type = strtoupper($type);
            
            try {
                // WhoisXML API endpoint
                $url = "https://www.whoisxmlapi.com/whoisserver/DNSService";
                
                $params = [
                    'apiKey' => $apiKey,
                    'domainName' => $domain,
                    'type' => $type,
                    'outputFormat' => 'JSON'
                ];
                
                $url .= '?' . http_build_query($params);
                
                // Initialize cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode === 200 && $response) {
                    $data = json_decode($response, true);
                    
                    if (isset($data['DNSData']) && isset($data['DNSData']['dnsRecords'])) {
                        $records = $data['DNSData']['dnsRecords'];
                        $results[$type] = $this->formatWhoisXMLRecords($records, $type);
                    }
                }
                
            } catch (\Exception $e) {
                Log::warning("WhoisXML API DNS lookup failed for {$domain} ({$type})", [
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return $results;
    }

    /**
     * Format WhoisXML API records for display
     */
    private function formatWhoisXMLRecords($records, $type)
    {
        $formatted = [];

        foreach ($records as $record) {
            switch ($type) {
                case 'A':
                    if (isset($record['address'])) {
                        $formatted[] = [
                            'ip' => $record['address'],
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'AAAA':
                    if (isset($record['address'])) {
                        $formatted[] = [
                            'ipv6' => $record['address'],
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'CNAME':
                    if (isset($record['target'])) {
                        $formatted[] = [
                            'target' => $record['target'],
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'MX':
                    if (isset($record['target']) && isset($record['priority'])) {
                        $formatted[] = [
                            'Priority' => $record['priority'],
                            'Target' => $record['target'],
                            'TTL' => $record['ttl'] ?? null,
                            'Name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'TXT':
                    if (isset($record['strings'])) {
                        $txtValue = is_array($record['strings']) 
                            ? implode(' ', $record['strings']) 
                            : $record['strings'];
                        
                        $formatted[] = [
                            'value' => $txtValue,
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null,
                            'raw' => $record['rawText'] ?? null
                        ];
                    }
                    break;

                case 'NS':
                    if (isset($record['target'])) {
                        $formatted[] = [
                            'nameserver' => $record['target'],
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null,
                            'additional_name' => $record['additionalName'] ?? null
                        ];
                    }
                    break;

                case 'SOA':
                    if (isset($record['host'])) {
                        $formatted[] = [
                            'Primary NS' => $record['host'] ?? '',
                            'Admin Email' => $record['admin'] ?? $record['email'] ?? '',
                            'Serial' => $record['serial'] ?? '',
                            'Refresh' => $record['refresh'] ?? '',
                            'Retry' => $record['retry'] ?? '',
                            'Expire' => $record['expire'] ?? '',
                            'Minimum TTL' => $record['minimum'] ?? '',
                            'TTL' => $record['ttl'] ?? null,
                            'Name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'CAA':
                    if (isset($record['tag'])) {
                        $formatted[] = [
                            'Tag' => $record['tag'],
                            'Value' => $record['value'] ?? '',
                            'Flags' => $record['flags'] ?? 0,
                            'TTL' => $record['ttl'] ?? null,
                            'Name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'PTR':
                    if (isset($record['target'])) {
                        $formatted[] = [
                            'target' => $record['target'],
                            'ttl' => $record['ttl'] ?? null,
                            'name' => $record['name'] ?? null
                        ];
                    }
                    break;

                case 'SRV':
                    if (isset($record['target'])) {
                        $formatted[] = [
                            'Target' => $record['target'],
                            'Priority' => $record['priority'] ?? null,
                            'Weight' => $record['weight'] ?? null,
                            'Port' => $record['port'] ?? null,
                            'TTL' => $record['ttl'] ?? null,
                            'Name' => $record['name'] ?? null
                        ];
                    }
                    break;

                default:
                    // For any other record type
                    if (isset($record['rawText'])) {
                        $formatted[] = [
                            'type' => $record['dnsType'] ?? $type,
                            'raw' => $record['rawText'],
                            'ttl' => $record['ttl'] ?? null
                        ];
                    }
            }
        }

        return $formatted;
    }
}
