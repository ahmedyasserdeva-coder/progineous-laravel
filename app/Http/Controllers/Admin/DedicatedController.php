<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DedicatedPlan;
use App\Models\DedicatedInstance;
use App\Services\HetznerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DedicatedController extends Controller
{
    protected HetznerService $hetznerService;

    public function __construct(HetznerService $hetznerService)
    {
        $this->hetznerService = $hetznerService;
    }

    /**
     * Display dedicated server plans list
     */
    public function index()
    {
        $plans = DedicatedPlan::with('instances')
            ->orderBy('sort_order')
            ->orderBy('monthly_price')
            ->get();

        return view('admin.products.dedicated.index', compact('plans'));
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

        return view('admin.products.dedicated.create', compact('locations', 'serverTypes', 'images'));
    }

    /**
     * Store new dedicated server plan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_description' => 'nullable|string',
            'cpu_type' => 'required|string|max:255',
            'cpu_cores' => 'required|integer|min:1',
            'cpu_threads' => 'required|integer|min:1',
            'cpu_frequency' => 'nullable|string|max:50',
            'ram_gb' => 'required|integer|min:1',
            'hetzner_server_type' => 'nullable|string|max:255',
            'hetzner_location' => 'nullable|string|max:255',
            'storage_config' => 'required|string',
            'storage_type' => 'required|in:SSD,NVMe,HDD,SATA',
            'storage_total_gb' => 'required|integer|min:1',
            'disk_count' => 'nullable|integer|min:1',
            'bandwidth' => 'required|string',
            'ipv4_count' => 'required|integer|min:1',
            'enable_ipv6' => 'boolean',
            'monthly_price' => 'required|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
            'setup_time' => 'nullable|string',
            'auto_setup' => 'boolean',
            'os_options' => 'nullable|array',
            'control_panel_options' => 'nullable|array',
            'features_list' => 'nullable|array',
            'features_list_ar' => 'nullable|array',
            'allow_ipmi' => 'boolean',
            'allow_custom_os' => 'boolean',
            'allow_raid_config' => 'boolean',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            $plan = DedicatedPlan::create($validated);

            return redirect()
                ->route('admin.system-settings.products.dedicated-plans.index')
                ->with('success', __('crm.dedicated_plan_created_successfully'));
        } catch (Exception $e) {
            Log::error('Dedicated Plan Creation Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_creating_dedicated_plan'));
        }
    }

    /**
     * Show edit form
     */
    public function edit(DedicatedPlan $dedicatedPlan)
    {
        $hetznerService = app(HetznerService::class);
        
        // Get Hetzner data
        $locations = $hetznerService->listLocations();
        $serverTypes = $hetznerService->listServerTypes();
        $images = $hetznerService->listImages();

        return view('admin.products.dedicated.edit', compact('dedicatedPlan', 'locations', 'serverTypes', 'images'));
    }

    /**
     * Update dedicated server plan
     */
    public function update(Request $request, DedicatedPlan $dedicatedPlan)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_tagline' => 'nullable|string|max:255',
            'plan_short_description' => 'nullable|string',
            'plan_description' => 'nullable|string',
            'cpu_type' => 'required|string|max:255',
            'cpu_cores' => 'required|integer|min:1',
            'cpu_threads' => 'required|integer|min:1',
            'cpu_frequency' => 'nullable|string|max:50',
            'ram_gb' => 'required|integer|min:1',
            'hetzner_server_type' => 'nullable|string|max:255',
            'hetzner_location' => 'nullable|string|max:255',
            'storage_config' => 'required|string',
            'storage_type' => 'required|in:SSD,NVMe,HDD,SATA',
            'storage_total_gb' => 'required|integer|min:1',
            'disk_count' => 'nullable|integer|min:1',
            'bandwidth' => 'required|string',
            'monthly_price' => 'required|numeric|min:0',
            'quarterly_price' => 'nullable|numeric|min:0',
            'semi_annually_price' => 'nullable|numeric|min:0',
            'annually_price' => 'nullable|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
            'os_options' => 'nullable|array',
            'control_panel_options' => 'nullable|array',
            'features_list' => 'nullable|array',
            'features_list_ar' => 'nullable|array',
            'allow_ipmi' => 'boolean',
            'allow_custom_os' => 'boolean',
            'allow_raid_config' => 'boolean',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            $dedicatedPlan->update($validated);

            return redirect()
                ->route('admin.system-settings.products.dedicated-plans.index')
                ->with('success', __('crm.dedicated_plan_updated_successfully'));
        } catch (Exception $e) {
            Log::error('Dedicated Plan Update Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_updating_dedicated_plan'));
        }
    }

    /**
     * Delete dedicated server plan
     */
    public function destroy(DedicatedPlan $dedicatedPlan)
    {
        $activeInstances = $dedicatedPlan->instances()->where('status', 'active')->count();

        if ($activeInstances > 0) {
            return back()->with('error', __('crm.cannot_delete_plan_with_active_instances'));
        }

        try {
            $dedicatedPlan->delete();

            return redirect()
                ->route('admin.system-settings.products.dedicated-plans.index')
                ->with('success', __('crm.dedicated_plan_deleted_successfully'));
        } catch (Exception $e) {
            Log::error('Dedicated Plan Deletion Error', ['error' => $e->getMessage()]);

            return back()->with('error', __('crm.error_deleting_dedicated_plan'));
        }
    }

    /**
     * Sync plans from Hetzner API
     */
    public function syncPlans()
    {
        try {
            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Get server types from Hetzner
            $serverTypes = $hetznerService->listServerTypes();
            
            if (empty($serverTypes)) {
                return back()->with('error', 'No server types found from Hetzner API');
            }
            
            $syncedCount = 0;
            $updatedCount = 0;
            
            foreach ($serverTypes as $serverType) {
                // Skip ARM plans and deprecated plans
                if ($serverType['architecture'] !== 'x86' || $serverType['deprecated'] ?? false) {
                    continue;
                }
                
                // Check if plan already exists
                $plan = \App\Models\DedicatedPlan::where('hetzner_server_type', $serverType['name'])->first();
                
                $monthlyPrice = floatval($serverType['prices'][0]['price_monthly']['gross'] ?? 0);
                
                $planData = [
                    'hetzner_server_type' => $serverType['name'],
                    'plan_name' => strtoupper($serverType['name']),
                    'plan_tagline' => $serverType['description'] ?? strtoupper($serverType['name']),
                    'plan_short_description' => 'Hetzner Dedicated Server ' . strtoupper($serverType['name']),
                    'cpu_type' => $serverType['cpu_type'],
                    'cpu_cores' => $serverType['cores'],
                    'cpu_threads' => $serverType['cores'] * 2, // Estimate
                    'ram_gb' => $serverType['memory'],
                    'storage_type' => $serverType['storage_type'] ?? 'local',
                    'storage_config' => $serverType['disk'] . 'GB ' . ($serverType['storage_type'] ?? 'Local'),
                    'storage_total_gb' => $serverType['disk'],
                    'disk_count' => 1,
                    'bandwidth' => 'Unlimited',
                    'ipv4_count' => 1,
                    'enable_ipv6' => true,
                    'monthly_price' => $monthlyPrice,
                    'quarterly_price' => round($monthlyPrice * 3 * 0.95, 2), // 5% discount
                    'semi_annually_price' => round($monthlyPrice * 6 * 0.90, 2), // 10% discount
                    'annually_price' => round($monthlyPrice * 12 * 0.85, 2), // 15% discount
                    'setup_fee' => 0,
                    'is_active' => true,
                    'is_hidden' => false,
                    'auto_setup' => 'manual',
                ];
                
                if ($plan) {
                    $plan->update($planData);
                    $updatedCount++;
                } else {
                    \App\Models\DedicatedPlan::create($planData);
                    $syncedCount++;
                }
            }
            
            return back()->with('success', "Synced {$syncedCount} new plans and updated {$updatedCount} existing plans from Hetzner");
            
        } catch (\Exception $e) {
            Log::error('Hetzner Sync Error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to sync plans from Hetzner: ' . $e->getMessage());
        }
    }

    /**
     * List dedicated server instances
     */
    public function instances()
    {
        $instances = DedicatedInstance::with(['dedicatedPlan', 'client', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.products.dedicated.instances', compact('instances'));
    }

    /**
     * Show instance details
     */
    public function showInstance(DedicatedInstance $instance)
    {
        $instance->load(['dedicatedPlan', 'client', 'order']);

        // Vultr integration removed
        $vultrData = null;

        return view('admin.products.dedicated.show-instance', compact('instance', 'vultrData'));
    }

    /**
     * Approve pending dedicated server instance
     */
    public function approveInstance(DedicatedInstance $instance)
    {
        if ($instance->isApproved()) {
            return back()->with('warning', __('crm.instance_already_approved'));
        }

        DB::beginTransaction();
        try {
            // Update approval status
            $instance->update([
                'approved_at' => now(),
                'status' => 'provisioning',
            ]);

            // Vultr integration removed - Manual provisioning required
            $instance->update([
                'status' => 'pending',
            ]);

            Log::info('Dedicated instance approved but requires manual provisioning', [
                'instance_id' => $instance->id,
            ]);

            DB::commit();

            return back()->with('success', __('crm.instance_approved_and_provisioned'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Dedicated Instance Approval Error', ['error' => $e->getMessage()]);

            return back()->with('error', __('crm.error_approving_instance', ['error' => $e->getMessage()]));
        }
    }

    /**
     * Reject pending dedicated server instance
     */
    public function rejectInstance(Request $request, DedicatedInstance $instance)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $instance->update([
                'status' => 'rejected',
                'admin_notes' => $validated['rejection_reason'],
            ]);

            return back()->with('success', __('crm.instance_rejected_successfully'));
        } catch (Exception $e) {
            Log::error('Dedicated Instance Rejection Error', ['error' => $e->getMessage()]);

            return back()->with('error', __('crm.error_rejecting_instance'));
        }
    }

    /**
     * Provision new dedicated server instance
     */
    public function provisionInstance(Request $request)
    {
        $validated = $request->validate([
            'dedicated_plan_id' => 'required|exists:dedicated_plans,id',
            'client_id' => 'required|exists:clients,id',
            'order_id' => 'nullable|exists:orders,id',
            'hostname' => 'required|string|max:255',
            'os_id' => 'required|integer',
            'control_panel' => 'nullable|in:cpanel,plesk,webmin',
        ]);

        DB::beginTransaction();
        try {
            $plan = DedicatedPlan::findOrFail($validated['dedicated_plan_id']);

            // Create instance record
            $instance = DedicatedInstance::create([
                'dedicated_plan_id' => $plan->id,
                'client_id' => $validated['client_id'],
                'order_id' => $validated['order_id'] ?? null,
                'hostname' => $validated['hostname'],
                'os_id' => $validated['os_id'],
                'control_panel' => $validated['control_panel'] ?? null,
                'status' => $plan->requires_approval ? 'pending' : 'provisioning',
                'requires_approval' => $plan->requires_approval,
                'vultr_region' => $plan->vultr_region,
            ]);

            // If auto-approval, provision immediately (Vultr removed)
            if (!$plan->requires_approval) {
                $instance->update([
                    'status' => 'pending',
                    'provisioned_at' => null,
                ]);
                
                Log::info('Dedicated instance created but requires manual provisioning', [
                    'instance_id' => $instance->id,
                ]);
            }

            DB::commit();

            $message = $plan->requires_approval 
                ? __('crm.dedicated_instance_pending_approval')
                : __('crm.dedicated_instance_provisioned_successfully');

            return redirect()
                ->route('admin.dedicated-instances.show', $instance)
                ->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Dedicated Instance Provisioning Error', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', __('crm.error_provisioning_dedicated_instance', ['error' => $e->getMessage()]));
        }
    }
}
