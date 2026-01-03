<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class HetznerService
{
    protected string $apiToken;
    protected string $baseUrl = 'https://api.hetzner.cloud/v1';

    public function __construct()
    {
        $this->apiToken = config('services.hetzner.api_token', env('HETZNER_API_TOKEN', ''));
    }

    /**
     * Make HTTP request to Hetzner API
     */
    protected function makeRequest(string $method, string $endpoint, array $data = [])
    {
        try {
            $httpClient = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ]);

            if (strtolower($method) === 'get' && !empty($data)) {
                $response = $httpClient->get($this->baseUrl . $endpoint, $data);
            } else {
                $response = $httpClient->{$method}($this->baseUrl . $endpoint, $data);
            }

            if ($response->failed()) {
                Log::error('Hetzner API Error', [
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                throw new Exception('Hetzner API request failed: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Hetzner API Exception', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Test API connection
     */
    public function testConnection(): bool
    {
        try {
            $this->makeRequest('get', '/datacenters');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * List all server types (plans)
     */
    public function listServerTypes(): array
    {
        $response = $this->makeRequest('get', '/server_types');
        return $response['server_types'] ?? [];
    }

    /**
     * List all locations (datacenters)
     */
    public function listLocations(): array
    {
        $response = $this->makeRequest('get', '/locations');
        return $response['locations'] ?? [];
    }

    /**
     * List all datacenters
     */
    public function listDatacenters(): array
    {
        $response = $this->makeRequest('get', '/datacenters');
        return $response['datacenters'] ?? [];
    }

    /**
     * List all images (OS)
     */
    public function listImages(string $type = null): array
    {
        $params = [];
        if ($type) {
            $params['type'] = $type; // system, snapshot, backup, app
        }

        $response = $this->makeRequest('get', '/images', $params);
        return $response['images'] ?? [];
    }

    /**
     * Create a new server
     */
    public function createServer(array $params): array
    {
        $requiredParams = ['name', 'server_type', 'image'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                throw new Exception("Missing required parameter: {$param}");
            }
        }

        $data = [
            'name' => $params['name'],
            'server_type' => $params['server_type'],
            'image' => $params['image'],
            'location' => $params['location'] ?? null,
            'datacenter' => $params['datacenter'] ?? null,
            'start_after_create' => $params['start_after_create'] ?? true,
            'labels' => $params['labels'] ?? [],
            'user_data' => $params['user_data'] ?? null,
            'ssh_keys' => $params['ssh_keys'] ?? [],
            'volumes' => $params['volumes'] ?? [],
            'networks' => $params['networks'] ?? [],
            'firewalls' => $params['firewalls'] ?? [],
            'automount' => $params['automount'] ?? false,
            'public_net' => $params['public_net'] ?? [
                'enable_ipv4' => true,
                'enable_ipv6' => true,
            ],
        ];

        // Remove null values
        $data = array_filter($data, function($value) {
            return $value !== null;
        });

        $response = $this->makeRequest('post', '/servers', $data);
        return $response;
    }

    /**
     * Get server information
     */
    public function getServer(int $serverId): array
    {
        $response = $this->makeRequest('get', "/servers/{$serverId}");
        return $response['server'] ?? [];
    }

    /**
     * Get server actions
     */
    public function getServerActions(int $serverId, int $limit = 10): array
    {
        $response = $this->makeRequest('get', "/servers/{$serverId}/actions", [
            'sort' => 'started:desc',
            'per_page' => $limit
        ]);
        return $response['actions'] ?? [];
    }

    /**
     * Get server metrics (CPU, Disk, Network)
     */
    public function getServerMetrics(int $serverId, string $type, $startTime, $endTime): array
    {
        // Convert to ISO 8601 format for Hetzner API
        if ($startTime instanceof \DateTime) {
            $start = $startTime->format('Y-m-d\TH:i:s\Z');
        } else {
            $start = date('Y-m-d\TH:i:s\Z', strtotime($startTime));
        }
        
        if ($endTime instanceof \DateTime) {
            $end = $endTime->format('Y-m-d\TH:i:s\Z');
        } else {
            $end = date('Y-m-d\TH:i:s\Z', strtotime($endTime));
        }
        
        $response = $this->makeRequest('get', "/servers/{$serverId}/metrics", [
            'type' => $type,
            'start' => $start,
            'end' => $end,
            'step' => 60 // Data point every 60 seconds
        ]);
        
        // Format the response for easier consumption
        $metrics = [];
        
        if (isset($response['metrics']['time_series'])) {
            $timeSeries = $response['metrics']['time_series'];
            
            // For disk metrics, combine read and write bandwidth
            if ($type === 'disk') {
                $readKey = 'disk.0.bandwidth.read';
                $writeKey = 'disk.0.bandwidth.write';
                
                if (isset($timeSeries[$readKey]['values']) && isset($timeSeries[$writeKey]['values'])) {
                    $readValues = $timeSeries[$readKey]['values'];
                    $writeValues = $timeSeries[$writeKey]['values'];
                    
                    foreach ($readValues as $index => $readValue) {
                        if (is_array($readValue) && count($readValue) >= 2) {
                            $writeValue = $writeValues[$index] ?? [0, 0];
                            $combinedValue = (float)$readValue[1] + (float)$writeValue[1];
                            
                            $metrics[] = [
                                'timestamp' => (int)$readValue[0],
                                'value' => $combinedValue
                            ];
                        }
                    }
                }
            }
            // For network metrics, combine in and out bandwidth
            elseif ($type === 'network') {
                $inKey = 'network.0.bandwidth.in';
                $outKey = 'network.0.bandwidth.out';
                
                if (isset($timeSeries[$inKey]['values']) && isset($timeSeries[$outKey]['values'])) {
                    $inValues = $timeSeries[$inKey]['values'];
                    $outValues = $timeSeries[$outKey]['values'];
                    
                    foreach ($inValues as $index => $inValue) {
                        if (is_array($inValue) && count($inValue) >= 2) {
                            $outValue = $outValues[$index] ?? [0, 0];
                            $combinedValue = (float)$inValue[1] + (float)$outValue[1];
                            
                            $metrics[] = [
                                'timestamp' => (int)$inValue[0],
                                'value' => $combinedValue
                            ];
                        }
                    }
                }
            }
            // For CPU and other single-value metrics
            else {
                $metricKey = array_key_first($timeSeries);
                
                if ($metricKey && isset($timeSeries[$metricKey]['values'])) {
                    $values = $timeSeries[$metricKey]['values'];
                    
                    foreach ($values as $valueArray) {
                        if (is_array($valueArray) && count($valueArray) >= 2) {
                            $metrics[] = [
                                'timestamp' => (int)$valueArray[0],
                                'value' => (float)$valueArray[1]
                            ];
                        }
                    }
                }
            }
        }
        
        return $metrics;
    }

    /**
     * Get server backups
     */
    public function getServerBackups(int $serverId): array
    {
        try {
            $response = $this->makeRequest('get', "/servers/{$serverId}");
            $server = $response['server'] ?? [];
            
            // Get all images (backups are stored as images)
            $imagesResponse = $this->makeRequest('get', '/images', [
                'type' => 'backup',
                'bound_to' => $serverId
            ]);
            
            $backups = [];
            foreach ($imagesResponse['images'] ?? [] as $image) {
                $backups[] = [
                    'id' => $image['id'],
                    'description' => $image['description'] ?? '',
                    'created' => $image['created'],
                    'image_size' => $image['image_size'] ?? 0,
                    'disk_size' => $image['disk_size'] ?? 0,
                    'status' => $image['status'] ?? 'available'
                ];
            }
            
            return $backups;
        } catch (Exception $e) {
            Log::error('Failed to get server backups', [
                'server_id' => $serverId,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Enable backups for server
     */
    public function enableBackups(int $serverId): array
    {
        try {
            $response = $this->makeRequest('post', "/servers/{$serverId}/actions/enable_backup");
            
            Log::info('Backups enabled', [
                'server_id' => $serverId,
                'action' => $response['action'] ?? []
            ]);
            
            return $response['action'] ?? [];
        } catch (Exception $e) {
            Log::error('Failed to enable backups', [
                'server_id' => $serverId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Create a backup
     */
    public function createBackup(int $serverId): array
    {
        try {
            $response = $this->makeRequest('post', "/servers/{$serverId}/actions/create_image", [
                'type' => 'backup',
                'description' => 'Backup created at ' . now()->toDateTimeString()
            ]);
            
            Log::info('Backup created', [
                'server_id' => $serverId,
                'action' => $response['action'] ?? []
            ]);
            
            return $response['action'] ?? [];
        } catch (Exception $e) {
            Log::error('Failed to create backup', [
                'server_id' => $serverId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Restore from backup
     */
    public function restoreBackup(int $serverId, int $backupId): array
    {
        try {
            $response = $this->makeRequest('post', "/servers/{$serverId}/actions/rebuild", [
                'image' => $backupId
            ]);
            
            Log::info('Backup restored', [
                'server_id' => $serverId,
                'backup_id' => $backupId,
                'action' => $response['action'] ?? []
            ]);
            
            return $response['action'] ?? [];
        } catch (Exception $e) {
            Log::error('Failed to restore backup', [
                'server_id' => $serverId,
                'backup_id' => $backupId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete a backup (image)
     */
    public function deleteBackup(int $backupId): bool
    {
        try {
            $this->makeRequest('delete', "/images/{$backupId}");
            
            Log::info('Backup deleted', [
                'backup_id' => $backupId
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to delete backup', [
                'backup_id' => $backupId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get server snapshots (images with type 'snapshot')
     */
    public function getServerSnapshots(int $serverId): array
    {
        try {
            Log::info('Fetching snapshots for server', ['server_id' => $serverId]);
            
            // First try with bound_to parameter
            $response = $this->makeRequest('get', '/images', [
                'type' => 'snapshot',
                'sort' => 'created:desc'
            ]);
            
            Log::info('All snapshots received', [
                'total_count' => count($response['images'] ?? []),
                'images' => $response['images'] ?? []
            ]);
            
            // Filter snapshots that are bound to this server
            $serverSnapshots = [];
            foreach ($response['images'] ?? [] as $image) {
                if (isset($image['bound_to']) && $image['bound_to'] == $serverId) {
                    $serverSnapshots[] = $image;
                }
                // Also include if created_from contains this server
                elseif (isset($image['created_from']['id']) && $image['created_from']['id'] == $serverId) {
                    $serverSnapshots[] = $image;
                }
            }
            
            Log::info('Filtered snapshots for server', [
                'server_id' => $serverId,
                'filtered_count' => count($serverSnapshots)
            ]);
            
            return $serverSnapshots;
        } catch (Exception $e) {
            Log::error('Failed to get server snapshots', [
                'server_id' => $serverId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete a snapshot (image)
     */
    public function deleteSnapshot(int $snapshotId): bool
    {
        try {
            $this->makeRequest('delete', "/images/{$snapshotId}");
            
            Log::info('Snapshot deleted', [
                'snapshot_id' => $snapshotId
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to delete snapshot', [
                'snapshot_id' => $snapshotId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete a server
     */
    public function deleteServer(int $serverId): bool
    {
        try {
            $this->makeRequest('delete', "/servers/{$serverId}");
            return true;
        } catch (Exception $e) {
            Log::error('Failed to delete Hetzner server', [
                'server_id' => $serverId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Power on server
     */
    public function powerOnServer(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/poweron");
        return $response;
    }

    /**
     * Power off server
     */
    public function powerOffServer(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/poweroff");
        return $response;
    }

    /**
     * Reboot server
     */
    public function rebootServer(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/reboot");
        return $response;
    }

    /**
     * Reset server
     */
    public function resetServer(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/reset");
        return $response;
    }

    /**
     * Shutdown server
     */
    public function shutdownServer(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/shutdown");
        return $response;
    }

    /**
     * List all SSH keys
     */
    public function listSshKeys(): array
    {
        $response = $this->makeRequest('get', '/ssh_keys');
        return $response['ssh_keys'] ?? [];
    }

    /**
     * Create SSH key
     */
    public function createSshKey(string $name, string $publicKey, array $labels = []): array
    {
        $data = [
            'name' => $name,
            'public_key' => $publicKey,
            'labels' => $labels,
        ];

        $response = $this->makeRequest('post', '/ssh_keys', $data);
        return $response['ssh_key'] ?? [];
    }

    /**
     * List all volumes
     */
    public function listVolumes(): array
    {
        $response = $this->makeRequest('get', '/volumes');
        return $response['volumes'] ?? [];
    }

    /**
     * Create volume
     */
    public function createVolume(string $name, int $size, string $location = null, array $labels = []): array
    {
        $data = [
            'name' => $name,
            'size' => $size,
            'location' => $location,
            'labels' => $labels,
            'format' => 'ext4',
        ];

        $data = array_filter($data, function($value) {
            return $value !== null;
        });

        $response = $this->makeRequest('post', '/volumes', $data);
        return $response;
    }

    /**
     * Get pricing information
     */
    public function getPricing(): array
    {
        $response = $this->makeRequest('get', '/pricing');
        return $response['pricing'] ?? [];
    }

    /**
     * List all firewalls
     */
    public function listFirewalls(): array
    {
        $response = $this->makeRequest('get', '/firewalls');
        return $response['firewalls'] ?? [];
    }

    /**
     * List all networks
     */
    public function listNetworks(): array
    {
        $response = $this->makeRequest('get', '/networks');
        return $response['networks'] ?? [];
    }

    /**
     * List all floating IPs
     */
    public function listFloatingIps(): array
    {
        $response = $this->makeRequest('get', '/floating_ips');
        return $response['floating_ips'] ?? [];
    }

    /**
     * Create floating IP
     */
    public function createFloatingIp(string $type, string $location = null, int $serverId = null): array
    {
        $data = [
            'type' => $type, // ipv4 or ipv6
            'home_location' => $location,
            'server' => $serverId,
        ];

        $data = array_filter($data, function($value) {
            return $value !== null;
        });

        $response = $this->makeRequest('post', '/floating_ips', $data);
        return $response;
    }

    /**
     * Delete Floating IP
     */
    public function deleteFloatingIp(int $floatingIpId): bool
    {
        $this->makeRequest('delete', "/floating_ips/{$floatingIpId}");
        return true;
    }

    /**
     * Create server snapshot
     */
    public function createSnapshot(int $serverId, string $description = null): array
    {
        $data = [];
        if ($description) {
            $data['description'] = $description;
        }

        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/create_image", $data);
        return $response;
    }

    /**
     * List server actions (history)
     */
    public function listServerActions(int $serverId): array
    {
        $response = $this->makeRequest('get', "/servers/{$serverId}/actions");
        return $response['actions'] ?? [];
    }

    /**
     * Get action status
     */
    public function getAction(int $actionId): array
    {
        $response = $this->makeRequest('get', "/actions/{$actionId}");
        return $response['action'] ?? [];
    }

    /**
     * Enable backup for server
     */
    public function enableBackup(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/enable_backup");
        return $response;
    }

    /**
     * Disable backup for server
     */
    public function disableBackup(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/disable_backup");
        return $response;
    }

    /**
     * Rebuild server from image
     */
    public function rebuildServer(int $serverId, string $image): array
    {
        $data = ['image' => $image];
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/rebuild", $data);
        return $response;
    }

    /**
     * Get available ISO images
     */
    public function getISOImages(): array
    {
        $response = $this->makeRequest('get', '/isos');
        return $response['isos'] ?? [];
    }

    /**
     * Attach ISO to server
     */
    public function attachISO(int $serverId, int $isoId): array
    {
        $data = ['iso' => $isoId];
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/attach_iso", $data);
        return $response;
    }

    /**
     * Detach ISO from server
     */
    public function detachISO(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/detach_iso");
        return $response;
    }

    /**
     * Request VNC console
     */
    public function requestConsole(int $serverId): array
    {
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/request_console");
        return $response;
    }

    /**
     * Change server reverse DNS
     */
    public function changeReverseDns(int $serverId, string $ip, ?string $dnsPtr = null): array
    {
        $data = [
            'ip' => $ip,
            'dns_ptr' => $dnsPtr,
        ];
        
        Log::info('Changing Reverse DNS', [
            'server_id' => $serverId,
            'data' => $data
        ]);

        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/change_dns_ptr", $data);
        return $response;
    }

    /**
     * Apply firewall to server
     */
    public function applyFirewall(int $serverId, int $firewallId): array
    {
        $data = ['firewall' => $firewallId];
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/apply_firewall", $data);
        return $response;
    }

    /**
     * Remove firewall from server
     */
    public function removeFirewall(int $serverId, int $firewallId): array
    {
        $data = ['firewall' => $firewallId];
        $response = $this->makeRequest('post', "/servers/{$serverId}/actions/remove_firewall", $data);
        return $response;
    }
}
