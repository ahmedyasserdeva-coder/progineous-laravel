<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VpsPlan;
use App\Models\VpsInstance;
use App\Services\HetznerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class VpsController extends Controller
{
    protected HetznerService $hetznerService;

    public function __construct(HetznerService $hetznerService)
    {
        $this->hetznerService = $hetznerService;
    }

    /**
     * Display VPS plans list
     */
    public function index()
    {
        $plans = VpsPlan::with('instances')
            ->orderBy('sort_order')
            ->orderBy('monthly_price')
            ->get();

        return view('admin.products.vps.index', compact('plans'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        try {
            $locations = $this->hetznerService->listLocations();
            $serverTypes = $this->hetznerService->listServerTypes();
            $images = $this->hetznerService->listImages('system');
        } catch (Exception $e) {
            Log::error('Failed to fetch Hetzner data', ['error' => $e->getMessage()]);
            $locations = [];
            $serverTypes = [];
            $images = [];
        }

        return view('admin.products.vps.create', compact('locations', 'serverTypes', 'images'));
    }

    /**
     * Store new VPS plan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_description' => 'nullable|string',
            'vcpu_count' => 'required|integer|min:1',
            'ram_mb' => 'required|integer|min:512',
            'storage_gb' => 'required|integer|min:10',
            'storage_type' => 'required|in:SSD,NVMe',
            'bandwidth_gb' => 'required|integer|min:0',
            'hetzner_server_type' => 'nullable|string|max:255',
            'hetzner_location' => 'nullable|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
            'os_options' => 'nullable|array',
            'control_panel_options' => 'nullable|array',
            'features_list' => 'nullable|array',
            'features_list_ar' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'allow_ssh' => 'boolean',
            'allow_root' => 'boolean',
        ]);

        try {
            $plan = VpsPlan::create($validated);

            return redirect()
                ->route('admin.system-settings.products.vps-plans.index')
                ->with('success', __('crm.vps_plan_created_successfully'));
        } catch (Exception $e) {
            Log::error('VPS Plan Creation Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_creating_vps_plan'));
        }
    }

    /**
     * Show edit form
     */
    public function edit(VpsPlan $vpsPlan)
    {
        $hetznerService = app(HetznerService::class);
        
        // Get Hetzner data
        $locations = $hetznerService->listLocations();
        $serverTypes = $hetznerService->listServerTypes();
        $images = $hetznerService->listImages();

        return view('admin.products.vps.edit', compact('vpsPlan', 'locations', 'serverTypes', 'images'));
    }

    /**
     * Update VPS plan
     */
    public function update(Request $request, VpsPlan $vpsPlan)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_description' => 'nullable|string',
            'vcpu_count' => 'required|integer|min:1',
            'ram_mb' => 'required|integer|min:512',
            'storage_gb' => 'required|integer|min:10',
            'storage_type' => 'required|in:SSD,NVMe',
            'bandwidth_gb' => 'required|integer|min:0',
            'hetzner_server_type' => 'nullable|string|max:255',
            'hetzner_location' => 'nullable|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
            'os_options' => 'nullable|array',
            'control_panel_options' => 'nullable|array',
            'features_list' => 'nullable|array',
            'features_list_ar' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'allow_ssh' => 'boolean',
            'allow_root' => 'boolean',
        ]);

        try {
            $vpsPlan->update($validated);

            return redirect()
                ->route('admin.system-settings.products.vps-plans.index')
                ->with('success', __('crm.vps_plan_updated_successfully'));
        } catch (Exception $e) {
            Log::error('VPS Plan Update Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_updating_vps_plan'));
        }
    }

    /**
     * Delete VPS plan
     */
    public function destroy(VpsPlan $vpsPlan)
    {
        // Check if plan has active instances
        $activeInstances = $vpsPlan->instances()->where('status', 'active')->count();

        if ($activeInstances > 0) {
            return back()->with('error', __('crm.cannot_delete_plan_with_active_instances'));
        }

        try {
            $vpsPlan->delete();

            return redirect()
                ->route('admin.system-settings.products.vps-plans.index')
                ->with('success', __('crm.vps_plan_deleted_successfully'));
        } catch (Exception $e) {
            Log::error('VPS Plan Deletion Error', ['error' => $e->getMessage()]);

            return back()->with('error', __('crm.error_deleting_vps_plan'));
        }
    }

    /**
     * Sync plans from Hetzner API
     */
    public function syncPlans()
    {
        try {
            $serverTypes = $this->hetznerService->listServerTypes();
            $locations = $this->hetznerService->listLocations();
            
            $synced = 0;
            $skipped = 0;
            
            foreach ($serverTypes as $serverType) {
                // Check if already exists
                $exists = VpsPlan::where('hetzner_server_type', $serverType['name'])->exists();
                
                if ($exists) {
                    $skipped++;
                    continue;
                }
                
                // Create new plan from Hetzner server type
                VpsPlan::create([
                    'plan_name' => $serverType['name'] . ' - ' . $serverType['description'],
                    'plan_description' => $serverType['description'],
                    'vcpu_count' => $serverType['cores'],
                    'ram_mb' => $serverType['memory'] * 1024, // Convert GB to MB
                    'storage_gb' => $serverType['disk'],
                    'storage_type' => $serverType['storage_type'] ?? 'SSD',
                    'bandwidth_gb' => 0, // Hetzner doesn't limit bandwidth
                    'hetzner_server_type' => $serverType['name'],
                    'monthly_price' => $serverType['prices'][0]['price_monthly']['gross'] ?? 0,
                    'is_active' => false, // Require manual activation
                ]);
                
                $synced++;
            }
            
            return back()->with('success', __('Synced :synced plans from Hetzner. Skipped :skipped existing plans.', ['synced' => $synced, 'skipped' => $skipped]));
            
        } catch (Exception $e) {
            Log::error('Hetzner sync error', ['error' => $e->getMessage()]);
            return back()->with('error', __('Failed to sync from Hetzner: :message', ['message' => $e->getMessage()]));
        }
    }

    /**
     * Test Hetzner API connection
     */
    public function testConnection()
    {
        try {
            $isConnected = $this->hetznerService->testConnection();
            
            if ($isConnected) {
                return response()->json([
                    'success' => true,
                    'message' => __('Successfully connected to Hetzner Cloud API'),
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => __('Failed to connect to Hetzner Cloud API'),
            ], 400);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('API Error: :message', ['message' => $e->getMessage()]),
            ], 500);
        }
    }

    /**
     * List VPS instances
     */
    public function instances()
    {
        $instances = VpsInstance::with(['vpsPlan', 'client', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.products.vps.instances', compact('instances'));
    }

    /**
     * Show instance details
     */
    public function showInstance(VpsInstance $instance)
    {
        $instance->load(['vpsPlan', 'client', 'order']);

        // Vultr integration removed
        $vultrData = null;

        return view('admin.products.vps.show-instance', compact('instance', 'vultrData'));
    }

    /**
     * Provision new VPS instance
     */
    public function provisionInstance(Request $request)
    {
        $validated = $request->validate([
            'vps_plan_id' => 'required|exists:vps_plans,id',
            'client_id' => 'required|exists:clients,id',
            'order_id' => 'nullable|exists:orders,id',
            'hostname' => 'required|string|max:255',
            'os_id' => 'required|integer',
            'control_panel' => 'nullable|in:cpanel,plesk,webmin',
            'backups_enabled' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $plan = VpsPlan::findOrFail($validated['vps_plan_id']);

            // Create instance record
            $instance = VpsInstance::create([
                'vps_plan_id' => $plan->id,
                'client_id' => $validated['client_id'],
                'order_id' => $validated['order_id'] ?? null,
                'hostname' => $validated['hostname'],
                'os_id' => $validated['os_id'],
                'control_panel' => $validated['control_panel'] ?? null,
                'status' => 'provisioning',
                'backups_enabled' => $validated['backups_enabled'] ?? false,
                'vultr_region' => $plan->vultr_region,
            ]);

            // Vultr integration removed - Manual provisioning required
            $instance->update([
                'status' => 'pending',
                'provisioned_at' => null,
            ]);

            Log::info('VPS instance created but requires manual provisioning', [
                'instance_id' => $instance->id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.vps-instances.show', $instance)
                ->with('success', __('crm.vps_instance_provisioned_successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('VPS Instance Provisioning Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_provisioning_vps_instance', ['error' => $e->getMessage()]));
        }
    }
}
