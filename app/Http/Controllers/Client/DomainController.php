<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\DomainPricing;
use App\Models\DomainRegistrar;
use App\Services\DynadotService;
use App\Services\CloudflareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    /**
     * Display a listing of the client's domains.
     */
    public function index(Request $request)
    {
        $client = Auth::guard('client')->user();

        $query = Domain::where('client_id', $client->id)
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by expiring soon (within X days)
        if ($request->filled('expiring')) {
            $days = (int) $request->expiring;
            $query->where('status', 'active')
                ->where('expiry_date', '<=', now()->addDays($days))
                ->where('expiry_date', '>', now());
        }

        // Search by domain name
        if ($request->filled('search')) {
            $query->where('domain_name', 'like', '%' . $request->search . '%');
        }

        $domains = $query->paginate(10)->withQueryString();

        // Get localized statuses
        $statuses = app()->getLocale() == 'ar' ? Domain::getStatusesArabic() : Domain::getStatuses();

        return view('frontend.client.domains.index', compact('domains', 'statuses'));
    }

    /**
     * Generate domain recommendations based on user's existing domains.
     * Returns 3 recommendations for each user domain, grouped by domain name.
     * Uses Dynadot API to check real availability.
     */
    private function generateRecommendations($clientId)
    {
        try {
            // Get ALL user's domains with their full info
            $userDomainsRaw = Domain::where('client_id', $clientId)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($userDomainsRaw->isEmpty()) {
                return collect();
            }

            // Extract unique domain names (without TLD)
            $userDomainNames = $userDomainsRaw->map(function ($domain) {
                $parts = explode('.', $domain->domain_name);
                return [
                    'name' => $parts[0] ?? $domain->domain_name,
                    'full_domain' => $domain->domain_name,
                    'tld' => $this->extractTld($domain->domain_name),
                ];
            })->unique('name')->values();

            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if (!$registrar || !$registrar->api_key) {
                return collect(); // No API configured, return empty
            }

            // Get popular TLDs with prices (ordered by price, cheapest first)
            $popularTlds = DomainPricing::whereIn('tld', ['com', 'net', 'org', 'io', 'co', 'store', 'online', 'site', 'tech', 'xyz', 'me', 'info', 'app', 'dev'])
                ->where('dynadot_register', '>', 0)
                ->orderBy('dynadot_register', 'asc')
                ->get()
                ->keyBy('tld');

            if ($popularTlds->isEmpty()) {
                return collect();
            }

            // Get user's existing domains to exclude
            $userExistingDomains = $userDomainsRaw->pluck('domain_name')->toArray();

            // Build candidate list - 6 TLDs per domain name (to have fallbacks)
            $candidates = collect();
            $tldKeys = $popularTlds->keys()->toArray();

            foreach ($userDomainNames as $domainInfo) {
                $domainName = $domainInfo['name'];
                $currentTld = $domainInfo['tld'];

                // Get 6 different TLDs for this domain (excluding the one they already have)
                $availableTlds = array_filter($tldKeys, fn($tld) => $tld !== $currentTld);
                $selectedTlds = array_slice($availableTlds, 0, 6);

                foreach ($selectedTlds as $tld) {
                    $fullDomain = $domainName . '.' . $tld;

                    // Skip if user already owns this domain
                    if (in_array($fullDomain, $userExistingDomains)) {
                        continue;
                    }

                    $candidates->push([
                        'original_domain' => $domainInfo['full_domain'],
                        'name' => $domainName,
                        'tld' => $tld,
                        'full_domain' => $fullDomain,
                        'price' => $popularTlds[$tld]->progineous_register ?? $popularTlds[$tld]->dynadot_register ?? 0,
                        'currency' => $popularTlds[$tld]->currency ?? 'USD',
                    ]);
                }
            }

            if ($candidates->isEmpty()) {
                return collect();
            }

            // Check availability via Dynadot API (no cache - always fresh results)
            $dynadotService = new DynadotService($registrar);
            $availableDomains = collect();

            // Check domains in batches (Dynadot supports multiple domains per request)
            $domainList = $candidates->pluck('full_domain')->toArray();

            try {
                $searchResult = $dynadotService->searchDomains($domainList);

                if (isset($searchResult['domains'])) {
                    foreach ($searchResult['domains'] as $domainResult) {
                        if (($domainResult['available'] ?? false) === true) {
                            // Find the matching candidate
                            $candidate = $candidates->firstWhere('full_domain', $domainResult['domain']);
                            if ($candidate) {
                                $availableDomains->push($candidate);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Domain recommendation availability check failed', [
                    'error' => $e->getMessage()
                ]);
                // Return empty on API error
                return collect();
            }

            // Group by original domain and take 3 per domain
            $grouped = $availableDomains->groupBy('original_domain')->map(function ($items) {
                return $items->take(3)->values();
            });

            return $grouped;

        } catch (\Exception $e) {
            Log::error('Error generating domain recommendations', [
                'client_id' => $clientId,
                'error' => $e->getMessage()
            ]);
            return collect();
        }
    }

    /**
     * Extract TLD from domain name
     */
    private function extractTld($domain)
    {
        $parts = explode('.', $domain);
        array_shift($parts); // Remove the first part (domain name)
        return implode('.', $parts);
    }

    /**
     * Display the specified domain.
     */
    public function show(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            abort(403, 'Unauthorized');
        }

        $domain->load('client');

        // Check if Cloudflare was setup via Quick Setup
        // Shows DNS Records and DNS Settings only when:
        // 1. Domain has cloudflare_zone_id (was setup via Quick Setup)
        // 2. Current nameservers are Cloudflare nameservers
        $cloudflareActive = $domain->cloudflare_zone_id && $domain->isUsingCloudflareNameservers();

        // Get renewal price from DomainPricing
        $renewalPrice = 0;
        // Remove leading dot from TLD if present (domains table has .com, pricing table has com)
        $tld = ltrim($domain->tld, '.');
        $domainPricing = \App\Models\DomainPricing::where('tld', $tld)->first();
        if ($domainPricing) {
            $renewalPrice = $domainPricing->progineous_renew ?? $domainPricing->dynadot_renew ?? 0;
        }

        return view('frontend.client.domains.show', compact('domain', 'cloudflareActive', 'renewalPrice'));
    }

    /**
     * Toggle auto-renew for a domain
     */
    public function toggleAutoRenew(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow toggling for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن تغيير التجديد التلقائي فقط للنطاقات النشطة'
                    : 'Auto-renew can only be changed for active domains'
            ], 400);
        }

        try {
            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            $newValue = !$domain->auto_renew;

            // If Dynadot is configured, sync with API
            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);

                // auto = enable, donot = disable
                $renewOption = $newValue ? 'auto' : 'donot';
                // This will throw an exception if it fails
                $dynadotService->setRenewOption($domain->domain_name, $renewOption);
            }

            // Update local database
            $domain->auto_renew = $newValue;
            $domain->save();

            // Log activity
            activity()
                ->performedOn($domain)
                ->causedBy($client)
                ->withProperties(['auto_renew' => $newValue])
                ->event('updated')
                ->log($newValue ? 'Auto-renew enabled' : 'Auto-renew disabled');

            return response()->json([
                'success' => true,
                'value' => $newValue,
                'message' => $newValue
                    ? (app()->getLocale() == 'ar' ? 'تم تفعيل التجديد التلقائي' : 'Auto-renew enabled')
                    : (app()->getLocale() == 'ar' ? 'تم تعطيل التجديد التلقائي' : 'Auto-renew disabled')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle auto-renew', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في تغيير التجديد التلقائي'
                    : 'Failed to change auto-renew'
            ], 500);
        }
    }

    /**
     * Toggle transfer lock for a domain
     */
    public function toggleTransferLock(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow toggling for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن تغيير قفل النقل فقط للنطاقات النشطة'
                    : 'Transfer lock can only be changed for active domains'
            ], 400);
        }

        try {
            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            $newValue = !$domain->registrar_lock;

            // If Dynadot is configured, sync with API
            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);

                if ($newValue) {
                    $dynadotService->lockDomain($domain->domain_name);
                } else {
                    $dynadotService->unlockDomain($domain->domain_name);
                }
            }

            // Update local database
            $domain->registrar_lock = $newValue;
            $domain->save();

            // Log activity
            activity()
                ->performedOn($domain)
                ->causedBy($client)
                ->withProperties(['transfer_lock' => $newValue])
                ->event('updated')
                ->log($newValue ? 'Transfer lock enabled' : 'Transfer lock disabled');

            return response()->json([
                'success' => true,
                'value' => $newValue,
                'message' => $newValue
                    ? (app()->getLocale() == 'ar' ? 'تم تفعيل قفل النقل' : 'Transfer lock enabled')
                    : (app()->getLocale() == 'ar' ? 'تم تعطيل قفل النقل' : 'Transfer lock disabled')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle transfer lock', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في تغيير قفل النقل'
                    : 'Failed to change transfer lock'
            ], 500);
        }
    }

    /**
     * Toggle WHOIS privacy for a domain
     */
    public function toggleWhoisPrivacy(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow toggling for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن تغيير خصوصية WHOIS فقط للنطاقات النشطة'
                    : 'WHOIS privacy can only be changed for active domains'
            ], 400);
        }

        try {
            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            $newValue = !$domain->id_protection;

            // If Dynadot is configured, sync with API
            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);

                // full = enable, off = disable
                $privacyOption = $newValue ? 'full' : 'off';
                $dynadotService->setPrivacy($domain->domain_name, $privacyOption);
            }

            // Update local database
            $domain->id_protection = $newValue;
            $domain->save();

            // Log activity
            activity()
                ->performedOn($domain)
                ->causedBy($client)
                ->withProperties(['whois_privacy' => $newValue])
                ->event('updated')
                ->log($newValue ? 'WHOIS privacy enabled' : 'WHOIS privacy disabled');

            return response()->json([
                'success' => true,
                'value' => $newValue,
                'message' => $newValue
                    ? (app()->getLocale() == 'ar' ? 'تم تفعيل خصوصية WHOIS' : 'WHOIS privacy enabled')
                    : (app()->getLocale() == 'ar' ? 'تم تعطيل خصوصية WHOIS' : 'WHOIS privacy disabled')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle WHOIS privacy', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في تغيير خصوصية WHOIS'
                    : 'Failed to change WHOIS privacy'
            ], 500);
        }
    }

    /**
     * Get Authorization Code (EPP Code) for domain transfer
     */
    public function getAuthCode(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن الحصول على كود التفويض فقط للنطاقات النشطة'
                    : 'Authorization code can only be retrieved for active domains'
            ], 400);
        }

        try {
            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if (!$registrar || !$registrar->api_key) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar'
                        ? 'مسجل النطاقات غير مهيأ'
                        : 'Registrar not configured'
                ], 400);
            }

            $dynadotService = new DynadotService($registrar);
            $result = $dynadotService->getTransferAuthCode($domain->domain_name);

            Log::info('Dynadot getTransferAuthCode result', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);

            // Check response status
            $responseCode = $result['GetTransferAuthCodeResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $authCode = $result['GetTransferAuthCodeResponse']['AuthCode'] ?? ($result['AuthCode'] ?? null);

            if (($responseCode === 0 || $responseCode === '0') && $authCode) {
                // Save auth code to domain
                $domain->update(['auth_code' => $authCode]);

                return response()->json([
                    'success' => true,
                    'auth_code' => $authCode,
                    'message' => app()->getLocale() == 'ar'
                        ? 'تم الحصول على كود التفويض بنجاح'
                        : 'Authorization code retrieved successfully'
                ]);
            } else {
                $errorMessage = $result['GetTransferAuthCodeResponse']['Error'] ?? ($result['Error'] ?? 'Unknown error');

                return response()->json([
                    'success' => false,
                    'message' => (app()->getLocale() == 'ar' ? 'فشل في الحصول على كود التفويض' : 'Failed to get authorization code') . ': ' . $errorMessage
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Failed to get auth code', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في الحصول على كود التفويض'
                    : 'Failed to get authorization code'
            ], 500);
        }
    }

    /**
     * Update nameservers for a domain
     */
    public function updateNameservers(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow updating for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن تغيير خوادم الأسماء فقط للنطاقات النشطة'
                    : 'Nameservers can only be changed for active domains'
            ], 400);
        }

        // Validate nameservers
        $request->validate([
            'nameservers' => 'required|array|min:2|max:4',
            'nameservers.*' => 'required|string|regex:/^[a-zA-Z0-9][a-zA-Z0-9\-\.]*\.[a-zA-Z]{2,}$/'
        ]);

        $nameservers = array_filter($request->nameservers, fn($ns) => !empty(trim($ns)));

        if (count($nameservers) < 2) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يجب إدخال خادمي أسماء على الأقل'
                    : 'At least 2 nameservers are required'
            ], 400);
        }

        try {
            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            // If Dynadot is configured, sync with API
            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);
                $dynadotService->setNameservers($domain->domain_name, array_values($nameservers));
            }

            // Update local database
            $oldNameservers = $domain->nameservers;
            $domain->nameservers = array_values($nameservers);
            $domain->save();

            // Log activity
            activity()
                ->performedOn($domain)
                ->causedBy($client)
                ->withProperties(['old' => $oldNameservers, 'new' => array_values($nameservers)])
                ->event('updated')
                ->log('Nameservers updated');

            return response()->json([
                'success' => true,
                'nameservers' => $domain->nameservers,
                'message' => app()->getLocale() == 'ar'
                    ? 'تم تحديث خوادم الأسماء بنجاح'
                    : 'Nameservers updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update nameservers', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في تحديث خوادم الأسماء'
                    : 'Failed to update nameservers'
            ], 500);
        }
    }

    /**
     * Check live nameservers for a domain from Dynadot API
     */
    public function checkNameservers(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $liveNameservers = [];

            // Get Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if ($registrar && $registrar->api_key) {
                // Get live nameservers from Dynadot API
                $dynadotService = new DynadotService($registrar);
                $liveNameservers = $dynadotService->getNameservers($domain->domain_name);
            }

            // If Dynadot didn't return nameservers, fallback to DNS lookup
            if (empty($liveNameservers)) {
                $dnsRecords = @dns_get_record($domain->domain_name, DNS_NS);
                if ($dnsRecords) {
                    foreach ($dnsRecords as $record) {
                        if (isset($record['target'])) {
                            $liveNameservers[] = rtrim($record['target'], '.');
                        }
                    }
                }
            }

            // Compare with stored nameservers
            $storedNs = array_map('strtolower', $domain->nameservers ?? []);
            $liveNs = array_map('strtolower', $liveNameservers);

            // Check if nameservers match
            $matched = !empty($storedNs) && !empty($liveNs);
            if ($matched) {
                sort($storedNs);
                sort($liveNs);
                $matched = $storedNs === $liveNs;
            }

            // Update local database if nameservers changed
            if (!empty($liveNameservers) && $liveNs !== array_map('strtolower', $domain->nameservers ?? [])) {
                $domain->nameservers = $liveNameservers;
                $domain->save();
            }

            return response()->json([
                'success' => true,
                'live_nameservers' => $liveNameservers,
                'stored_nameservers' => $domain->nameservers ?? [],
                'matched' => $matched
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to check nameservers', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'live_nameservers' => [],
                'matched' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check SSL status for a domain
     */
    public function checkSSL(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $hasSSL = false;
            $sslInfo = null;
            $domainName = $domain->domain_name;

            // Create a stream context with SSL options
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'capture_peer_cert' => true,
                ],
            ]);

            // Try to connect via HTTPS
            $socket = @stream_socket_client(
                "ssl://{$domainName}:443",
                $errno,
                $errstr,
                5, // 5 second timeout
                STREAM_CLIENT_CONNECT,
                $context
            );

            if ($socket) {
                // SSL connection successful
                $hasSSL = true;
                
                // Get certificate details
                $params = stream_context_get_params($socket);
                if (isset($params['options']['ssl']['peer_certificate'])) {
                    $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
                    if ($cert) {
                        $sslInfo = [
                            'issuer' => $cert['issuer']['O'] ?? $cert['issuer']['CN'] ?? 'Unknown',
                            'valid_from' => date('M d, Y', $cert['validFrom_time_t']),
                            'valid_to' => date('M d, Y', $cert['validTo_time_t']),
                            'is_expired' => time() > $cert['validTo_time_t'],
                            'days_remaining' => max(0, floor(($cert['validTo_time_t'] - time()) / 86400)),
                            'common_name' => $cert['subject']['CN'] ?? 'Unknown',
                        ];
                    }
                }
                
                fclose($socket);
            }

            return response()->json([
                'success' => true,
                'has_ssl' => $hasSSL,
                'ssl_info' => $sslInfo
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to check SSL status', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'has_ssl' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Setup Cloudflare for a domain
     */
    public function setupCloudflare(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        // Ensure the domain belongs to the client
        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow for active domains
        if ($domain->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'يمكن إعداد Cloudflare فقط للنطاقات النشطة'
                    : 'Cloudflare can only be setup for active domains'
            ], 400);
        }

        try {
            // Initialize Cloudflare service
            $cloudflare = new CloudflareService();

            // Add domain to Cloudflare
            $result = $cloudflare->addZone($domain->domain_name);

            if (!$result['success']) {
                throw new \Exception($result['message'] ?? 'Failed to add domain to Cloudflare');
            }

            $nameservers = $result['nameservers'] ?? [];

            if (empty($nameservers)) {
                throw new \Exception('Cloudflare did not return nameservers');
            }

            // Update nameservers in Dynadot
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);
                $dynadotService->setNameservers($domain->domain_name, $nameservers);
            }

            // Update local database
            $oldNameservers = $domain->nameservers;
            $domain->nameservers = $nameservers;
            $domain->cloudflare_zone_id = $result['zone_id'] ?? null;
            $domain->save();

            // Log activity
            activity()
                ->performedOn($domain)
                ->causedBy($client)
                ->withProperties([
                    'old_nameservers' => $oldNameservers,
                    'new_nameservers' => $nameservers,
                    'cloudflare_zone_id' => $result['zone_id'] ?? null,
                ])
                ->event('cloudflare_setup')
                ->log('Cloudflare setup - Nameservers updated');

            return response()->json([
                'success' => true,
                'nameservers' => $nameservers,
                'zone_id' => $result['zone_id'],
                'status' => $result['status'],
                'message' => app()->getLocale() == 'ar'
                    ? 'تم إعداد Cloudflare بنجاح. تم تحديث خوادم الأسماء.'
                    : 'Cloudflare setup successful. Nameservers updated.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to setup Cloudflare', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في إعداد Cloudflare: ' . $e->getMessage()
                    : 'Failed to setup Cloudflare: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get DNS records from Cloudflare
     */
    public function getDnsRecords(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!$domain->cloudflare_zone_id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'هذا النطاق غير مرتبط بـ Cloudflare'
                    : 'This domain is not connected to Cloudflare'
            ], 400);
        }

        try {
            $cloudflare = new CloudflareService();
            $records = $cloudflare->getDnsRecords($domain->cloudflare_zone_id);

            return response()->json([
                'success' => true,
                'records' => $records
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get DNS records', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add DNS record to Cloudflare
     */
    public function addDnsRecord(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!$domain->cloudflare_zone_id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'هذا النطاق غير مرتبط بـ Cloudflare'
                    : 'This domain is not connected to Cloudflare'
            ], 400);
        }

        $request->validate([
            'type' => 'required|string|in:A,AAAA,CAA,CERT,CNAME,HTTPS,LOC,MX,NAPTR,NS,OPENPGPKEY,PTR,SMIMEA,SRV,SSHFP,SVCB,TLSA,TXT,URI',
            'name' => 'required|string',
            'content' => 'nullable|string',
            'ttl' => 'nullable|integer|min:1',
            'priority' => 'nullable|integer|min:0',
            'proxied' => 'nullable|boolean',
            'data' => 'nullable|array',
        ]);

        try {
            $cloudflare = new CloudflareService();

            $recordData = [
                'type' => $request->type,
                'name' => $request->name,
                'ttl' => $request->ttl ?? 1, // 1 = auto
            ];

            // Handle SRV records with data object
            if ($request->type === 'SRV' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['priority'] ?? 10),
                    'weight' => (int)($request->data['weight'] ?? 100),
                    'port' => (int)($request->data['port'] ?? 443),
                    'target' => $request->data['target'] ?? '',
                ];
            }
            // Handle CAA records with data object
            elseif ($request->type === 'CAA' && $request->data) {
                $recordData['data'] = [
                    'flags' => (int)($request->data['flags'] ?? 0),
                    'tag' => $request->data['tag'] ?? 'issue',
                    'value' => $request->data['value'] ?? '',
                ];
            }
            // Handle CERT records with data object
            elseif ($request->type === 'CERT' && $request->data) {
                $recordData['data'] = [
                    'type' => (int)($request->data['cert_type'] ?? 0),
                    'key_tag' => (int)($request->data['key_tag'] ?? 0),
                    'algorithm' => (int)($request->data['algorithm'] ?? 0),
                    'certificate' => $request->data['certificate'] ?? '',
                ];
            }
            // Handle DNSKEY records with data object
            elseif ($request->type === 'DNSKEY' && $request->data) {
                $recordData['data'] = [
                    'flags' => (int)($request->data['dnskey_flags'] ?? 256),
                    'protocol' => (int)($request->data['protocol'] ?? 3),
                    'algorithm' => (int)($request->data['dnskey_algorithm'] ?? 0),
                    'public_key' => $request->data['public_key'] ?? '',
                ];
            }
            // Handle DS records with data object
            elseif ($request->type === 'DS' && $request->data) {
                $recordData['data'] = [
                    'key_tag' => (int)($request->data['ds_key_tag'] ?? 0),
                    'algorithm' => (int)($request->data['ds_algorithm'] ?? 0),
                    'digest_type' => (int)($request->data['digest_type'] ?? 1),
                    'digest' => $request->data['digest'] ?? '',
                ];
            }
            // Handle HTTPS records with data object
            elseif ($request->type === 'HTTPS' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['https_priority'] ?? 1),
                    'target' => $request->data['https_target'] ?? '.',
                    'value' => $request->data['https_value'] ?? '',
                ];
            }
            // Handle LOC records with data object
            elseif ($request->type === 'LOC' && $request->data) {
                $recordData['data'] = [
                    'lat_degrees' => (int)($request->data['lat_degrees'] ?? 0),
                    'lat_minutes' => (int)($request->data['lat_minutes'] ?? 0),
                    'lat_seconds' => (float)($request->data['lat_seconds'] ?? 0),
                    'lat_direction' => $request->data['lat_direction'] ?? 'N',
                    'long_degrees' => (int)($request->data['long_degrees'] ?? 0),
                    'long_minutes' => (int)($request->data['long_minutes'] ?? 0),
                    'long_seconds' => (float)($request->data['long_seconds'] ?? 0),
                    'long_direction' => $request->data['long_direction'] ?? 'E',
                    'precision_horz' => (float)($request->data['precision_horz'] ?? 0),
                    'precision_vert' => (float)($request->data['precision_vert'] ?? 0),
                    'altitude' => (float)($request->data['altitude'] ?? 0),
                    'size' => (float)($request->data['size'] ?? 0),
                ];
            }
            // Handle NAPTR records with data object
            elseif ($request->type === 'NAPTR' && $request->data) {
                $recordData['data'] = [
                    'order' => (int)($request->data['naptr_order'] ?? 0),
                    'preference' => (int)($request->data['naptr_preference'] ?? 0),
                    'flags' => $request->data['naptr_flags'] ?? '',
                    'service' => $request->data['naptr_service'] ?? '',
                    'regex' => $request->data['naptr_regex'] ?? '',
                    'replacement' => $request->data['naptr_replacement'] ?? '',
                ];
            }
            // Handle SMIMEA records with data object
            elseif ($request->type === 'SMIMEA' && $request->data) {
                $recordData['data'] = [
                    'usage' => (int)($request->data['smimea_usage'] ?? 0),
                    'selector' => (int)($request->data['smimea_selector'] ?? 0),
                    'matching_type' => (int)($request->data['smimea_matching_type'] ?? 0),
                    'certificate' => $request->data['smimea_certificate'] ?? '',
                ];
            }
            // Handle SSHFP records with data object
            elseif ($request->type === 'SSHFP' && $request->data) {
                $recordData['data'] = [
                    'algorithm' => (int)($request->data['sshfp_algorithm'] ?? 0),
                    'type' => (int)($request->data['sshfp_type'] ?? 0),
                    'fingerprint' => $request->data['sshfp_fingerprint'] ?? '',
                ];
            }
            // Handle SVCB records with data object
            elseif ($request->type === 'SVCB' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['svcb_priority'] ?? 0),
                    'target' => $request->data['svcb_target'] ?? '.',
                    'value' => $request->data['svcb_value'] ?? '',
                ];
            }
            // Handle TLSA records with data object
            elseif ($request->type === 'TLSA' && $request->data) {
                $recordData['data'] = [
                    'usage' => (int)($request->data['tlsa_usage'] ?? 0),
                    'selector' => (int)($request->data['tlsa_selector'] ?? 0),
                    'matching_type' => (int)($request->data['tlsa_matching_type'] ?? 0),
                    'certificate' => $request->data['tlsa_certificate'] ?? '',
                ];
            }
            // Handle URI records with data object
            elseif ($request->type === 'URI' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['uri_priority'] ?? 0),
                    'weight' => (int)($request->data['uri_weight'] ?? 0),
                    'target' => $request->data['uri_target'] ?? '',
                ];
            }
            // Handle standard records with content
            else {
                $recordData['content'] = $request->content;
            }

            // Add proxied for supported types
            if (in_array($request->type, ['A', 'AAAA', 'CNAME'])) {
                $recordData['proxied'] = $request->proxied ?? false;
            }

            // Add priority for MX records
            if ($request->type === 'MX') {
                $recordData['priority'] = $request->priority ?? 10;
            }

            $result = $cloudflare->addDnsRecord($domain->cloudflare_zone_id, $recordData);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'record' => $result['record'],
                    'message' => app()->getLocale() == 'ar'
                        ? 'تم إضافة السجل بنجاح'
                        : 'Record added successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);

        } catch (\Exception $e) {
            Log::error('Failed to add DNS record', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update DNS record in Cloudflare
     */
    public function updateDnsRecord(Request $request, Domain $domain, string $recordId)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!$domain->cloudflare_zone_id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'هذا النطاق غير مرتبط بـ Cloudflare'
                    : 'This domain is not connected to Cloudflare'
            ], 400);
        }

        $request->validate([
            'type' => 'required|string|in:A,AAAA,CAA,CERT,CNAME,HTTPS,LOC,MX,NAPTR,NS,OPENPGPKEY,PTR,SMIMEA,SRV,SSHFP,SVCB,TLSA,TXT,URI',
            'name' => 'required|string',
            'content' => 'nullable|string',
            'ttl' => 'nullable|integer|min:1',
            'priority' => 'nullable|integer|min:0',
            'proxied' => 'nullable|boolean',
            'data' => 'nullable|array',
        ]);

        try {
            $cloudflare = new CloudflareService();

            $recordData = [
                'type' => $request->type,
                'name' => $request->name,
                'ttl' => $request->ttl ?? 1,
            ];

            // Handle SRV records with data object
            if ($request->type === 'SRV' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['priority'] ?? 10),
                    'weight' => (int)($request->data['weight'] ?? 100),
                    'port' => (int)($request->data['port'] ?? 443),
                    'target' => $request->data['target'] ?? '',
                ];
            }
            // Handle CAA records with data object
            elseif ($request->type === 'CAA' && $request->data) {
                $recordData['data'] = [
                    'flags' => (int)($request->data['flags'] ?? 0),
                    'tag' => $request->data['tag'] ?? 'issue',
                    'value' => $request->data['value'] ?? '',
                ];
            }
            // Handle CERT records with data object
            elseif ($request->type === 'CERT' && $request->data) {
                $recordData['data'] = [
                    'type' => (int)($request->data['cert_type'] ?? 0),
                    'key_tag' => (int)($request->data['key_tag'] ?? 0),
                    'algorithm' => (int)($request->data['algorithm'] ?? 0),
                    'certificate' => $request->data['certificate'] ?? '',
                ];
            }
            // Handle DNSKEY records with data object
            elseif ($request->type === 'DNSKEY' && $request->data) {
                $recordData['data'] = [
                    'flags' => (int)($request->data['dnskey_flags'] ?? 256),
                    'protocol' => (int)($request->data['protocol'] ?? 3),
                    'algorithm' => (int)($request->data['dnskey_algorithm'] ?? 0),
                    'public_key' => $request->data['public_key'] ?? '',
                ];
            }
            // Handle DS records with data object
            elseif ($request->type === 'DS' && $request->data) {
                $recordData['data'] = [
                    'key_tag' => (int)($request->data['ds_key_tag'] ?? 0),
                    'algorithm' => (int)($request->data['ds_algorithm'] ?? 0),
                    'digest_type' => (int)($request->data['digest_type'] ?? 1),
                    'digest' => $request->data['digest'] ?? '',
                ];
            }
            // Handle HTTPS records with data object
            elseif ($request->type === 'HTTPS' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['https_priority'] ?? 1),
                    'target' => $request->data['https_target'] ?? '.',
                    'value' => $request->data['https_value'] ?? '',
                ];
            }
            // Handle LOC records with data object
            elseif ($request->type === 'LOC' && $request->data) {
                $recordData['data'] = [
                    'lat_degrees' => (int)($request->data['lat_degrees'] ?? 0),
                    'lat_minutes' => (int)($request->data['lat_minutes'] ?? 0),
                    'lat_seconds' => (float)($request->data['lat_seconds'] ?? 0),
                    'lat_direction' => $request->data['lat_direction'] ?? 'N',
                    'long_degrees' => (int)($request->data['long_degrees'] ?? 0),
                    'long_minutes' => (int)($request->data['long_minutes'] ?? 0),
                    'long_seconds' => (float)($request->data['long_seconds'] ?? 0),
                    'long_direction' => $request->data['long_direction'] ?? 'E',
                    'precision_horz' => (float)($request->data['precision_horz'] ?? 0),
                    'precision_vert' => (float)($request->data['precision_vert'] ?? 0),
                    'altitude' => (float)($request->data['altitude'] ?? 0),
                    'size' => (float)($request->data['size'] ?? 0),
                ];
            }
            // Handle NAPTR records with data object
            elseif ($request->type === 'NAPTR' && $request->data) {
                $recordData['data'] = [
                    'order' => (int)($request->data['naptr_order'] ?? 0),
                    'preference' => (int)($request->data['naptr_preference'] ?? 0),
                    'flags' => $request->data['naptr_flags'] ?? '',
                    'service' => $request->data['naptr_service'] ?? '',
                    'regex' => $request->data['naptr_regex'] ?? '',
                    'replacement' => $request->data['naptr_replacement'] ?? '',
                ];
            }
            // Handle SMIMEA records with data object
            elseif ($request->type === 'SMIMEA' && $request->data) {
                $recordData['data'] = [
                    'usage' => (int)($request->data['smimea_usage'] ?? 0),
                    'selector' => (int)($request->data['smimea_selector'] ?? 0),
                    'matching_type' => (int)($request->data['smimea_matching_type'] ?? 0),
                    'certificate' => $request->data['smimea_certificate'] ?? '',
                ];
            }
            // Handle SSHFP records with data object
            elseif ($request->type === 'SSHFP' && $request->data) {
                $recordData['data'] = [
                    'algorithm' => (int)($request->data['sshfp_algorithm'] ?? 0),
                    'type' => (int)($request->data['sshfp_type'] ?? 0),
                    'fingerprint' => $request->data['sshfp_fingerprint'] ?? '',
                ];
            }
            // Handle SVCB records with data object
            elseif ($request->type === 'SVCB' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['svcb_priority'] ?? 0),
                    'target' => $request->data['svcb_target'] ?? '.',
                    'value' => $request->data['svcb_value'] ?? '',
                ];
            }
            // Handle TLSA records with data object
            elseif ($request->type === 'TLSA' && $request->data) {
                $recordData['data'] = [
                    'usage' => (int)($request->data['tlsa_usage'] ?? 0),
                    'selector' => (int)($request->data['tlsa_selector'] ?? 0),
                    'matching_type' => (int)($request->data['tlsa_matching_type'] ?? 0),
                    'certificate' => $request->data['tlsa_certificate'] ?? '',
                ];
            }
            // Handle URI records with data object
            elseif ($request->type === 'URI' && $request->data) {
                $recordData['data'] = [
                    'priority' => (int)($request->data['uri_priority'] ?? 0),
                    'weight' => (int)($request->data['uri_weight'] ?? 0),
                    'target' => $request->data['uri_target'] ?? '',
                ];
            }
            // Handle standard records with content
            else {
                $recordData['content'] = $request->content;
            }

            if (in_array($request->type, ['A', 'AAAA', 'CNAME'])) {
                $recordData['proxied'] = $request->proxied ?? false;
            }

            if ($request->type === 'MX') {
                $recordData['priority'] = $request->priority ?? 10;
            }

            $result = $cloudflare->updateDnsRecord($domain->cloudflare_zone_id, $recordId, $recordData);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'record' => $result['record'],
                    'message' => app()->getLocale() == 'ar'
                        ? 'تم تحديث السجل بنجاح'
                        : 'Record updated successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);

        } catch (\Exception $e) {
            Log::error('Failed to update DNS record', [
                'domain' => $domain->domain_name,
                'record_id' => $recordId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete DNS record from Cloudflare
     */
    public function deleteDnsRecord(Domain $domain, string $recordId)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!$domain->cloudflare_zone_id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'هذا النطاق غير مرتبط بـ Cloudflare'
                    : 'This domain is not connected to Cloudflare'
            ], 400);
        }

        try {
            $cloudflare = new CloudflareService();
            $result = $cloudflare->deleteDnsRecord($domain->cloudflare_zone_id, $recordId);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => app()->getLocale() == 'ar'
                        ? 'تم حذف السجل بنجاح'
                        : 'Record deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);

        } catch (\Exception $e) {
            Log::error('Failed to delete DNS record', [
                'domain' => $domain->domain_name,
                'record_id' => $recordId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Domain Health Check - comprehensive check of domain status
     */
    public function healthCheck(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $checks = [];
        $domainName = $domain->domain_name;

        // 1. DNS Resolution Check
        try {
            $dnsRecords = @dns_get_record($domainName, DNS_A);
            $checks['dns_resolution'] = [
                'name' => app()->getLocale() == 'ar' ? 'تحليل DNS' : 'DNS Resolution',
                'status' => !empty($dnsRecords) ? 'success' : 'warning',
                'message' => !empty($dnsRecords) 
                    ? (app()->getLocale() == 'ar' ? 'يتم تحليل النطاق بشكل صحيح' : 'Domain resolves correctly')
                    : (app()->getLocale() == 'ar' ? 'لا توجد سجلات A' : 'No A records found'),
                'details' => $dnsRecords ? array_column($dnsRecords, 'ip') : []
            ];
        } catch (\Exception $e) {
            $checks['dns_resolution'] = [
                'name' => app()->getLocale() == 'ar' ? 'تحليل DNS' : 'DNS Resolution',
                'status' => 'error',
                'message' => app()->getLocale() == 'ar' ? 'فشل فحص DNS' : 'DNS check failed',
                'details' => []
            ];
        }

        // 2. Nameservers Check
        try {
            $nsRecords = @dns_get_record($domainName, DNS_NS);
            $checks['nameservers'] = [
                'name' => app()->getLocale() == 'ar' ? 'خوادم الأسماء' : 'Nameservers',
                'status' => !empty($nsRecords) ? 'success' : 'warning',
                'message' => !empty($nsRecords) 
                    ? (app()->getLocale() == 'ar' ? 'خوادم الأسماء مُعدّة' : 'Nameservers configured')
                    : (app()->getLocale() == 'ar' ? 'لا توجد خوادم أسماء' : 'No nameservers found'),
                'details' => $nsRecords ? array_column($nsRecords, 'target') : []
            ];
        } catch (\Exception $e) {
            $checks['nameservers'] = [
                'name' => app()->getLocale() == 'ar' ? 'خوادم الأسماء' : 'Nameservers',
                'status' => 'error',
                'message' => app()->getLocale() == 'ar' ? 'فشل فحص خوادم الأسماء' : 'Nameserver check failed',
                'details' => []
            ];
        }

        // 3. Website Reachability Check
        try {
            $context = stream_context_create([
                'http' => ['timeout' => 5],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ]);
            $headers = @get_headers("https://{$domainName}", 0, $context);
            if (!$headers) {
                $headers = @get_headers("http://{$domainName}", 0, $context);
            }
            
            $isReachable = $headers && strpos($headers[0], '200') !== false;
            $isRedirect = $headers && (strpos($headers[0], '301') !== false || strpos($headers[0], '302') !== false);
            
            $checks['website'] = [
                'name' => app()->getLocale() == 'ar' ? 'الموقع الإلكتروني' : 'Website',
                'status' => $isReachable ? 'success' : ($isRedirect ? 'warning' : 'error'),
                'message' => $isReachable 
                    ? (app()->getLocale() == 'ar' ? 'الموقع يعمل' : 'Website is reachable')
                    : ($isRedirect 
                        ? (app()->getLocale() == 'ar' ? 'الموقع يقوم بإعادة توجيه' : 'Website redirects')
                        : (app()->getLocale() == 'ar' ? 'الموقع غير متاح' : 'Website not reachable')),
                'details' => $headers ? [$headers[0]] : []
            ];
        } catch (\Exception $e) {
            $checks['website'] = [
                'name' => app()->getLocale() == 'ar' ? 'الموقع الإلكتروني' : 'Website',
                'status' => 'error',
                'message' => app()->getLocale() == 'ar' ? 'فشل فحص الموقع' : 'Website check failed',
                'details' => []
            ];
        }

        // 4. SSL Certificate Check
        try {
            $context = stream_context_create([
                'ssl' => [
                    'capture_peer_cert' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]);
            $socket = @stream_socket_client(
                "ssl://{$domainName}:443",
                $errno,
                $errstr,
                5,
                STREAM_CLIENT_CONNECT,
                $context
            );
            
            if ($socket) {
                $params = stream_context_get_params($socket);
                $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate'] ?? null);
                fclose($socket);
                
                if ($cert) {
                    $validTo = $cert['validTo_time_t'] ?? 0;
                    $daysLeft = round(($validTo - time()) / 86400);
                    
                    $checks['ssl'] = [
                        'name' => app()->getLocale() == 'ar' ? 'شهادة SSL' : 'SSL Certificate',
                        'status' => $daysLeft > 30 ? 'success' : ($daysLeft > 0 ? 'warning' : 'error'),
                        'message' => $daysLeft > 0 
                            ? (app()->getLocale() == 'ar' ? "صالحة لـ {$daysLeft} يوم" : "Valid for {$daysLeft} days")
                            : (app()->getLocale() == 'ar' ? 'منتهية الصلاحية' : 'Expired'),
                        'details' => [
                            'issuer' => $cert['issuer']['O'] ?? $cert['issuer']['CN'] ?? 'Unknown',
                            'expires' => date('Y-m-d', $validTo)
                        ]
                    ];
                } else {
                    throw new \Exception('Could not parse certificate');
                }
            } else {
                throw new \Exception('Could not connect');
            }
        } catch (\Exception $e) {
            $checks['ssl'] = [
                'name' => app()->getLocale() == 'ar' ? 'شهادة SSL' : 'SSL Certificate',
                'status' => 'warning',
                'message' => app()->getLocale() == 'ar' ? 'لا توجد شهادة SSL' : 'No SSL certificate',
                'details' => []
            ];
        }

        // 5. MX Records Check (Email)
        try {
            $mxRecords = @dns_get_record($domainName, DNS_MX);
            $checks['email'] = [
                'name' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني (MX)' : 'Email (MX Records)',
                'status' => !empty($mxRecords) ? 'success' : 'warning',
                'message' => !empty($mxRecords) 
                    ? (app()->getLocale() == 'ar' ? 'سجلات MX مُعدّة' : 'MX records configured')
                    : (app()->getLocale() == 'ar' ? 'لا توجد سجلات MX' : 'No MX records'),
                'details' => $mxRecords ? array_map(function($r) {
                    return ['host' => $r['target'], 'priority' => $r['pri']];
                }, $mxRecords) : []
            ];
        } catch (\Exception $e) {
            $checks['email'] = [
                'name' => app()->getLocale() == 'ar' ? 'البريد الإلكتروني (MX)' : 'Email (MX Records)',
                'status' => 'error',
                'message' => app()->getLocale() == 'ar' ? 'فشل فحص MX' : 'MX check failed',
                'details' => []
            ];
        }

        // 6. Domain Expiry Check
        $expiryDays = $domain->expiry_date ? now()->diffInDays($domain->expiry_date, false) : null;
        $checks['expiry'] = [
            'name' => app()->getLocale() == 'ar' ? 'صلاحية النطاق' : 'Domain Expiry',
            'status' => $expiryDays === null ? 'warning' : ($expiryDays > 90 ? 'success' : ($expiryDays > 30 ? 'warning' : 'error')),
            'message' => $expiryDays === null 
                ? (app()->getLocale() == 'ar' ? 'تاريخ الانتهاء غير معروف' : 'Expiry date unknown')
                : ($expiryDays > 0 
                    ? (app()->getLocale() == 'ar' ? "ينتهي خلال {$expiryDays} يوم" : "Expires in {$expiryDays} days")
                    : (app()->getLocale() == 'ar' ? 'منتهي' : 'Expired')),
            'details' => $domain->expiry_date ? ['date' => $domain->expiry_date->format('Y-m-d')] : []
        ];

        // Calculate overall score
        $scores = ['success' => 3, 'warning' => 1, 'error' => 0];
        $totalScore = array_sum(array_map(fn($c) => $scores[$c['status']] ?? 0, $checks));
        $maxScore = count($checks) * 3;
        $healthPercentage = round(($totalScore / $maxScore) * 100);

        return response()->json([
            'success' => true,
            'checks' => $checks,
            'score' => $healthPercentage,
            'overall' => $healthPercentage >= 80 ? 'healthy' : ($healthPercentage >= 50 ? 'warning' : 'critical')
        ]);
    }

    /**
     * Get activity log for a domain
     */
    public function activityLog(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Get activities for this domain from Spatie Activity Log (table: activity_log)
        $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', Domain::class)
            ->where('subject_id', $domain->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'event' => $activity->event,
                    'description' => $activity->description,
                    'properties' => $activity->properties,
                    'created_at' => $activity->created_at->format('M d, Y H:i'),
                    'time_ago' => $activity->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }

    /**
     * Show contact information page for a domain
     */
    public function contacts(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            abort(403, 'Unauthorized');
        }

        // Get contacts from Dynadot if available
        $contacts = null;
        try {
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);
                $contacts = $dynadotService->getDomainContacts($domain->domain_name);
            }
        } catch (\Exception $e) {
            Log::error('Failed to get domain contacts', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
        }

        return view('frontend.client.domains.contacts', compact('domain', 'contacts'));
    }

    /**
     * Update contact information for a domain
     */
    public function updateContacts(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'contact_type' => 'required|in:registrant,admin,technical,billing',
            'contact' => 'required|array',
            'contact.first_name' => 'required|string|max:100',
            'contact.last_name' => 'required|string|max:100',
            'contact.email' => 'required|email|max:255',
            'contact.phone' => 'required|string|max:50',
            'contact.address1' => 'required|string|max:255',
            'contact.city' => 'required|string|max:100',
            'contact.state' => 'required|string|max:100',
            'contact.zip' => 'required|string|max:20',
            'contact.country' => 'required|string|size:2',
        ]);

        try {
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();

            if ($registrar && $registrar->api_key) {
                $dynadotService = new DynadotService($registrar);
                $contactType = $request->input('contact_type');
                $contactData = $request->input('contact');
                
                $result = $dynadotService->updateSingleContact(
                    $domain->domain_name, 
                    $contactType, 
                    $contactData
                );

                if ($result['success']) {
                    $typeLabels = [
                        'registrant' => app()->getLocale() == 'ar' ? 'بيانات المسجل' : 'Registrant contact',
                        'admin' => app()->getLocale() == 'ar' ? 'جهة الاتصال الإدارية' : 'Admin contact',
                        'technical' => app()->getLocale() == 'ar' ? 'جهة الاتصال التقنية' : 'Technical contact',
                        'billing' => app()->getLocale() == 'ar' ? 'جهة اتصال الفوترة' : 'Billing contact',
                    ];

                    // Log activity
                    activity()
                        ->performedOn($domain)
                        ->causedBy($client)
                        ->withProperties([
                            'contact_type' => $contactType,
                            'contact_name' => $contactData['first_name'] . ' ' . $contactData['last_name'],
                            'contact_email' => $contactData['email'],
                        ])
                        ->event('contact_updated')
                        ->log(ucfirst($contactType) . ' contact updated');
                    
                    return response()->json([
                        'success' => true,
                        'message' => app()->getLocale() == 'ar'
                            ? 'تم تحديث ' . $typeLabels[$contactType] . ' بنجاح'
                            : $typeLabels[$contactType] . ' updated successfully'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? (app()->getLocale() == 'ar' ? 'فشل في تحديث البيانات' : 'Failed to update contact')
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'لم يتم تكوين مسجل النطاقات'
                    : 'Domain registrar not configured'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Failed to update domain contact', [
                'domain' => $domain->domain_name,
                'contact_type' => $request->input('contact_type'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show ownership transfer page for a domain
     */
    public function ownership(Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.client.domains.ownership', compact('domain'));
    }

    /**
     * Lookup a client by email or username for ownership transfer
     */
    public function lookupOwner(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'identifier' => 'required|string|min:3',
        ]);

        $identifier = $request->identifier;

        // Search by email or username
        $targetClient = \App\Models\Client::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        if (!$targetClient) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'لا يوجد حساب بهذا البريد الإلكتروني أو اسم المستخدم'
                    : 'No account found with this email or username'
            ], 404);
        }

        if ($targetClient->id === $client->id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'لا يمكنك نقل النطاق لنفسك'
                    : 'You cannot transfer the domain to yourself'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'client' => [
                'id' => $targetClient->id,
                'name' => $targetClient->name,
                'email' => $this->maskEmail($targetClient->email),
                'username' => $targetClient->username,
            ]
        ]);
    }

    /**
     * Mask email for privacy (show first 2 chars and domain)
     */
    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) return $email;
        
        $name = $parts[0];
        $domain = $parts[1];
        
        if (strlen($name) <= 2) {
            $masked = $name[0] . '***';
        } else {
            $masked = substr($name, 0, 2) . str_repeat('*', min(strlen($name) - 2, 5));
        }
        
        return $masked . '@' . $domain;
    }

    /**
     * Send OTP for ownership transfer verification
     */
    public function sendOwnershipOtp(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
        ]);

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in cache with 10 minutes expiry
        $cacheKey = 'ownership_otp_' . $domain->id . '_' . $client->id;
        \Illuminate\Support\Facades\Cache::put($cacheKey, [
            'otp' => $otp,
            'target_client_id' => $request->client_id,
            'domain_id' => $domain->id,
        ], now()->addMinutes(10));

        // Send OTP email
        try {
            \Illuminate\Support\Facades\Mail::send('emails.ownership-otp', [
                'otp' => $otp,
                'domain' => $domain->domain_name,
                'client_name' => $client->name,
            ], function ($message) use ($client) {
                $message->to($client->email, $client->name)
                    ->subject(app()->getLocale() == 'ar' ? 'كود التحقق لنقل ملكية النطاق' : 'Domain Ownership Transfer Verification Code');
            });

            Log::info('Ownership OTP sent', [
                'domain' => $domain->domain_name,
                'client' => $client->id
            ]);

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar'
                    ? 'تم إرسال كود التحقق إلى بريدك الإلكتروني'
                    : 'Verification code has been sent to your email'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send ownership OTP', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'فشل في إرسال كود التحقق'
                    : 'Failed to send verification code'
            ], 500);
        }
    }

    /**
     * Transfer domain ownership to another account
     */
    public function transferOwnership(Request $request, Domain $domain)
    {
        $client = Auth::guard('client')->user();

        if ($domain->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'confirm_domain' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        // Verify OTP
        $cacheKey = 'ownership_otp_' . $domain->id . '_' . $client->id;
        $otpData = \Illuminate\Support\Facades\Cache::get($cacheKey);

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'انتهت صلاحية كود التحقق. يرجى طلب كود جديد'
                    : 'Verification code has expired. Please request a new code'
            ], 400);
        }

        if ($otpData['otp'] !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'كود التحقق غير صحيح'
                    : 'Invalid verification code'
            ], 400);
        }

        if ($otpData['target_client_id'] != $request->client_id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'كود التحقق غير صالح لهذا الطلب'
                    : 'Verification code is not valid for this request'
            ], 400);
        }

        // Verify domain name confirmation
        if (strtolower($request->confirm_domain) !== strtolower($domain->domain_name)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar'
                    ? 'اسم النطاق المدخل غير صحيح'
                    : 'Domain name confirmation does not match'
            ], 400);
        }

        try {
            // Clear OTP from cache
            \Illuminate\Support\Facades\Cache::forget($cacheKey);

            // Find target client by ID
            $targetClient = \App\Models\Client::find($request->client_id);

            if (!$targetClient) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar'
                        ? 'لا يوجد حساب بهذا المعرف'
                        : 'No account found with this ID'
                ], 404);
            }

            if ($targetClient->id === $client->id) {
                return response()->json([
                    'success' => false,
                    'message' => app()->getLocale() == 'ar'
                        ? 'لا يمكنك نقل النطاق لنفسك'
                        : 'You cannot transfer the domain to yourself'
                ], 400);
            }

            // Transfer domain
            $domain->client_id = $targetClient->id;
            $domain->save();

            // Log the transfer
            Log::info('Domain ownership transferred', [
                'domain' => $domain->domain_name,
                'from_client' => $client->id,
                'to_client' => $targetClient->id
            ]);

            // Send email to original owner (domain transferred from)
            try {
                \Illuminate\Support\Facades\Mail::send('emails.domain-transferred-from', [
                    'domain' => $domain->domain_name,
                    'from_client_name' => $client->first_name . ' ' . $client->last_name,
                    'to_client_name' => $targetClient->first_name . ' ' . $targetClient->last_name,
                    'transfer_date' => now()->format('Y-m-d H:i'),
                ], function ($message) use ($client) {
                    $message->to($client->email, $client->first_name . ' ' . $client->last_name)
                        ->subject(app()->getLocale() == 'ar' ? 'تم نقل النطاق من حسابك' : 'Domain Transferred From Your Account');
                });
            } catch (\Exception $e) {
                Log::error('Failed to send transfer notification to original owner', [
                    'domain' => $domain->domain_name,
                    'error' => $e->getMessage()
                ]);
            }

            // Send email to new owner (domain transferred to)
            try {
                \Illuminate\Support\Facades\Mail::send('emails.domain-transferred-to', [
                    'domain' => $domain->domain_name,
                    'from_client_name' => $client->first_name . ' ' . $client->last_name,
                    'to_client_name' => $targetClient->first_name . ' ' . $targetClient->last_name,
                    'transfer_date' => now()->format('Y-m-d H:i'),
                    'expiry_date' => $domain->expiry_date ? $domain->expiry_date->format('Y-m-d') : null,
                ], function ($message) use ($targetClient) {
                    $message->to($targetClient->email, $targetClient->first_name . ' ' . $targetClient->last_name)
                        ->subject(app()->getLocale() == 'ar' ? 'تم استلام نطاق جديد في حسابك' : 'New Domain Received In Your Account');
                });
            } catch (\Exception $e) {
                Log::error('Failed to send transfer notification to new owner', [
                    'domain' => $domain->domain_name,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar'
                    ? 'تم نقل ملكية النطاق بنجاح'
                    : 'Domain ownership transferred successfully',
                'redirect' => route('client.domains.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to transfer domain ownership', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
