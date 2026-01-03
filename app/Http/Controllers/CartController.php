<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Get cart contents
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Clean up orphaned coupon data if cart is empty
        if (empty($cart)) {
            Session::forget('coupon_id');
            Session::forget('coupon_code');
            Session::forget('coupon_discount');
            Session::forget('coupon_description');
        }
        
        // Fix old cart items without TLD (only for domain items)
        foreach ($cart as $key => &$item) {
            // Only process domain items
            if (isset($item['type']) && $item['type'] === 'domain') {
                if (!isset($item['tld']) || empty($item['tld'])) {
                    // Extract TLD from domain name if domain exists
                    if (isset($item['domain']) && !empty($item['domain'])) {
                        $domainParts = explode('.', $item['domain']);
                        if (count($domainParts) >= 2) {
                            $item['tld'] = end($domainParts);
                        } else {
                            $item['tld'] = 'com'; // Default fallback
                        }
                    }
                }
            }
        }
        
        // Save fixed cart back to session
        if (!empty($cart)) {
            Session::put('cart', $cart);
        }
        
        $subtotal = $this->calculateTotal($cart);
        $discount = 0;
        
        // Only apply discount if there's an active coupon
        if (Session::has('coupon_id')) {
            $coupon = \App\Models\Coupon::find(Session::get('coupon_id'));
            if ($coupon && $coupon->isValid()) {
                // Calculate eligible total (only items that coupon applies to)
                $eligibleTotal = 0;
                
                if ($coupon->apply_to_all) {
                    // Apply to all items
                    $eligibleTotal = $subtotal;
                } else {
                    // Apply only to specific products
                    $couponProducts = $coupon->products ?? [];
                    
                    foreach ($cart as $item) {
                        // Skip items without product_id (like domains with only 'type')
                        if (!isset($item['product_id']) || !isset($item['type'])) {
                            continue;
                        }
                        
                        $productIdentifier = $item['type'] . '_' . $item['product_id'];
                        
                        if (in_array($productIdentifier, $couponProducts)) {
                            $eligibleTotal += $item['price'] * $item['quantity'];
                        }
                    }
                }
                
                // If no eligible items, clear coupon
                if ($eligibleTotal <= 0) {
                    Session::forget('coupon_id');
                    Session::forget('coupon_code');
                    Session::forget('coupon_discount');
                    Session::forget('coupon_description');
                    $discount = 0;
                } else {
                    // Recalculate discount based on eligible items only
                    if ($coupon->type === 'percentage') {
                        $discount = ($eligibleTotal * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                    $discount = min($discount, $eligibleTotal);
                    Session::put('coupon_discount', $discount);
                }
            } else {
                // Coupon no longer valid, clear it
                Session::forget('coupon_id');
                Session::forget('coupon_code');
                Session::forget('coupon_discount');
                Session::forget('coupon_description');
                $discount = 0;
            }
        } else {
            // No coupon, make sure discount is cleared
            $discount = 0;
            if (Session::has('coupon_discount')) {
                Session::forget('coupon_discount');
            }
            if (Session::has('coupon_code')) {
                Session::forget('coupon_code');
            }
            if (Session::has('coupon_description')) {
                Session::forget('coupon_description');
            }
        }
        
        $total = $subtotal - $discount;
        
        return view('frontend.cart.index', compact('cart', 'total', 'subtotal', 'discount'));
    }

    /**
     * Add domain to cart
     */
    public function addDomain(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:register,transfer,renew',
            'tld' => 'required|string',
            'renewal_price' => 'nullable|numeric|min:0',
        ]);

        $cart = Session::get('cart', []);
        
        // Fix TLD if it's "undefined" or empty
        $tld = $request->tld;
        if (empty($tld) || $tld === 'undefined') {
            $domainParts = explode('.', $request->domain);
            $tld = count($domainParts) >= 2 ? end($domainParts) : 'com';
        }
        
        // Create unique key for cart item
        $itemKey = $request->type . '_' . $request->domain;
        
        // Check if domain already in cart
        if (isset($cart[$itemKey])) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.domain_already_in_cart')
            ]);
        }
        
        // Add domain to cart
        $cart[$itemKey] = [
            'type' => 'domain',
            'action' => $request->type,
            'domain' => $request->domain,
            'tld' => $tld,
            'price' => $request->price,
            'renewal_price' => $request->renewal_price ?? $request->price, // Default to same price if not provided
            'years' => 1, // Default to 1 year
            'privacy' => true, // Default privacy enabled
            'quantity' => 1,
            'auth_code' => $request->auth_code ?? null, // Auth code for transfers
            'added_at' => now()->toDateTimeString()
        ];
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.domain_added_to_cart'),
            'cartCount' => count($cart),
            'cart' => $cart
        ]);
    }

    /**
     * Add hosting to cart
     */
    public function addHosting(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'domain_option' => 'required|in:existing,new,subdomain',
            'domain' => 'required|string',
            'billing_cycle' => 'required|in:monthly,quarterly,semi_annually,semiannually,annually,biennially,triennially',
            'datacenter' => 'nullable|string',
            'cpanel_tier' => 'nullable|string',
        ]);

        // Check if domain already exists in active services OR in WHM
        if ($request->domain_option === 'existing' || $request->domain_option === 'new') {
            // 1. Check database for active services
            $existingService = \App\Models\Service::where('domain', $request->domain)
                ->where('status', 'active')
                ->first();
                
            if ($existingService) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['domain' => __('frontend.domain_already_exists_in_service', ['domain' => $request->domain])]);
            }
            
            // 2. Check WHM for orphaned domains
            try {
                $cpanelService = app(\App\Services\CpanelService::class);
                $accounts = $cpanelService->listAccounts();
                
                if ($accounts && isset($accounts['data'])) {
                    foreach ($accounts['data'] as $account) {
                        if (isset($account['domain']) && $account['domain'] === $request->domain) {
                            Log::warning('Domain exists in WHM but not in database', [
                                'domain' => $request->domain,
                                'whm_username' => $account['user'] ?? 'unknown'
                            ]);
                            
                            return redirect()->back()
                                ->withInput()
                                ->withErrors(['domain' => __('frontend.domain_already_exists_in_whm', ['domain' => $request->domain])]);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Log error but don't block the order
                Log::error('Failed to check WHM for domain', [
                    'domain' => $request->domain,
                    'error' => $e->getMessage()
                ]);
                // Continue with order - better to try and fail with clear error message
            }
        }

        $product = \App\Models\Product::findOrFail($request->product_id);
        
        // Calculate price based on billing cycle
        $pricing = $product->pricing['recurring'][$request->billing_cycle] ?? ['price' => $product->price];
        $price = $pricing['price'];
        $setupFee = $pricing['setup_fee'] ?? 0;
        
        // Calculate datacenter price
        $datacenterPrice = 0;
        $datacenterName = null;
        if ($request->datacenter) {
            $datacenterPrices = $product->datacenter_price ?? [];
            $dcPricePerMonth = $datacenterPrices[$request->datacenter] ?? 0;
            
            // Calculate based on billing cycle
            $months = [
                'monthly' => 1,
                'quarterly' => 3,
                'semi_annually' => 6,
                'semiannually' => 6,
                'annually' => 12,
                'biennially' => 24,
                'triennially' => 36
            ];
            
            $cycleMonths = $months[$request->billing_cycle] ?? 1;
            $datacenterPrice = $dcPricePerMonth * $cycleMonths;
            
            // Get datacenter name
            $datacenterInfo = [
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
            
            $datacenterName = $datacenterInfo[$request->datacenter] ?? ucfirst(str_replace('-', ' ', $request->datacenter));
        }
        
        // Calculate cPanel tier price for Reseller Hosting
        $cpanelTierPrice = 0;
        $cpanelAccounts = $product->base_cpanel_accounts ?? 0;
        $cpanelTierId = null;
        
        if ($request->cpanel_tier && $request->cpanel_tier !== 'base' && $product->enable_cpanel_tiers) {
            $tier = $product->cpanelTiers()->find($request->cpanel_tier);
            if ($tier) {
                $cpanelTierId = $tier->id;
                $cpanelAccounts = $tier->tier;
                
                // Get tier price based on billing cycle
                $tierPriceMap = [
                    'monthly' => $tier->monthly_price,
                    'quarterly' => $tier->quarterly_price,
                    'semi_annually' => $tier->semi_annually_price,
                    'semiannually' => $tier->semi_annually_price,
                    'annually' => $tier->annually_price,
                    'biennially' => $tier->biennially_price,
                    'triennially' => $tier->triennially_price,
                ];
                
                $cpanelTierPrice = $tierPriceMap[$request->billing_cycle] ?? 0;
            }
        }
        
        $cart = Session::get('cart', []);
        
        // Create unique key for cart item
        $itemKey = 'hosting_' . $product->id . '_' . time();
        
        // Add hosting to cart
        $cart[$itemKey] = [
            'type' => 'hosting',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'domain_option' => $request->domain_option,
            'domain' => $request->domain,
            'billing_cycle' => $request->billing_cycle,
            'price' => $price + $datacenterPrice + $cpanelTierPrice,
            'setup_fee' => $setupFee,
            'datacenter' => $request->datacenter,
            'datacenter_name' => $datacenterName,
            'datacenter_price' => $datacenterPrice,
            'cpanel_tier_id' => $cpanelTierId,
            'cpanel_accounts' => $cpanelAccounts,
            'cpanel_tier_price' => $cpanelTierPrice,
            'ssl' => $request->has('ssl'),
            'backups' => $request->has('backups'),
            'privacy' => $request->has('privacy'),
            'quantity' => 1,
            'added_at' => now()->toDateTimeString()
        ];
        
        Session::put('cart', $cart);
        
        // Check if we need to apply free domain discount to domains in cart
        $this->applyFreeDomainDiscounts($product, $request->billing_cycle);
        
        return redirect()->route('cart.index')->with('success', __('frontend.hosting_added_to_cart'));
    }
    
    /**
     * Apply free domain discounts to domains in cart based on hosting plan
     */
    private function applyFreeDomainDiscounts($product, $billingCycle)
    {
        $freeDomainConfig = $product->free_domain_config ?? null;
        
        // If no free domain config, return
        if (!$freeDomainConfig || !isset($freeDomainConfig['tlds']) || !isset($freeDomainConfig['terms'])) {
            return;
        }
        
        // Check if current billing cycle qualifies
        if (!in_array($billingCycle, $freeDomainConfig['terms'])) {
            return;
        }
        
        $cart = Session::get('cart', []);
        $freeTlds = $freeDomainConfig['tlds'];
        $modified = false;
        $freeDomainApplied = false; // Track if we already applied free domain
        
        // Loop through cart and update domain prices
        foreach ($cart as $key => $item) {
            // Only process domain items
            if (isset($item['type']) && $item['type'] === 'domain') {
                $domainTld = $item['tld'] ?? '';
                
                // Check if this domain TLD is in the free list AND we haven't applied free domain yet
                if (in_array($domainTld, $freeTlds) && !$freeDomainApplied) {
                    // Check if domain is not already free with another hosting
                    if (!isset($item['is_free_with_hosting']) || !$item['is_free_with_hosting']) {
                        // Store original price if not already stored
                        if (!isset($item['original_price'])) {
                            $cart[$key]['original_price'] = $item['price'];
                        }
                        
                        // Mark as free and linked to hosting
                        $cart[$key]['price'] = 0;
                        $cart[$key]['is_free_with_hosting'] = true;
                        $cart[$key]['linked_hosting'] = $product->id;
                        $modified = true;
                        $freeDomainApplied = true; // Mark that we applied the free domain
                    }
                }
            }
        }
        
        if ($modified) {
            Session::put('cart', $cart);
        }
    }

    /**
     * Add VPS to cart
     */
    public function addVps(Request $request)
    {
        $request->validate([
            'vps_plan_id' => 'required|exists:vps_plans,id',
            'billing_cycle' => 'required|in:monthly,quarterly,semi_annually,annually',
            'os_id' => 'required_without:app_id|string',
            'app_id' => 'required_without:os_id|string',
            'datacenter' => 'required|string',
            'hostname' => ['required', 'string', 'regex:/^[a-zA-Z0-9.-]+$/'],
        ]);
        
        // Validate hostname contains only English letters, numbers, dots, and hyphens
        if (!preg_match('/^[a-zA-Z0-9.-]+$/', $request->hostname)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.hostname_english_only_error'));
        }
        
        // Validate hostname is a subdomain (must contain at least 3 parts: subdomain.domain.tld)
        $hostnameParts = explode('.', $request->hostname);
        if (count($hostnameParts) < 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.hostname_must_be_subdomain_error'));
        }
        
        // Ensure user doesn't select both OS and App
        if ($request->filled('os_id') && $request->filled('app_id')) {
            return redirect()->back()->with('error', __('frontend.cannot_select_both_os_and_app'));
        }

        $vpsPlan = \App\Models\VpsPlan::findOrFail($request->vps_plan_id);
        
        // Check if plan is active
        if (!$vpsPlan->is_active || $vpsPlan->is_hidden) {
            return redirect()->back()->with('error', __('frontend.plan_not_available'));
        }
        
        // Get price based on billing cycle
        $priceMap = [
            'monthly' => $vpsPlan->monthly_price,
            'quarterly' => $vpsPlan->quarterly_price,
            'semi_annually' => $vpsPlan->semi_annually_price,
            'annually' => $vpsPlan->annually_price,
        ];
        
        $price = $priceMap[$request->billing_cycle] ?? $vpsPlan->monthly_price;
        $setupFee = $vpsPlan->setup_fee ?? 0;
        
        $cart = Session::get('cart', []);
        
        // Create unique key for cart item
        $itemKey = 'vps_' . $vpsPlan->id . '_' . time();
        
        // Calculate backup cost if enabled (20% of plan price)
        $enableBackups = $request->has('enable_backups') && $request->enable_backups == '1';
        $backupCost = 0;
        
        if ($enableBackups) {
            // Backup cost is 20% of the plan price
            $backupCost = $price * 0.20;
        }
        
        // Calculate additional IPv4 cost ($5 per IP per month)
        $additionalIpv4 = (int) ($request->additional_ipv4 ?? 0);
        $ipv4Cost = 0;
        
        if ($additionalIpv4 > 0) {
            $ipv4MonthlyPrice = 5.00;
            switch ($request->billing_cycle) {
                case 'monthly':
                    $ipv4Cost = $ipv4MonthlyPrice * $additionalIpv4;
                    break;
                case 'quarterly':
                    $ipv4Cost = $ipv4MonthlyPrice * 3 * $additionalIpv4;
                    break;
                case 'semi_annually':
                    $ipv4Cost = $ipv4MonthlyPrice * 6 * $additionalIpv4;
                    break;
                case 'annually':
                    $ipv4Cost = $ipv4MonthlyPrice * 12 * $additionalIpv4;
                    break;
            }
        }
        
        // Check if IPv6 is enabled
        $enableIpv6 = $request->has('enable_ipv6') && $request->enable_ipv6 == '1';
        
        // Calculate DDoS Protection cost ($15 per month)
        $enableDdos = $request->has('enable_ddos') && $request->enable_ddos == '1';
        $ddosCost = 0;
        
        if ($enableDdos) {
            $ddosMonthlyPrice = 15.00;
            switch ($request->billing_cycle) {
                case 'monthly':
                    $ddosCost = $ddosMonthlyPrice;
                    break;
                case 'quarterly':
                    $ddosCost = $ddosMonthlyPrice * 3;
                    break;
                case 'semi_annually':
                    $ddosCost = $ddosMonthlyPrice * 6;
                    break;
                case 'annually':
                    $ddosCost = $ddosMonthlyPrice * 12;
                    break;
            }
        }
        
        // Add VPS to cart
        $cart[$itemKey] = [
            'type' => 'vps',
            'vps_plan_id' => $vpsPlan->id,
            'product_name' => $vpsPlan->plan_name,
            'billing_cycle' => $request->billing_cycle,
            'price' => $price,
            'setup_fee' => $setupFee,
            'os_id' => $request->os_id,
            'app_id' => $request->app_id,
            'datacenter' => $request->datacenter,
            'hostname' => $request->hostname,
            'enable_backups' => $enableBackups,
            'backup_cost' => $backupCost,
            'additional_ipv4' => $additionalIpv4,
            'ipv4_cost' => $ipv4Cost,
            'enable_ipv6' => $enableIpv6,
            'enable_ddos' => $enableDdos,
            'ddos_cost' => $ddosCost,
            'quantity' => 1,
            'added_at' => now()->toDateTimeString(),
            // VPS specifications for display
            'vcpu_count' => $vpsPlan->vcpu_count,
            'ram_mb' => $vpsPlan->ram_mb,
            'storage_gb' => $vpsPlan->storage_gb,
            'bandwidth_gb' => $vpsPlan->bandwidth_gb,
        ];
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', __('frontend.vps_added_to_cart'));
    }

    /**
     * Add Dedicated Server to cart
     */
    public function addDedicated(Request $request)
    {
        $request->validate([
            'dedicated_plan_id' => 'required|exists:dedicated_plans,id',
            'billing_cycle' => 'required|in:monthly,quarterly,semi_annually,annually',
            'hostname' => ['required', 'string', 'regex:/^[a-zA-Z0-9.-]+$/'],
            'disk_configuration' => 'required|in:raid_1,no_raid_formatted,no_raid_unformatted',
            'os_id' => 'nullable|integer',
            'app_id' => 'nullable|integer',
            'additional_ipv4' => 'nullable|integer|min:0|max:10',
            'enable_ipv6' => 'nullable|boolean',
        ]);
        
        // Validate that either os_id or app_id is provided (not both, not neither)
        if (empty($request->os_id) && empty($request->app_id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.must_select_os_or_app'));
        }
        
        if (!empty($request->os_id) && !empty($request->app_id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.cannot_select_both_os_and_app'));
        }
        
        // Validate hostname contains only English letters, numbers, dots, and hyphens
        if (!preg_match('/^[a-zA-Z0-9.-]+$/', $request->hostname)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.hostname_english_only_error'));
        }
        
        // Validate hostname is a subdomain (must contain at least 3 parts: subdomain.domain.tld)
        $hostnameParts = explode('.', $request->hostname);
        if (count($hostnameParts) < 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('frontend.hostname_must_be_subdomain_error'));
        }

        $dedicatedPlan = \App\Models\DedicatedPlan::findOrFail($request->dedicated_plan_id);
        
        // Check if plan is active
        if (!$dedicatedPlan->is_active || $dedicatedPlan->is_hidden) {
            return redirect()->back()->with('error', __('frontend.plan_not_available'));
        }
        
        // Get price based on billing cycle
        $priceMap = [
            'monthly' => $dedicatedPlan->monthly_price,
            'quarterly' => $dedicatedPlan->quarterly_price,
            'semi_annually' => $dedicatedPlan->semi_annually_price,
            'annually' => $dedicatedPlan->annually_price,
        ];
        
        $price = $priceMap[$request->billing_cycle] ?? $dedicatedPlan->monthly_price;
        $setupFee = $dedicatedPlan->setup_fee ?? 0;
        
        // Calculate additional IPv4 cost based on billing cycle
        $additionalIpv4Count = $request->additional_ipv4 ?? 0;
        $ipv4PricePerUnit = [
            'monthly' => 6,
            'quarterly' => 18,      // 6 * 3
            'semi_annually' => 36,  // 6 * 6
            'annually' => 72        // 6 * 12
        ];
        $currentIpv4Price = $ipv4PricePerUnit[$request->billing_cycle] ?? 6;
        $ipv4Cost = $additionalIpv4Count * $currentIpv4Price;
        
        // Add IPv4 cost to total price
        $totalPrice = $price + $ipv4Cost;
        
        $cart = Session::get('cart', []);
        $itemKey = 'dedicated_' . $dedicatedPlan->id . '_' . $request->billing_cycle;
        
        // Add Dedicated Server to cart
        $cart[$itemKey] = [
            'type' => 'dedicated',
            'dedicated_plan_id' => $dedicatedPlan->id,
            'product_name' => $dedicatedPlan->plan_name,
            'billing_cycle' => $request->billing_cycle,
            'price' => $totalPrice,
            'base_price' => $price,
            'setup_fee' => $setupFee,
            'hostname' => $request->hostname,
            'disk_configuration' => $request->disk_configuration,
            'os_id' => $request->os_id ?? null,
            'app_id' => $request->app_id ?? null,
            'additional_ipv4' => $additionalIpv4Count,
            'ipv4_cost' => $ipv4Cost,
            'enable_ipv6' => $request->has('enable_ipv6') ? true : false,
            'quantity' => 1,
            'added_at' => now()->toDateTimeString(),
            // Dedicated Server specifications for display
            'cpu_cores' => $dedicatedPlan->cpu_cores,
            'ram_gb' => $dedicatedPlan->ram_gb,
            'storage_total_gb' => $dedicatedPlan->storage_total_gb,
            'bandwidth' => $dedicatedPlan->bandwidth,
        ];
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', __('frontend.dedicated_added_to_cart'));
    }
    
    /**
     * Restore domain prices when hosting plan is removed
     */
    private function restoreDomainPrices($hostingProductId)
    {
        $cart = Session::get('cart', []);
        $modified = false;
        $restoredDomains = [];
        
        foreach ($cart as $key => $item) {
            // Only process domains linked to this hosting
            if (isset($item['type']) && $item['type'] === 'domain' && 
                isset($item['linked_hosting']) && $item['linked_hosting'] == $hostingProductId) {
                
                // Store restored domain info
                $restoredPrice = $item['original_price'] ?? $item['price'];
                
                // Restore original price
                if (isset($item['original_price'])) {
                    $cart[$key]['price'] = $item['original_price'];
                }
                
                // Remove free domain flags
                unset($cart[$key]['is_free_with_hosting']);
                unset($cart[$key]['linked_hosting']);
                unset($cart[$key]['original_price']);
                
                // Add to restored domains array
                $restoredDomains[] = [
                    'key' => $key,
                    'domain' => $item['domain'] ?? '',
                    'price' => $restoredPrice
                ];
                
                $modified = true;
            }
        }
        
        if ($modified) {
            Session::put('cart', $cart);
        }
        
        return $restoredDomains;
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->key])) {
            $removedItem = $cart[$request->key];
            unset($cart[$request->key]);
            Session::put('cart', $cart);
            
            // If removed item was a hosting plan, restore domain prices
            $restoredDomains = [];
            if (isset($removedItem['type']) && $removedItem['type'] === 'hosting' && isset($removedItem['product_id'])) {
                $restoredDomains = $this->restoreDomainPrices($removedItem['product_id']);
            }
            
            // Recalculate subtotal and discount
            $cart = Session::get('cart', []); // Re-get cart after restoration
            $subtotal = $this->calculateTotal($cart);
            $discount = 0;
            
            // Recalculate discount if there's a coupon
            if (Session::has('coupon_id')) {
                $coupon = \App\Models\Coupon::find(Session::get('coupon_id'));
                if ($coupon && $coupon->isValid()) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($subtotal * $coupon->value) / 100;
                    } else {
                        $discount = $coupon->value;
                    }
                    $discount = min($discount, $subtotal);
                    Session::put('coupon_discount', $discount);
                } else {
                    // Coupon no longer valid, clear it
                    Session::forget('coupon_id');
                    Session::forget('coupon_code');
                    Session::forget('coupon_discount');
                    Session::forget('coupon_description');
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.item_removed_from_cart'),
                'cartCount' => count($cart),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $subtotal - $discount,
                'restoredDomains' => $restoredDomains
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => __('frontend.item_not_found')
        ], 404);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        Session::forget('coupon_id');
        Session::forget('coupon_code');
        Session::forget('coupon_discount');
        Session::forget('coupon_description');
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.cart_cleared'),
            'cartCount' => 0
        ]);
    }

    /**
     * Get cart count
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        
        return response()->json([
            'count' => count($cart)
        ]);
    }

    /**
     * Calculate cart total
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $years = $item['years'] ?? 1;
            $quantity = $item['quantity'] ?? 1;
            $registrationPrice = $item['price'];
            $renewalPrice = $item['renewal_price'] ?? $item['price'];
            
            if ($years == 1) {
                // First year only: use registration price
                $itemTotal = $registrationPrice * $quantity;
            } else {
                // First year (registration) + remaining years (renewal)
                $itemTotal = ($registrationPrice + ($renewalPrice * ($years - 1))) * $quantity;
            }
            
            // Add setup fee if exists (for hosting/VPS)
            if (isset($item['setup_fee']) && $item['setup_fee'] > 0) {
                $itemTotal += $item['setup_fee'] * $quantity;
            }
            
            // Add backup cost if enabled (for VPS)
            if (isset($item['backup_cost']) && $item['backup_cost'] > 0) {
                $itemTotal += $item['backup_cost'] * $quantity;
            }
            
            // Add IPv4 cost if additional IPs ordered (for VPS)
            if (isset($item['ipv4_cost']) && $item['ipv4_cost'] > 0) {
                $itemTotal += $item['ipv4_cost'] * $quantity;
            }
            
            // Add DDoS Protection cost if enabled (for VPS)
            if (isset($item['ddos_cost']) && $item['ddos_cost'] > 0) {
                $itemTotal += $item['ddos_cost'] * $quantity;
            }
            
            $total += $itemTotal;
        }
        return $total;
    }

    /**
     * Proceed to checkout
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', __('frontend.cart_is_empty'));
        }
        
        $subtotal = $this->calculateTotal($cart);
        $discount = Session::get('coupon_discount', 0);
        $total = $subtotal - $discount;
        
        // Get all countries using rinvex/countries with localization
        $locale = app()->getLocale(); // Get current locale (ar or en)
        $countries = collect(countries())
            ->map(function ($country) use ($locale) {
                // Safely get country name
                if (is_string($country['name'])) {
                    $name = $country['name'];
                } elseif (is_array($country['name'])) {
                    $name = $country['name']['common'] ?? $country['name']['official'] ?? 'Unknown';
                    
                    // If Arabic locale, try to get native name if it uses Arabic script
                    if ($locale === 'ar' && isset($country['name']['native']) && is_array($country['name']['native'])) {
                        foreach ($country['name']['native'] as $nativeName) {
                            if (is_array($nativeName) && isset($nativeName['common'])) {
                                // Check if native name contains Arabic characters
                                if (preg_match('/[\x{0600}-\x{06FF}]/u', $nativeName['common'])) {
                                    $name = $nativeName['common'];
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    $name = 'Unknown';
                }
                
                return [
                    'code' => $country['iso_3166_1_alpha2'] ?? '',
                    'name' => $name,
                ];
            })
            ->filter(function ($country) {
                return !empty($country['code']) && !empty($country['name']);
            })
            ->sortBy('name')
            ->pluck('name', 'code')
            ->toArray();
        
        // Get Fawaterak payment methods
        $fawaterakPaymentMethods = [];
        try {
            $fawaterakService = app(\App\Services\FawaterakPaymentService::class);
            $response = $fawaterakService->getPaymentMethods();
            
            Log::info('Fawaterak Response', ['response' => $response]);
            
            // Normalize the payment methods data
            if (isset($response['methods']) && is_array($response['methods'])) {
                $fawaterakPaymentMethods = collect($response['methods'])->map(function($method) {
                    return [
                        'paymentId' => $method['paymentId'] ?? null,
                        'nameEn' => $method['name_en'] ?? $method['nameEn'] ?? 'Unknown',
                        'nameAr' => $method['name_ar'] ?? $method['nameAr'] ?? 'غير معروف',
                        'paymentType' => $method['payment_type'] ?? $method['paymentType'] ?? null,
                        'logo' => $method['logo'] ?? null,
                        'redirect' => $method['redirect'] ?? 'false',
                    ];
                })->toArray();
                
                Log::info('Normalized Payment Methods', ['count' => count($fawaterakPaymentMethods), 'methods' => $fawaterakPaymentMethods]);
            } else {
                Log::warning('No methods found in response', ['response' => $response]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch Fawaterak payment methods: ' . $e->getMessage(), ['exception' => $e]);
        }
        
        return view('frontend.cart.checkout', compact('cart', 'subtotal', 'discount', 'total', 'countries', 'fawaterakPaymentMethods'));
    }

    /**
     * Update years for cart item
     */
    public function updateYears(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'years' => 'required|integer|min:1|max:10'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->key])) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.item_not_found')
            ]);
        }
        
        // Update years (price remains per year, calculation done in calculateTotal)
        $cart[$request->key]['years'] = $request->years;
        
        Session::put('cart', $cart);
        
        // Calculate new totals
        $subtotal = $this->calculateTotal($cart);
        $discount = Session::get('coupon_discount', 0);
        $total = $subtotal - $discount;
        
        // Update discount if there's a coupon (recalculate based on new subtotal)
        if (Session::has('coupon_id')) {
            $coupon = \App\Models\Coupon::find(Session::get('coupon_id'));
            if ($coupon && $coupon->isValid()) {
                if ($coupon->type === 'percentage') {
                    $discount = ($subtotal * $coupon->value) / 100;
                } else {
                    $discount = $coupon->value;
                }
                $discount = min($discount, $subtotal);
                $total = $subtotal - $discount;
                
                // Update discount in session
                Session::put('coupon_discount', $discount);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.cart_updated'),
            'cartCount' => count($cart),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ]);
    }

    /**
     * Toggle privacy protection for cart item
     */
    public function togglePrivacy(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'privacy' => 'required|boolean'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->key])) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.item_not_found')
            ]);
        }
        
        // Update privacy setting
        $cart[$request->key]['privacy'] = $request->privacy;
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.cart_updated')
        ]);
    }

    /**
     * Update DNS type for cart item
     */
    public function updateDnsType(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'dns_type' => 'required|in:default,custom'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->key])) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.item_not_found')
            ]);
        }
        
        // Update DNS type
        $cart[$request->key]['dns_type'] = $request->dns_type;
        
        // Clear DNS values if switching to default
        if ($request->dns_type === 'default') {
            unset($cart[$request->key]['dns1']);
            unset($cart[$request->key]['dns2']);
            unset($cart[$request->key]['dns3']);
            unset($cart[$request->key]['dns4']);
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.cart_updated')
        ]);
    }

    /**
     * Update DNS servers for cart item
     */
    public function updateDns(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'field' => 'required|in:dns1,dns2,dns3,dns4',
            'value' => 'nullable|string'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->key])) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.item_not_found')
            ]);
        }
        
        // Update DNS value
        $cart[$request->key][$request->field] = $request->value;
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => __('frontend.cart_updated')
        ]);
    }

    /**
     * Apply Coupon Code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));
        
        // Find coupon in database
        $coupon = \App\Models\Coupon::where('code', $couponCode)->first();

        // Check if coupon exists
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.invalid_coupon')
            ]);
        }

        // Check if coupon is valid (active, not expired, has remaining uses)
        if (!$coupon->isValid()) {
            $message = __('frontend.coupon_expired');
            if (!$coupon->is_active) {
                $message = __('frontend.coupon_inactive');
            } elseif ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
                $message = __('frontend.coupon_limit_reached');
            }
            
            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }

        $cart = Session::get('cart', []);
        $subtotal = $this->calculateTotal($cart);
        
        // Calculate eligible total (only items that coupon applies to)
        $eligibleTotal = 0;
        $hasEligibleItems = false;
        
        if ($coupon->apply_to_all) {
            // Apply to all items
            $eligibleTotal = $subtotal;
            $hasEligibleItems = true;
        } else {
            // Apply only to specific products
            $couponProducts = $coupon->products ?? [];
            
            foreach ($cart as $item) {
                // Skip items without product_id (like domains with only 'type')
                if (!isset($item['product_id']) || !isset($item['type'])) {
                    continue;
                }
                
                $productIdentifier = $item['type'] . '_' . $item['product_id'];
                
                if (in_array($productIdentifier, $couponProducts)) {
                    $eligibleTotal += $item['price'] * $item['quantity'];
                    $hasEligibleItems = true;
                }
            }
        }
        
        // Check if there are any eligible items in cart
        if (!$hasEligibleItems || $eligibleTotal <= 0) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.coupon_no_eligible_products')
            ]);
        }
        
        // Check minimum order value (based on eligible items only)
        if ($coupon->min_order && $eligibleTotal < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.min_order_not_met', ['amount' => '$' . number_format($coupon->min_order, 2)])
            ]);
        }

        // Check if user is authenticated for customer type check
        if ($coupon->customer_type !== 'all' && auth('client')->check()) {
            $user = auth('client')->user();
            $isNewCustomer = !$user->orders()->exists(); // Check if user has any orders
            
            if ($coupon->customer_type === 'new' && !$isNewCustomer) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.coupon_new_customers_only')
                ]);
            }
            
            if ($coupon->customer_type === 'existing' && $isNewCustomer) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.coupon_existing_customers_only')
                ]);
            }
        }
        
        // Check if coupon is for specific customer
        if ($coupon->specific_customer_id && auth('client')->check()) {
            if ($coupon->specific_customer_id !== auth('client')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.coupon_not_for_you')
                ]);
            }
        }
        
        // Calculate discount (based on eligible items only)
        if ($coupon->type === 'percentage') {
            $discount = ($eligibleTotal * $coupon->value) / 100;
        } else {
            $discount = $coupon->value;
        }
        
        // Ensure discount doesn't exceed eligible total
        $discount = min($discount, $eligibleTotal);
        $newTotal = $subtotal - $discount;
        
        // Prepare description
        $description = $coupon->description;
        if (!$description) {
            if ($coupon->type === 'percentage') {
                $description = $coupon->value . '% ' . __('frontend.discount');
            } else {
                $description = '$' . number_format($coupon->value, 2) . ' ' . __('frontend.off');
            }
        }
        
        // Store coupon in session
        Session::put('coupon_id', $coupon->id);
        Session::put('coupon_code', $couponCode);
        Session::put('coupon_discount', $discount);
        Session::put('coupon_description', $description);

        return response()->json([
            'success' => true,
            'message' => __('frontend.coupon_applied') . ': ' . $description,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'new_total' => $newTotal
        ]);
    }

    /**
     * Remove Coupon Code
     */
    public function removeCoupon()
    {
        Session::forget('coupon_id');
        Session::forget('coupon_code');
        Session::forget('coupon_discount');
        Session::forget('coupon_description');
        
        $cart = Session::get('cart', []);
        $newTotal = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'new_total' => $newTotal
        ]);
    }
    
    /**
     * Check if username is available
     */
    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:20|regex:/^[A-Za-z0-9]+$/'
        ]);
        
        $username = $request->username;
        
        // Check if username exists in clients table
        $exists = \App\Models\Client::where('username', $username)->exists();
        
        return response()->json([
            'available' => !$exists,
            'username' => $username
        ]);
    }
    
    /**
     * Check if email is available
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $email = trim($request->email);
        
        // Check if email exists in clients table
        $exists = \App\Models\Client::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'email' => $email
        ]);
    }
    
    /**
     * Check if phone number is available
     */
    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);
        
        $phone = trim($request->phone);
        $countryCode = trim($request->country_code ?? '');
        
        // Combine country code and phone number
        $fullPhone = $countryCode . $phone;
        
        // Check if phone exists in clients table
        $exists = \App\Models\Client::where('phone', $fullPhone)
                                    ->orWhere('phone', $phone)
                                    ->exists();
        
        return response()->json([
            'available' => !$exists,
            'phone' => $phone
        ]);
    }
    
    /**
     * Check if tax registration number is available
     */
    public function checkTaxNumber(Request $request)
    {
        $request->validate([
            'tax_number' => 'required|string'
        ]);
        
        $taxNumber = trim($request->tax_number);
        
        // Check if tax number exists in clients table
        $exists = \App\Models\Client::where('tax_number', $taxNumber)->exists();
        
        return response()->json([
            'available' => !$exists,
            'tax_number' => $taxNumber
        ]);
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

        // Configure SSL certificate verification
        $http = \Illuminate\Support\Facades\Http::asForm()->timeout(30);
        
        // Check if we're on local Laragon environment
        $laravelCertPath = base_path('../etc/ssl/cacert.pem');
        if (app()->environment('local') && file_exists($laravelCertPath)) {
            $http = $http->withOptions(['verify' => $laravelCertPath]);
        }

        $response = $http->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (isset($result['success']) && $result['success']) {
            Log::info('Turnstile verification successful (Checkout)', [
                'ip' => $request->ip(),
                'hostname' => $result['hostname'] ?? null,
            ]);
            return true;
        }

        Log::warning('Turnstile verification failed (Checkout)', [
            'ip' => $request->ip(),
            'error_codes' => $result['error-codes'] ?? [],
        ]);

        return false;
    }
}
