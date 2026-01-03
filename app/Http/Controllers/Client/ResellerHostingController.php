<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResellerHostingController extends Controller
{
    /**
     * Display client's reseller hosting services list
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        
        // Get reseller hosting services for this client (exclude failed)
        $resellerServices = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('status', '!=', 'failed')
            ->whereHas('orderItem', function($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                      ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                });
            })
            ->with(['order', 'orderItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistics for reseller hosting only (exclude failed)
        $stats = [
            'total' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', '!=', 'failed')
                ->whereHas('orderItem', function($query) {
                    $query->where(function($q) {
                        $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                          ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                    });
                })
                ->count(),
            'active' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'active')
                ->whereHas('orderItem', function($query) {
                    $query->where(function($q) {
                        $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                          ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                    });
                })
                ->count(),
            'pending' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'pending')
                ->whereHas('orderItem', function($query) {
                    $query->where(function($q) {
                        $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                          ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                    });
                })
                ->count(),
            'suspended' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'suspended')
                ->whereHas('orderItem', function($query) {
                    $query->where(function($q) {
                        $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                          ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                    });
                })
                ->count(),
        ];
        
        return view('frontend.client.hosting.reseller', compact('resellerServices', 'stats', 'client'));
    }
    
    /**
     * Show specific reseller hosting service details
     * 
     * Reseller hosting works differently:
     * - Service stays in 'pending' until admin manually adds WHM credentials
     * - Admin provides: login_url, username, password
     * - Once credentials are added and service is activated, client can access WHM
     */
    public function show($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::select('*')
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->whereHas('orderItem', function($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                      ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                });
            })
            ->with(['order', 'orderItem', 'server', 'client'])
            ->firstOrFail();
        
        // Get related invoices for this service (through order_id)
        $invoices = Invoice::where('client_id', $client->id)
            ->where(function($query) use ($service) {
                $query->where('order_id', $service->order_id)
                      ->orWhere('notes', 'like', '%Service #' . $service->id . '%');
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get configuration from orderItem
        $configuration = $service->orderItem->configuration ?? [];
        
        // Get product features
        $product = \App\Models\Product::where('name', $configuration['plan'] ?? '')
            ->orWhere('name', 'like', '%' . ($configuration['plan'] ?? 'NOMATCH') . '%')
            ->first();
        
        $features = [];
        if ($product) {
            $isArabic = app()->getLocale() === 'ar';
            $features = $isArabic && !empty($product->features_list_ar) 
                ? $product->features_list_ar 
                : ($product->features_list ?? []);
        }
        
        // Get WHM credentials from service metadata (added by admin)
        $metadata = $service->metadata ?? [];
        $whmCredentials = [
            'login_url' => $metadata['whm_login_url'] ?? $metadata['login_url'] ?? null,
            'username' => $service->username ?? $metadata['whm_username'] ?? null,
            'password' => $service->decrypted_password ?? $metadata['whm_password'] ?? null,
        ];
        
        // Check if credentials are complete
        $hasCredentials = !empty($whmCredentials['login_url']) && 
                          !empty($whmCredentials['username']) && 
                          !empty($whmCredentials['password']);
        
        return view('frontend.client.hosting.show-reseller', compact(
            'service', 
            'client', 
            'invoices',
            'configuration',
            'whmCredentials',
            'hasCredentials',
            'features'
        ));
    }
    
    /**
     * Login to WHM panel
     */
    public function loginWhm($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->whereHas('orderItem', function($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['reseller'])
                      ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.category"))) LIKE ?', ['%reseller%']);
                });
            })
            ->firstOrFail();
        
        // Get WHM login URL from metadata
        $metadata = $service->metadata ?? [];
        $loginUrl = $metadata['whm_login_url'] ?? $metadata['login_url'] ?? null;
        
        if (!$loginUrl) {
            return back()->with('error', __('frontend.whm_login_not_available') ?? 'WHM login is not available for this service.');
        }
        
        // Redirect to WHM login URL
        return redirect()->away($loginUrl);
    }
}
