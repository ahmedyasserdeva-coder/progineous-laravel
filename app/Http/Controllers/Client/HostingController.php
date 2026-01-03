<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Server;
use App\Models\Invoice;
use App\Models\Order;
use App\Services\CpanelService;
use App\Services\HetznerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HostingController extends Controller
{
    /**
     * Display client's shared hosting services
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        
        // Get shared hosting services only (exclude Cloud hosting)
        $hostingServices = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('status', '!=', 'failed')
            ->whereHas('orderItem', function($query) {
                $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) != ?', ['cloud']);
            })
            ->with(['order', 'orderItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistics for shared hosting only (exclude Cloud and failed)
        $stats = [
            'total' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', '!=', 'failed')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) != ?', ['cloud']);
                })
                ->count(),
            'active' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'active')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) != ?', ['cloud']);
                })
                ->count(),
            'pending' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'pending')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) != ?', ['cloud']);
                })
                ->count(),
            'suspended' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'suspended')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) != ?', ['cloud']);
                })
                ->count(),
        ];
        
        return view('frontend.client.hosting.index', compact('hostingServices', 'stats', 'client'));
    }
    
    /**
     * Display client's cloud hosting services only
     */
    public function cloudHosting()
    {
        $client = Auth::guard('client')->user();
        
        // Get cloud hosting services for this client (exclude failed)
        $cloudHostingServices = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('status', '!=', 'failed')
            ->whereHas('orderItem', function($query) {
                $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
            })
            ->with(['order', 'orderItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistics for cloud hosting only (exclude failed)
        $stats = [
            'total' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', '!=', 'failed')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
                })
                ->count(),
            'active' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'active')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
                })
                ->count(),
            'pending' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'pending')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
                })
                ->count(),
            'suspended' => Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('status', 'suspended')
                ->whereHas('orderItem', function($query) {
                    $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
                })
                ->count(),
        ];
        
        return view('frontend.client.hosting.cloud', compact('cloudHostingServices', 'stats', 'client'));
    }
    
    /**
     * Display client's reseller hosting services
     */
    public function resellerHosting()
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
     * Display client's VPS hosting services
     */
    public function vpsHosting()
    {
        $client = Auth::guard('client')->user();
        
        // Get VPS services for this client
        $vpsServices = Service::where('client_id', $client->id)
            ->where('type', 'vps')
            ->with(['order', 'orderItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistics for VPS hosting
        $stats = [
            'total' => Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->count(),
            'active' => Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('status', 'active')
                ->count(),
            'pending' => Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('status', 'pending')
                ->count(),
            'suspended' => Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('status', 'suspended')
                ->count(),
            'failed' => Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('status', 'failed')
                ->count(),
        ];
        
        return view('frontend.client.hosting.vps', compact('vpsServices', 'stats', 'client'));
    }
    
    /**
     * Display client's dedicated servers
     */
    public function dedicatedServers()
    {
        $client = Auth::guard('client')->user();
        
        // Get dedicated server services for this client
        $dedicatedServers = Service::where('client_id', $client->id)
            ->where('type', 'dedicated')
            ->with(['order', 'orderItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistics for dedicated servers
        $stats = [
            'total' => Service::where('client_id', $client->id)->where('type', 'dedicated')->count(),
            'active' => Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('status', 'active')
                ->count(),
            'pending' => Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->whereIn('status', ['pending', 'pending_approval', 'provisioning'])
                ->count(),
            'suspended' => Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('status', 'suspended')
                ->count(),
        ];
        
        return view('frontend.client.hosting.dedicated', compact('dedicatedServers', 'stats', 'client'));
    }
    
    /**
     * Show specific dedicated server details
     */
    public function showDedicated($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'dedicated')
            ->where('id', $id)
            ->with(['order', 'orderItem'])
            ->firstOrFail();
        
        // Decode server data
        $serverData = null;
        if ($service->server_data) {
            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;
        }
        
        // Get live server specs from Hetzner if available
        $serverSpecs = null;
        if ($serverData && isset($serverData['hetzner_server_id']) && $service->status === 'active') {
            try {
                $hetznerService = app(\App\Services\HetznerService::class);
                $serverInfo = $hetznerService->getServer($serverData['hetzner_server_id']);
                
                if ($serverInfo && isset($serverInfo['server_type'])) {
                    $serverType = $serverInfo['server_type'];
                    
                    // Get included traffic - use server's actual included_traffic
                    $includedTraffic = null;
                    if (isset($serverInfo['included_traffic'])) {
                        // Convert bytes to TB
                        $includedTraffic = round($serverInfo['included_traffic'] / 1099511627776, 0);
                    }
                    
                    $serverSpecs = [
                        'cores' => $serverType['cores'] ?? null,
                        'memory' => $serverType['memory'] ?? null,
                        'disk' => $serverType['disk'] ?? null,
                        'disk_type' => $serverType['storage_type'] ?? 'local',
                        'included_traffic' => $includedTraffic,
                        'cpu_type' => $serverType['cpu_type'] ?? null,
                        'architecture' => $serverType['architecture'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to fetch Hetzner server specs', [
                    'service_id' => $id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return view('frontend.client.hosting.show-dedicated', compact('service', 'serverData', 'client', 'serverSpecs'));
    }
    
    /**
     * Get dedicated server activities from Hetzner
     */
    public function dedicatedActivities($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();
            
            // Decode server data
            $serverData = null;
            if ($service->server_data) {
                $serverData = is_string($service->server_data) 
                    ? json_decode($service->server_data, true) 
                    : $service->server_data;
            }
            
            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'activities' => []
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $actions = $hetznerService->getServerActions($serverData['hetzner_server_id'], 10);
            
            // Format actions for display
            $formattedActions = array_map(function($action) {
                return [
                    'id' => $action['id'],
                    'command' => $action['command'],
                    'status' => $action['status'],
                    'started' => $action['started'],
                    'finished' => $action['finished'] ?? null,
                    'error' => $action['error'] ?? null,
                ];
            }, $actions);
            
            return response()->json([
                'success' => true,
                'activities' => $formattedActions
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Activities Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'activities' => []
            ], 500);
        }
    }
    
    /**
     * Get dedicated server metrics for graphs
     */
    public function dedicatedMetrics($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get time range from request or default to last 24 hours
            $hours = request('hours', 24);
            $endTime = now();
            $startTime = now()->subHours($hours);
            
            $metrics = [];
            
            // Get CPU metrics
            try {
                $cpuData = $hetznerService->getServerMetrics($serverId, 'cpu', $startTime, $endTime);
                $metrics['cpu'] = $this->formatMetricsData($cpuData, 'cpu');
            } catch (\Exception $e) {
                Log::warning('Failed to get CPU metrics', ['error' => $e->getMessage()]);
                $metrics['cpu'] = ['labels' => [], 'data' => []];
            }
            
            // Get Disk metrics (includes read/write throughput and iops)
            try {
                $diskData = $hetznerService->getServerMetrics($serverId, 'disk', $startTime, $endTime);
                $metrics['disk'] = $this->formatMetricsData($diskData, 'disk');
            } catch (\Exception $e) {
                Log::warning('Failed to get Disk metrics', ['error' => $e->getMessage()]);
                $metrics['disk'] = ['labels' => [], 'data' => []];
            }
            
            // Get Network metrics (includes bandwidth in/out)
            try {
                $networkData = $hetznerService->getServerMetrics($serverId, 'network', $startTime, $endTime);
                $metrics['network'] = $this->formatMetricsData($networkData, 'network');
            } catch (\Exception $e) {
                Log::warning('Failed to get Network metrics', ['error' => $e->getMessage()]);
                $metrics['network'] = ['labels' => [], 'data' => []];
            }
            
            return response()->json([
                'success' => true,
                'metrics' => $metrics,
                'period' => [
                    'start' => $startTime->toIso8601String(),
                    'end' => $endTime->toIso8601String(),
                    'hours' => $hours
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Metrics Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Format metrics data for Chart.js
     */
    private function formatMetricsData(array $data, string $type): array
    {
        $labels = [];
        $values = [];
        
        foreach ($data as $point) {
            $labels[] = date('H:i', $point['timestamp']);
            $values[] = round($point['value'], 2);
        }
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }
    
    /**
     * Get dedicated server backups
     */
    public function dedicatedBackups($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get server info to check if backups are enabled
            $serverInfo = $hetznerService->getServer($serverId);
            $backupsEnabled = !empty($serverInfo['backup_window']);
            
            // Get backups list
            $backups = $hetznerService->getServerBackups($serverId);
            
            return response()->json([
                'success' => true,
                'backups_enabled' => $backupsEnabled,
                'backup_window' => $serverInfo['backup_window'] ?? null,
                'backups' => $backups,
                'max_backups' => 7
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Backups Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enable backups for dedicated server
     */
    public function dedicatedEnableBackups($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            // Calculate backup cost (20% of plan price)
            $planPrice = floatval($service->recurring_amount ?? 0);
            $backupCost = round($planPrice * 0.20, 2);
            $billingCycle = $service->billing_cycle ?? 'monthly';
            
            // Check if client has sufficient balance
            if (!$client->hasSufficientBalance($backupCost)) {
                return response()->json([
                    'success' => false,
                    'insufficient_balance' => true,
                    'required_amount' => $backupCost,
                    'current_balance' => floatval($client->wallet_balance),
                    'error' => __('frontend.insufficient_balance_for_backup')
                ]);
            }
            
            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Enable backups on Hetzner
            $result = $hetznerService->enableBackups($serverId);
            
            // Deduct from wallet
            $client->deductFunds($backupCost, "Backup service for dedicated server #{$service->id}");
            
            // Record the transaction
            \App\Models\WalletTransaction::create([
                'client_id' => $client->id,
                'amount' => $backupCost,
                'type' => 'deduction',
                'status' => 'completed',
                'payment_method' => 'wallet',
                'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                'description' => __('frontend.backup_charge_description', ['service_id' => $service->id]),
                'notes' => "Backup enabled for dedicated server - Billing: {$billingCycle}",
                'metadata' => [
                    'service_id' => $service->id,
                    'service_type' => 'dedicated',
                    'addon_type' => 'backup',
                    'billing_cycle' => $billingCycle,
                    'next_charge_date' => $this->calculateNextBackupChargeDate($billingCycle),
                ],
                'completed_at' => now(),
            ]);
            
            // Update server_data to store backup info
            $serverData['backup_enabled'] = true;
            $serverData['backup_cost'] = $backupCost;
            $serverData['backup_billing_cycle'] = $billingCycle;
            $serverData['backup_next_charge'] = $this->calculateNextBackupChargeDate($billingCycle);
            $serverData['backup_enabled_at'] = now()->toIso8601String();
            
            $service->server_data = $serverData;
            $service->save();
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.backups_enabled_success'),
                'charged_amount' => $backupCost,
                'new_balance' => floatval($client->fresh()->wallet_balance),
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Enable Backups Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calculate next backup charge date based on billing cycle
     */
    private function calculateNextBackupChargeDate(string $billingCycle): string
    {
        $now = now();
        
        return match($billingCycle) {
            'monthly' => $now->addMonth()->toDateString(),
            'quarterly' => $now->addMonths(3)->toDateString(),
            'semi-annually', 'semiannually' => $now->addMonths(6)->toDateString(),
            'annually', 'yearly' => $now->addYear()->toDateString(),
            'biennially' => $now->addYears(2)->toDateString(),
            'triennially' => $now->addYears(3)->toDateString(),
            default => $now->addMonth()->toDateString(),
        };
    }
    
    /**
     * Get backup cost for a service
     */
    public function dedicatedBackupCost($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();
            
            $planPrice = floatval($service->recurring_amount ?? 0);
            $backupCost = round($planPrice * 0.20, 2);
            
            return response()->json([
                'success' => true,
                'backup_cost' => $backupCost,
                'billing_cycle' => $service->billing_cycle ?? 'monthly',
                'wallet_balance' => floatval($client->wallet_balance),
                'has_sufficient_balance' => $client->hasSufficientBalance($backupCost)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get snapshots for dedicated server
     */
    public function dedicatedSnapshots($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get snapshots list
            $snapshots = $hetznerService->getServerSnapshots($serverId);
            
            // Get stored snapshot data from server_data
            $storedSnapshots = $serverData['snapshots'] ?? [];
            
            // Merge snapshot billing info
            foreach ($snapshots as &$snapshot) {
                if (isset($storedSnapshots[$snapshot['id']])) {
                    $snapshot['billing_info'] = $storedSnapshots[$snapshot['id']];
                }
            }
            
            return response()->json([
                'success' => true,
                'snapshots' => $snapshots
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Snapshots Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get snapshot cost for dedicated server
     * Price: $0.5/GB/month based on server disk size
     */
    public function dedicatedSnapshotCost($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get server info for disk size
            $serverInfo = $hetznerService->getServer($serverId);
            $diskSize = $serverInfo['server_type']['disk'] ?? 50; // GB
            
            // Calculate snapshot cost: $0.5/GB/month (prorated daily = $0.5/30)
            $snapshotCostPerMonth = round($diskSize * 0.5, 2);
            
            return response()->json([
                'success' => true,
                'disk_size' => $diskSize,
                'snapshot_cost' => $snapshotCostPerMonth,
                'cost_per_gb' => 0.5,
                'billing_cycle' => 'monthly', // Snapshots are always billed monthly
                'wallet_balance' => floatval($client->wallet_balance),
                'has_sufficient_balance' => $client->hasSufficientBalance($snapshotCostPerMonth)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Create snapshot for dedicated server with wallet payment
     */
    public function dedicatedCreateSnapshot(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get server info for disk size and calculate cost
            $serverInfo = $hetznerService->getServer($serverId);
            $diskSize = $serverInfo['server_type']['disk'] ?? 50;
            $snapshotCost = round($diskSize * 0.5, 2);
            
            // Check if client has sufficient balance
            if (!$client->hasSufficientBalance($snapshotCost)) {
                return response()->json([
                    'success' => false,
                    'insufficient_balance' => true,
                    'required_amount' => $snapshotCost,
                    'current_balance' => floatval($client->wallet_balance),
                    'error' => __('frontend.insufficient_balance_for_snapshot')
                ]);
            }
            
            // Generate description
            $description = $request->input('description') ?? 'Snapshot - ' . now()->format('Y-m-d H:i');
            
            // Create snapshot on Hetzner
            $result = $hetznerService->createSnapshot($serverId, $description);
            
            if (!isset($result['image']['id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to create snapshot on Hetzner'
                ], 500);
            }
            
            $snapshotId = $result['image']['id'];
            
            // Deduct from wallet
            $client->deductFunds($snapshotCost, "Snapshot service for dedicated server #{$service->id}");
            
            // Calculate next charge date (1 month from now)
            $nextChargeDate = now()->addMonth()->toDateString();
            
            // Record the transaction
            \App\Models\WalletTransaction::create([
                'client_id' => $client->id,
                'amount' => $snapshotCost,
                'type' => 'deduction',
                'status' => 'completed',
                'payment_method' => 'wallet',
                'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                'description' => __('frontend.snapshot_charge_description', ['service_id' => $service->id]),
                'notes' => "Snapshot created for dedicated server - Monthly billing",
                'metadata' => [
                    'service_id' => $service->id,
                    'service_type' => 'dedicated',
                    'addon_type' => 'snapshot',
                    'snapshot_id' => $snapshotId,
                    'disk_size' => $diskSize,
                    'billing_cycle' => 'monthly',
                    'next_charge_date' => $nextChargeDate,
                ],
                'completed_at' => now(),
            ]);
            
            // Update server_data to store snapshot billing info
            $storedSnapshots = $serverData['snapshots'] ?? [];
            $storedSnapshots[$snapshotId] = [
                'created_at' => now()->toIso8601String(),
                'cost' => $snapshotCost,
                'disk_size' => $diskSize,
                'next_charge_date' => $nextChargeDate,
                'auto_delete_date' => now()->addMonth()->addDays(3)->toDateString(), // 3 days grace period
            ];
            
            $serverData['snapshots'] = $storedSnapshots;
            $service->server_data = $serverData;
            $service->save();
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.snapshot_created_success'),
                'charged_amount' => $snapshotCost,
                'new_balance' => floatval($client->fresh()->wallet_balance),
                'snapshot_id' => $snapshotId,
                'next_charge_date' => $nextChargeDate
            ]);

        } catch (\Exception $e) {
            Log::error('Create Snapshot Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete snapshot for dedicated server
     */
    public function dedicatedDeleteSnapshot($id, $snapshotId)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Delete snapshot on Hetzner
            $result = $hetznerService->deleteSnapshot((int) $snapshotId);
            
            // Remove from stored snapshots
            if (isset($serverData['snapshots'][$snapshotId])) {
                unset($serverData['snapshots'][$snapshotId]);
                $service->server_data = $serverData;
                $service->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.snapshot_deleted_success')
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Snapshot Error', [
                'service_id' => $id,
                'snapshot_id' => $snapshotId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get network info for dedicated server
     */
    public function dedicatedNetwork($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get server info for IP addresses
            $serverInfo = $hetznerService->getServer($serverId);
            
            // Get all floating IPs and filter for this server
            $allFloatingIps = $hetznerService->listFloatingIps();
            $floatingIps = array_filter($allFloatingIps, function($ip) use ($serverId) {
                return isset($ip['server']) && $ip['server'] == $serverId;
            });
            
            // Get stored floating IP data for billing info
            $storedFloatingIps = $serverData['floating_ips'] ?? [];
            
            // Merge billing info
            foreach ($floatingIps as &$fip) {
                if (isset($storedFloatingIps[$fip['id']])) {
                    $fip['billing_info'] = $storedFloatingIps[$fip['id']];
                }
            }
            
            return response()->json([
                'success' => true,
                'ipv4' => $serverInfo['public_net']['ipv4']['ip'] ?? null,
                'ipv4_dns_ptr' => $serverInfo['public_net']['ipv4']['dns_ptr'] ?? null,
                'ipv6' => $serverInfo['public_net']['ipv6']['ip'] ?? null,
                'ipv6_dns_ptr' => $serverInfo['public_net']['ipv6']['dns_ptr'] ?? null,
                'location' => $serverInfo['datacenter']['location']['name'] ?? null,
                'floating_ips' => array_values($floatingIps),
                'wallet_balance' => floatval($client->wallet_balance)
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Network Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update reverse DNS for dedicated server
     */
    public function dedicatedUpdateReverseDns(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $ip = trim($request->input('ip', ''));
            $dnsPtr = trim($request->input('dns_ptr', ''));
            
            // Log the received values
            Log::info('Reverse DNS Update Request', [
                'service_id' => $id,
                'ip' => $ip,
                'dns_ptr' => $dnsPtr
            ]);
            
            // Remove subnet notation if present (e.g., /64, /32)
            $ipClean = preg_replace('/\/\d+$/', '', $ip);
            
            // Validate IP address
            if (!$ipClean || $ipClean === '--' || !filter_var($ipClean, FILTER_VALIDATE_IP)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Valid IP address is required'
                ]);
            }
            
            // Validate dns_ptr (must be valid domain or empty)
            if ($dnsPtr && !preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?)*$/', $dnsPtr)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid domain name format'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Update reverse DNS (pass null if empty) - use clean IP without subnet
            $result = $hetznerService->changeReverseDns($serverId, $ipClean, $dnsPtr ?: null);
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.reverse_dns_updated'),
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Update Reverse DNS Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Create floating IP for dedicated server
     * IPv4: $5/month, IPv6: $3/month
     */
    public function dedicatedCreateFloatingIP(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $type = $request->input('type'); // ipv4 or ipv6
            $name = $request->input('name');
            
            if (!in_array($type, ['ipv4', 'ipv6'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid IP type. Must be ipv4 or ipv6'
                ]);
            }
            
            // Calculate cost based on type
            $cost = $type === 'ipv4' ? 5.00 : 3.00;
            
            // Check if client has sufficient balance
            if (!$client->hasSufficientBalance($cost)) {
                return response()->json([
                    'success' => false,
                    'insufficient_balance' => true,
                    'required_amount' => $cost,
                    'current_balance' => floatval($client->wallet_balance),
                    'error' => __('frontend.insufficient_balance_for_floating_ip')
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get server location
            $serverInfo = $hetznerService->getServer($serverId);
            $location = $serverInfo['datacenter']['location']['name'] ?? null;
            
            // Create floating IP on Hetzner
            $result = $hetznerService->createFloatingIp($type, $location, $serverId);
            
            if (!isset($result['floating_ip']['id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to create floating IP on Hetzner'
                ], 500);
            }
            
            $floatingIpId = $result['floating_ip']['id'];
            $floatingIpAddress = $result['floating_ip']['ip'] ?? null;
            
            // Deduct from wallet
            $client->deductFunds($cost, "Floating IP ({$type}) for dedicated server #{$service->id}");
            
            // Calculate next charge date (30 days from now)
            $nextChargeDate = now()->addDays(30)->toDateString();
            
            // Record the transaction
            \App\Models\WalletTransaction::create([
                'client_id' => $client->id,
                'amount' => $cost,
                'type' => 'deduction',
                'status' => 'completed',
                'payment_method' => 'wallet',
                'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                'description' => __('frontend.floating_ip_charge_description', ['service_id' => $service->id, 'type' => strtoupper($type)]),
                'notes' => "Floating IP ({$type}) created for dedicated server - Monthly billing",
                'metadata' => [
                    'service_id' => $service->id,
                    'service_type' => 'dedicated',
                    'addon_type' => 'floating_ip',
                    'floating_ip_id' => $floatingIpId,
                    'floating_ip_address' => $floatingIpAddress,
                    'ip_type' => $type,
                    'billing_cycle' => 'monthly',
                    'next_charge_date' => $nextChargeDate,
                ],
                'completed_at' => now(),
            ]);
            
            // Update server_data to store floating IP billing info
            $storedFloatingIps = $serverData['floating_ips'] ?? [];
            $storedFloatingIps[$floatingIpId] = [
                'created_at' => now()->toIso8601String(),
                'cost' => $cost,
                'type' => $type,
                'name' => $name,
                'next_charge_date' => $nextChargeDate,
            ];
            
            $serverData['floating_ips'] = $storedFloatingIps;
            $service->server_data = $serverData;
            $service->save();
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.floating_ip_created_success'),
                'charged_amount' => $cost,
                'new_balance' => floatval($client->fresh()->wallet_balance),
                'floating_ip' => $result['floating_ip'],
                'next_charge_date' => $nextChargeDate
            ]);

        } catch (\Exception $e) {
            Log::error('Create Floating IP Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete floating IP for dedicated server
     */
    public function dedicatedDeleteFloatingIP($id, $floatingIpId)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Delete floating IP on Hetzner
            $result = $hetznerService->deleteFloatingIp((int) $floatingIpId);
            
            // Remove from stored floating IPs
            if (isset($serverData['floating_ips'][$floatingIpId])) {
                unset($serverData['floating_ips'][$floatingIpId]);
                $service->server_data = $serverData;
                $service->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.floating_ip_deleted_success')
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Floating IP Error', [
                'service_id' => $id,
                'floating_ip_id' => $floatingIpId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get ISO images for dedicated server
     */
    public function dedicatedIsoImages($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Get server details to check if ISO is mounted
            $server = $hetznerService->getServer($serverData['hetzner_server_id']);
            // The getServer returns data directly, not under ['server'] key
            $mountedIso = $server['iso'] ?? null;
            
            // Get available ISO images
            $isoImages = $hetznerService->getISOImages();
            
            return response()->json([
                'success' => true,
                'iso_images' => $isoImages,
                'mounted_iso' => $mountedIso
            ]);

        } catch (\Exception $e) {
            Log::error('Get ISO Images Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mount ISO to dedicated server
     */
    public function dedicatedMountIso(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $isoId = $request->input('iso_id');
            if (!$isoId) {
                return response()->json([
                    'success' => false,
                    'error' => __('frontend.iso_id_required')
                ], 400);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Mount ISO
            $result = $hetznerService->attachISO($serverData['hetzner_server_id'], (int) $isoId);
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.iso_mounted_success'),
                'action' => $result['action'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Mount ISO Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Unmount ISO from dedicated server
     */
    public function dedicatedUnmountIso($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            
            // Unmount ISO
            $result = $hetznerService->detachISO($serverData['hetzner_server_id']);
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.iso_unmounted_success'),
                'action' => $result['action'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Unmount ISO Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Execute action on dedicated server (start, stop, restart, power_off)
     */
    public function dedicatedAction(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'dedicated')
            ->where('id', $id)
            ->firstOrFail();

        $action = $request->input('action');
        $serverData = is_string($service->server_data) 
            ? json_decode($service->server_data, true) 
            : $service->server_data;

        if (!$serverData || !isset($serverData['hetzner_server_id'])) {
            return response()->json(['error' => 'Server ID not found'], 400);
        }

        $serverId = $serverData['hetzner_server_id'];
        $hetznerService = app(\App\Services\HetznerService::class);

        try {
            $result = match($action) {
                'restart' => $hetznerService->rebootServer($serverId),
                'stop' => $hetznerService->shutdownServer($serverId),
                'start' => $hetznerService->powerOnServer($serverId),
                'power_off' => $hetznerService->powerOffServer($serverId),
                'reset' => $hetznerService->resetServer($serverId),
                default => throw new \Exception('Invalid action')
            };

            Log::info('Dedicated server action executed', [
                'service_id' => $service->id,
                'action' => $action,
                'server_id' => $serverId,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('frontend.action_executed_successfully'),
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated server action failed', [
                'service_id' => $service->id,
                'action' => $action,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get dedicated server status from Hetzner
     */
    public function dedicatedStatus($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->where('id', $id)
                ->firstOrFail();
            
            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server ID not found'
                ], 400);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $server = $hetznerService->getServer($serverData['hetzner_server_id']);
            
            // Server status can be: running, initializing, starting, stopping, off, deleting, migrating, rebuilding, unknown
            $status = $server['status'] ?? 'unknown';
            
            return response()->json([
                'success' => true,
                'status' => $status,
                'server_name' => $server['name'] ?? null,
            ]);

        } catch (\Exception $e) {
            Log::error('Dedicated Status Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'status' => 'unknown',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show specific VPS service details
     */
    public function showVps($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'vps')
            ->where('id', $id)
            ->with(['order', 'orderItem'])
            ->firstOrFail();
        
        // Decode server data
        $serverData = null;
        if ($service->server_data) {
            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;
        }
        
        // Get server IP
        $serverIp = $service->server_ip;
        if (!$serverIp && $serverData) {
            $serverIp = $serverData['ipv4'] ?? null;
        }
        
        // Get OS from Hetzner API
        $osName = null;
        if ($serverData && isset($serverData['hetzner_server_id'])) {
            try {
                $hetznerService = app(\App\Services\HetznerService::class);
                $serverInfo = $hetznerService->getServer($serverData['hetzner_server_id']);
                $osName = $serverInfo['image']['description'] ?? $serverInfo['image']['name'] ?? null;
            } catch (\Exception $e) {
                Log::error('Failed to get OS from Hetzner', [
                    'service_id' => $id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return view('frontend.client.hosting.show-vps', compact('service', 'client', 'serverData', 'serverIp', 'osName'));
    }

    /**
     * Get VPS server resources
     */
    public function vpsResources($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            Log::info('VPS Resources Request', [
                'service_id' => $id,
                'client_id' => $client ? $client->id : null
            ]);
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json(['error' => 'Server not provisioned'], 400);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverInfo = $hetznerService->getServer($serverData['hetzner_server_id']);
            
            $serverType = $serverInfo['server_type'] ?? null;
            
            // Get included_traffic from the first price location
            $includedTraffic = null;
            if (isset($serverType['prices'][0]['included_traffic'])) {
                $includedTraffic = round($serverType['prices'][0]['included_traffic'] / 1099511627776, 2); // Convert bytes to TB
            }
            
            // Get current traffic usage
            $outgoingTraffic = isset($serverInfo['outgoing_traffic']) ? round($serverInfo['outgoing_traffic'] / 1099511627776, 2) : 0;
            $ingoingTraffic = isset($serverInfo['ingoing_traffic']) ? round($serverInfo['ingoing_traffic'] / 1099511627776, 2) : 0;
            
            Log::info('VPS Resources Result', [
                'server_type' => $serverType,
                'included_traffic' => $includedTraffic,
                'outgoing_traffic' => $outgoingTraffic,
                'ingoing_traffic' => $ingoingTraffic
            ]);
            
            // Get datacenter location info
            $datacenter = $serverInfo['datacenter'] ?? null;
            $location = null;
            if ($datacenter) {
                $location = [
                    'name' => $datacenter['name'] ?? null,
                    'description' => $datacenter['description'] ?? null,
                    'country' => $datacenter['location']['country'] ?? null,
                    'city' => $datacenter['location']['city'] ?? null,
                ];
            }
            
            return response()->json([
                'success' => true,
                'resources' => [
                    'cores' => $serverType['cores'] ?? null,
                    'memory' => $serverType['memory'] ?? null,
                    'disk' => $serverType['disk'] ?? null,
                    'traffic_limit' => $includedTraffic,
                    'traffic_used' => $outgoingTraffic,
                    'traffic_in' => $ingoingTraffic,
                ],
                'location' => $location
            ]);

        } catch (\Exception $e) {
            Log::error('VPS Resources Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get VPS activities
     */
    public function vpsActivities($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            Log::info('VPS Activities Request', [
                'service_id' => $id,
                'client_id' => $client ? $client->id : null
            ]);
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'activities' => []
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $actions = $hetznerService->getServerActions($serverData['hetzner_server_id'], 10);
            
            Log::info('VPS Activities Result', [
                'service_id' => $id,
                'actions_count' => count($actions)
            ]);
            
            // Format actions for display
            $formattedActions = array_map(function($action) {
                return [
                    'id' => $action['id'],
                    'command' => $action['command'],
                    'status' => $action['status'],
                    'started' => $action['started'],
                    'finished' => $action['finished'] ?? null,
                    'error' => $action['error'] ?? null,
                ];
            }, $actions);
            
            return response()->json([
                'success' => true,
                'activities' => $formattedActions
            ]);

        } catch (\Exception $e) {
            Log::error('VPS Activities Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'activities' => []
            ], 500);
        }
    }

    /**
     * Get VPS metrics graphs from Hetzner API
     */
    public function vpsGraphs($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            Log::info('VPS Graphs Request', [
                'service_id' => $id,
                'client_id' => $client ? $client->id : null
            ]);
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            if (!$serverData || !isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found'
                ]);
            }

            $hetznerService = app(\App\Services\HetznerService::class);
            $serverId = $serverData['hetzner_server_id'];
            
            // Get metrics for last 24 hours
            $endTime = now();
            $startTime = now()->subHours(24);
            
            $graphs = [];
            
            // Get CPU metrics
            try {
                $cpuMetrics = $hetznerService->getServerMetrics($serverId, 'cpu', $startTime, $endTime);
                $graphs['cpu'] = [
                    'type' => 'cpu',
                    'data' => $cpuMetrics
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to get CPU metrics', ['error' => $e->getMessage()]);
            }
            
            // Get Network metrics
            try {
                $networkMetrics = $hetznerService->getServerMetrics($serverId, 'network', $startTime, $endTime);
                $graphs['network'] = [
                    'type' => 'network',
                    'data' => $networkMetrics
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to get Network metrics', ['error' => $e->getMessage()]);
            }
            
            // Get Disk metrics
            try {
                $diskMetrics = $hetznerService->getServerMetrics($serverId, 'disk', $startTime, $endTime);
                $graphs['disk'] = [
                    'type' => 'disk',
                    'data' => $diskMetrics
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to get Disk metrics', ['error' => $e->getMessage()]);
            }
            
            // Get Bandwidth metrics (using network as bandwidth)
            try {
                $bandwidthMetrics = $hetznerService->getServerMetrics($serverId, 'network', $startTime, $endTime);
                $graphs['bandwidth'] = [
                    'type' => 'bandwidth',
                    'data' => $bandwidthMetrics
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to get Bandwidth metrics', ['error' => $e->getMessage()]);
            }
            
            // Get Disk Throughput metrics
            try {
                $throughputMetrics = $hetznerService->getServerMetrics($serverId, 'disk', $startTime, $endTime);
                $graphs['throughput'] = [
                    'type' => 'throughput',
                    'data' => $throughputMetrics
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to get Bandwidth metrics', ['error' => $e->getMessage()]);
            }
            
            Log::info('VPS Graphs Result', [
                'service_id' => $id,
                'graphs_available' => array_keys($graphs)
            ]);
            
            return response()->json([
                'success' => true,
                'graphs' => $graphs
            ]);

        } catch (\Exception $e) {
            Log::error('VPS Graphs Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get backup status and list
     */
    public function backupStatus($id)
    {
        try {
            Log::info('Backup Status Request', ['service_id' => $id]);
            
            $client = Auth::guard('client')->user();
            
            if (!$client) {
                Log::warning('Backup Status: No authenticated client');
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized'
                ], 401);
            }
            
            Log::info('Backup Status: Client authenticated', ['client_id' => $client->id]);
            
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            // Get hetzner_server_id from server_data JSON column
            $serverId = $service->server_data['hetzner_server_id'] ?? null;

            Log::info('Backup Status: Service found', [
                'service_id' => $service->id,
                'hetzner_server_id' => $serverId
            ]);

            if (!$serverId) {
                Log::warning('Backup Status: No hetzner_server_id in server_data');
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);

            Log::info('Backup Status: Fetching server details', ['server_id' => $serverId]);

            // Get server details to check if backups are enabled
            $serverDetails = $hetznerService->getServer($serverId);
            
            Log::info('Backup Status: Server details received', [
                'has_backup_window' => isset($serverDetails['backup_window']),
                'backup_window' => $serverDetails['backup_window'] ?? null
            ]);
            
            $backupEnabled = isset($serverDetails['backup_window']) && $serverDetails['backup_window'] !== null;

            // Get list of backups (images with type 'backup' for this server)
            $backups = [];
            if ($backupEnabled) {
                Log::info('Backup Status: Fetching backups list');
                $backups = $hetznerService->getServerBackups($serverId);
                Log::info('Backup Status: Backups received', ['count' => count($backups)]);
            }

            // Get pending actions to check for ongoing backup creation
            Log::info('Backup Status: Checking for pending actions');
            $actions = $hetznerService->getServerActions($serverId, 5);
            $hasPendingBackup = false;
            foreach ($actions as $action) {
                if ($action['command'] === 'create_image' && 
                    in_array($action['status'], ['running', 'pending'])) {
                    $hasPendingBackup = true;
                    break;
                }
            }

            Log::info('Backup Status: Sending response', [
                'backup_enabled' => $backupEnabled,
                'backups_count' => count($backups),
                'has_pending_backup' => $hasPendingBackup
            ]);

            return response()->json([
                'success' => true,
                'backup_enabled' => $backupEnabled,
                'backups' => $backups,
                'has_pending_backup' => $hasPendingBackup
            ]);

        } catch (\Exception $e) {
            Log::error('Backup Status Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enable backups for server (create invoice first)
     */
    public function enableBackups($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::with('orderItem')
                ->where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            // Get hetzner_server_id from server_data
            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            // Check if backups are already enabled
            $hetznerService = app(HetznerService::class);
            $serverDetails = $hetznerService->getServer($serverId);
            
            if (isset($serverDetails['backup_window']) && !empty($serverDetails['backup_window'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Backups are already enabled for this server'
                ], 400);
            }

            // Calculate backup cost (20% of service price)
            // Try recurring_amount first, then fall back to order_item subtotal
            $servicePrice = $service->recurring_amount;
            
            if ($servicePrice <= 0 && $service->orderItem) {
                $servicePrice = $service->orderItem->subtotal ?? 0;
            }
            
            $backupCost = $servicePrice * 0.20;
            
            if ($backupCost <= 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unable to calculate backup cost. Service price not found.'
                ], 400);
            }

            // Create invoice for backup service
            DB::beginTransaction();
            
            try {
                // Generate invoice number
                $lastInvoice = Invoice::orderBy('id', 'desc')->first();
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 6, '0', STR_PAD_LEFT);
                
                // Create invoice
                $invoice = Invoice::create([
                    'order_id' => $service->order_id,
                    'client_id' => $client->id,
                    'invoice_number' => $invoiceNumber,
                    'invoice_date' => now(),
                    'due_date' => now()->addDays(7),
                    'subtotal' => $backupCost,
                    'tax' => 0,
                    'discount' => 0,
                    'total' => $backupCost,
                    'paid_amount' => 0,
                    'balance' => $backupCost,
                    'currency' => 'USD',
                    'status' => 'unpaid',
                    'notes' => 'Backup Service Activation Fee for VPS Service #' . $service->id . ' - ' . $service->service_name,
                ]);

                // Store pending backup activation in service notes
                $service->notes = ($service->notes ? $service->notes . "\n\n" : '') . 
                    '[' . now() . '] Backup activation requested. Waiting for payment of invoice ' . $invoiceNumber;
                $service->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoiceNumber,
                    'amount' => $backupCost,
                    'message' => 'Invoice created successfully. Please complete payment to activate backups.',
                    'redirect_url' => route('client.invoices.show', $invoice->id)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Enable Backups Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a backup
     */
    public function createBackup($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->createBackup($serverId);

            return response()->json([
                'success' => true,
                'message' => 'Backup creation started',
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Create Backup Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore from backup
     */
    public function restoreBackup($id, $backupId)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->restoreBackup($serverId, $backupId);

            return response()->json([
                'success' => true,
                'message' => 'Backup restoration started',
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Restore Backup Error', [
                'service_id' => $id,
                'backup_id' => $backupId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a backup
     */
    public function deleteBackup($id, $backupId)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->deleteBackup($backupId);

            return response()->json([
                'success' => true,
                'message' => 'Backup deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Backup Error', [
                'service_id' => $id,
                'backup_id' => $backupId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get snapshots list
     */
    public function getSnapshots($id)
    {
        try {
            Log::info('Get Snapshots Request', ['service_id' => $id]);
            
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            
            Log::info('Snapshots: Service found', [
                'service_id' => $service->id,
                'hetzner_server_id' => $serverId
            ]);
            
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $snapshots = $hetznerService->getServerSnapshots($serverId);

            // Get pending actions to check for ongoing snapshot creation
            Log::info('Snapshots: Checking for pending actions');
            $actions = $hetznerService->getServerActions($serverId, 5);
            $hasPendingSnapshot = false;
            foreach ($actions as $action) {
                if ($action['command'] === 'create_image' && 
                    in_array($action['status'], ['running', 'pending'])) {
                    $hasPendingSnapshot = true;
                    break;
                }
            }

            // Process completed snapshots and charge wallet if not already charged
            $client = Auth::guard('client')->user();
            foreach ($snapshots as $snapshot) {
                // Check if this snapshot has been charged
                $snapshotId = $snapshot['id'];
                $alreadyCharged = \App\Models\WalletTransaction::where('client_id', $client->id)
                    ->where('payment_method', 'snapshot_charge')
                    ->where('metadata->snapshot_id', $snapshotId)
                    ->exists();
                
                if (!$alreadyCharged && isset($snapshot['image_size'])) {
                    // Calculate monthly cost: $0.05 per GB
                    $sizeGB = $snapshot['image_size'];
                    $monthlyCost = round($sizeGB * 0.05, 2);
                    
                    // Only charge if cost is greater than $0.01
                    if ($monthlyCost >= 0.01 && $client->wallet_balance >= $monthlyCost) {
                        DB::beginTransaction();
                        try {
                            // Deduct from wallet
                            $client->decrement('wallet_balance', $monthlyCost);
                            
                            // Create transaction record
                            \App\Models\WalletTransaction::create([
                                'client_id' => $client->id,
                                'amount' => $monthlyCost,
                                'type' => 'deduction',
                                'status' => 'completed',
                                'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                                'payment_method' => 'snapshot_charge',
                                'completed_at' => now(),
                                'notes' => app()->getLocale() == 'ar' 
                                    ? "رسوم Snapshot شهرية - {$sizeGB} GB"
                                    : "Monthly Snapshot Fee - {$sizeGB} GB",
                                'metadata' => [
                                    'snapshot_id' => $snapshotId,
                                    'snapshot_description' => $snapshot['description'] ?? null,
                                    'service_id' => $id,
                                    'server_id' => $serverId,
                                    'size_gb' => $sizeGB,
                                    'price_per_gb' => 0.05,
                                    'monthly_cost' => $monthlyCost
                                ]
                            ]);
                            
                            DB::commit();
                            
                            Log::info('Snapshot charge applied', [
                                'snapshot_id' => $snapshotId,
                                'client_id' => $client->id,
                                'size_gb' => $sizeGB,
                                'cost' => $monthlyCost
                            ]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Failed to charge snapshot', [
                                'snapshot_id' => $snapshotId,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
            }

            Log::info('Snapshots: Sending response', [
                'snapshots_count' => count($snapshots),
                'has_pending_snapshot' => $hasPendingSnapshot
            ]);

            return response()->json([
                'success' => true,
                'snapshots' => $snapshots,
                'has_pending_snapshot' => $hasPendingSnapshot
            ]);

        } catch (\Exception $e) {
            Log::error('Get Snapshots Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create snapshot
     */
    public function createSnapshot($id, Request $request)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            // Check wallet balance - minimum $15 required for snapshot creation
            $minimumBalance = 15.00;
            if ($client->wallet_balance < $minimumBalance) {
                return response()->json([
                    'success' => false,
                    'error' => app()->getLocale() == 'ar' 
                        ? "رصيد المحفظة غير كافٍ. يجب أن يكون لديك على الأقل \${$minimumBalance} لإنشاء Snapshot."
                        : "Insufficient wallet balance. You need at least \${$minimumBalance} to create a snapshot.",
                    'insufficient_balance' => true,
                    'current_balance' => $client->wallet_balance,
                    'required_balance' => $minimumBalance
                ], 400);
            }

            $description = $request->input('description');
            
            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->createSnapshot($serverId, $description);

            Log::info('Snapshot Creation Started', [
                'service_id' => $id,
                'client_id' => $client->id,
                'server_id' => $serverId,
                'action_id' => $result['action']['id'] ?? null,
                'image_id' => $result['image']['id'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Snapshot creation started',
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Create Snapshot Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete snapshot
     */
    public function deleteSnapshot($id, $snapshotId)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->deleteSnapshot($snapshotId);

            return response()->json([
                'success' => true,
                'message' => 'Snapshot deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Snapshot Error', [
                'service_id' => $id,
                'snapshot_id' => $snapshotId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute VPS action
            Log::error('VPS Activities Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show specific cloud hosting service details
     */
    public function showCloud($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::select('*')
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->whereHas('orderItem', function($query) {
                $query->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(configuration, "$.product_type"))) = ?', ['cloud']);
            })
            ->with(['order', 'orderItem', 'server'])
            ->firstOrFail();
        
        // Get cPanel usage statistics if service is active and has username
        $stats = null;
        if ($service->status === 'active' && $service->username) {
            $cpanelService = app(\App\Services\CpanelService::class);
            $stats = $cpanelService->getAccountStats($service->username);
        }
        
        return view('frontend.client.hosting.show-cloud', compact('service', 'client', 'stats'));
    }
    
    /**
     * Show specific hosting service details
     */
    public function show($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::select('*')
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->with(['order', 'orderItem', 'server'])
            ->firstOrFail();
        
        // Check if this is a Cloud Hosting service - redirect to cloud page
        $configuration = $service->orderItem->configuration ?? [];
        $productType = strtolower($configuration['product_type'] ?? '');
        
        if ($productType === 'cloud') {
            return redirect()->route('client.hosting.cloud.show', $id);
        }
        
        // Debug: Log the service data
        Log::info('Service Data:', [
            'id' => $service->id,
            'next_due_date_raw' => $service->getAttributes()['next_due_date'] ?? 'NULL',
            'next_due_date_cast' => $service->next_due_date,
            'expiry_date' => $service->expiry_date,
        ]);
        
        // Get cPanel usage statistics if service is active and has username
        $stats = null;
        if ($service->status === 'active' && $service->username) {
            $cpanelService = app(\App\Services\CpanelService::class);
            $stats = $cpanelService->getAccountStats($service->username);
        }
        
        return view('frontend.client.hosting.show', compact('service', 'client', 'stats'));
    }

    /**
     * Login to cPanel with auto-authentication
     */
    public function loginCpanel($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Redirect to cPanel with auto-login session token
            return redirect()->away($result['data']['url']);
        }

        // Fallback: redirect to cPanel login page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel SSL/TLS Manager with auto-authentication
     */
    public function loginCpanelSSL($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Extract session token from URL
            $sessionUrl = $result['data']['url'];
            
            // Log the original URL for debugging
            Log::info('Original cPanel Session URL', ['url' => $sessionUrl]);
            
            // Extract the base URL and session token
            // Format: https://hostname:2083/cpsessXXXXXX/login/?session=...
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token and query string
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get the session parameter from original URL
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build SSL/TLS Status page URL with goto_uri parameter
                // The goto_uri tells cPanel where to redirect after successful login
                $gotoUri = '/' . $sessionToken . '/frontend/jupiter/security/tls_status/';
                $sslUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                Log::info('Modified SSL URL', ['url' => $sslUrl]);
                
                // Redirect to cPanel SSL/TLS Status page with auto-login
                return redirect()->away($sslUrl);
            }
            
            // Fallback: redirect to original URL (dashboard)
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel SSL/TLS page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel FTP Accounts Manager with auto-authentication
     */
    public function loginCpanelFTP($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Extract session token from URL
            $sessionUrl = $result['data']['url'];
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token and query string
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get the session parameter from original URL
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build FTP Accounts page URL with goto_uri parameter
                $gotoUri = '/' . $sessionToken . '/frontend/jupiter/ftp/accounts.html';
                $ftpUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                // Redirect to cPanel FTP Accounts page with auto-login
                return redirect()->away($ftpUrl);
            }
            
            // Fallback: redirect to original URL (dashboard)
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel login page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel Database Wizard with auto-authentication
     */
    public function loginCpanelDatabase($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Extract session token from URL
            $sessionUrl = $result['data']['url'];
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token and query string
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get the session parameter from original URL
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build Database Wizard page URL with goto_uri parameter
                $gotoUri = '/' . $sessionToken . '/frontend/jupiter/sql/wizard1.html';
                $databaseUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                // Redirect to cPanel Database Wizard page with auto-login
                return redirect()->away($databaseUrl);
            }
            
            // Fallback: redirect to original URL (dashboard)
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel login page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel Domains Manager with auto-authentication
     */
    public function loginCpanelDomains($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Extract session token from URL
            $sessionUrl = $result['data']['url'];
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token and query string
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get the session parameter from original URL
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build Domains Manager page URL with goto_uri parameter
                $gotoUri = '/' . $sessionToken . '/frontend/jupiter/domains/index.html';
                $domainsUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                // Redirect to cPanel Domains Manager page with auto-login
                return redirect()->away($domainsUrl);
            }
            
            // Fallback: redirect to original URL (dashboard)
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel login page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel Email Accounts Manager with auto-authentication
     */
    public function loginCpanelEmailAccounts($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            // Extract session token from URL
            $sessionUrl = $result['data']['url'];
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token and query string
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get the session parameter from original URL
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build Email Accounts Manager page URL with goto_uri parameter
                $gotoUri = '/' . $sessionToken . '/frontend/jupiter/email_accounts/index.html#/list';
                $emailUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                // Redirect to cPanel Email Accounts Manager page with auto-login
                return redirect()->away($emailUrl);
            }
            
            // Fallback: redirect to original URL (dashboard)
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel login page
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel PHP Selector with auto-authentication
     */
    public function loginPHPSelector($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        // Check if service has username
        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        // Create user session via WHM API
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            
            // Parse URL to get host and session token
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            // Extract session token
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                
                // Get session parameter
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                // Build PHP Selector URL - CloudLinux LVE PHP Selector
                $phpSelectorPath = '/frontend/jupiter/lveversion/php_selector.live.pl';
                $gotoUri = '/' . $sessionToken . $phpSelectorPath;
                $phpSelectorUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                Log::info('PHP Selector URL', ['url' => $phpSelectorUrl]);
                
                return redirect()->away($phpSelectorUrl);
            }
            
            // Fallback: redirect to original URL
            return redirect()->away($sessionUrl);
        }

        // Fallback: redirect to cPanel
        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel File Manager with auto-authentication
     */
    public function loginFileManager($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $fileManagerPath = '/frontend/jupiter/filemanager/index.html';
                $gotoUri = '/' . $sessionToken . $fileManagerPath;
                $fileManagerUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($fileManagerUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to cPanel Databases with auto-authentication
     */
    public function loginDatabases($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $databasesPath = '/frontend/jupiter/sql/index.html';
                $gotoUri = '/' . $sessionToken . $databasesPath;
                $databasesUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($databasesUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to Webmail with auto-authentication
     */
    public function loginWebmail($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $webmailPath = '/frontend/jupiter/email_accounts/index.html';
                $gotoUri = '/' . $sessionToken . $webmailPath;
                $webmailUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($webmailUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Login to WordPress (Softaculous) with auto-authentication
     */
    public function loginWordPress($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $wordpressPath = '/frontend/jupiter/softaculous/index.live.php?act=wordpress';
                $gotoUri = '/' . $sessionToken . $wordpressPath;
                $wordpressUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($wordpressUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    public function loginModSecurity($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $modsecurityPath = '/frontend/jupiter/security/mod_security/index.html';
                $gotoUri = '/' . $sessionToken . $modsecurityPath;
                $modsecurityUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($modsecurityUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    public function loginSitejet($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $sitejetPath = '/frontend/jupiter/sitejet/index.html';
                $gotoUri = '/' . $sessionToken . $sitejetPath;
                $sitejetUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($sitejetUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    public function loginSocialBee($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available') ?? 'cPanel login is not available for this service.');
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = isset($queryParams['session']) ? $queryParams['session'] : '';
                
                $socialbeePath = '/frontend/jupiter/socialbee/index.html';
                $gotoUri = '/' . $sessionToken . $socialbeePath;
                $socialbeeUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($socialbeeUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found') ?? 'Server information not found.');
    }

    /**
     * Get hosting service statistics via AJAX
     */
    public function getStats($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        // Get cPanel usage statistics if service is active and has username
        $stats = null;
        if ($service->status === 'active' && $service->username) {
            $cpanelService = app(\App\Services\CpanelService::class);
            $stats = $cpanelService->getAccountStats($service->username);
        }
        
        // Return stats in expected format
        if ($stats) {
            return response()->json([
                'success' => true,
                'disk_used' => $stats['disk_used_bytes'] ?? 0,
                'disk_limit' => $stats['disk_limit_bytes'] ?? 0,
                'bandwidth_used' => $stats['bandwidth_used_bytes'] ?? 0,
                'bandwidth_limit' => $stats['bandwidth_limit_bytes'] ?? 0,
                'addon_domains_used' => $stats['addon_domains_used'] ?? 0,
                'addon_domains_limit' => $stats['addon_domains'] ?? 0,
                'email_accounts_used' => $stats['email_accounts_used'] ?? 0,
                'email_accounts_limit' => $stats['email_accounts'] ?? 0,
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unable to retrieve statistics'
        ]);
    }

    /**
     * Login to Sitepad
     */
    public function loginSitepad($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->where('status', 'active')
            ->with('server')
            ->firstOrFail();

        if (!$service->username) {
            return back()->with('error', __('frontend.cpanel_login_not_available'));
        }

        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createUserSession($service->username, 'cpaneld');

        if ($result && isset($result['data']['url'])) {
            $sessionUrl = $result['data']['url'];
            $urlParts = parse_url($sessionUrl);
            $host = $urlParts['scheme'] . '://' . $urlParts['host'] . ':' . ($urlParts['port'] ?? 2083);
            
            if (preg_match('#/(cpsess\d+)/#', $sessionUrl, $matches)) {
                $sessionToken = $matches[1];
                parse_str($urlParts['query'] ?? '', $queryParams);
                $sessionParam = $queryParams['session'] ?? '';
                
                $sitepadPath = '/3rdparty/sitepad/index.live.php';
                $gotoUri = '/' . $sessionToken . $sitepadPath;
                $sitepadUrl = $host . '/' . $sessionToken . '/login/?session=' . urlencode($sessionParam) . '&goto_uri=' . urlencode($gotoUri);
                
                return redirect()->away($sitepadUrl);
            }
            
            return redirect()->away($sessionUrl);
        }

        if ($service->server) {
            $cpanelUrl = 'https://' . ($service->server->hostname ?? $service->server->ip_address) . ':2083';
            return redirect()->away($cpanelUrl);
        }

        return back()->with('error', __('frontend.cpanel_server_not_found'));
    }

    /**
     * List email accounts
     */
    public function listEmails($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'accounts' => []
            ]);
        }

        if (!$service->server) {
            return response()->json([
                'success' => false,
                'message' => 'Server not found',
                'accounts' => []
            ]);
        }
        
        $server = $service->server;
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );
        
        $result = $cpanelService->listEmailAccounts($service->username);
        
        \Log::info('List Email Accounts Response', ['result' => $result]);
        
        if ($result['success']) {
            $accounts = $result['accounts'] ?? $result['emails'] ?? [];
            return response()->json([
                'success' => true,
                'accounts' => $accounts
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to fetch email accounts',
            'accounts' => []
        ]);
    }

    /**
     * Create email account
     */
    public function createEmail(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.service_not_active')
            ]);
        }
        
        $request->validate([
            'email_username' => 'required|string|max:64|regex:/^[a-zA-Z0-9._-]+$/',
            'email_domain' => 'required|string',
            'password' => 'required|string|min:8',
            'quota' => 'nullable|integer|min:0|max:10000'
        ]);
        
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->createEmailAccount(
            $service->username,
            $request->email_username,
            $request->password,
            $request->quota ?? 250,
            $request->email_domain
        );
        
        return response()->json($result);
    }

    /**
     * Delete email account
     */
    public function deleteEmail(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.service_not_active')
            ]);
        }
        
        $request->validate([
            'email_user' => 'required|string',
            'email_domain' => 'nullable|string'
        ]);
        
        // Use the provided domain or fallback to service domain
        $emailDomain = $request->email_domain ?? $service->domain;
        
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->deleteEmailAccount(
            $service->username,
            $request->email_user,
            $emailDomain
        );
        
        return response()->json($result);
    }

    /**
     * Get available domains for email creation
     */
    public function getDomains($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.service_not_active'),
                'domains' => []
            ]);
        }
        
        $cpanelService = app(\App\Services\CpanelService::class);
        $result = $cpanelService->getAccountDomains($service->username);
        
        return response()->json($result);
    }

    /**
     * Change cPanel account password
     */
    public function changePassword(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'hosting')
            ->where('id', $id)
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.service_not_active')
            ]);
        }
        
        $request->validate([
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:new_password'
        ]);
        
        $cpanelService = app(\App\Services\CpanelService::class);
        
        \Log::info('Attempting to change cPanel password', [
            'username' => $service->username,
            'client_id' => $client->id
        ]);
        
        $result = $cpanelService->changeAccountPassword(
            $service->username,
            $request->new_password
        );
        
        \Log::info('cPanel password change result', $result);
        
        if ($result['success']) {
            // Optionally log the password change
            \Log::info('cPanel password changed for user: ' . $service->username . ' by client: ' . $client->id);
        }
        
        return response()->json($result);
    }

    // List FTP accounts
    public function listFtp($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $accounts = $cpanelService->listFtpAccounts($service->username);
        
        return response()->json([
            'success' => true,
            'accounts' => $accounts
        ]);
    }

    // Create FTP account
    public function createFtp(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'directory' => 'nullable|string',
            'quota' => 'nullable|integer|min:0'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->createFtpAccount(
            $service->username,
            $request->username,
            $request->password,
            $request->directory,
            $request->quota
        );

        return response()->json($result);
    }

    // Delete FTP account
    public function deleteFtp(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'username' => 'required|string'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->deleteFtpAccount(
            $service->username,
            $request->username
        );

        return response()->json($result);
    }

    // Database Wizard - Create Database
    public function createDatabase(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'database' => 'required|string|max:64|regex:/^[a-zA-Z0-9_]+$/'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->createDatabase(
            $service->username,
            $request->database
        );

        return response()->json($result);
    }

    // Database Wizard - Create Database User
    public function createDatabaseUser(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'username' => 'required|string|max:16|regex:/^[a-zA-Z0-9_]+$/',
            'password' => 'required|string|min:5'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->createDatabaseUser(
            $service->username,
            $request->username,
            $request->password
        );

        return response()->json($result);
    }

    // Database Wizard - Assign Privileges
    public function assignDatabasePrivileges(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'database' => 'required|string',
            'username' => 'required|string',
            'privileges' => 'required|string'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->assignDatabasePrivileges(
            $service->username,
            $request->database,
            $request->username,
            $request->privileges
        );

        return response()->json($result);
    }

    // ===== Domains Manager Methods =====

    // List Addon Domains
    public function listAddonDomains($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'domains' => []
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->listAddonDomains($service->username);
        return response()->json($result);
    }

    // Add Addon Domain
    public function addAddonDomain(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'domain' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
            'directory' => 'required|string|max:255'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->addAddonDomain(
            $service->username,
            $request->domain,
            $request->subdomain,
            $request->directory
        );

        return response()->json($result);
    }

    // Delete Addon Domain
    public function deleteAddonDomain(Request $request, $id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Delete addon domain functionality is currently disabled'
        ]);
    }

    // List Subdomains
    public function listSubdomains($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'subdomains' => []
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->listSubdomains($service->username);
        return response()->json($result);
    }

    // Add Subdomain
    public function addSubdomain(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'subdomain' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'directory' => 'required|string|max:255'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->addSubdomain(
            $service->username,
            $request->subdomain,
            $request->domain,
            $request->directory
        );

        return response()->json($result);
    }

    // Delete Subdomain
    public function deleteSubdomain(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'subdomain' => 'required|string',
            'domain' => 'required|string'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->deleteSubdomain(
            $service->username,
            $request->subdomain,
            $request->domain
        );

        return response()->json($result);
    }

    // ==================== Zone Editor (DNS) Functions ====================

    // List DNS Zones
    public function listZones($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'zones' => []
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->listZones($service->username);
        return response()->json($result);
    }

    // Get DNS Records for a Zone
    public function getZoneRecords(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'domain' => 'required|string'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->fetchZoneRecords($service->username, $request->domain);
        return response()->json($result);
    }

    // Add DNS Record
    public function addZoneRecord(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();

        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $request->validate([
            'domain' => 'required|string',
            'name' => 'required|string',
            'type' => 'required|in:A,AAAA,CNAME,MX,TXT',
            'record' => 'required|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer'
        ]);

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new \App\Services\CpanelService(
            $server->hostname,
            $server->username,
            $server->password,
            $server->api_token
        );

        $result = $cpanelService->addZoneRecord(
            $service->username,
            $request->domain,
            $request->name,
            $request->type,
            $request->record,
            $request->ttl ?? 14400,
            $request->priority
        );

        return response()->json($result);
    }

    public function listSSLCertificates($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'certificates' => []
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService($server->hostname, $server->username, $server->password);
        $result = $cpanelService->listSSLCertificates($service->username);
        
        return response()->json($result);
    }

    public function getSSLStatus($id)
    {
        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'status' => []
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService($server->hostname, $server->username, $server->password);
        $result = $cpanelService->getSSLStatus($service->username);
        
        return response()->json($result);
    }

    public function installAutoSSL(Request $request, $id)
    {
        $request->validate([
            'domain' => 'required|string'
        ]);

        $client = Auth::guard('client')->user();
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }

        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService($server->hostname, $server->username, $server->password);
        $result = $cpanelService->installAutoSSL(
            $service->username,
            $request->domain
        );
        
        return response()->json($result);
    }

    /**
     * Get available PHP versions
     */
    public function getAvailablePHPVersions($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active',
                'versions' => []
            ]);
        }
        
        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService(
            $server->hostname,
            $server->username,
            $server->password
        );
        
        $result = $cpanelService->getAvailablePHPVersions($service->username);
        
        // Parse cPanel response
        if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
            $versions = [];
            foreach ($result['cpanelresult']['data'] as $version) {
                if (is_string($version)) {
                    $versions[] = $version;
                }
            }
            return response()->json([
                'success' => true,
                'versions' => $versions
            ]);
        }
        
        return response()->json([
            'success' => false,
            'versions' => []
        ]);
    }

    /**
     * Get current PHP version
     */
    public function getCurrentPHPVersion($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }
        
        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService(
            $server->hostname,
            $server->username,
            $server->password
        );
        
        $result = $cpanelService->getCurrentPHPVersion($service->username);
        
        // Parse cPanel response
        if (isset($result['cpanelresult']['data']['version'])) {
            return response()->json([
                'success' => true,
                'version' => $result['cpanelresult']['data']['version']
            ]);
        } elseif (isset($result['cpanelresult']['data'][0])) {
            return response()->json([
                'success' => true,
                'version' => $result['cpanelresult']['data'][0]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'version' => null
        ]);
    }

    /**
     * Set PHP version (applies to entire cPanel account)
     */
    public function setPHPVersion(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('id', $id)
            ->where('client_id', $client->id)
            ->where('type', 'hosting')
            ->firstOrFail();
        
        if ($service->status !== 'active' || !$service->username) {
            return response()->json([
                'success' => false,
                'message' => 'Service is not active'
            ]);
        }
        
        $request->validate([
            'version' => 'required|string'
        ]);
        
        $server = Server::findOrFail($service->server_id);
        $cpanelService = new CpanelService(
            $server->hostname,
            $server->username,
            $server->password
        );
        
        $result = $cpanelService->setPHPVersion(
            $service->username,
            $request->version
        );
        
        // Parse cPanel response
        if (isset($result['cpanelresult']['data']['result']) && $result['cpanelresult']['data']['result'] == 1) {
            return response()->json([
                'success' => true,
                'message' => 'PHP version changed successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['cpanelresult']['error'] ?? 'Failed to change PHP version'
        ]);
    }
    
    /**
     * Send cancellation verification code to client email
     */
    public function sendCancellationCode(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('id', $id)
                ->firstOrFail();
            
            // Get cancellation reason from request
            $reason = $request->input('reason');
            
            // Generate 6-digit verification code
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store code and reason in cache for 10 minutes
            Cache::put("cancellation_code_{$service->id}_{$client->id}", $code, now()->addMinutes(10));
            Cache::put("cancellation_reason_{$service->id}_{$client->id}", $reason, now()->addMinutes(10));
            
            // Send email with verification code
            Mail::send('emails.cancellation-code', ['code' => $code, 'service' => $service, 'client' => $client], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject(__('frontend.cancellation_verification_code'));
            });
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.code_sent')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending cancellation code: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => __('frontend.error_sending_code')
            ], 500);
        }
    }
    
    /**
     * Verify cancellation code and submit request
     */
    public function verifyCancellation(Request $request, $id)
    {
        try {
            Log::info("=== CANCELLATION VERIFICATION STARTED ===");
            Log::info("Service ID: {$id}");
            Log::info("Code received: " . $request->input('code'));
            
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'hosting')
                ->where('id', $id)
                ->firstOrFail();
            
            Log::info("Service found: {$service->id}, Domain: {$service->domain}");
            
            $code = $request->input('code');
            
            // Get stored code from cache
            $storedCode = Cache::get("cancellation_code_{$service->id}_{$client->id}");
            
            if (!$storedCode) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.code_expired')
                ], 400);
            }
            
            if ($code !== $storedCode) {
                return response()->json([
                    'success' => false,
                    'message' => __('frontend.invalid_code')
                ], 400);
            }
            
            // Clear the verification code
            Cache::forget("cancellation_code_{$service->id}_{$client->id}");
            
            // Get stored reason from cache
            $reason = Cache::get("cancellation_reason_{$service->id}_{$client->id}");
            Cache::forget("cancellation_reason_{$service->id}_{$client->id}");
            
            Log::info("Updating service with cancellation timestamp...");
            
            // Update service status to 'cancellation_requested' or similar
            // You may want to create a cancellation request record instead
            $result = $service->update([
                'cancellation_requested_at' => now(),
                'cancellation_reason' => $reason,
                'notes' => ($service->notes ?? '') . "\nCancellation requested on " . now()->format('Y-m-d H:i:s') . "\nReason: " . $reason
            ]);
            
            Log::info("Update result: " . ($result ? 'SUCCESS' : 'FAILED'));
            Log::info("Service after update - cancellation_requested_at: " . $service->fresh()->cancellation_requested_at);
            
            // TODO: Send notification to admin about cancellation request
            
            Log::info("Cancellation request submitted for service ID: {$service->id} by client ID: {$client->id}");
            
            return response()->json([
                'success' => true,
                'message' => __('frontend.request_submitted')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error verifying cancellation: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => __('frontend.error_occurred')
            ], 500);
        }
    }

    /**
     * VPS Server Control Actions
     */
    public function vpsAction(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'vps')
            ->where('id', $id)
            ->firstOrFail();

        $action = $request->input('action');
        $serverData = is_string($service->server_data) 
            ? json_decode($service->server_data, true) 
            : $service->server_data;

        if (!$serverData || !isset($serverData['hetzner_server_id'])) {
            return response()->json(['error' => 'Server ID not found'], 400);
        }

        $serverId = $serverData['hetzner_server_id'];
        $hetznerService = app(\App\Services\HetznerService::class);

        try {
            $result = match($action) {
                'restart' => $hetznerService->rebootServer($serverId),
                'stop' => $hetznerService->shutdownServer($serverId),
                'start' => $hetznerService->powerOnServer($serverId),
                'power_off' => $hetznerService->powerOffServer($serverId),
                'reset' => $hetznerService->resetServer($serverId),
                default => throw new \Exception('Invalid action')
            };

            Log::info('VPS action executed', [
                'service_id' => $service->id,
                'action' => $action,
                'server_id' => $serverId,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('frontend.action_executed_successfully'),
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('VPS action failed', [
                'service_id' => $service->id,
                'action' => $action,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get VPS server status and metrics
     */
    public function vpsStatus($id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'vps')
            ->where('id', $id)
            ->firstOrFail();

        $serverData = is_string($service->server_data) 
            ? json_decode($service->server_data, true) 
            : $service->server_data;

        if (!$serverData || !isset($serverData['hetzner_server_id'])) {
            return response()->json(['error' => 'Server ID not found'], 400);
        }

        $serverId = $serverData['hetzner_server_id'];
        $hetznerService = app(\App\Services\HetznerService::class);

        try {
            $serverInfo = $hetznerService->getServer($serverId);

            return response()->json([
                'status' => $serverInfo['status'] ?? 'unknown',
                'server' => $serverInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create VPS snapshot
     */
    public function vpsCreateSnapshot(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        
        $service = Service::where('client_id', $client->id)
            ->where('type', 'vps')
            ->where('id', $id)
            ->firstOrFail();

        $serverData = is_string($service->server_data) 
            ? json_decode($service->server_data, true) 
            : $service->server_data;

        if (!$serverData || !isset($serverData['hetzner_server_id'])) {
            return response()->json(['error' => 'Server ID not found'], 400);
        }

        $serverId = $serverData['hetzner_server_id'];
        $hetznerService = app(\App\Services\HetznerService::class);

        try {
            $result = $hetznerService->createSnapshot(
                $serverId,
                $request->input('description', 'Snapshot ' . now()->format('Y-m-d H:i:s'))
            );

            return response()->json([
                'success' => true,
                'message' => __('frontend.snapshot_created'),
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Request VPS console access
     */
    public function vpsConsole($id)
    {
        try {
            $client = Auth::guard('client')->user();
            
            $service = Service::where('client_id', $client->id)
                ->where('type', 'vps')
                ->where('id', $id)
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;

            Log::info('VPS Console Request', [
                'service_id' => $id,
                'server_data' => $serverData
            ]);

            if (!$serverData) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server data not found. Please wait for server provisioning to complete.'
                ], 400);
            }

            if (!isset($serverData['hetzner_server_id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server ID not found in server data. Available keys: ' . implode(', ', array_keys($serverData))
                ], 400);
            }

            $serverId = $serverData['hetzner_server_id'];
            $hetznerService = app(\App\Services\HetznerService::class);

            $result = $hetznerService->requestConsole($serverId);

            Log::info('Console request result', ['result' => $result]);

            return response()->json([
                'success' => true,
                'console_url' => $result['wss_url'] ?? null,
                'password' => $result['password'] ?? null,
            ]);

        } catch (\Exception $e) {
            Log::error('VPS Console Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get network information
     */
    public function getNetwork($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            $serverDetails = $hetznerService->getServer($serverId);

            $network = [
                'ipv4' => null,
                'ipv6' => null,
            ];

            // Get IPv4 information
            if (isset($serverDetails['public_net']['ipv4'])) {
                $network['ipv4'] = [
                    'ip' => $serverDetails['public_net']['ipv4']['ip'] ?? null,
                    'blocked' => $serverDetails['public_net']['ipv4']['blocked'] ?? false,
                    'dns_ptr' => $serverDetails['public_net']['ipv4']['dns_ptr'] ?? null,
                ];
            }

            // Get IPv6 information
            if (isset($serverDetails['public_net']['ipv6'])) {
                $network['ipv6'] = [
                    'ip' => $serverDetails['public_net']['ipv6']['ip'] ?? null,
                    'blocked' => $serverDetails['public_net']['ipv6']['blocked'] ?? false,
                    'dns_ptr' => $serverDetails['public_net']['ipv6']['dns_ptr'] ?? [],
                ];
            }

            // Get Floating IPs from server_data
            $serverData = $service->server_data ?? [];
            $network['floating_ips'] = $serverData['floating_ips'] ?? [];

            return response()->json([
                'success' => true,
                'network' => $network
            ]);

        } catch (\Exception $e) {
            Log::error('Get Network Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update reverse DNS
     */
    public function updateReverseDns($id, Request $request)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $request->validate([
                'ip' => 'required|string',
                'dns_ptr' => 'nullable|string',
            ]);

            $hetznerService = app(HetznerService::class);
            $result = $hetznerService->changeReverseDns(
                $serverId, 
                $request->ip, 
                $request->dns_ptr
            );

            Log::info('Reverse DNS Updated', [
                'service_id' => $id,
                'ip' => $request->ip,
                'dns_ptr' => $request->dns_ptr
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reverse DNS updated successfully',
                'action' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Update Reverse DNS Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Hetzner locations
     */
    public function getHetznerLocations($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            
            // Get server details to find its location
            $serverDetails = $hetznerService->getServer($serverId);
            $serverLocation = $serverDetails['datacenter']['location']['name'] ?? null;

            // Get all available locations from Hetzner
            $locations = $hetznerService->listLocations();

            return response()->json([
                'success' => true,
                'serverLocation' => $serverLocation,
                'locations' => $locations
            ]);

        } catch (\Exception $e) {
            Log::error('Get Hetzner Locations Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Floating IP
     */
    public function createFloatingIP(Request $request, $id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $validated = $request->validate([
                'protocol' => 'required|in:ipv4,ipv6',
                'location' => 'required|string',
                'name' => 'required|string|max:255',
                'payment_method' => 'required|in:wallet,card,fawry,mobile_wallet',
                'billing_cycle' => 'required|in:monthly,quarterly,semi_annually,annually',
            ]);

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Server not found'
                ], 404);
            }

            // Calculate price based on protocol
            $monthlyPrice = $validated['protocol'] === 'ipv4' ? 5.00 : 3.00;
            
            // Calculate total based on billing cycle
            $billingMultiplier = [
                'monthly' => 1,
                'quarterly' => 3,
                'semi_annually' => 6,
                'annually' => 12,
            ];
            
            $totalAmount = $monthlyPrice * $billingMultiplier[$validated['billing_cycle']];

            // Check payment method and process payment
            if ($validated['payment_method'] === 'wallet') {
                // Check wallet balance
                if ($client->wallet_balance < $totalAmount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient wallet balance. Required: $' . number_format($totalAmount, 2)
                    ], 400);
                }

                // Map billing cycle to match orders table enum values
                $billingCycleMap = [
                    'monthly' => 'monthly',
                    'quarterly' => 'monthly',
                    'semi_annually' => 'yearly',
                    'annually' => 'yearly',
                ];
                $orderBillingCycle = $billingCycleMap[$validated['billing_cycle']] ?? 'monthly';
                
                // Create order for the floating IP
                $order = Order::create([
                    'client_id' => $client->id,
                    'order_number' => 'FIP-' . time() . '-' . $client->id,
                    'amount' => $totalAmount,
                    'subtotal' => $totalAmount,
                    'total' => $totalAmount,
                    'currency' => 'USD',
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'payment_method' => 'wallet',
                    'billing_cycle' => $orderBillingCycle,
                    'paid_at' => now(),
                    'completed_at' => now(),
                    'order_details' => [
                        'type' => 'floating_ip',
                        'service_id' => $service->id,
                        'protocol' => $validated['protocol'],
                        'location' => $validated['location'],
                        'name' => $validated['name'],
                        'actual_billing_cycle' => $validated['billing_cycle'],
                    ],
                    'notes' => 'Floating IP (' . strtoupper($validated['protocol']) . ') for ' . $service->service_name,
                ]);
                
                // Create invoice linked to order
                $invoice = Invoice::create([
                    'order_id' => $order->id,
                    'client_id' => $client->id,
                    'invoice_number' => 'INV-FIP-' . time() . '-' . $client->id,
                    'invoice_date' => now(),
                    'subtotal' => $totalAmount,
                    'total' => $totalAmount,
                    'paid_amount' => $totalAmount,
                    'balance' => 0,
                    'currency' => 'USD',
                    'status' => 'paid',
                    'paid_at' => now(),
                    'due_date' => now(),
                    'notes' => 'Floating IP (' . strtoupper($validated['protocol']) . ') - ' . $validated['name'] . ' for ' . $service->service_name . ' (Paid via Wallet)',
                ]);

                // Deduct from wallet
                $client->wallet_balance -= $totalAmount;
                $client->save();

                // Record wallet transaction
                \App\Models\WalletTransaction::create([
                    'client_id' => $client->id,
                    'type' => 'deduction',
                    'amount' => $totalAmount,
                    'status' => 'completed',
                    'payment_method' => 'wallet',
                    'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                    'description' => 'Floating IP Purchase - ' . $validated['name'],
                    'metadata' => json_encode([
                        'invoice_id' => $invoice->id,
                        'order_id' => $order->id,
                        'protocol' => $validated['protocol'],
                        'location' => $validated['location'],
                    ]),
                    'completed_at' => now(),
                ]);
                
                // Create floating IP directly
                $hetznerService = app(HetznerService::class);
                $floatingIP = $hetznerService->createFloatingIp(
                    $validated['protocol'],
                    $validated['location'],
                    $serverId
                );

                if (!$floatingIP) {
                    // Refund if creation failed
                    $client->wallet_balance += $totalAmount;
                    $client->save();
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create Floating IP'
                    ], 500);
                }

                // Store floating IP information
                $serverData = $service->server_data ?? [];
                if (!isset($serverData['floating_ips'])) {
                    $serverData['floating_ips'] = [];
                }
                
                $serverData['floating_ips'][] = [
                    'id' => $floatingIP['floating_ip']['id'] ?? null,
                    'ip' => $floatingIP['floating_ip']['ip'] ?? null,
                    'type' => $validated['protocol'],
                    'name' => $validated['name'],
                    'location' => $validated['location'],
                    'monthly_price' => $monthlyPrice,
                    'billing_cycle' => $validated['billing_cycle'],
                    'created_at' => now()->toDateTimeString(),
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'payment_method' => 'wallet',
                ];
                
                $service->server_data = $serverData;
                $service->save();

                Log::info('Floating IP Created via Wallet', [
                    'client_id' => $client->id,
                    'service_id' => $service->id,
                    'floating_ip_id' => $floatingIP['floating_ip']['id'] ?? null,
                    'amount_paid' => $totalAmount,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Floating IP created successfully and payment processed',
                    'floatingIP' => $floatingIP['floating_ip'] ?? null,
                    'amount_paid' => $totalAmount,
                    'new_balance' => $client->wallet_balance
                ]);
                
            } else {
                // Use Fawaterak for card, fawry, and mobile wallet payments
                
                // Map billing cycle to match orders table enum values
                $billingCycleMap = [
                    'monthly' => 'monthly',
                    'quarterly' => 'monthly',
                    'semi_annually' => 'yearly',
                    'annually' => 'yearly',
                ];
                $orderBillingCycle = $billingCycleMap[$validated['billing_cycle']] ?? 'monthly';
                
                // First, create an order for the floating IP
                $order = Order::create([
                    'client_id' => $client->id,
                    'order_number' => 'FIP-' . time() . '-' . $client->id,
                    'amount' => $totalAmount,
                    'subtotal' => $totalAmount,
                    'total' => $totalAmount,
                    'currency' => 'USD',
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $validated['payment_method'],
                    'billing_cycle' => $orderBillingCycle,
                    'order_details' => [
                        'type' => 'floating_ip',
                        'service_id' => $service->id,
                        'protocol' => $validated['protocol'],
                        'location' => $validated['location'],
                        'name' => $validated['name'],
                        'actual_billing_cycle' => $validated['billing_cycle'], // Store actual cycle
                    ],
                    'notes' => 'Floating IP (' . strtoupper($validated['protocol']) . ') for ' . $service->service_name,
                ]);
                
                // Create invoice linked to order
                $invoice = Invoice::create([
                    'order_id' => $order->id,
                    'client_id' => $client->id,
                    'invoice_number' => 'INV-FIP-' . time() . '-' . $client->id,
                    'invoice_date' => now(),
                    'subtotal' => $totalAmount,
                    'total' => $totalAmount,
                    'balance' => $totalAmount,
                    'currency' => 'USD',
                    'status' => 'unpaid',
                    'due_date' => now()->addDays(7),
                    'notes' => 'Floating IP (' . strtoupper($validated['protocol']) . ') - ' . $validated['name'] . ' for ' . $service->service_name,
                ]);
                
                $fawaterakService = app(\App\Services\FawaterakPaymentService::class);
                
                // Get payment methods from Fawaterak to ensure we use correct IDs
                $paymentMethodsResponse = $fawaterakService->getPaymentMethods();
                
                // Map payment methods to Fawaterak IDs
                // These are the default IDs, but they may vary based on Fawaterak account
                $paymentMethodMap = [
                    'card' => 2,           // Visa/Mastercard
                    'fawry' => 3,          // Fawry
                    'mobile_wallet' => 5,  // Mobile Wallet (Vodafone Cash, etc.)
                ];
                
                // If we successfully got payment methods from API, use them
                if ($paymentMethodsResponse['success'] && isset($paymentMethodsResponse['methods'])) {
                    foreach ($paymentMethodsResponse['methods'] as $method) {
                        $methodNameEn = strtolower($method['nameEn'] ?? $method['name_en'] ?? '');
                        
                        // Map based on method name
                        if (str_contains($methodNameEn, 'card') || str_contains($methodNameEn, 'visa') || str_contains($methodNameEn, 'credit')) {
                            $paymentMethodMap['card'] = $method['paymentId'] ?? $method['payment_id'] ?? 2;
                        } elseif (str_contains($methodNameEn, 'fawry')) {
                            $paymentMethodMap['fawry'] = $method['paymentId'] ?? $method['payment_id'] ?? 3;
                        } elseif (str_contains($methodNameEn, 'wallet') || str_contains($methodNameEn, 'vodafone') || str_contains($methodNameEn, 'mobile')) {
                            $paymentMethodMap['mobile_wallet'] = $method['paymentId'] ?? $method['payment_id'] ?? 5;
                        }
                    }
                }
                
                Log::info('Floating IP Payment Method Mapping', [
                    'requested_method' => $validated['payment_method'],
                    'payment_method_map' => $paymentMethodMap,
                    'fawaterak_methods' => $paymentMethodsResponse['methods'] ?? []
                ]);
                
                $fawaterakPaymentId = $paymentMethodMap[$validated['payment_method']] ?? null;
                
                if (!$fawaterakPaymentId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid payment method'
                    ], 400);
                }
                
                // Clean phone number for Fawaterak
                $phone = $client->phone ?? '';
                if (!empty($phone)) {
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    if (str_starts_with($phone, '2') && strlen($phone) == 12) {
                        $phone = '0' . substr($phone, 2);
                    } elseif (str_starts_with($phone, '00')) {
                        $phone = substr($phone, 2);
                        if (str_starts_with($phone, '2')) {
                            $phone = '0' . substr($phone, 2);
                        }
                    }
                }
                
                // Prepare payment data
                $paymentData = [
                    'payment_method_id' => $fawaterakPaymentId,
                    'cartTotal' => $totalAmount,
                    'currency' => 'USD',
                    'customer' => [
                        'first_name' => $client->first_name ?? 'Client',
                        'last_name' => $client->last_name ?? '',
                        'email' => $client->email,
                        'phone' => $phone,
                        'address' => $client->address ?? '',
                    ],
                    'redirectionUrls' => [
                        'successUrl' => route('client.hosting.vps.floating-ip.success', ['id' => $service->id]),
                        'failUrl' => route('client.hosting.vps.floating-ip.failed', ['id' => $service->id]),
                        'pendingUrl' => route('client.hosting.vps.floating-ip.pending', ['id' => $service->id]),
                    ],
                    'cartItems' => [[
                        'name' => 'Floating IP (' . strtoupper($validated['protocol']) . ') - ' . $validated['name'],
                        'price' => $totalAmount,
                        'quantity' => 1,
                    ]],
                    'lang' => app()->getLocale(),
                    'sendEmail' => true,
                ];
                
                try {
                    $response = $fawaterakService->initiatePayment($paymentData);
                    
                    if ($response['success']) {
                        // Store pending floating IP order in session
                        session([
                            'floating_ip_pending' => [
                                'service_id' => $service->id,
                                'server_id' => $serverId,
                                'protocol' => $validated['protocol'],
                                'location' => $validated['location'],
                                'name' => $validated['name'],
                                'billing_cycle' => $validated['billing_cycle'],
                                'monthly_price' => $monthlyPrice,
                                'total_amount' => $totalAmount,
                                'order_id' => $order->id,  // Store order ID
                                'invoice_id' => $invoice->id,  // Our internal invoice ID
                                'fawaterak_invoice_id' => $response['invoice_id'] ?? null,
                                'fawaterak_invoice_key' => $response['invoice_key'] ?? null,
                                'payment_method' => $validated['payment_method'],
                            ]
                        ]);
                        
                        $paymentData = $response['payment_data'] ?? [];
                        
                        // Handle different payment methods
                        if (!empty($paymentData['redirectTo'])) {
                            // Card payment - redirect to gateway
                            return response()->json([
                                'success' => true,
                                'redirect' => true,
                                'url' => $paymentData['redirectTo']
                            ]);
                        } elseif (!empty($paymentData['fawryCode'])) {
                            // Fawry payment - show reference code
                            return response()->json([
                                'success' => true,
                                'payment_method' => 'fawry',
                                'reference_code' => $paymentData['fawryCode'],
                                'expires_at' => $paymentData['expireDate'] ?? null,
                                'pending_url' => route('client.hosting.vps.floating-ip.pending', ['id' => $service->id])
                            ]);
                        } elseif (!empty($paymentData['meezaReference']) || !empty($paymentData['mobileWalletReference'])) {
                            // Mobile wallet - show reference and QR code
                            $reference = $paymentData['meezaReference'] ?? $paymentData['mobileWalletReference'] ?? null;
                            $qrCode = $paymentData['meezaQrCode'] ?? $paymentData['qrCode'] ?? null;
                            
                            return response()->json([
                                'success' => true,
                                'payment_method' => 'mobile_wallet',
                                'reference' => $reference,
                                'qr_code' => $qrCode,
                                'pending_url' => route('client.hosting.vps.floating-ip.pending', ['id' => $service->id])
                            ]);
                        } else {
                            // Generic pending payment - redirect to pending page
                            return response()->json([
                                'success' => true,
                                'redirect' => true,
                                'url' => route('client.hosting.vps.floating-ip.pending', ['id' => $service->id])
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => $response['message'] ?? 'Failed to initiate payment'
                        ], 500);
                    }
                } catch (\Exception $e) {
                    Log::error('Fawaterak Payment Error', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment gateway error: ' . $e->getMessage()
                    ], 500);
                }
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Create Floating IP Error', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle successful Floating IP payment
     */
    public function floatingIPSuccess($id)
    {
        $pendingData = session('floating_ip_pending');
        
        if (!$pendingData || $pendingData['service_id'] != $id) {
            return redirect()->route('client.hosting.vps.show', $id)
                ->with('error', 'Invalid payment session');
        }
        
        try {
            $hetznerService = app(HetznerService::class);
            $client = Auth::guard('client')->user();
            $service = Service::findOrFail($id);
            
            // Update invoice status to paid
            if (isset($pendingData['invoice_id'])) {
                $invoice = Invoice::find($pendingData['invoice_id']);
                if ($invoice) {
                    $invoice->status = 'paid';
                    $invoice->paid_at = now();
                    $invoice->save();
                    
                    // Update order status
                    if (isset($pendingData['order_id'])) {
                        $order = Order::find($pendingData['order_id']);
                        if ($order) {
                            $order->status = 'completed';
                            $order->payment_status = 'paid';
                            $order->paid_at = now();
                            $order->completed_at = now();
                            $order->save();
                        }
                    }
                    
                    // Record payment transaction
                    \App\Models\WalletTransaction::create([
                        'client_id' => $client->id,
                        'amount' => $pendingData['total_amount'],
                        'type' => 'deduction',
                        'status' => 'completed',
                        'payment_method' => $pendingData['payment_method'],
                        'payment_provider' => 'fawaterak',
                        'fawaterak_invoice_id' => $pendingData['fawaterak_invoice_id'] ?? null,
                        'transaction_reference' => \App\Models\WalletTransaction::generateReference(),
                        'description' => 'Floating IP Purchase - ' . $pendingData['name'],
                        'metadata' => json_encode([
                            'invoice_id' => $invoice->id,
                            'order_id' => $pendingData['order_id'] ?? null,
                            'protocol' => $pendingData['protocol'],
                            'location' => $pendingData['location'],
                        ]),
                        'completed_at' => now(),
                    ]);
                }
            }
            
            // Create floating IP
            $floatingIP = $hetznerService->createFloatingIp(
                $pendingData['protocol'],
                $pendingData['location'],
                $pendingData['server_id']
            );
            
            if ($floatingIP) {
                // Store floating IP information
                $serverData = $service->server_data ?? [];
                if (!isset($serverData['floating_ips'])) {
                    $serverData['floating_ips'] = [];
                }
                
                $serverData['floating_ips'][] = [
                    'id' => $floatingIP['floating_ip']['id'] ?? null,
                    'ip' => $floatingIP['floating_ip']['ip'] ?? null,
                    'type' => $pendingData['protocol'],
                    'name' => $pendingData['name'],
                    'location' => $pendingData['location'],
                    'monthly_price' => $pendingData['monthly_price'],
                    'billing_cycle' => $pendingData['billing_cycle'],
                    'created_at' => now()->toDateTimeString(),
                    'payment_invoice_id' => $pendingData['invoice_id'] ?? null,
                    'fawaterak_invoice_id' => $pendingData['fawaterak_invoice_id'] ?? null,
                ];
                
                $service->server_data = $serverData;
                $service->save();
                
                // Clear session
                session()->forget('floating_ip_pending');
                
                return redirect()->route('client.hosting.vps.show', $id)
                    ->with('success', 'Floating IP created successfully!');
            }
        } catch (\Exception $e) {
            Log::error('Floating IP Creation Failed', [
                'error' => $e->getMessage(),
                'pending_data' => $pendingData
            ]);
        }
        
        return redirect()->route('client.hosting.vps.show', $id)
            ->with('error', 'Failed to create Floating IP. Please contact support.');
    }

    /**
     * Handle failed Floating IP payment
     */
    public function floatingIPFailed($id)
    {
        $pendingData = session('floating_ip_pending');
        
        // Update invoice and order status to cancelled if exists
        if ($pendingData) {
            if (isset($pendingData['invoice_id'])) {
                $invoice = Invoice::find($pendingData['invoice_id']);
                if ($invoice && $invoice->status === 'unpaid') {
                    $invoice->status = 'cancelled';
                    $invoice->save();
                }
            }
            
            if (isset($pendingData['order_id'])) {
                $order = Order::find($pendingData['order_id']);
                if ($order && $order->status === 'pending') {
                    $order->status = 'cancelled';
                    $order->payment_status = 'failed';
                    $order->save();
                }
            }
        }
        
        session()->forget('floating_ip_pending');
        
        return redirect()->route('client.hosting.vps.show', $id)
            ->with('error', 'Payment failed or was cancelled.');
    }

    /**
     * Handle pending Floating IP payment
     */
    public function floatingIPPending($id)
    {
        $pendingData = session('floating_ip_pending');
        
        if (!$pendingData || $pendingData['service_id'] != $id) {
            return redirect()->route('client.hosting.vps.show', $id)
                ->with('error', 'Invalid payment session');
        }
        
        $client = Auth::guard('client')->user();
        $service = Service::findOrFail($id);
        
        return view('frontend.client.hosting.floating-ip-pending', compact('service', 'client', 'pendingData'));
    }

    /**
     * Delete Floating IP
     */
    public function deleteFloatingIP($id, $floatingIpId)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverData = $service->server_data ?? [];
            $floatingIps = $serverData['floating_ips'] ?? [];

            // Find the floating IP
            $floatingIpIndex = null;
            $floatingIpToDelete = null;
            foreach ($floatingIps as $index => $ip) {
                if ($ip['id'] == $floatingIpId) {
                    $floatingIpIndex = $index;
                    $floatingIpToDelete = $ip;
                    break;
                }
            }

            if ($floatingIpIndex === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Floating IP not found'
                ], 404);
            }

            // Try to delete from Hetzner (ignore if not found)
            try {
                $hetznerService = app(HetznerService::class);
                $hetznerService->deleteFloatingIp($floatingIpId);
            } catch (\Exception $hetznerError) {
                // Log the error but continue with deletion from database
                // This handles cases where IP was already deleted from Hetzner
                Log::warning('Hetzner Floating IP Delete Warning', [
                    'floating_ip_id' => $floatingIpId,
                    'error' => $hetznerError->getMessage()
                ]);
            }

            // Remove from server_data
            unset($floatingIps[$floatingIpIndex]);
            $serverData['floating_ips'] = array_values($floatingIps); // Re-index array
            $service->server_data = $serverData;
            $service->save();

            Log::info('Floating IP Deleted', [
                'service_id' => $id,
                'floating_ip_id' => $floatingIpId,
                'client_id' => $client->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Floating IP deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Floating IP Error', [
                'service_id' => $id,
                'floating_ip_id' => $floatingIpId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ISO Images
     */
    public function getISOImages($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            
            // Get all available ISO images
            $isoImages = $hetznerService->getISOImages();
            
            // Get server details to check mounted ISO
            $serverDetails = $hetznerService->getServer($serverId);
            $mountedIso = $serverDetails['iso'] ?? null;

            return response()->json([
                'success' => true,
                'images' => $isoImages,
                'mounted_iso' => $mountedIso
            ]);

        } catch (\Exception $e) {
            Log::error('Get ISO Images Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mount ISO to server
     */
    public function mountISO($id, Request $request)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $request->validate([
                'iso_id' => 'required|integer',
            ]);

            $hetznerService = app(HetznerService::class);
            
            // Attach ISO to server
            $result = $hetznerService->attachISO($serverId, $request->iso_id);

            Log::info('ISO Mounted', [
                'service_id' => $id,
                'server_id' => $serverId,
                'iso_id' => $request->iso_id,
                'client_id' => $client->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'ISO mounted successfully',
                'action' => $result['action'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Mount ISO Error', [
                'service_id' => $id,
                'iso_id' => $request->iso_id ?? null,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unmount ISO from server
     */
    public function unmountISO($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            
            // Detach ISO from server
            $result = $hetznerService->detachISO($serverId);

            Log::info('ISO Unmounted', [
                'service_id' => $id,
                'server_id' => $serverId,
                'client_id' => $client->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'ISO unmounted successfully',
                'action' => $result['action'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Unmount ISO Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Console for Dedicated Server
     */
    public function dedicatedConsole($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'dedicated')
                ->firstOrFail();

            $serverData = is_string($service->server_data) 
                ? json_decode($service->server_data, true) 
                : $service->server_data;
                
            $serverId = $serverData['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            
            // Request VNC console from Hetzner
            $result = $hetznerService->requestConsole($serverId);
            
            Log::info('Dedicated Console Response from Hetzner', [
                'service_id' => $id,
                'server_id' => $serverId,
                'result' => $result
            ]);

            if (isset($result['wss_url'])) {
                Log::info('Dedicated Console Requested', [
                    'service_id' => $id,
                    'server_id' => $serverId,
                    'client_id' => $client->id
                ]);

                return view('frontend.client.hosting.vnc-console', [
                    'service' => $service,
                    'consoleUrl' => $result['wss_url'],
                    'password' => $result['password'] ?? ''
                ]);
            }

            abort(500, 'Failed to get console URL');

        } catch (\Exception $e) {
            Log::error('Dedicated Get Console Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Console URL
     */
    public function getConsole($id)
    {
        try {
            $client = Auth::guard('client')->user();
            $service = Service::where('id', $id)
                ->where('client_id', $client->id)
                ->where('type', 'vps')
                ->firstOrFail();

            $serverId = $service->server_data['hetzner_server_id'] ?? null;
            if (!$serverId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Server not found'
                ], 404);
            }

            $hetznerService = app(HetznerService::class);
            
            // Request VNC console from Hetzner
            $result = $hetznerService->requestConsole($serverId);
            
            Log::info('Console Response from Hetzner', [
                'service_id' => $id,
                'server_id' => $serverId,
                'result' => $result
            ]);

            if (isset($result['wss_url'])) {
                Log::info('Console Requested', [
                    'service_id' => $id,
                    'server_id' => $serverId,
                    'client_id' => $client->id
                ]);

                return view('frontend.client.hosting.vnc-console', [
                    'service' => $service,
                    'consoleUrl' => $result['wss_url'],
                    'password' => $result['password'] ?? ''
                ]);
            }

            abort(500, 'Failed to get console URL');

        } catch (\Exception $e) {
            Log::error('Get Console Error', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
































