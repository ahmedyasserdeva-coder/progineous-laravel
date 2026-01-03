<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ServiceSuspendedMail;
use App\Mail\ServiceTerminatedMail;
use App\Mail\ServiceUnsuspendedMail;
use App\Models\Service;
use App\Services\CpanelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(Request $request)
    {
        $query = Service::with('client');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%")
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
        
        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $services = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        return view('admin.services.index', compact('services'));
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        $service->load(['client', 'order.invoice.payments', 'orderItem', 'server']);
        
        // Get all invoices related to this service (through order_id)
        $invoices = \App\Models\Invoice::where('order_id', $service->order_id)
            ->orWhere(function($query) use ($service) {
                $query->where('client_id', $service->client_id)
                      ->where('notes', 'like', '%Service #' . $service->id . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.services.show', compact('service', 'invoices'));
    }

    /**
     * Display the specified reseller hosting service.
     */
    public function showReseller(Service $service)
    {
        $service->load(['client', 'order.invoice.payments', 'orderItem', 'server']);
        
        // Get all invoices related to this service (through order_id)
        $invoices = \App\Models\Invoice::where('order_id', $service->order_id)
            ->orWhere(function($query) use ($service) {
                $query->where('client_id', $service->client_id)
                      ->where('notes', 'like', '%Service #' . $service->id . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get product with cPanel tiers for this service
        $product = null;
        $cpanelTiers = collect();
        if ($service->orderItem && isset($service->orderItem->configuration['plan'])) {
            $planName = $service->orderItem->configuration['plan'];
            $product = \App\Models\Product::where('name', 'like', '%' . $planName . '%')
                ->orWhere('name', $planName)
                ->whereHas('cpanelTiers')
                ->with('cpanelTiers')
                ->first();
            
            if ($product) {
                $cpanelTiers = $product->cpanelTiers;
            }
        }
        
        return view('admin.services.reseller-show', compact('service', 'invoices', 'product', 'cpanelTiers'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $service->load('client');
        
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|in:active,pending,suspended,cancelled,terminated,failed',
            'domain' => 'nullable|string|max:255',
            'next_due_date' => 'nullable|date',
            'recurring_amount' => 'nullable|numeric|min:0',
            'billing_cycle' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        
        $service->update($validated);
        
        return redirect()->route('admin.services.show', $service)
            ->with('success', __('crm.service_updated') ?? 'Service updated successfully');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        $clientId = $service->client_id;
        $serviceName = $service->service_name;
        
        $service->delete();
        
        return redirect()->route('admin.clients.show', $clientId)
            ->with('success', __('crm.service_deleted', ['name' => $serviceName]) ?? "Service '{$serviceName}' deleted successfully");
    }

    /**
     * Update service status
     */
    public function updateStatus(Request $request, Service $service)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:active,pending,suspended,cancelled,terminated',
        ]);
        
        $oldStatus = $service->status;
        
        $service->update([
            'status' => $validated['status'],
            'activated_at' => $validated['status'] === 'active' && $oldStatus !== 'active' ? now() : $service->activated_at,
            'suspended_at' => $validated['status'] === 'suspended' ? now() : $service->suspended_at,
            'terminated_at' => $validated['status'] === 'terminated' ? now() : $service->terminated_at,
        ]);
        
        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('crm.status_updated') ?? 'Status updated successfully',
            ]);
        }
        
        // Otherwise redirect back
        return redirect()->back()->with('success', __('crm.status_updated') ?? 'Status updated successfully');
    }

    /**
     * Suspend service
     */
    public function suspend(Request $request, Service $service)
    {
        // Get reason - use custom_reason if "other" is selected
        $reason = $request->input('reason', 'Suspended by admin');
        if ($reason === 'other' && $request->filled('custom_reason')) {
            $reason = $request->input('custom_reason');
        }
        
        // If service has a server and username, suspend in WHM
        if ($service->server_id && $service->username) {
            try {
                $service->load('server');
                
                if ($service->server && in_array($service->server->type, ['cpanel', 'whm'])) {
                    $cpanelService = app(CpanelService::class)->configureForServer($service->server);
                    $result = $cpanelService->suspendAccount($service->username, $reason);
                    
                    if ($result === false || (isset($result['metadata']['result']) && $result['metadata']['result'] == 0)) {
                        $errorMsg = $result['metadata']['reason'] ?? 'Unknown error';
                        Log::error('WHM Suspend Failed', [
                            'service_id' => $service->id,
                            'username' => $service->username,
                            'error' => $errorMsg
                        ]);
                        
                        return back()->with('error', __('crm.whm_suspend_failed') . ': ' . $errorMsg);
                    }
                    
                    Log::info('WHM Account Suspended', [
                        'service_id' => $service->id,
                        'username' => $service->username
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('WHM Suspend Exception', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage()
                ]);
                
                return back()->with('error', __('crm.whm_suspend_failed') . ': ' . $e->getMessage());
            }
        }
        
        // Update service status in database
        $service->update([
            'status' => 'suspended',
            'suspended_at' => now(),
        ]);
        
        // Send email notification to client
        try {
            $service->load('client');
            if ($service->client && $service->client->email) {
                Mail::to($service->client->email)->send(
                    new ServiceSuspendedMail($service, $service->client, $reason)
                );
                
                Log::info('Service Suspension Email Sent', [
                    'service_id' => $service->id,
                    'client_email' => $service->client->email
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send suspension email', [
                'service_id' => $service->id,
                'error' => $e->getMessage()
            ]);
            // Continue even if email fails - service is already suspended
        }
        
        return back()->with('success', __('crm.service_suspended') ?? 'Service suspended successfully');
    }

    /**
     * Unsuspend/Activate service
     */
    public function unsuspend(Service $service)
    {
        // If service has a server and username, unsuspend in WHM
        if ($service->server_id && $service->username) {
            try {
                $service->load('server');
                
                if ($service->server && in_array($service->server->type, ['cpanel', 'whm'])) {
                    $cpanelService = app(CpanelService::class)->configureForServer($service->server);
                    $result = $cpanelService->unsuspendAccount($service->username);
                    
                    if ($result === false || (isset($result['metadata']['result']) && $result['metadata']['result'] == 0)) {
                        $errorMsg = $result['metadata']['reason'] ?? 'Unknown error';
                        Log::error('WHM Unsuspend Failed', [
                            'service_id' => $service->id,
                            'username' => $service->username,
                            'error' => $errorMsg
                        ]);
                        
                        return back()->with('error', __('crm.whm_unsuspend_failed') . ': ' . $errorMsg);
                    }
                    
                    Log::info('WHM Account Unsuspended', [
                        'service_id' => $service->id,
                        'username' => $service->username
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('WHM Unsuspend Exception', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage()
                ]);
                
                return back()->with('error', __('crm.whm_unsuspend_failed') . ': ' . $e->getMessage());
            }
        }
        
        // Update service status in database
        $service->update([
            'status' => 'active',
            'suspended_at' => null,
        ]);
        
        // Send email notification to client
        try {
            $service->load('client');
            if ($service->client && $service->client->email) {
                Mail::to($service->client->email)->send(
                    new ServiceUnsuspendedMail($service, $service->client)
                );
                
                Log::info('Service Unsuspension Email Sent', [
                    'service_id' => $service->id,
                    'client_email' => $service->client->email
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send unsuspension email', [
                'service_id' => $service->id,
                'error' => $e->getMessage()
            ]);
            // Continue even if email fails - service is already activated
        }
        
        return back()->with('success', __('crm.service_activated') ?? 'Service activated successfully');
    }

    /**
     * Terminate service
     */
    public function terminate(Request $request, Service $service)
    {
        $keepDns = $request->boolean('keep_dns', false);
        
        // If service has a server and username, terminate in WHM
        if ($service->server_id && $service->username) {
            try {
                $service->load('server');
                
                if ($service->server && in_array($service->server->type, ['cpanel', 'whm'])) {
                    $cpanelService = app(CpanelService::class)->configureForServer($service->server);
                    $result = $cpanelService->terminateAccount($service->username, $keepDns);
                    
                    if ($result === false || (isset($result['metadata']['result']) && $result['metadata']['result'] == 0)) {
                        $errorMsg = $result['metadata']['reason'] ?? 'Unknown error';
                        Log::error('WHM Terminate Failed', [
                            'service_id' => $service->id,
                            'username' => $service->username,
                            'error' => $errorMsg
                        ]);
                        
                        return back()->with('error', __('crm.whm_terminate_failed') . ': ' . $errorMsg);
                    }
                    
                    Log::info('WHM Account Terminated', [
                        'service_id' => $service->id,
                        'username' => $service->username
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('WHM Terminate Exception', [
                    'service_id' => $service->id,
                    'error' => $e->getMessage()
                ]);
                
                return back()->with('error', __('crm.whm_terminate_failed') . ': ' . $e->getMessage());
            }
        }
        
        // Update service status in database
        $service->update([
            'status' => 'terminated',
            'terminated_at' => now(),
        ]);
        
        // Send email notification to client
        try {
            $service->load('client');
            if ($service->client && $service->client->email) {
                Mail::to($service->client->email)->send(
                    new ServiceTerminatedMail($service, $service->client)
                );
                Log::info('Service Termination Email Sent', [
                    'service_id' => $service->id,
                    'client_id' => $service->client->id,
                    'email' => $service->client->email
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send termination email', [
                'service_id' => $service->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return back()->with('success', __('crm.service_terminated') ?? 'Service terminated successfully');
    }

    /**
     * Change cPanel password for a service
     */
    public function changePassword(Request $request, Service $service)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        // Check if service has WHM credentials
        if (!$service->server_id || !$service->username) {
            return back()->with('error', __('crm.service_not_configured_for_whm') ?? 'Service is not configured for WHM');
        }

        try {
            $service->load('server');
            
            if (!$service->server || !in_array($service->server->type, ['cpanel', 'whm'])) {
                return back()->with('error', __('crm.invalid_server_type') ?? 'Invalid server type');
            }

            $cpanelService = app(CpanelService::class)->configureForServer($service->server);
            $result = $cpanelService->changeAccountPassword($service->username, $request->password);

            if ($result && isset($result['success']) && $result['success']) {
                // Update password in database
                $service->update([
                    'password' => encrypt($request->password),
                ]);

                Log::info('cPanel Password Changed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'admin_id' => auth()->guard('admin')->id(),
                ]);

                // Redirect with full page reload to show updated password
                return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.password_changed_successfully') ?? 'Password changed successfully');
            } else {
                $errorMsg = $result['message'] ?? 'Unknown error';
                Log::error('cPanel Password Change Failed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'error' => $errorMsg,
                ]);

                return back()->with('error', __('crm.password_change_failed') . ': ' . $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('cPanel Password Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', __('crm.password_change_failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Update WHM credentials for a reseller hosting service
     * This is for manual provisioning where admin adds credentials
     */
    public function updateWhmCredentials(Request $request, Service $service)
    {
        // Auto-add https:// if not present
        $whmLoginUrl = $request->whm_login_url;
        if ($whmLoginUrl && !preg_match('/^https?:\/\//', $whmLoginUrl)) {
            $whmLoginUrl = 'https://' . $whmLoginUrl;
            $request->merge(['whm_login_url' => $whmLoginUrl]);
        }

        Log::info('WHM Credentials Update Request Received', [
            'service_id' => $service->id,
            'request_data' => $request->except('password'),
        ]);

        $request->validate([
            'whm_login_url' => 'required|url',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:1',
            'activate_service' => 'nullable|boolean',
            'whm_customer_note' => 'nullable|string|max:1000',
            'whm_ip_address' => 'nullable|ip',
        ]);

        try {
            // Update service credentials
            $service->username = $request->username;
            $service->password = encrypt($request->password);
            
            // Update metadata with WHM login URL
            $metadata = $service->metadata ?? [];
            $metadata['whm_login_url'] = $request->whm_login_url;
            $metadata['whm_customer_note'] = $request->whm_customer_note;
            $metadata['whm_ip_address'] = $request->whm_ip_address;
            $metadata['credentials_updated_at'] = now()->toISOString();
            $metadata['credentials_updated_by'] = auth()->guard('admin')->id();
            $service->metadata = $metadata;
            
            // Activate service if checkbox is checked
            if ($request->boolean('activate_service') && $service->status === 'pending') {
                $service->status = 'active';
                $service->activated_at = now();
            }
            
            $service->save();

            Log::info('WHM Credentials Updated', [
                'service_id' => $service->id,
                'admin_id' => auth()->guard('admin')->id(),
                'activated' => $request->boolean('activate_service'),
            ]);

            return redirect()->route('admin.services.reseller.show', $service)
                ->with('success', __('crm.whm_credentials_updated') ?? 'WHM credentials updated successfully');
        } catch (\Exception $e) {
            Log::error('WHM Credentials Update Failed', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', __('crm.whm_credentials_update_failed') ?? 'Failed to update WHM credentials: ' . $e->getMessage());
        }
    }

    /**
     * Update cPanel accounts count for reseller service
     */
    public function updateCpanelAccounts(Request $request, Service $service)
    {
        $request->validate([
            'cpanel_accounts' => 'required|integer|min:1|max:1000',
        ]);

        try {
            $newCpanelAccounts = (int) $request->cpanel_accounts;
            $oldCpanelAccounts = $service->orderItem->configuration['cpanel_accounts'] ?? $service->server_data['cpanel_accounts'] ?? 0;
            
            // Get product and calculate new price
            $product = null;
            $tierPrice = 0;
            $billingCycle = $service->billing_cycle ?? $service->orderItem->configuration['billing_cycle'] ?? 'monthly';
            
            if ($service->orderItem && isset($service->orderItem->configuration['plan'])) {
                $planName = $service->orderItem->configuration['plan'];
                $product = \App\Models\Product::where('name', 'like', '%' . $planName . '%')
                    ->orWhere('name', $planName)
                    ->whereHas('cpanelTiers')
                    ->with('cpanelTiers')
                    ->first();
            }
            
            // Calculate tier price based on billing cycle
            if ($product) {
                $billingCycleMapping = [
                    'monthly' => 'monthly_price',
                    'quarterly' => 'quarterly_price',
                    'semi-annually' => 'semi_annually_price',
                    'semi_annually' => 'semi_annually_price',
                    'annually' => 'annually_price',
                    'biennially' => 'biennially_price',
                    'triennially' => 'triennially_price',
                ];
                $priceColumn = $billingCycleMapping[$billingCycle] ?? 'monthly_price';
                
                // Find the matching tier
                $tier = $product->cpanelTiers->where('tier', $newCpanelAccounts)->first();
                if ($tier) {
                    $tierPrice = (float) $tier->$priceColumn;
                }
                
                // Get base product price
                $basePriceColumn = str_replace('_price', '', $priceColumn);
                $basePrice = 0;
                if ($product->pricing && isset($product->pricing['recurring'][$basePriceColumn]['price'])) {
                    $basePrice = (float) $product->pricing['recurring'][$basePriceColumn]['price'];
                } elseif ($product->pricing && isset($product->pricing['recurring'][str_replace('_', '-', $basePriceColumn)]['price'])) {
                    $basePrice = (float) $product->pricing['recurring'][str_replace('_', '-', $basePriceColumn)]['price'];
                }
                
                // Calculate new recurring amount
                $newRecurringAmount = $basePrice + $tierPrice;
                
                // Update service recurring amount
                $service->recurring_amount = $newRecurringAmount;
            }
            
            // Update in orderItem configuration
            if ($service->orderItem) {
                $configuration = $service->orderItem->configuration ?? [];
                $configuration['cpanel_accounts'] = $newCpanelAccounts;
                $configuration['cpanel_tier_price'] = $tierPrice;
                $service->orderItem->configuration = $configuration;
                $service->orderItem->save();
            }

            // Also update in server_data as backup
            $serverData = $service->server_data ?? [];
            $serverData['cpanel_accounts'] = $newCpanelAccounts;
            $service->server_data = $serverData;
            $service->save();

            Log::info('cPanel Accounts Updated', [
                'service_id' => $service->id,
                'admin_id' => auth()->guard('admin')->id(),
                'old_cpanel_accounts' => $oldCpanelAccounts,
                'new_cpanel_accounts' => $newCpanelAccounts,
                'tier_price' => $tierPrice,
                'new_recurring_amount' => $service->recurring_amount,
            ]);

            return redirect()->route('admin.services.reseller.show', $service)
                ->with('success', __('crm.cpanel_accounts_updated') ?? 'cPanel accounts updated successfully');
        } catch (\Exception $e) {
            Log::error('cPanel Accounts Update Failed', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', __('crm.cpanel_accounts_update_failed') ?? 'Failed to update cPanel accounts: ' . $e->getMessage());
        }
    }

    /**
     * Change cPanel username via WHM API
     */
    public function changeUsername(Request $request, Service $service)
    {
        $request->validate([
            'username' => 'required|string|min:1|max:16|regex:/^[a-z][a-z0-9]*$/i',
        ]);

        // Check if service has WHM credentials
        if (!$service->server_id || !$service->username) {
            return back()->with('error', __('crm.service_not_configured_for_whm') ?? 'Service is not configured for WHM');
        }

        try {
            $service->load('server');

            if (!$service->server || !in_array($service->server->type, ['cpanel', 'whm'])) {
                return back()->with('error', __('crm.invalid_server_type') ?? 'Invalid server type');
            }

            $oldUsername = $service->username;
            $newUsername = strtolower($request->username);

            // Check if username is the same
            if ($oldUsername === $newUsername) {
                return back()->with('error', __('crm.username_same_as_current') ?? 'New username is the same as current');
            }

            $cpanelService = app(CpanelService::class)->configureForServer($service->server);
            $result = $cpanelService->changeAccountUsername($oldUsername, $newUsername);

            if ($result && isset($result['success']) && $result['success']) {
                // Update username in database
                $service->update([
                    'username' => $newUsername,
                ]);

                // Also update server_data if it has cpanel_username
                if ($service->server_data && isset($service->server_data['cpanel_username'])) {
                    $serverData = $service->server_data;
                    $serverData['cpanel_username'] = $newUsername;
                    $service->update(['server_data' => $serverData]);
                }

                Log::info('cPanel Username Changed', [
                    'service_id' => $service->id,
                    'old_username' => $oldUsername,
                    'new_username' => $newUsername,
                    'admin_id' => auth()->guard('admin')->id(),
                ]);

                return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.username_changed_successfully') ?? 'Username changed successfully');
            } else {
                $errorMsg = $result['message'] ?? 'Unknown error';
                Log::error('cPanel Username Change Failed', [
                    'service_id' => $service->id,
                    'old_username' => $oldUsername,
                    'new_username' => $newUsername,
                    'error' => $errorMsg,
                ]);

                return back()->with('error', (__('crm.username_change_failed') ?? 'Failed to change username') . ': ' . $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('cPanel Username Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.username_change_failed') ?? 'Failed to change username') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change cPanel package/plan via WHM API
     */
    public function changePackage(Request $request, Service $service)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'package' => 'required|string',
        ]);

        // Check if service has WHM credentials
        if (!$service->server_id || !$service->username) {
            return back()->with('error', __('crm.service_not_configured_for_whm') ?? 'Service is not configured for WHM');
        }

        try {
            $service->load('server');

            if (!$service->server || !in_array($service->server->type, ['cpanel', 'whm'])) {
                return back()->with('error', __('crm.invalid_server_type') ?? 'Invalid server type');
            }

            // Get the new product
            $newProduct = \App\Models\Product::find($request->product_id);
            if (!$newProduct || !$newProduct->whm_package_name) {
                return back()->with('error', __('crm.invalid_product') ?? 'Invalid product selected');
            }

            $cpanelService = app(CpanelService::class)->configureForServer($service->server);
            $result = $cpanelService->changePackage($service->username, $newProduct->whm_package_name);

            if ($result && isset($result['success']) && $result['success']) {
                // Update package in database
                $oldPackage = $service->whm_package;
                $oldProductId = $service->product_id;
                $oldRecurringAmount = $service->recurring_amount;
                
                // Get the new recurring amount based on service's billing cycle
                $billingCycle = $service->billing_cycle ?? 'monthly';
                $newRecurringAmount = $oldRecurringAmount; // Default to old amount
                
                if ($newProduct->pricing && isset($newProduct->pricing['recurring'][$billingCycle]['price'])) {
                    $newRecurringAmount = $newProduct->pricing['recurring'][$billingCycle]['price'];
                } elseif ($newProduct->price) {
                    $newRecurringAmount = $newProduct->price;
                }
                
                // Generate new service name: "Package Name - Domain"
                $newServiceName = $newProduct->name . ' - ' . $service->domain;
                
                $service->update([
                    'whm_package' => $newProduct->whm_package_name,
                    'product_id' => $newProduct->id,
                    'package_name' => $newProduct->name,
                    'service_name' => $newServiceName,
                    'recurring_amount' => $newRecurringAmount,
                ]);

                // Also update server_data if it has whm_package
                if ($service->server_data) {
                    $serverData = $service->server_data;
                    $serverData['whm_package'] = $newProduct->whm_package_name;
                    $service->update(['server_data' => $serverData]);
                }

                Log::info('cPanel Package Changed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'old_package' => $oldPackage,
                    'new_package' => $newProduct->whm_package_name,
                    'old_product_id' => $oldProductId,
                    'new_product_id' => $newProduct->id,
                    'old_recurring_amount' => $oldRecurringAmount,
                    'new_recurring_amount' => $newRecurringAmount,
                    'billing_cycle' => $billingCycle,
                    'admin_id' => auth()->guard('admin')->id(),
                ]);

                return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.package_changed_successfully') ?? 'Package changed successfully');
            } else {
                $errorMsg = $result['message'] ?? 'Unknown error';
                Log::error('cPanel Package Change Failed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'new_package' => $newProduct->whm_package_name,
                    'error' => $errorMsg,
                ]);

                return back()->with('error', (__('crm.package_change_failed') ?? 'Failed to change package') . ': ' . $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('cPanel Package Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.package_change_failed') ?? 'Failed to change package') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service domain via WHM API
     */
    public function changeDomain(Request $request, Service $service)
    {
        $request->validate([
            'new_domain' => 'required|string|max:255',
        ]);

        $newDomain = strtolower(trim($request->new_domain));

        // Basic domain validation
        if (!preg_match('/^[a-z0-9][a-z0-9-]*(\.[a-z0-9][a-z0-9-]*)+$/', $newDomain)) {
            return back()->with('error', __('crm.invalid_domain_format') ?? 'Invalid domain format');
        }

        // Check if same domain
        if ($newDomain === strtolower($service->domain)) {
            return back()->with('error', __('crm.domain_same_as_current') ?? 'New domain is the same as current domain');
        }

        // Check if service has WHM credentials
        if (!$service->server_id || !$service->username) {
            return back()->with('error', __('crm.service_not_configured_for_whm') ?? 'Service is not configured for WHM');
        }

        try {
            $service->load('server');

            if (!$service->server || !in_array($service->server->type, ['cpanel', 'whm'])) {
                return back()->with('error', __('crm.invalid_server_type') ?? 'Invalid server type');
            }

            $cpanelService = app(CpanelService::class)->configureForServer($service->server);
            
            // Check if domain already exists on server
            $domainCheck = $cpanelService->domainExistsInWhm($newDomain);
            if ($domainCheck && isset($domainCheck['exists']) && $domainCheck['exists']) {
                return back()->with('error', __('crm.domain_already_exists_on_server') ?? 'Domain already exists on this server');
            }

            $result = $cpanelService->changeAccountDomain($service->username, $newDomain);

            if ($result && isset($result['success']) && $result['success']) {
                $oldDomain = $service->domain;
                
                // Update service name to reflect new domain
                $packageName = $service->package_name ?? $service->whm_package ?? '';
                $newServiceName = $packageName ? $packageName . ' - ' . $newDomain : $newDomain;
                
                $service->update([
                    'domain' => $newDomain,
                    'service_name' => $newServiceName,
                ]);

                Log::info('cPanel Domain Changed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'old_domain' => $oldDomain,
                    'new_domain' => $newDomain,
                    'admin_id' => auth()->guard('admin')->id(),
                ]);

                return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.domain_changed_successfully') ?? 'Domain changed successfully');
            } else {
                $errorMsg = $result['message'] ?? 'Unknown error';
                Log::error('cPanel Domain Change Failed', [
                    'service_id' => $service->id,
                    'username' => $service->username,
                    'new_domain' => $newDomain,
                    'error' => $errorMsg,
                ]);

                return back()->with('error', (__('crm.domain_change_failed') ?? 'Failed to change domain') . ': ' . $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('cPanel Domain Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.domain_change_failed') ?? 'Failed to change domain') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service server (database update only - manual migration required)
     */
    public function changeServer(Request $request, Service $service)
    {
        $request->validate([
            'server_id' => 'required|exists:servers,id',
        ]);

        $newServerId = $request->server_id;

        // Check if same server
        if ($newServerId == $service->server_id) {
            return back()->with('error', __('crm.server_same_as_current') ?? 'New server is the same as current server');
        }

        try {
            $newServer = \App\Models\Server::find($newServerId);
            
            if (!$newServer || (!$newServer->status && $newServer->status !== 'active')) {
                return back()->with('error', __('crm.invalid_server') ?? 'Invalid or inactive server selected');
            }

            if (!in_array($newServer->type, ['cpanel', 'whm'])) {
                return back()->with('error', __('crm.invalid_server_type') ?? 'Invalid server type');
            }

            $oldServerId = $service->server_id;
            $oldServerName = $service->server->name ?? 'Unknown';
            
            $service->update([
                'server_id' => $newServerId,
            ]);

            Log::info('Service Server Changed', [
                'service_id' => $service->id,
                'username' => $service->username,
                'old_server_id' => $oldServerId,
                'old_server_name' => $oldServerName,
                'new_server_id' => $newServerId,
                'new_server_name' => $newServer->name,
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.server_changed_successfully') ?? 'Server changed successfully. Remember to manually migrate the cPanel account.');

        } catch (\Exception $e) {
            Log::error('Service Server Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.server_change_failed') ?? 'Failed to change server') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service datacenter
     */
    public function changeDatacenter(Request $request, Service $service)
    {
        $request->validate([
            'datacenter' => 'required|string|max:50',
        ]);

        $newDatacenter = $request->datacenter;

        // Datacenter name mapping
        $datacenterNames = [
            'us-east' => 'United States (East)',
            'us-west' => 'United States (West)',
            'eu-west' => 'Europe (West)',
            'eu-central' => 'Europe (Central)',
            'asia-pacific' => 'Asia Pacific',
            'australia' => 'Australia',
            'canada' => 'Canada',
            'uk' => 'United Kingdom',
            'germany' => 'Germany',
            'france' => 'France',
            'singapore' => 'Singapore',
            'japan' => 'Japan',
            'EGYPT' => 'Egypt',
        ];

        $newDatacenterName = $datacenterNames[$newDatacenter] ?? ucfirst(str_replace('-', ' ', $newDatacenter));

        try {
            $oldDatacenter = null;
            $oldDatacenterName = null;
            
            // Get current datacenter from orderItem configuration
            if ($service->orderItem) {
                $oldDatacenter = $service->orderItem->configuration['datacenter'] ?? null;
                $oldDatacenterName = $service->orderItem->configuration['datacenter_name'] ?? null;
            }

            // Update the orderItem configuration
            if ($service->orderItem) {
                $configuration = $service->orderItem->configuration ?? [];
                $configuration['datacenter'] = $newDatacenter;
                $configuration['datacenter_name'] = $newDatacenterName;
                
                $service->orderItem->update([
                    'configuration' => $configuration,
                ]);
            } else {
                // If no orderItem exists, store in server_data
                $serverData = $service->server_data ?? [];
                $serverData['datacenter'] = $newDatacenter;
                $serverData['datacenter_name'] = $newDatacenterName;
                
                $service->update([
                    'server_data' => $serverData,
                ]);
            }

            Log::info('Service Datacenter Changed', [
                'service_id' => $service->id,
                'old_datacenter' => $oldDatacenter,
                'old_datacenter_name' => $oldDatacenterName,
                'new_datacenter' => $newDatacenter,
                'new_datacenter_name' => $newDatacenterName,
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            return redirect()->route('admin.services.show', $service->id)->with('success', __('crm.datacenter_changed_successfully') ?? 'Datacenter changed successfully.');

        } catch (\Exception $e) {
            Log::error('Service Datacenter Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.datacenter_change_failed') ?? 'Failed to change datacenter') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service recurring amount
     */
    public function changeRecurringAmount(Request $request, Service $service)
    {
        $request->validate([
            'recurring_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:500',
        ]);

        $newAmount = $request->recurring_amount;
        $oldAmount = $service->recurring_amount;

        try {
            DB::beginTransaction();

            // Update service recurring amount
            $service->update([
                'recurring_amount' => $newAmount,
            ]);

            // Update unpaid invoices related to this service
            $updatedInvoices = [];
            if ($service->order_id) {
                $unpaidInvoices = \App\Models\Invoice::where('order_id', $service->order_id)
                    ->whereIn('status', ['unpaid', 'partially_paid'])
                    ->get();

                foreach ($unpaidInvoices as $invoice) {
                    $oldInvoiceTotal = $invoice->total;
                    
                    // Calculate new total (update subtotal and total with new amount)
                    $invoice->subtotal = $newAmount;
                    $invoice->total = $newAmount - $invoice->discount + $invoice->tax;
                    $invoice->balance = $invoice->total - $invoice->paid_amount;
                    $invoice->save();

                    $updatedInvoices[] = [
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'old_total' => $oldInvoiceTotal,
                        'new_total' => $invoice->total,
                    ];
                }
            }

            DB::commit();

            Log::info('Service Recurring Amount Changed', [
                'service_id' => $service->id,
                'service_name' => $service->service_name,
                'old_amount' => $oldAmount,
                'new_amount' => $newAmount,
                'reason' => $request->reason,
                'updated_invoices' => $updatedInvoices,
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            $message = __('crm.recurring_amount_changed_successfully') ?? 'Recurring amount changed successfully.';
            if (count($updatedInvoices) > 0) {
                $message .= ' ' . count($updatedInvoices) . ' ' . (app()->getLocale() === 'ar' ? 'فاتورة تم تحديثها' : 'invoice(s) updated.');
            }

            return redirect()->route('admin.services.show', $service->id)->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Service Recurring Amount Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.recurring_amount_change_failed') ?? 'Failed to change recurring amount') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service billing cycle
     */
    public function changeBillingCycle(Request $request, Service $service)
    {
        $request->validate([
            'billing_cycle' => 'required|string|in:monthly,quarterly,semi_annually,semiannually,annually,biennially,triennially',
            'recalculate_due_date' => 'nullable|boolean',
        ]);

        $newCycle = $request->billing_cycle;
        $oldCycle = $service->billing_cycle;
        $recalculateDueDate = $request->has('recalculate_due_date');

        // Billing cycle labels for logging
        $cycleLabels = [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'semi_annually' => 'Semi-Annually',
            'semiannually' => 'Semi-Annually',
            'annually' => 'Annually',
            'biennially' => 'Biennially',
            'triennially' => 'Triennially',
        ];

        try {
            $updateData = [
                'billing_cycle' => $newCycle,
            ];

            // Recalculate next due date if requested
            $newDueDate = null;
            if ($recalculateDueDate && $service->next_due_date) {
                $currentDueDate = \Carbon\Carbon::parse($service->next_due_date);
                
                // Calculate new due date based on new cycle (from today or last due date)
                $baseDate = $currentDueDate->isPast() ? now() : $currentDueDate;
                
                $newDueDate = match (strtolower($newCycle)) {
                    'monthly' => $baseDate->copy()->addMonth(),
                    'quarterly' => $baseDate->copy()->addMonths(3),
                    'semi_annually', 'semiannually' => $baseDate->copy()->addMonths(6),
                    'annually' => $baseDate->copy()->addYear(),
                    'biennially' => $baseDate->copy()->addYears(2),
                    'triennially' => $baseDate->copy()->addYears(3),
                    default => $baseDate->copy()->addMonth(),
                };

                $updateData['next_due_date'] = $newDueDate;
            }

            $service->update($updateData);

            Log::info('Service Billing Cycle Changed', [
                'service_id' => $service->id,
                'service_name' => $service->service_name,
                'old_cycle' => $oldCycle,
                'new_cycle' => $newCycle,
                'recalculate_due_date' => $recalculateDueDate,
                'new_due_date' => $newDueDate?->format('Y-m-d'),
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            $message = __('crm.billing_cycle_changed_successfully') ?? 'Billing cycle changed successfully.';
            if ($newDueDate) {
                $message .= ' ' . (app()->getLocale() === 'ar' 
                    ? 'تاريخ الاستحقاق الجديد: ' . $newDueDate->format('Y-m-d')
                    : 'New due date: ' . $newDueDate->format('M d, Y'));
            }

            return redirect()->route('admin.services.show', $service->id)->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Service Billing Cycle Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (__('crm.billing_cycle_change_failed') ?? 'Failed to change billing cycle') . ': ' . $e->getMessage());
        }
    }

    /**
     * Change service next due date
     */
    public function changeNextDueDate(Request $request, Service $service)
    {
        $request->validate([
            'next_due_date' => 'required|date',
        ]);

        $newDueDate = \Carbon\Carbon::parse($request->next_due_date);
        $oldDueDate = $service->next_due_date;

        try {
            $service->update([
                'next_due_date' => $newDueDate,
            ]);

            Log::info('Service Next Due Date Changed', [
                'service_id' => $service->id,
                'service_name' => $service->service_name,
                'old_due_date' => $oldDueDate,
                'new_due_date' => $newDueDate->format('Y-m-d'),
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            $message = app()->getLocale() === 'ar' 
                ? 'تم تغيير تاريخ الاستحقاق بنجاح إلى: ' . $newDueDate->format('Y-m-d')
                : 'Next due date changed successfully to: ' . $newDueDate->format('M d, Y');

            return redirect()->route('admin.services.show', $service->id)->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Service Next Due Date Change Exception', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', (app()->getLocale() === 'ar' ? 'فشل تغيير تاريخ الاستحقاق' : 'Failed to change next due date') . ': ' . $e->getMessage());
        }
    }
}