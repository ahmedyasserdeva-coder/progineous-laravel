<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CloudflareService
{
    protected string $apiKey;
    protected ?string $email;
    protected string $baseUrl = 'https://api.cloudflare.com/client/v4';

    public function __construct(?string $apiKey = null, ?string $email = null)
    {
        $this->apiKey = $apiKey ?? config('services.cloudflare.api_key', '');
        $this->email = $email ?? config('services.cloudflare.email');
    }

    /**
     * Make API request to Cloudflare
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        // Use Global API Key authentication if email is provided
        if ($this->email) {
            $headers = [
                'X-Auth-Email' => $this->email,
                'X-Auth-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ];
        } else {
            // Use API Token authentication
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ];
        }

        $response = Http::withHeaders($headers)->{$method}($this->baseUrl . $endpoint, $data);

        $result = $response->json();

        if (!$response->successful() || !($result['success'] ?? false)) {
            $errors = $result['errors'] ?? [];
            $errorMessage = !empty($errors) ? $errors[0]['message'] ?? 'Unknown error' : 'API request failed';

            Log::error('Cloudflare API Error', [
                'endpoint' => $endpoint,
                'errors' => $errors,
                'response' => $result,
            ]);

            throw new Exception($errorMessage);
        }

        return $result;
    }

    /**
     * Add a domain (zone) to Cloudflare
     */
    public function addZone(string $domain): array
    {
        try {
            // First check if zone already exists
            $existingZone = $this->getZoneByName($domain);

            if ($existingZone) {
                return [
                    'success' => true,
                    'zone_id' => $existingZone['id'],
                    'nameservers' => $existingZone['name_servers'] ?? [],
                    'status' => $existingZone['status'],
                    'message' => 'Zone already exists',
                ];
            }

            // Create new zone
            $result = $this->request('post', '/zones', [
                'name' => $domain,
                'jump_start' => true, // Auto-scan DNS records
            ]);

            $zone = $result['result'];

            return [
                'success' => true,
                'zone_id' => $zone['id'],
                'nameservers' => $zone['name_servers'] ?? [],
                'status' => $zone['status'],
                'message' => 'Zone created successfully',
            ];

        } catch (Exception $e) {
            Log::error('Failed to add zone to Cloudflare', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get zone by domain name
     */
    public function getZoneByName(string $domain): ?array
    {
        try {
            $result = $this->request('get', '/zones', [
                'name' => $domain,
            ]);

            $zones = $result['result'] ?? [];

            return !empty($zones) ? $zones[0] : null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get zone details by ID
     */
    public function getZone(string $zoneId): ?array
    {
        try {
            $result = $this->request('get', "/zones/{$zoneId}");
            return $result['result'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Delete a zone from Cloudflare
     */
    public function deleteZone(string $zoneId): bool
    {
        try {
            $this->request('delete', "/zones/{$zoneId}");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get DNS records for a zone
     */
    public function getDnsRecords(string $zoneId): array
    {
        try {
            $result = $this->request('get', "/zones/{$zoneId}/dns_records");
            return $result['result'] ?? [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Add DNS record to a zone
     */
    public function addDnsRecord(string $zoneId, array $record): array
    {
        try {
            $result = $this->request('post', "/zones/{$zoneId}/dns_records", $record);
            return [
                'success' => true,
                'record' => $result['result'],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify API connection
     */
    public function testConnection(): array
    {
        try {
            $result = $this->request('get', '/user/tokens/verify');
            return [
                'success' => true,
                'message' => 'API connection successful',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update DNS record
     */
    public function updateDnsRecord(string $zoneId, string $recordId, array $record): array
    {
        try {
            $result = $this->request('put', "/zones/{$zoneId}/dns_records/{$recordId}", $record);
            return [
                'success' => true,
                'record' => $result['result'],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete DNS record
     */
    public function deleteDnsRecord(string $zoneId, string $recordId): array
    {
        try {
            $this->request('delete', "/zones/{$zoneId}/dns_records/{$recordId}");
            return [
                'success' => true,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get DNSSEC status for a zone
     */
    public function getDnssecStatus(string $zoneId): array
    {
        try {
            $response = $this->request('get', "/zones/{$zoneId}/dnssec");
            $result = $response['result'] ?? $response;

            return [
                'success' => true,
                'dnssec' => [
                    'status' => $result['status'] ?? 'disabled',
                    'ds' => $result['ds'] ?? null,
                    'digest' => $result['digest'] ?? null,
                    'digest_type' => $result['digest_type'] ?? null,
                    'digest_algorithm' => $result['digest_algorithm'] ?? null,
                    'algorithm' => $result['algorithm'] ?? null,
                    'public_key' => $result['public_key'] ?? null,
                    'key_tag' => $result['key_tag'] ?? null,
                    'flags' => $result['flags'] ?? null,
                    'key_type' => $result['key_type'] ?? null,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Enable DNSSEC for a zone
     */
    public function enableDnssec(string $zoneId): array
    {
        try {
            $response = $this->request('patch', "/zones/{$zoneId}/dnssec", [
                'status' => 'active',
            ]);
            $result = $response['result'] ?? $response;

            return [
                'success' => true,
                'dnssec' => [
                    'status' => $result['status'] ?? 'pending',
                    'ds' => $result['ds'] ?? null,
                    'digest' => $result['digest'] ?? null,
                    'digest_type' => $result['digest_type'] ?? null,
                    'digest_algorithm' => $result['digest_algorithm'] ?? null,
                    'algorithm' => $result['algorithm'] ?? null,
                    'public_key' => $result['public_key'] ?? null,
                    'key_tag' => $result['key_tag'] ?? null,
                    'flags' => $result['flags'] ?? null,
                    'key_type' => $result['key_type'] ?? null,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Disable DNSSEC for a zone
     */
    public function disableDnssec(string $zoneId): array
    {
        try {
            $this->request('patch', "/zones/{$zoneId}/dnssec", [
                'status' => 'disabled',
            ]);

            return [
                'success' => true,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get HSTS settings for a zone
     */
    public function getHstsSettings(string $zoneId): array
    {
        try {
            $response = $this->request('get', "/zones/{$zoneId}/settings/security_header");
            $result = $response['result'] ?? $response;
            $value = $result['value'] ?? [];
            $hsts = $value['strict_transport_security'] ?? [];

            return [
                'success' => true,
                'hsts' => [
                    'enabled' => $hsts['enabled'] ?? false,
                    'max_age' => $hsts['max_age'] ?? 0,
                    'include_subdomains' => $hsts['include_subdomains'] ?? false,
                    'preload' => $hsts['preload'] ?? false,
                    'nosniff' => $value['nosniff'] ?? false,
                ],
            ];
        } catch (Exception $e) {
            // Check if it's a permission error
            $message = $e->getMessage();
            $isPermissionError = str_contains($message, 'Unauthorized') || str_contains($message, 'permission') || str_contains($message, '403');

            return [
                'success' => false,
                'permission_error' => $isPermissionError,
                'message' => $isPermissionError
                    ? 'HSTS settings require Zone Settings permission on your Cloudflare API token, or a Pro/Business/Enterprise plan.'
                    : $message,
                'hsts' => [
                    'enabled' => false,
                    'max_age' => 0,
                    'include_subdomains' => false,
                    'preload' => false,
                    'nosniff' => false,
                ],
            ];
        }
    }

    /**
     * Update HSTS settings for a zone
     */
    public function updateHstsSettings(string $zoneId, array $settings): array
    {
        try {
            $response = $this->request('patch', "/zones/{$zoneId}/settings/security_header", [
                'value' => [
                    'strict_transport_security' => [
                        'enabled' => $settings['enabled'] ?? false,
                        'max_age' => $settings['max_age'] ?? 0,
                        'include_subdomains' => $settings['include_subdomains'] ?? false,
                        'preload' => $settings['preload'] ?? false,
                    ],
                    'nosniff' => $settings['nosniff'] ?? false,
                ],
            ]);

            $result = $response['result'] ?? $response;
            $value = $result['value'] ?? [];
            $hsts = $value['strict_transport_security'] ?? [];

            return [
                'success' => true,
                'hsts' => [
                    'enabled' => $hsts['enabled'] ?? false,
                    'max_age' => $hsts['max_age'] ?? 0,
                    'include_subdomains' => $hsts['include_subdomains'] ?? false,
                    'preload' => $hsts['preload'] ?? false,
                    'nosniff' => $value['nosniff'] ?? false,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get SSL/TLS certificate packs for a zone (Advanced Certificate Manager)
     */
    public function getCertificatePacks(string $zoneId): array
    {
        try {
            $response = $this->request('get', "/zones/{$zoneId}/ssl/certificate_packs?status=all");
            $packs = $response['result'] ?? [];

            return [
                'success' => true,
                'certificate_packs' => $packs,
                'has_advanced' => !empty(array_filter($packs, fn($p) => ($p['type'] ?? '') === 'advanced')),
            ];
        } catch (Exception $e) {
            $message = $e->getMessage();

            Log::warning('Cloudflare Certificate Packs Error', [
                'zone_id' => $zoneId,
                'error' => $message,
            ]);

            // Check for specific error types
            $isPermissionError = str_contains($message, 'Unauthorized') ||
                                 str_contains($message, 'permission') ||
                                 str_contains($message, '403') ||
                                 str_contains($message, 'not allowed');

            // If it's not a permission error, try to get Universal SSL instead
            if (!$isPermissionError) {
                return [
                    'success' => true,
                    'certificate_packs' => [],
                    'has_advanced' => false,
                    'message' => $message,
                ];
            }

            return [
                'success' => false,
                'permission_error' => $isPermissionError,
                'message' => $message,
                'certificate_packs' => [],
                'has_advanced' => false,
            ];
        }
    }

    /**
     * Order Advanced Certificate Manager pack for a zone
     */
    public function orderAdvancedCertificate(string $zoneId, array $hosts = []): array
    {
        try {
            $data = [
                'type' => 'advanced',
                'hosts' => $hosts,
                'validation_method' => 'txt',
                'validity_days' => 365,
                'certificate_authority' => 'lets_encrypt',
            ];

            $response = $this->request('post', "/zones/{$zoneId}/ssl/certificate_packs/order", $data);
            $result = $response['result'] ?? $response;

            return [
                'success' => true,
                'certificate_pack' => $result,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get SSL/TLS settings for a zone
     */
    public function getSslSettings(string $zoneId): array
    {
        try {
            $response = $this->request('get', "/zones/{$zoneId}/settings/ssl");
            $result = $response['result'] ?? $response;

            return [
                'success' => true,
                'ssl' => [
                    'value' => $result['value'] ?? 'off',
                    'editable' => $result['editable'] ?? true,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update SSL/TLS mode for a zone
     */
    public function updateSslMode(string $zoneId, string $mode): array
    {
        try {
            $response = $this->request('patch', "/zones/{$zoneId}/settings/ssl", [
                'value' => $mode, // off, flexible, full, strict
            ]);
            $result = $response['result'] ?? $response;

            return [
                'success' => true,
                'ssl' => [
                    'value' => $result['value'] ?? $mode,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
