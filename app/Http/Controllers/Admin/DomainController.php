<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\DomainRegistrar;
use App\Services\DynadotService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of domains.
     */
    public function index(Request $request)
    {
        $query = Domain::with('client');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('domain_name', 'like', "%{$search}%")
                  ->orWhere('tld', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('username', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%")
                                  ->orWhere('first_name', 'like', "%{$search}%")
                                  ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $domains = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        return view('admin.domains.index', compact('domains'));
    }

    /**
     * Display the specified domain.
     */
    public function show(Domain $domain)
    {
        $domain->load(['client', 'service', 'order.invoice.payments']);
        
        $statuses = Domain::getStatuses();
        $statusesArabic = Domain::getStatusesArabic();
        
        return view('admin.domains.show', compact('domain', 'statuses', 'statusesArabic'));
    }

    /**
     * Show the form for editing the specified domain.
     */
    public function edit(Domain $domain)
    {
        $domain->load('client');
        
        return view('admin.domains.edit', compact('domain'));
    }

    /**
     * Update the specified domain in storage.
     */
    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|in:' . implode(',', array_keys(Domain::getStatuses())),
            'auto_renew' => 'nullable|boolean',
            'registration_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'next_due_date' => 'nullable|date',
            'registrar' => 'nullable|string|max:255',
            'nameservers' => 'nullable|array',
            'nameservers.*' => 'nullable|string|max:255',
            'registrar_lock' => 'nullable|boolean',
            'id_protection' => 'nullable|boolean',
            'first_payment_amount' => 'nullable|numeric|min:0',
            'recurring_amount' => 'nullable|numeric|min:0',
            'registration_period' => 'nullable|integer|min:1|max:10',
            'payment_method' => 'nullable|string|max:255',
            'promotion_code' => 'nullable|string|max:255',
        ]);
        
        // Filter out null values for boolean fields
        if (isset($validated['auto_renew'])) {
            $validated['auto_renew'] = (bool) $validated['auto_renew'];
        }
        if (isset($validated['registrar_lock'])) {
            $validated['registrar_lock'] = (bool) $validated['registrar_lock'];
        }
        if (isset($validated['id_protection'])) {
            $validated['id_protection'] = (bool) $validated['id_protection'];
        }
        
        // Clean nameservers array
        if (isset($validated['nameservers'])) {
            $validated['nameservers'] = array_values(array_filter($validated['nameservers']));
        }
        
        $domain->update($validated);
        
        return redirect()->route('admin.domains.show', $domain)
            ->with('success', __('crm.domain_updated_successfully'));
    }

    /**
     * Update domain status via AJAX
     */
    public function updateStatus(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(Domain::getStatuses())),
        ]);
        
        $domain->update(['status' => $validated['status']]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.domain_status_updated'),
            'status' => $domain->status,
            'status_label' => $domain->status_label,
            'status_color' => $domain->status_color,
        ]);
    }

    /**
     * Update nameservers
     */
    public function updateNameservers(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'nameservers' => 'required|array|min:1|max:5',
            'nameservers.*' => 'nullable|string|max:255',
        ]);
        
        $nameservers = array_values(array_filter($validated['nameservers']));
        
        // Try to update nameservers in Dynadot
        $dynadotUpdated = false;
        $dynadotError = null;
        
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', 1)
                ->first();
            
            if ($registrar && count($nameservers) >= 2) {
                $dynadotService = new \App\Services\DynadotService($registrar);
                $result = $dynadotService->setNameservers($domain->domain_name, $nameservers);
                
                if (isset($result['SetNsResponse']['Status']) && $result['SetNsResponse']['Status'] === 'success') {
                    $dynadotUpdated = true;
                } elseif (isset($result['Status']) && $result['Status'] === 'success') {
                    $dynadotUpdated = true;
                }
            }
        } catch (\Exception $e) {
            $dynadotError = $e->getMessage();
            \Log::warning('Failed to update nameservers in Dynadot', [
                'domain' => $domain->domain_name,
                'error' => $dynadotError
            ]);
        }
        
        // Update local database
        $domain->update(['nameservers' => $nameservers]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.nameservers_updated'),
            'nameservers' => $nameservers,
        ]);
    }

    /**
     * Reset nameservers to default
     */
    public function resetNameservers(Domain $domain)
    {
        $domain->resetToDefaultNameservers();
        
        return response()->json([
            'success' => true,
            'message' => __('crm.nameservers_reset_to_default'),
            'nameservers' => Domain::DEFAULT_NAMESERVERS,
        ]);
    }

    /**
     * Toggle registrar lock
     */
    public function toggleRegistrarLock(Domain $domain)
    {
        $newLockStatus = !$domain->registrar_lock;
        
        // Try to sync with Dynadot if registrar is Dynadot
        $dynadotSynced = false;
        $dynadotError = null;
        
        $registrar = \App\Models\DomainRegistrar::where('name', 'like', '%dynadot%')
            ->where('status', 1)
            ->first();
            
        if ($registrar) {
            try {
                $dynadotService = new \App\Services\DynadotService($registrar);
                
                if ($newLockStatus) {
                    // Lock the domain
                    $result = $dynadotService->lockDomain($domain->domain_name);
                } else {
                    // Unlock the domain
                    $result = $dynadotService->unlockDomain($domain->domain_name);
                }
                
                \Log::info('Dynadot lock/unlock result', ['result' => $result, 'newLockStatus' => $newLockStatus]);
                
                // Check for success in different response structures
                $isSuccess = false;
                
                if (isset($result['LockDomainResponse']['Status']) && $result['LockDomainResponse']['Status'] === 'success') {
                    $isSuccess = true;
                } elseif (isset($result['GetTransferAuthCodeResponse']['Status']) && $result['GetTransferAuthCodeResponse']['Status'] === 'success') {
                    $isSuccess = true;
                } elseif (isset($result['Status']) && $result['Status'] === 'success') {
                    $isSuccess = true;
                } elseif (isset($result['ResponseCode']) && $result['ResponseCode'] == 0) {
                    $isSuccess = true;
                }
                
                if ($isSuccess) {
                    $dynadotSynced = true;
                } else {
                    $dynadotError = $result['Error'] ?? ($result['Status'] ?? 'Unknown error');
                }
            } catch (\Exception $e) {
                \Log::error('Dynadot lock/unlock error', ['error' => $e->getMessage()]);
                $dynadotError = $e->getMessage();
            }
        }
        
        // Update local database
        $domain->update(['registrar_lock' => $newLockStatus]);
        
        $message = $newLockStatus 
            ? __('crm.registrar_lock_enabled') 
            : __('crm.registrar_lock_disabled');
            
        if ($dynadotError) {
            $message .= ' (' . __('crm.dynadot_sync_failed') . ')';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'registrar_lock' => $domain->registrar_lock,
            'dynadot_synced' => $dynadotSynced,
        ]);
    }

    /**
     * Update first payment amount
     */
    public function updateFirstPayment(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'first_payment_amount' => 'required|numeric|min:0',
        ]);
        
        $domain->update(['first_payment_amount' => $validated['first_payment_amount']]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.first_payment_updated') ?? 'First payment amount updated successfully',
            'first_payment_amount' => $domain->first_payment_amount,
        ]);
    }

    /**
     * Update recurring amount
     */
    public function updateRecurringAmount(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'recurring_amount' => 'required|numeric|min:0',
        ]);
        
        $domain->update(['recurring_amount' => $validated['recurring_amount']]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.recurring_amount_updated') ?? 'Recurring amount updated successfully',
            'recurring_amount' => $domain->recurring_amount,
        ]);
    }

    /**
     * Update registration period
     */
    public function updateRegistrationPeriod(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'registration_period' => 'required|integer|min:1|max:10',
        ]);
        
        $domain->update(['registration_period' => $validated['registration_period']]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.registration_period_updated') ?? 'Registration period updated successfully',
            'registration_period' => $domain->registration_period,
        ]);
    }

    /**
     * Update domain name
     */
    public function updateDomainName(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'domain_name' => 'required|string|max:255',
        ]);
        
        // Extract TLD from domain name
        $parts = explode('.', $validated['domain_name'], 2);
        $tld = isset($parts[1]) ? '.' . $parts[1] : $domain->tld;
        
        $domain->update([
            'domain_name' => $validated['domain_name'],
            'tld' => $tld,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.domain_name_updated') ?? 'Domain name updated successfully',
            'domain_name' => $domain->domain_name,
            'tld' => $domain->tld,
        ]);
    }

    /**
     * Update auth code (transfer code)
     */
    public function updateAuthCode(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'auth_code' => 'nullable|string|max:255',
        ]);
        
        // Update domain configuration
        $configuration = $domain->configuration ?? [];
        $configuration['auth_code'] = $validated['auth_code'];
        $domain->update(['configuration' => $configuration]);
        
        // Also update related OrderItem if exists
        if ($domain->order_id) {
            $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
                ->where('type', 'domain')
                ->first();
            
            if ($orderItem) {
                $itemConfig = $orderItem->configuration ?? [];
                $itemConfig['auth_code'] = $validated['auth_code'];
                $orderItem->update(['configuration' => $itemConfig]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => __('crm.auth_code_updated') ?? 'Auth code updated successfully',
            'auth_code' => $validated['auth_code'],
        ]);
    }

    /**
     * Update expiry date
     */
    public function updateExpiryDate(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'expiry_date' => 'required|date',
        ]);
        
        $expiryDate = \Carbon\Carbon::parse($validated['expiry_date']);
        $domain->update(['expiry_date' => $expiryDate]);
        
        // Calculate expiry status
        $expiryStatus = 'active';
        if ($expiryDate->isPast()) {
            $expiryStatus = 'expired';
        } elseif ($expiryDate->diffInDays(now()) < 30) {
            $expiryStatus = 'expiring';
        }
        
        return response()->json([
            'success' => true,
            'message' => __('crm.expiry_date_updated') ?? 'Expiry date updated successfully',
            'expiry_date' => $expiryDate->format('M d, Y'),
            'expiry_date_human' => $expiryDate->diffForHumans(),
            'expiry_status' => $expiryStatus,
        ]);
    }

    /**
     * Update next due date
     */
    public function updateNextDueDate(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'next_due_date' => 'required|date',
        ]);
        
        $nextDueDate = \Carbon\Carbon::parse($validated['next_due_date']);
        $domain->update(['next_due_date' => $nextDueDate]);
        
        return response()->json([
            'success' => true,
            'message' => __('crm.next_due_date_updated') ?? 'Next due date updated successfully',
            'next_due_date' => $nextDueDate->format('M d, Y'),
            'next_due_date_human' => $nextDueDate->diffForHumans(),
        ]);
    }

    /**
     * Fetch domain dates from Dynadot API
     */
    public function fetchDatesFromDynadot(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', true)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_not_configured') ?? 'Dynadot registrar not configured or disabled',
                ]);
            }
            
            if (!$registrar->api_key) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_api_key_missing') ?? 'Dynadot API key is not configured',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Get raw response for debugging
            $rawResult = $dynadotService->getDomainInfoRaw($domain->domain_name);
            \Log::info('Dynadot getDomainInfo raw result', ['domain' => $domain->domain_name, 'result' => $rawResult]);
            
            $info = $rawResult['DomainInfoResponse']['DomainInfo'] ?? $rawResult['DomainInfo'] ?? [];
            
            if (empty($info)) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.domain_not_found_dynadot') ?? 'Domain not found in Dynadot account',
                    'debug' => app()->environment('local') ? $rawResult : null,
                ]);
            }
            
            // Get timestamps and convert to dates
            // Dynadot returns timestamps in MILLISECONDS, so we need to divide by 1000
            $expirationTimestamp = isset($info['Expiration']) ? (int)($info['Expiration'] / 1000) : null;
            $registrationTimestamp = isset($info['Registration']) ? (int)($info['Registration'] / 1000) : null;
            
            $expiryDate = $expirationTimestamp ? \Carbon\Carbon::createFromTimestamp($expirationTimestamp) : null;
            $registrationDate = $registrationTimestamp ? \Carbon\Carbon::createFromTimestamp($registrationTimestamp) : null;
            
            // Update domain record
            $updateData = [];
            
            if ($expiryDate) {
                $updateData['expiry_date'] = $expiryDate;
                $updateData['next_due_date'] = $expiryDate; // Also update next due date
            }
            
            if ($registrationDate) {
                $updateData['registration_date'] = $registrationDate;
            }
            
            if (!empty($updateData)) {
                $domain->update($updateData);
                $domain->refresh();
            }
            
            // Determine expiry status
            $expiryStatus = 'active';
            if ($expiryDate) {
                if ($expiryDate->isPast()) {
                    $expiryStatus = 'expired';
                } elseif ($expiryDate->diffInDays(now()) < 30) {
                    $expiryStatus = 'expiring';
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => __('crm.dates_fetched_successfully') ?? 'Domain dates fetched successfully from Dynadot',
                'dates' => [
                    'registration_date' => $registrationDate ? $registrationDate->format('M d, Y') : '',
                    'registration_date_human' => $registrationDate ? $registrationDate->diffForHumans() : '',
                    'expiry_date' => $expiryDate ? $expiryDate->format('M d, Y') : '',
                    'expiry_date_human' => $expiryDate ? $expiryDate->diffForHumans() : '',
                    'expiry_status' => $expiryStatus,
                    'next_due_date' => $expiryDate ? $expiryDate->format('M d, Y') : '',
                    'next_due_date_human' => $expiryDate ? $expiryDate->diffForHumans() : '',
                ],
            ]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Translate common Dynadot errors
            if (stripos($errorMessage, 'invalid key') !== false) {
                $errorMessage = __('crm.dynadot_invalid_api_key') ?? 'Invalid Dynadot API key. Please check your API key configuration.';
            } elseif (stripos($errorMessage, 'domain not found') !== false || stripos($errorMessage, 'not in your account') !== false) {
                $errorMessage = __('crm.domain_not_in_dynadot_account') ?? 'This domain is not found in your Dynadot account.';
            } elseif (stripos($errorMessage, 'unauthorized ip') !== false) {
                $errorMessage = __('crm.dynadot_unauthorized_ip') ?? 'Your server IP is not authorized in Dynadot. Please add it to the allowed IPs list.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ]);
        }
    }

    /**
     * Fetch nameservers from Dynadot API
     */
    public function fetchNameserversFromDynadot(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('type', 'dynadot')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_not_configured') ?? 'Dynadot registrar not configured or disabled',
                ]);
            }
            
            // Initialize Dynadot service with registrar model
            $dynadotService = new \App\Services\DynadotService($registrar);
            
            // Get domain info from Dynadot
            $rawResult = $dynadotService->getDomainInfoRaw($domain->domain_name);
            
            $info = $rawResult['DomainInfoResponse']['DomainInfo'] ?? $rawResult['DomainInfo'] ?? [];
            
            if (empty($info)) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.domain_not_found_dynadot') ?? 'Domain not found in Dynadot account',
                ]);
            }
            
            // Extract nameservers from response
            $nameservers = [];
            $nsSettings = $info['NameServerSettings'] ?? [];
            
            if (isset($nsSettings['NameServers'])) {
                $nsList = $nsSettings['NameServers'];
                // Handle both single nameserver and array of nameservers
                if (isset($nsList['ServerName'])) {
                    // Single nameserver
                    $nameservers[] = $nsList['ServerName'];
                } else {
                    // Array of nameservers
                    foreach ($nsList as $ns) {
                        if (isset($ns['ServerName'])) {
                            $nameservers[] = $ns['ServerName'];
                        }
                    }
                }
            }
            
            // Update domain record
            if (!empty($nameservers)) {
                $domain->update(['nameservers' => $nameservers]);
                $domain->refresh();
            }
            
            // Pad array to 6 elements for frontend
            while (count($nameservers) < 6) {
                $nameservers[] = '';
            }
            
            return response()->json([
                'success' => true,
                'message' => __('crm.nameservers_fetched_successfully') ?? 'Nameservers fetched successfully',
                'nameservers' => $nameservers,
            ]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Translate common Dynadot errors
            if (stripos($errorMessage, 'invalid key') !== false) {
                $errorMessage = __('crm.dynadot_invalid_api_key') ?? 'Invalid Dynadot API key.';
            } elseif (stripos($errorMessage, 'domain not found') !== false) {
                $errorMessage = __('crm.domain_not_in_dynadot_account') ?? 'Domain not found in Dynadot account.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ]);
        }
    }

    /**
     * Toggle management tools (DNS Management, Email Forwarding, ID Protection, Auto Renew)
     */
    public function toggleTool(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'tool' => 'required|string|in:dns_management,email_forwarding,id_protection,auto_renew',
        ]);
        
        $tool = $validated['tool'];
        $newValue = !$domain->$tool;
        
        // For id_protection and auto_renew, sync with Dynadot
        $dynadotError = null;
        if (in_array($tool, ['id_protection', 'auto_renew'])) {
            $registrar = \App\Models\DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
                
            if ($registrar) {
                try {
                    $dynadotService = new \App\Services\DynadotService($registrar);
                    
                    if ($tool === 'id_protection') {
                        $privacyOption = $newValue ? 'full' : 'off';
                        $result = $dynadotService->setPrivacy($domain->domain_name, $privacyOption);
                        
                        \Log::info('Dynadot setPrivacy result', [
                            'domain' => $domain->domain_name,
                            'option' => $privacyOption,
                            'result' => $result
                        ]);
                        
                        // Check for success
                        $isSuccess = false;
                        if (isset($result['SetPrivacyResponse']['Status']) && $result['SetPrivacyResponse']['Status'] === 'success') {
                            $isSuccess = true;
                        } elseif (isset($result['Status']) && $result['Status'] === 'success') {
                            $isSuccess = true;
                        } elseif (isset($result['ResponseCode']) && $result['ResponseCode'] == 0) {
                            $isSuccess = true;
                        }
                        
                        if (!$isSuccess) {
                            $dynadotError = $result['Error'] ?? ($result['Status'] ?? 'Unknown error');
                        }
                    } elseif ($tool === 'auto_renew') {
                        // auto = enable auto renew, donot = disable auto renew
                        $renewOption = $newValue ? 'auto' : 'donot';
                        $result = $dynadotService->setRenewOption($domain->domain_name, $renewOption);
                        
                        \Log::info('Dynadot setRenewOption result', [
                            'domain' => $domain->domain_name,
                            'option' => $renewOption,
                            'result' => $result
                        ]);
                        
                        // Check for success
                        $isSuccess = false;
                        if (isset($result['SetRenewOptionResponse']['Status']) && $result['SetRenewOptionResponse']['Status'] === 'success') {
                            $isSuccess = true;
                        } elseif (isset($result['Status']) && $result['Status'] === 'success') {
                            $isSuccess = true;
                        } elseif (isset($result['ResponseCode']) && $result['ResponseCode'] == 0) {
                            $isSuccess = true;
                        }
                        
                        if (!$isSuccess) {
                            $dynadotError = $result['Error'] ?? ($result['Status'] ?? 'Unknown error');
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Dynadot tool sync error', ['tool' => $tool, 'error' => $e->getMessage()]);
                    $dynadotError = $e->getMessage();
                }
            }
        }
        
        $domain->update([$tool => $newValue]);
        
        $toolLabels = [
            'dns_management' => __('crm.dns_management'),
            'email_forwarding' => __('crm.email_forwarding'),
            'id_protection' => __('crm.id_protection'),
            'auto_renew' => __('crm.auto_renew'),
        ];
        
        $message = $newValue 
            ? ($toolLabels[$tool] ?? $tool) . ' ' . __('crm.enabled')
            : ($toolLabels[$tool] ?? $tool) . ' ' . __('crm.disabled');
            
        if ($dynadotError) {
            $message .= ' (' . __('crm.dynadot_sync_failed') . ')';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'tool' => $tool,
            'value' => $newValue,
        ]);
    }
    /**
     * Remove the specified domain from storage.
     */
    public function destroy(Domain $domain)
    {
        $clientId = $domain->client_id;
        
        // Also delete related service if exists
        if ($domain->service) {
            $domain->service->delete();
        }
        
        $domain->delete();
        
        return redirect()->route('admin.clients.show', $clientId)
            ->with('success', __('crm.domain_deleted_successfully'));
    }

    // ========================================
    // Registrar Commands
    // ========================================

    /**
     * Register domain with registrar
     */
    public function register(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_not_configured') ?? 'Dynadot registrar not configured or disabled',
                ]);
            }
            
            // Get client contact info
            $client = $domain->client;
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.domain_has_no_client') ?? 'Domain has no associated client',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Step 1: Create contact from client information
            $contactData = [
                'name' => trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? '')),
                'email' => $client->email,
                'phone' => preg_replace('/[^0-9]/', '', $client->phone ?? ''),
                'phone_cc' => $this->extractPhoneCountryCode($client->phone ?? '', $client->country ?? 'US'),
                'organization' => $client->company_name ?? '',
                'address1' => $client->address1 ?? $client->address_1 ?? '',
                'address2' => $client->address2 ?? $client->address_2 ?? '',
                'city' => $client->city ?? '',
                'state' => $client->state ?? '',
                'postcode' => $client->postcode ?? '',
                'country' => $client->country ?? 'US',
            ];
            
            \Log::info('Creating Dynadot contact for domain registration', [
                'domain' => $domain->domain_name,
                'contact' => $contactData
            ]);
            
            // Create the contact
            $contactResult = $dynadotService->createContact($contactData);
            
            \Log::info('Dynadot createContact result', [
                'result' => $contactResult
            ]);
            
            // Get contact ID from response
            $contactId = null;
            if (isset($contactResult['CreateContactResponse']['ResponseCode']) && 
                $contactResult['CreateContactResponse']['ResponseCode'] == 0) {
                $contactId = $contactResult['CreateContactResponse']['CreateContactContent']['ContactId'] ?? null;
            } elseif (isset($contactResult['ResponseCode']) && $contactResult['ResponseCode'] == 0) {
                $contactId = $contactResult['CreateContactContent']['ContactId'] ?? null;
            }
            
            if (!$contactId) {
                $errorMsg = $contactResult['CreateContactResponse']['Error'] ?? 
                           $contactResult['Error'] ?? 
                           'Failed to create contact';
                return response()->json([
                    'success' => false,
                    'message' => __('crm.contact_creation_failed') . ': ' . $errorMsg,
                ]);
            }
            
            \Log::info('Contact created successfully', ['contact_id' => $contactId]);
            
            // Step 2: Register domain with contact IDs
            $options = [
                'currency' => 'USD',
                'registrant_contact' => $contactId,
                'admin_contact' => $contactId,
                'technical_contact' => $contactId,
                'billing_contact' => $contactId,
            ];
            
            // Call Dynadot API to register domain
            $result = $dynadotService->registerDomain(
                $domain->domain_name, 
                $domain->registration_period ?? 1,
                $options
            );
            
            \Log::info('Dynadot registerDomain result', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);
            
            // Check response status
            $responseCode = $result['RegisterResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $status = $result['RegisterResponse']['Status'] ?? ($result['Status'] ?? null);
            
            // Success if ResponseCode is 0 and Status is success
            if ($responseCode === 0 && $status === 'success') {
                // Update domain status
                $domain->update([
                    'status' => Domain::STATUS_ACTIVE,
                    'registration_date' => now(),
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.domain_registered_successfully') ?? 'Domain registered successfully in Dynadot',
                ]);
            } else {
                // Get specific error message based on status
                $errorMessages = [
                    'not_available' => __('crm.domain_not_available') ?? 'Domain is not available for registration (already registered)',
                    'insufficient_balance' => __('crm.insufficient_balance') ?? 'Insufficient balance in Dynadot account',
                    'invalid_domain' => __('crm.invalid_domain_name') ?? 'Invalid domain name',
                    'error' => $result['RegisterResponse']['Error'] ?? ($result['Error'] ?? 'Registration failed'),
                ];
                
                $errorMessage = $errorMessages[$status] ?? ($result['RegisterResponse']['Error'] ?? ($status ?? 'Unknown error'));
                
                return response()->json([
                    'success' => false,
                    'message' => __('crm.domain_registration_failed') . ': ' . $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Domain registration error', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.domain_registration_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Extract phone country code from phone number or country
     */
    private function extractPhoneCountryCode(string $phone, string $country): string
    {
        // If phone starts with +, extract the country code
        if (preg_match('/^\+(\d{1,4})/', $phone, $matches)) {
            return $matches[1];
        }
        
        // Map country codes to phone codes
        $countryCodes = [
            'US' => '1', 'CA' => '1', 'GB' => '44', 'UK' => '44',
            'AU' => '61', 'DE' => '49', 'FR' => '33', 'IT' => '39',
            'ES' => '34', 'NL' => '31', 'BE' => '32', 'CH' => '41',
            'AT' => '43', 'SE' => '46', 'NO' => '47', 'DK' => '45',
            'FI' => '358', 'IE' => '353', 'PT' => '351', 'GR' => '30',
            'PL' => '48', 'CZ' => '420', 'HU' => '36', 'RO' => '40',
            'BG' => '359', 'HR' => '385', 'SK' => '421', 'SI' => '386',
            'EE' => '372', 'LV' => '371', 'LT' => '370', 'CY' => '357',
            'MT' => '356', 'LU' => '352', 'IS' => '354',
            'RU' => '7', 'UA' => '380', 'BY' => '375',
            'CN' => '86', 'JP' => '81', 'KR' => '82', 'IN' => '91',
            'ID' => '62', 'MY' => '60', 'SG' => '65', 'TH' => '66',
            'VN' => '84', 'PH' => '63', 'HK' => '852', 'TW' => '886',
            'AE' => '971', 'SA' => '966', 'EG' => '20', 'ZA' => '27',
            'NG' => '234', 'KE' => '254', 'GH' => '233', 'MA' => '212',
            'TN' => '216', 'DZ' => '213', 'IL' => '972', 'TR' => '90',
            'IR' => '98', 'IQ' => '964', 'JO' => '962', 'LB' => '961',
            'KW' => '965', 'QA' => '974', 'BH' => '973', 'OM' => '968',
            'YE' => '967', 'SY' => '963', 'PS' => '970',
            'BR' => '55', 'MX' => '52', 'AR' => '54', 'CO' => '57',
            'CL' => '56', 'PE' => '51', 'VE' => '58', 'EC' => '593',
            'NZ' => '64', 'PK' => '92', 'BD' => '880', 'LK' => '94',
        ];
        
        return $countryCodes[strtoupper($country)] ?? '1';
    }

    /**
     * Transfer domain to registrar (Transfer In)
     */
    public function transfer(Request $request, Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_not_configured') ?? 'Dynadot registrar not configured or disabled',
                ]);
            }
            
            // Get auth_code - first check request, then domain configuration, then related order item
            $authCode = $request->input('auth_code');
            
            if (empty($authCode)) {
                // Check domain configuration
                $authCode = $domain->configuration['auth_code'] ?? null;
            }
            
            if (empty($authCode) && $domain->order_id) {
                // Check related OrderItem configuration
                $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
                    ->where('type', 'domain')
                    ->first();
                if ($orderItem) {
                    $authCode = $orderItem->configuration['auth_code'] ?? null;
                }
            }
            
            if (empty($authCode)) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.auth_code_required') ?? 'Auth code (EPP code) is required for domain transfer',
                    'requires_auth_code' => true,
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Call Dynadot API to transfer domain
            $result = $dynadotService->transferDomain($domain->domain_name, $authCode, [
                'currency' => 'USD',
            ]);
            
            \Log::info('Dynadot transferDomain result (Admin)', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);
            
            // Check response status
            $responseCode = $result['TransferResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $status = $result['TransferResponse']['Status'] ?? ($result['Status'] ?? null);
            $error = $result['TransferResponse']['Error'] ?? ($result['Error'] ?? null);
            
            // Success if ResponseCode is 0 and Status is success
            if ($responseCode === 0 && $status === 'success') {
                // Update domain status to pending_transfer
                $domain->update([
                    'status' => Domain::STATUS_PENDING_TRANSFER,
                    'order_type' => 'transfer',
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.domain_transfer_initiated') ?? 'Domain transfer initiated successfully',
                ]);
            } else {
                // Handle specific error messages
                $errorMessage = $error ?? __('crm.domain_transfer_failed') ?? 'Domain transfer failed';
                
                // Check for common errors
                if (stripos($errorMessage, 'already a transfer request in progress') !== false) {
                    // Update status anyway since transfer is already in progress
                    $domain->update([
                        'status' => Domain::STATUS_PENDING_TRANSFER,
                        'order_type' => 'transfer',
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => __('crm.transfer_already_in_progress') ?? 'Transfer is already in progress for this domain',
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Domain transfer error', [
                'domain_id' => $domain->id,
                'domain_name' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.domain_transfer_error') ?? 'Error initiating domain transfer: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Renew domain
     */
    public function renew(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.dynadot_not_configured') ?? 'Dynadot registrar not configured or disabled',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Prepare renewal options
            $options = [
                'currency' => 'USD',
            ];
            
            // Call Dynadot API to renew domain
            $result = $dynadotService->renewDomain(
                $domain->domain_name, 
                $domain->registration_period ?? 1,
                $options
            );
            
            \Log::info('Dynadot renewDomain result', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);
            
            // Check response status
            $responseCode = $result['RenewResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $status = $result['RenewResponse']['Status'] ?? ($result['Status'] ?? null);
            
            // Success if ResponseCode is 0 and Status is success
            if ($responseCode === 0 && $status === 'success') {
                // Get new expiry date from response if available
                $newExpiry = null;
                if (isset($result['RenewResponse']['Expiration'])) {
                    $newExpiry = \Carbon\Carbon::createFromTimestamp($result['RenewResponse']['Expiration'] / 1000);
                } else {
                    // Calculate new expiry by adding registration period to current expiry
                    $currentExpiry = $domain->expiry_date ?? now();
                    $newExpiry = $currentExpiry->copy()->addYears($domain->registration_period ?? 1);
                }
                
                // Update domain
                $domain->update([
                    'expiry_date' => $newExpiry,
                    'next_due_date' => $newExpiry,
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.domain_renewed_successfully') ?? 'Domain renewed successfully',
                ]);
            } else {
                // Get specific error message based on status
                $errorMessages = [
                    'not_available' => __('crm.domain_not_in_account') ?? 'Domain is not in your Dynadot account',
                    'insufficient_balance' => __('crm.insufficient_balance') ?? 'Insufficient balance in Dynadot account',
                    'insufficient_funds' => __('crm.insufficient_balance') ?? 'Insufficient balance in Dynadot account',
                    'invalid_domain' => __('crm.invalid_domain_name') ?? 'Invalid domain name',
                    'error' => $result['RenewResponse']['Error'] ?? ($result['Error'] ?? 'Renewal failed'),
                ];
                
                $errorMessage = $errorMessages[$status] ?? ($result['RenewResponse']['Error'] ?? ($status ?? 'Unknown error'));
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Domain renewal error', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.domain_renewal_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Modify contact details - Send client data to Dynadot
     */
    public function modifyContactDetails(Request $request, Domain $domain)
    {
        try {
            // Get client
            $client = $domain->client;
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.domain_has_no_client') ?? 'Domain has no associated client',
                ]);
            }
            
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.registrar_not_configured') ?? 'Registrar not configured or disabled',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Prepare contact data from client
            $contact = [
                'name' => trim($client->first_name . ' ' . $client->last_name),
                'email' => $client->email,
                'phone' => preg_replace('/[^0-9]/', '', $client->phone ?? ''),
                'phone_cc' => $client->country_code ?? '1',
                'address1' => $client->address1 ?? $client->address_1 ?? '',
                'address2' => $client->address2 ?? $client->address_2 ?? '',
                'city' => $client->city ?? '',
                'state' => $client->state ?? '',
                'postcode' => $client->postcode ?? '',
                'country' => $client->country ?? '',
                'organization' => $client->company_name ?? '',
            ];
            
            // Call Dynadot API to set contact
            $result = $dynadotService->setContact($domain->domain_name, $contact);
            
            \Log::info('Dynadot setContact result', [
                'domain' => $domain->domain_name,
                'contact' => $contact,
                'result' => $result
            ]);
            
            // Check response status - handle both SetWhoisResponse (from set_whois) and CreateContactResponse (if contact creation failed)
            $responseCode = $result['SetWhoisResponse']['ResponseCode'] 
                ?? ($result['SetWhoisResponse']['SuccessCode'] ?? null)
                ?? ($result['CreateContactResponse']['ResponseCode'] ?? null)
                ?? ($result['ResponseCode'] ?? null);
            $status = $result['SetWhoisResponse']['Status'] 
                ?? ($result['CreateContactResponse']['Status'] ?? null)
                ?? ($result['Status'] ?? null);
            
            if (($responseCode === 0 || $responseCode === '0') && $status === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => __('crm.contact_updated_successfully') ?? 'Contact information updated successfully',
                ]);
            } else {
                $errorMessage = $result['SetWhoisResponse']['Error'] 
                    ?? ($result['CreateContactResponse']['Error'] ?? null)
                    ?? ($result['Error'] ?? ($status ?? 'Unknown error'));
                
                return response()->json([
                    'success' => false,
                    'message' => __('crm.contact_update_failed') . ': ' . $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Modify contact error', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.contact_update_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Get EPP/Auth code from registrar
     */
    public function getEppCode(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.registrar_not_configured') ?? 'Registrar not configured or disabled',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Call Dynadot API to get EPP code
            $result = $dynadotService->getTransferAuthCode($domain->domain_name);
            
            \Log::info('Dynadot getTransferAuthCode result', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);
            
            // Check response status
            $responseCode = $result['GetTransferAuthCodeResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $status = $result['GetTransferAuthCodeResponse']['Status'] ?? ($result['Status'] ?? null);
            $authCode = $result['GetTransferAuthCodeResponse']['AuthCode'] ?? ($result['AuthCode'] ?? null);
            
            if (($responseCode === 0 || $responseCode === '0') && $authCode) {
                // Save auth code to domain
                $domain->update(['auth_code' => $authCode]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.epp_code_retrieved') ?? 'EPP code retrieved successfully',
                    'auth_code' => $authCode,
                ]);
            } else {
                $errorMessage = $result['GetTransferAuthCodeResponse']['Error'] ?? ($result['Error'] ?? ($status ?? 'Unknown error'));
                
                return response()->json([
                    'success' => false,
                    'message' => __('crm.epp_code_failed') . ': ' . $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Get EPP code error', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.epp_code_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Request domain deletion
     * WARNING: This action is IRREVERSIBLE and NO REFUND will be given
     */
    public function requestDelete(Domain $domain)
    {
        try {
            // Get active Dynadot registrar
            $registrar = DomainRegistrar::where('name', 'like', '%dynadot%')
                ->where('status', 1)
                ->first();
            
            if (!$registrar) {
                return response()->json([
                    'success' => false,
                    'message' => __('crm.registrar_not_configured') ?? 'Registrar not configured or disabled',
                ]);
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Call Dynadot API to delete domain
            $result = $dynadotService->deleteDomain($domain->domain_name);
            
            \Log::warning('Dynadot deleteDomain result', [
                'domain' => $domain->domain_name,
                'result' => $result
            ]);
            
            // Check response status
            $responseCode = $result['DeleteRegistrationResponse']['ResponseCode'] ?? ($result['ResponseCode'] ?? null);
            $status = $result['DeleteRegistrationResponse']['Status'] ?? ($result['Status'] ?? null);
            
            if (($responseCode === 0 || $responseCode === '0') && $status === 'success') {
                // Update domain status
                $domain->update(['status' => Domain::STATUS_CANCELLED]);
                
                return response()->json([
                    'success' => true,
                    'message' => __('crm.domain_deleted_successfully') ?? 'Domain deleted successfully',
                ]);
            } else {
                // Get specific error message
                $errorMessages = [
                    'not_available' => __('crm.domain_not_in_account') ?? 'Domain is not in your account',
                    'domain_not_in_grace_period' => __('crm.domain_not_in_grace_period') ?? 'Domain is not in grace period. Deletion only works within 5 days of registration.',
                    'cannot_delete' => __('crm.domain_cannot_be_deleted') ?? 'Domain cannot be deleted',
                ];
                
                $errorMessage = $errorMessages[$status] ?? ($result['DeleteRegistrationResponse']['Error'] ?? ($status ?? 'Unknown error'));
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Domain deletion error', [
                'domain' => $domain->domain_name,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => __('crm.domain_deletion_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Enable ID Protection
     */
    public function enableIdProtection(Domain $domain)
    {
        $dynadotError = null;
        
        // Try to sync with Dynadot
        $registrar = \App\Models\DomainRegistrar::where('name', 'like', '%dynadot%')
            ->where('status', 1)
            ->first();
            
        if ($registrar) {
            try {
                $dynadotService = new \App\Services\DynadotService($registrar);
                $result = $dynadotService->setPrivacy($domain->domain_name, 'full');
                
                \Log::info('Dynadot setPrivacy result', ['result' => $result, 'option' => 'full']);
                
                // Check for success
                $isSuccess = isset($result['SetPrivacyResponse']['Status']) && $result['SetPrivacyResponse']['Status'] === 'success';
                if (!$isSuccess) {
                    $isSuccess = isset($result['ResponseCode']) && $result['ResponseCode'] == 0;
                }
                
                if (!$isSuccess) {
                    $dynadotError = $result['Error'] ?? 'Unknown error';
                }
            } catch (\Exception $e) {
                \Log::error('Dynadot setPrivacy error', ['error' => $e->getMessage()]);
                $dynadotError = $e->getMessage();
            }
        }
        
        $domain->update(['id_protection' => true]);
        
        $message = __('crm.id_protection_enabled');
        if ($dynadotError) {
            $message .= ' (' . __('crm.dynadot_sync_failed') . ')';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'id_protection' => true,
        ]);
    }

    /**
     * Disable ID Protection
     */
    public function disableIdProtection(Domain $domain)
    {
        $dynadotError = null;
        
        // Try to sync with Dynadot
        $registrar = \App\Models\DomainRegistrar::where('name', 'like', '%dynadot%')
            ->where('status', 1)
            ->first();
            
        if ($registrar) {
            try {
                $dynadotService = new \App\Services\DynadotService($registrar);
                $result = $dynadotService->setPrivacy($domain->domain_name, 'off');
                
                \Log::info('Dynadot setPrivacy result', ['result' => $result, 'option' => 'off']);
                
                // Check for success
                $isSuccess = isset($result['SetPrivacyResponse']['Status']) && $result['SetPrivacyResponse']['Status'] === 'success';
                if (!$isSuccess) {
                    $isSuccess = isset($result['ResponseCode']) && $result['ResponseCode'] == 0;
                }
                
                if (!$isSuccess) {
                    $dynadotError = $result['Error'] ?? 'Unknown error';
                }
            } catch (\Exception $e) {
                \Log::error('Dynadot setPrivacy error', ['error' => $e->getMessage()]);
                $dynadotError = $e->getMessage();
            }
        }
        
        $domain->update(['id_protection' => false]);
        
        $message = __('crm.id_protection_disabled');
        if ($dynadotError) {
            $message .= ' (' . __('crm.dynadot_sync_failed') . ')';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'id_protection' => false,
        ]);
    }

    /**
     * Mark contact as verified
     */
    public function markContactVerified(Domain $domain)
    {
        // TODO: Implement contact verification with Dynadot API
        
        return response()->json([
            'success' => true,
            'message' => __('crm.contact_marked_as_verified'),
        ]);
    }

    /**
     * Sync domain with registrar
     */
    public function sync(Domain $domain)
    {
        // TODO: Implement domain sync with Dynadot API
        
        return response()->json([
            'success' => true,
            'message' => __('crm.domain_sync_initiated'),
        ]);
    }
}
