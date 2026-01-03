<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VpsPlan;
use App\Services\HetznerService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VpsHostingController extends Controller
{
    protected HetznerService $hetznerService;

    public function __construct(HetznerService $hetznerService)
    {
        $this->hetznerService = $hetznerService;
    }

    /**
     * Display VPS hosting page with plans from database
     */
    public function index(): View
    {
        // Get active VPS plans ordered by sort_order and featured first
        $vpsPlans = VpsPlan::where('is_active', true)
            ->where('is_hidden', false)
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('monthly_price', 'asc')
            ->get();

        // Static arrays since Vultr integration was removed
        $operatingSystems = [];

        // Static arrays since Vultr integration was removed
        $marketplaceApps = [];

        // Static arrays since Vultr integration was removed
        $datacenters = [];

        return view('frontend.server.vps-hosting', compact('vpsPlans', 'operatingSystems', 'marketplaceApps', 'datacenters'));
    }

    /**
     * Show VPS configuration page
     */
    public function configure(VpsPlan $vpsPlan): View
    {
        // Check if plan is active and not hidden
        if (!$vpsPlan->is_active || $vpsPlan->is_hidden) {
            abort(404);
        }

        // Get operating systems from Hetzner API with caching (24 hours)
        $allOperatingSystems = Cache::remember('hetzner_images', 86400, function () {
            try {
                $images = $this->hetznerService->listImages('system');
                
                return collect($images)->map(function ($image) {
                    return [
                        'id' => $image['id'],
                        'name' => $image['name'],
                        'description' => $image['description'],
                        'os_flavor' => $image['os_flavor'] ?? 'linux',
                        'type' => $image['type'],
                    ];
                })->sortBy('name')->values()->all();
            } catch (\Exception $e) {
                Log::error('Failed to fetch Hetzner images: ' . $e->getMessage());
                return [];
            }
        });

        // Filter operating systems based on plan specifications and os_options
        $operatingSystems = collect($allOperatingSystems)->filter(function ($os) use ($vpsPlan) {
            // Check minimum RAM requirements for OS (some OS need more RAM)
            $minRamRequirements = [
                'windows' => 2048, // Windows needs at least 2GB
                'plesk' => 1024,   // Plesk needs at least 1GB
            ];
            
            // Check if OS family has minimum requirements
            $osFamily = strtolower($os['family'] ?? '');
            if (isset($minRamRequirements[$osFamily]) && $vpsPlan->ram_mb < $minRamRequirements[$osFamily]) {
                return false; // Plan doesn't meet minimum RAM for this OS
            }
            
            // If plan has specific os_options defined, filter by them
            if (!empty($vpsPlan->os_options) && is_array($vpsPlan->os_options)) {
                return in_array($os['id'], $vpsPlan->os_options) || 
                       in_array($os['name'], $vpsPlan->os_options) ||
                       in_array($os['family'], $vpsPlan->os_options);
            }
            
            // If no specific restrictions, allow all OS that meet RAM requirements
            return true;
        })->values()->all();

        // Get regions/data centers from Hetzner API with caching (24 hours)
        $datacenters = Cache::remember('hetzner_locations', 86400, function () {
            try {
                $locations = $this->hetznerService->listLocations();
                
                return collect($locations)->map(function ($location) {
                    return [
                        'id' => $location['id'],
                        'name' => $location['name'],
                        'description' => $location['description'],
                        'country' => $location['country'],
                        'city' => $location['city'],
                        'latitude' => $location['latitude'] ?? 0,
                        'longitude' => $location['longitude'] ?? 0,
                        'network_zone' => $location['network_zone'],
                    ];
                })->values()->all();
            } catch (\Exception $e) {
                Log::error('Failed to fetch Hetzner Locations: ' . $e->getMessage());
                return [];
            }
        });

        // Marketplace apps - Empty for Hetzner (they don't have marketplace like Vultr)
        $allMarketplaceApps = [];

        // Filter marketplace apps based on plan specifications
        $marketplaceApps = [];

        return view('frontend.server.vps-configure', compact('vpsPlan', 'operatingSystems', 'datacenters', 'marketplaceApps'));
    }

    /**
     * Get approximate coordinates for regions
     */
    private function getRegionCoordinates(string $regionId, string $city): array
    {
        // Approximate coordinates for major cities
        $coordinates = [
            // North America
            'ewr' => ['lat' => 40.7128, 'lon' => -74.0060], // New York
            'ord' => ['lat' => 41.8781, 'lon' => -87.6298], // Chicago
            'dfw' => ['lat' => 32.7767, 'lon' => -96.7970], // Dallas
            'sea' => ['lat' => 47.6062, 'lon' => -122.3321], // Seattle
            'lax' => ['lat' => 34.0522, 'lon' => -118.2437], // Los Angeles
            'atl' => ['lat' => 33.7490, 'lon' => -84.3880], // Atlanta
            'mia' => ['lat' => 25.7617, 'lon' => -80.1918], // Miami
            'sjc' => ['lat' => 37.3382, 'lon' => -121.8863], // Silicon Valley
            'yto' => ['lat' => 43.6532, 'lon' => -79.3832], // Toronto
            // Europe
            'ams' => ['lat' => 52.3676, 'lon' => 4.9041], // Amsterdam
            'lhr' => ['lat' => 51.5074, 'lon' => -0.1278], // London
            'fra' => ['lat' => 50.1109, 'lon' => 8.6821], // Frankfurt
            'cdg' => ['lat' => 48.8566, 'lon' => 2.3522], // Paris
            'mad' => ['lat' => 40.4168, 'lon' => -3.7038], // Madrid
            'waw' => ['lat' => 52.2297, 'lon' => 21.0122], // Warsaw
            'sto' => ['lat' => 59.3293, 'lon' => 18.0686], // Stockholm
            // Asia Pacific
            'nrt' => ['lat' => 35.6762, 'lon' => 139.6503], // Tokyo
            'icn' => ['lat' => 37.5665, 'lon' => 126.9780], // Seoul
            'sgp' => ['lat' => 1.3521, 'lon' => 103.8198], // Singapore
            'syd' => ['lat' => -33.8688, 'lon' => 151.2093], // Sydney
            'mel' => ['lat' => -37.8136, 'lon' => 144.9631], // Melbourne
            'bom' => ['lat' => 19.0760, 'lon' => 72.8777], // Mumbai
            'del' => ['lat' => 28.7041, 'lon' => 77.1025], // Delhi
            // South America
            'sao' => ['lat' => -23.5505, 'lon' => -46.6333], // São Paulo
        ];

        $key = strtolower($regionId);
        if (isset($coordinates[$key])) {
            return $coordinates[$key];
        }

        // Default to center of map if unknown
        return ['lat' => 20.0, 'lon' => 0.0];
    }
}
