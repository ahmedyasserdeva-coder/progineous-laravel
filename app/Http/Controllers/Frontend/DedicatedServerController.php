<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DedicatedPlan;
use App\Services\HetznerService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DedicatedServerController extends Controller
{
    protected HetznerService $hetznerService;

    public function __construct(HetznerService $hetznerService)
    {
        $this->hetznerService = $hetznerService;
    }

    /**
     * Display Dedicated Servers hosting page
     */
    public function index(): View
    {
        // Get active dedicated server plans
        $dedicatedPlans = DedicatedPlan::where('is_active', true)
            ->where('is_hidden', false)
            ->orderBy('sort_order')
            ->orderBy('monthly_price')
            ->get();

        // Get operating systems from Hetzner API with caching (24 hours)
        $operatingSystems = Cache::remember('hetzner_os_images', 86400, function () {
            try {
                $images = $this->hetznerService->listImages('system');
                
                // Map Hetzner images to format
                return collect($images)->map(function ($image) {
                    return [
                        'id' => $image['id'],
                        'name' => $image['name'],
                        'description' => $image['description'] ?? $image['name'],
                        'os_flavor' => $image['os_flavor'] ?? 'linux',
                        'architecture' => $image['architecture'] ?? 'x86',
                    ];
                })->sortBy('name')->values()->all();
            } catch (\Exception $e) {
                Log::error('Failed to fetch Hetzner OS images: ' . $e->getMessage());
                return [];
            }
        });

        // Hetzner doesn't have marketplace apps - set empty array
        $marketplaceApps = [];

        return view('frontend.server.dedicated-servers', compact('dedicatedPlans', 'operatingSystems', 'marketplaceApps'));
    }

    /**
     * Show Dedicated Server configuration page
     */
    public function configure(DedicatedPlan $dedicatedPlan): View
    {
        // Check if plan is active and not hidden
        if (!$dedicatedPlan->is_active || $dedicatedPlan->is_hidden) {
            abort(404);
        }

        // Get operating systems from Hetzner API with caching (24 hours)
        $operatingSystems = Cache::remember('hetzner_os_images', 86400, function () {
            try {
                $images = $this->hetznerService->listImages('system');
                
                // Map Hetzner images to format
                return collect($images)->map(function ($image) {
                    return [
                        'id' => $image['id'],
                        'name' => $image['name'],
                        'description' => $image['description'] ?? $image['name'],
                        'os_flavor' => $image['os_flavor'] ?? 'linux',
                        'architecture' => $image['architecture'] ?? 'x86',
                    ];
                })->sortBy('name')->values()->all();
            } catch (\Exception $e) {
                Log::error('Failed to fetch Hetzner OS images: ' . $e->getMessage());
                return [];
            }
        });

        // Hetzner doesn't have marketplace apps - set empty array
        $marketplaceApps = [];

        return view('frontend.server.dedicated-configure', compact('dedicatedPlan', 'operatingSystems', 'marketplaceApps'));
    }
}

