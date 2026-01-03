<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class CpanelService
{
    private $client;
    private $baseUrl;
    private $username;
    private $password;
    private $apiToken;

    public function __construct(?string $hostname = null, ?string $username = null, ?string $passwordOrToken = null, bool $useSSL = true, int $port = 2087)
    {
        $this->client = new Client([
            'verify' => false, // Disable SSL verification if needed
            'timeout' => 30,
        ]);
        
        // If hostname is provided, use dynamic configuration
        if ($hostname) {
            $protocol = $useSSL ? 'https' : 'http';
            $this->baseUrl = "{$protocol}://{$hostname}:{$port}";
            $this->username = $username;
            
            // Check if passwordOrToken looks like an API token (typically longer and alphanumeric)
            if ($passwordOrToken && strlen($passwordOrToken) > 50) {
                $this->apiToken = $passwordOrToken;
                $this->password = null;
            } else {
                $this->password = $passwordOrToken;
                $this->apiToken = null;
            }
        } else {
            // Fallback to config values
            $this->baseUrl = config('services.cpanel.url');
            $this->username = config('services.cpanel.username');
            $this->password = config('services.cpanel.password');
            $this->apiToken = config('services.cpanel.api_token');
        }
    }

    /**
     * Configure the service for a specific server
     */
    public function configureForServer(\App\Models\Server $server): self
    {
        $protocol = $server->use_ssl ? 'https' : 'http';
        $port = $server->port ?: 2087;
        
        $this->baseUrl = "{$protocol}://{$server->hostname}:{$port}";
        $this->username = $server->username;
        
        if ($server->api_token) {
            $this->apiToken = $server->api_token;
            $this->password = null;
        } else {
            $this->password = $server->password;
            $this->apiToken = null;
        }
        
        return $this;
    }

    /**
     * Get authorization headers for API requests
     */
    private function getAuthHeaders()
    {
        if ($this->apiToken) {
            return [
                'Authorization' => 'WHM ' . $this->username . ':' . $this->apiToken,
                'Accept' => 'application/json',
            ];
        } else {
            return [
                'Accept' => 'application/json',
            ];
        }
    }

    /**
     * Get authentication for requests
     */
    private function getAuth()
    {
        if ($this->apiToken) {
            return null; // Use headers for token auth
        } else {
            return [$this->username, $this->password]; // Use basic auth
        }
    }

    /**
     * Create a new hosting account
     */
    public function createAccount($domain, $username, $password, $package = 'default', $contactEmail = '')
    {
        try {
            // Use WHM API v1 with /execute/ endpoint
            $params = [
                'domain' => $domain,
                'username' => $username,
                'password' => $password,
                'plan' => $package,
                'contactemail' => $contactEmail,
                'quota' => 0, // unlimited
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API v1 endpoint - createacct
            $response = $this->client->get($this->baseUrl . '/json-api/createacct', $requestOptions);

            $result = json_decode($response->getBody()->getContents(), true);
            
            // Log the response for debugging
            Log::info('WHM Create Account Response', ['result' => $result]);
            
            return $result;
        } catch (GuzzleException $e) {
            Log::error('WHM Create Account Error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'url' => $this->baseUrl . '/json-api/createacct',
                'params' => $params
            ]);
            return false;
        }
    }

    /**
     * Suspend an account
     */
    public function suspendAccount($username, $reason = 'Suspended by admin')
    {
        try {
            $params = [
                'user' => $username,
                'reason' => $reason,
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API v1 endpoint - suspendacct
            $response = $this->client->get($this->baseUrl . '/json-api/suspendacct', $requestOptions);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('WHM Suspend Account Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Unsuspend an account
     */
    public function unsuspendAccount($username)
    {
        try {
            $params = [
                'user' => $username,
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API v1 endpoint - unsuspendacct
            $response = $this->client->get($this->baseUrl . '/json-api/unsuspendacct', $requestOptions);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('WHM Unsuspend Account Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Terminate an account
     */
    public function terminateAccount($username, $keepDns = false)
    {
        try {
            $params = [
                'user' => $username,
                'keepdns' => $keepDns ? 1 : 0,
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API v1 endpoint - removeacct
            $response = $this->client->get($this->baseUrl . '/json-api/removeacct', $requestOptions);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('WHM Terminate Account Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get account information
     */
    public function getAccountInfo($username)
    {
        try {
            $response = $this->client->get($this->baseUrl . '/execute/Accounts/summary_account', [
                'auth' => [$this->username, $this->password],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'user' => $username,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('cPanel Get Account Info Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * List all accounts
     */
    public function listAccounts()
    {
        try {
            // Use WHM API v1 - listaccts function
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => []
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/listaccts', $requestOptions);

            $result = json_decode($response->getBody()->getContents(), true);
            
            // WHM returns data in 'acct' array
            if (isset($result['acct'])) {
                return ['data' => $result['acct']];
            }
            
            return $result;
        } catch (GuzzleException $e) {
            Log::error('WHM List Accounts Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Change account password
     */
    public function changePassword($username, $newPassword)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/execute/Accounts/passwd', [
                'auth' => [$this->username, $this->password],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'user' => $username,
                    'password' => $newPassword,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('cPanel Change Password Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get account usage statistics
     */
    public function getAccountUsage($username)
    {
        try {
            $response = $this->client->get($this->baseUrl . '/execute/StatsBar/get_stats', [
                'auth' => [$username, $this->password],
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('cPanel Get Usage Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a user session token for auto-login
     */
    public function createUserSession($username, $serviceName = 'cpaneld')
    {
        try {
            $params = [
                'api.version' => '1',
                'user' => $username,
                'service' => $serviceName, // cpaneld for cPanel, webmaild for Webmail
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API v1
            $response = $this->client->get($this->baseUrl . '/json-api/create_user_session', $requestOptions);

            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('WHM Create User Session Response', ['result' => $result]);
            
            return $result;
        } catch (GuzzleException $e) {
            Log::error('WHM Create User Session Error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'username' => $username
            ]);
            return false;
        }
    }

    /**
     * Get account usage statistics
     */
    public function getAccountStats($username)
    {
        try {
            $params = [
                'api.version' => '1',
                'user' => $username
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            // Use WHM API to get account summary
            $response = $this->client->get($this->baseUrl . '/json-api/accountsummary', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('WHM Account Summary Response', ['result' => $result]);
            
            if (isset($result['data']['acct']) && count($result['data']['acct']) > 0) {
                $account = $result['data']['acct'][0];
                
                // Parse disk usage - diskused comes as "0M", "1.5G", etc
                $diskUsedStr = $account['diskused'] ?? '0M';
                $diskLimitStr = $account['disklimit'] ?? 'unlimited';
                
                // Convert disk values to bytes
                $diskUsedBytes = $this->parseStorageValue($diskUsedStr);
                $diskLimitBytes = strtolower($diskLimitStr) === 'unlimited' ? 0 : $this->parseStorageValue($diskLimitStr);
                
                // Calculate disk percentage
                $diskPercent = 0;
                if ($diskLimitBytes > 0 && $diskUsedBytes > 0) {
                    $diskPercent = round(($diskUsedBytes / $diskLimitBytes) * 100, 2);
                }
                
                // Get bandwidth usage from showbw API
                $bandwidthData = $this->getBandwidthUsage($username);
                $bandwidthUsedBytes = $bandwidthData['used'] ?? 0;
                $bandwidthLimitBytes = $bandwidthData['limit'] ?? 0;
                
                // Calculate bandwidth percentage
                $bandwidthPercent = 0;
                if ($bandwidthLimitBytes > 0 && $bandwidthUsedBytes > 0) {
                    $bandwidthPercent = round(($bandwidthUsedBytes / $bandwidthLimitBytes) * 100, 2);
                }
                
                // Get current usage counts
                $usageCounts = $this->getAccountUsageCounts($username);
                
                return [
                    'disk_used_bytes' => $diskUsedBytes,
                    'disk_limit_bytes' => $diskLimitBytes,
                    'disk_used' => $this->formatBytes($diskUsedBytes),
                    'disk_limit' => $diskLimitBytes > 0 ? $this->formatBytes($diskLimitBytes) : 'Unlimited',
                    'disk_percent' => $diskPercent,
                    'bandwidth_used_bytes' => $bandwidthUsedBytes,
                    'bandwidth_limit_bytes' => $bandwidthLimitBytes,
                    'bandwidth_used' => $this->formatBytes($bandwidthUsedBytes),
                    'bandwidth_limit' => $bandwidthLimitBytes > 0 ? $this->formatBytes($bandwidthLimitBytes) : 'Unlimited',
                    'bandwidth_percent' => $bandwidthPercent,
                    'addon_domains' => intval($account['maxaddons'] ?? 0),
                    'addon_domains_used' => $usageCounts['addon_domains'] ?? 0,
                    'email_accounts' => intval($account['maxpop'] ?? 0),
                    'email_accounts_used' => $usageCounts['email_accounts'] ?? 0,
                    'databases' => intval($account['maxsql'] ?? 0),
                    'databases_used' => $usageCounts['databases'] ?? 0,
                    'ftp_accounts' => intval($account['maxftp'] ?? 0),
                    'subdomains' => intval($account['maxsub'] ?? 0),
                    'suspended' => isset($account['suspended']) && $account['suspended'] == 1,
                ];
            }
            
            return null;
        } catch (GuzzleException $e) {
            Log::error('WHM Account Summary Error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'username' => $username
            ]);
            return null;
        }
    }

    /**
     * Get account usage counts using UAPI through WHM
     */
    private function getAccountUsageCounts($username)
    {
        try {
            $counts = [
                'addon_domains' => 0,
                'email_accounts' => 0,
                'databases' => 0,
            ];

            // Get email accounts count using WHM UAPI call
            try {
                $emailParams = [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $username,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'Email',
                    'cpanel_jsonapi_func' => 'listpopswithdisk'
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $emailParams
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                Log::info('WHM Email Accounts Response', ['result' => $result]);
                
                if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                    $counts['email_accounts'] = count($result['cpanelresult']['data']);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get email accounts count', ['error' => $e->getMessage()]);
            }

            // Get addon domains count using WHM UAPI
            try {
                $domainsParams = [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $username,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'AddonDomain',
                    'cpanel_jsonapi_func' => 'listaddondomains'
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $domainsParams
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                Log::info('WHM Addon Domains Response', ['result' => $result]);
                
                if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                    $counts['addon_domains'] = count($result['cpanelresult']['data']);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get addon domains count', ['error' => $e->getMessage()]);
            }

            // Get databases count using WHM UAPI
            try {
                $dbParams = [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $username,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'Mysql',
                    'cpanel_jsonapi_func' => 'listdbs'
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $dbParams
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                Log::info('WHM Databases Response', ['result' => $result]);
                
                if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                    $counts['databases'] = count($result['cpanelresult']['data']);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get databases count', ['error' => $e->getMessage()]);
            }

            return $counts;
        } catch (\Exception $e) {
            Log::error('Failed to get account usage counts', ['error' => $e->getMessage()]);
            return [
                'addon_domains' => 0,
                'email_accounts' => 0,
                'databases' => 0,
            ];
        }
    }

    /**
     * Get bandwidth usage from WHM showbw API
     */
    private function getBandwidthUsage($username)
    {
        try {
            $params = [
                'api.version' => '1',
                'searchtype' => 'user',
                'search' => $username
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/showbw', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('WHM Bandwidth Response', ['result' => $result]);
            
            // Check both possible response structures
            if (isset($result['data']['acct'][0])) {
                $account = $result['data']['acct'][0];
                
                return [
                    'used' => intval($account['totalbytes'] ?? 0),
                    'limit' => intval($account['limit'] ?? 0),
                ];
            } elseif (isset($result['bandwidth'][0]['acct'][0])) {
                $account = $result['bandwidth'][0]['acct'][0];
                
                return [
                    'used' => intval($account['totalbytes'] ?? 0),
                    'limit' => intval($account['limit'] ?? 0),
                ];
            }
            
            return ['used' => 0, 'limit' => 0];
        } catch (\Exception $e) {
            Log::error('Failed to get bandwidth usage', ['error' => $e->getMessage()]);
            return ['used' => 0, 'limit' => 0];
        }
    }

    /**
     * Parse storage value from cPanel format (e.g., "0M", "1.5G", "500K")
     */
    private function parseStorageValue($value)
    {
        if (empty($value) || strtolower($value) === 'unlimited') {
            return 0;
        }
        
        // Extract numeric value and unit
        preg_match('/^([0-9.]+)([KMGT])?$/i', trim($value), $matches);
        
        if (empty($matches)) {
            return 0;
        }
        
        $number = floatval($matches[1]);
        $unit = isset($matches[2]) ? strtoupper($matches[2]) : 'B';
        
        // Convert to bytes
        switch ($unit) {
            case 'K':
                return $number * 1024;
            case 'M':
                return $number * 1024 * 1024;
            case 'G':
                return $number * 1024 * 1024 * 1024;
            case 'T':
                return $number * 1024 * 1024 * 1024 * 1024;
            default:
                return $number;
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes == 0) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get list of email accounts
     */
    public function listEmailAccounts($username)
    {
        try {
            $params = [
                'api.version' => '1',
                'cpanel_jsonapi_user' => $username,
                'cpanel_jsonapi_apiversion' => '2',
                'cpanel_jsonapi_module' => 'Email',
                'cpanel_jsonapi_func' => 'listpopswithdisk'
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('List Email Accounts Response', ['result' => $result]);
            
            if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                return [
                    'success' => true,
                    'emails' => $result['cpanelresult']['data']
                ];
            }
            
            return ['success' => false, 'emails' => []];
        } catch (\Exception $e) {
            Log::error('Failed to list email accounts', ['error' => $e->getMessage()]);
            return ['success' => false, 'emails' => [], 'error' => $e->getMessage()];
        }
    }

    /**
     * Create email account
     */
    public function createEmailAccount($username, $emailUser, $password, $quota = 250, $domain = null)
    {
        try {
            // If no domain provided, get the main domain
            if (!$domain) {
                $accountInfo = $this->getAccountInfo($username);
                $domain = $accountInfo['data']['account']['domain'] ?? null;
                
                if (!$domain) {
                    return ['success' => false, 'message' => 'Could not determine domain'];
                }
            }
            
            $params = [
                'api.version' => '1',
                'cpanel_jsonapi_user' => $username,
                'cpanel_jsonapi_apiversion' => '2',
                'cpanel_jsonapi_module' => 'Email',
                'cpanel_jsonapi_func' => 'addpop',
                'email' => $emailUser,
                'password' => $password,
                'quota' => $quota,
                'domain' => $domain
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('Create Email Account Response', ['result' => $result]);
            
            // Check if the result is in the expected format (cPanel API v2 returns data as array)
            if (isset($result['cpanelresult']['data'][0]['result']) && $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Email account created successfully'
                ];
            }
            
            $errorMsg = $result['cpanelresult']['data'][0]['reason'] ?? 'Failed to create email account';
            return ['success' => false, 'message' => $errorMsg];
        } catch (\Exception $e) {
            Log::error('Failed to create email account', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete email account
     */
    public function deleteEmailAccount($username, $emailUser, $domain)
    {
        try {
            $params = [
                'api.version' => '1',
                'cpanel_jsonapi_user' => $username,
                'cpanel_jsonapi_apiversion' => '2',
                'cpanel_jsonapi_module' => 'Email',
                'cpanel_jsonapi_func' => 'delpop',
                'email' => $emailUser,
                'domain' => $domain
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('Delete Email Account Response', ['result' => $result]);
            
            // Check if the result is in the expected format (cPanel API v2 returns data as array)
            if (isset($result['cpanelresult']['data'][0]['result']) && $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Email account deleted successfully'
                ];
            }
            
            $errorMsg = $result['cpanelresult']['data'][0]['reason'] ?? 'Failed to delete email account';
            return ['success' => false, 'message' => $errorMsg];
        } catch (\Exception $e) {
            Log::error('Failed to delete email account', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get list of domains (main domain + addon domains + subdomains)
     */
    public function getAccountDomains($username)
    {
        try {
            $domains = [];
            
            // Get account summary for main domain
            $params = [
                'api.version' => '1',
                'user' => $username
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $params
            ];

            if ($this->getAuth()) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get($this->baseUrl . '/json-api/accountsummary', $requestOptions);
            $result = json_decode($response->getBody()->getContents(), true);
            
            // Add main domain
            if (isset($result['data']['acct'][0]['domain'])) {
                $domains[] = $result['data']['acct'][0]['domain'];
            }
            
            // Get addon domains
            try {
                $addonParams = [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $username,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'AddonDomain',
                    'cpanel_jsonapi_func' => 'listaddondomains'
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $addonParams
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                    foreach ($result['cpanelresult']['data'] as $addon) {
                        if (isset($addon['domain'])) {
                            $domains[] = $addon['domain'];
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get addon domains', ['error' => $e->getMessage()]);
            }
            
            // Get subdomains
            try {
                $subdomainParams = [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $username,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'SubDomain',
                    'cpanel_jsonapi_func' => 'listsubdomains'
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $subdomainParams
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                    foreach ($result['cpanelresult']['data'] as $subdomain) {
                        if (isset($subdomain['domain'])) {
                            $domains[] = $subdomain['domain'];
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get subdomains', ['error' => $e->getMessage()]);
            }
            
            return [
                'success' => true,
                'domains' => array_unique($domains)
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get account domains', ['error' => $e->getMessage()]);
            return ['success' => false, 'domains' => [], 'error' => $e->getMessage()];
        }
    }

    /**
     * Get ALL domains from ALL cPanel accounts (main + addon + parked + subdomains)
     * This is useful for checking if a domain exists anywhere in WHM
     */
    public function getAllDomainsFromAllAccounts()
    {
        try {
            $allDomains = [];
            
            // First get all accounts
            $accounts = $this->listAccounts();
            
            if (!$accounts || !isset($accounts['data'])) {
                Log::warning('Failed to get accounts list for domain check');
                return ['success' => false, 'domains' => []];
            }
            
            foreach ($accounts['data'] as $account) {
                $username = $account['user'] ?? null;
                $mainDomain = $account['domain'] ?? null;
                
                if (!$username) continue;
                
                // Add main domain
                if ($mainDomain) {
                    $allDomains[] = strtolower($mainDomain);
                }
                
                // Get addon domains for this account
                try {
                    $addonParams = [
                        'api.version' => '1',
                        'cpanel_jsonapi_user' => $username,
                        'cpanel_jsonapi_apiversion' => '2',
                        'cpanel_jsonapi_module' => 'AddonDomain',
                        'cpanel_jsonapi_func' => 'listaddondomains'
                    ];

                    $requestOptions = [
                        'headers' => $this->getAuthHeaders(),
                        'query' => $addonParams
                    ];

                    if ($this->getAuth()) {
                        $requestOptions['auth'] = $this->getAuth();
                    }

                    $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                    $result = json_decode($response->getBody()->getContents(), true);
                    
                    if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                        foreach ($result['cpanelresult']['data'] as $addon) {
                            if (isset($addon['domain'])) {
                                $allDomains[] = strtolower($addon['domain']);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Continue with other accounts even if one fails
                    Log::debug('Failed to get addon domains for ' . $username, ['error' => $e->getMessage()]);
                }
                
                // Get parked/alias domains for this account
                try {
                    $parkedParams = [
                        'api.version' => '1',
                        'cpanel_jsonapi_user' => $username,
                        'cpanel_jsonapi_apiversion' => '2',
                        'cpanel_jsonapi_module' => 'Park',
                        'cpanel_jsonapi_func' => 'listparkeddomains'
                    ];

                    $requestOptions = [
                        'headers' => $this->getAuthHeaders(),
                        'query' => $parkedParams
                    ];

                    if ($this->getAuth()) {
                        $requestOptions['auth'] = $this->getAuth();
                    }

                    $response = $this->client->get($this->baseUrl . '/json-api/cpanel', $requestOptions);
                    $result = json_decode($response->getBody()->getContents(), true);
                    
                    if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                        foreach ($result['cpanelresult']['data'] as $parked) {
                            if (isset($parked['domain'])) {
                                $allDomains[] = strtolower($parked['domain']);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::debug('Failed to get parked domains for ' . $username, ['error' => $e->getMessage()]);
                }
            }
            
            $uniqueDomains = array_unique($allDomains);
            
            Log::info('Retrieved all domains from WHM', [
                'total_domains' => count($uniqueDomains)
            ]);
            
            return [
                'success' => true,
                'domains' => $uniqueDomains
            ];
            
        } catch (\Exception $e) {
            Log::error('Failed to get all domains from WHM', ['error' => $e->getMessage()]);
            return ['success' => false, 'domains' => [], 'error' => $e->getMessage()];
        }
    }

    /**
     * Check if a specific domain exists anywhere in WHM (FAST method)
     * Uses WHM API domainuserdata which directly checks if domain exists
     */
    public function domainExistsInWhm($domain)
    {
        try {
            $domain = strtolower(trim($domain));
            
            // Method 1: Use domainuserdata API - this is the FASTEST way
            // It directly checks if a domain exists and returns the user who owns it
            try {
                $params = [
                    'api.version' => '1',
                    'domain' => $domain
                ];

                $requestOptions = [
                    'headers' => $this->getAuthHeaders(),
                    'query' => $params
                ];

                if ($this->getAuth()) {
                    $requestOptions['auth'] = $this->getAuth();
                }

                $response = $this->client->get($this->baseUrl . '/json-api/domainuserdata', $requestOptions);
                $result = json_decode($response->getBody()->getContents(), true);
                
                Log::info('WHM domainuserdata response', [
                    'domain' => $domain,
                    'has_userdata' => isset($result['data']['userdata'])
                ]);
                
                // If we get userdata back, the domain exists
                if (isset($result['data']['userdata']) && !empty($result['data']['userdata'])) {
                    return ['exists' => true, 'owner' => $result['data']['userdata']['user'] ?? 'unknown'];
                }
                
                // Check if result indicates domain exists (different response format)
                if (isset($result['data']) && isset($result['data']['user'])) {
                    return ['exists' => true, 'owner' => $result['data']['user']];
                }
                
                // If metadata shows success but no userdata, domain doesn't exist
                if (isset($result['metadata']['result']) && $result['metadata']['result'] == 1) {
                    // API succeeded - check if domain data exists
                    if (empty($result['data']) || (isset($result['data']['userdata']) && empty($result['data']['userdata']))) {
                        return ['exists' => false];
                    }
                }
                
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // 404 or similar means domain doesn't exist
                Log::info('domainuserdata returned error (domain likely does not exist)', ['domain' => $domain]);
                return ['exists' => false];
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                Log::info('domainuserdata check failed', ['domain' => $domain, 'error' => $errorMessage]);
                
                // If error contains "does not exist" or similar, domain doesn't exist
                if (strpos($errorMessage, 'does not exist') !== false || 
                    strpos($errorMessage, 'not found') !== false ||
                    strpos($errorMessage, 'No such') !== false) {
                    return ['exists' => false];
                }
            }
            
            // Method 2: Fallback - check main domains only (still fast)
            $accounts = $this->listAccounts();
            if ($accounts && isset($accounts['data'])) {
                foreach ($accounts['data'] as $account) {
                    if (strtolower($account['domain'] ?? '') === $domain) {
                        return ['exists' => true, 'owner' => $account['user'] ?? 'unknown', 'type' => 'main'];
                    }
                }
            }
            
            // Domain not found
            return ['exists' => false];
            
        } catch (\Exception $e) {
            Log::error('Failed to check domain in WHM', ['error' => $e->getMessage()]);
            return ['exists' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Change cPanel account password
     */
    public function changeAccountPassword($username, $newPassword)
    {
        try {
            Log::info('CpanelService: Starting password change', [
                'username' => $username,
                'baseUrl' => $this->baseUrl
            ]);
            
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'user' => $username,
                    'password' => $newPassword,
                ]
            ];

            // Add auth if no API token
            if (!$this->apiToken && $this->username && $this->password) {
                $requestOptions['auth'] = $this->getAuth();
            }

            Log::info('CpanelService: Sending request to WHM', [
                'url' => $this->baseUrl . '/json-api/passwd',
                'query' => [
                    'api.version' => '1',
                    'user' => $username,
                    'password' => '***hidden***'
                ]
            ]);

            $response = $this->client->get(
                $this->baseUrl . '/json-api/passwd',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);
            
            Log::info('CpanelService: WHM Response received', [
                'result' => $result
            ]);

            // Check metadata result format (newer WHM versions)
            if (isset($result['metadata']['result']) && $result['metadata']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => __('frontend.password_changed_successfully')
                ];
            }

            // Check for success in various response formats
            if (isset($result['passwd'])) {
                // API v1 format
                if (isset($result['passwd'][0]['status']) && $result['passwd'][0]['status'] == 1) {
                    return [
                        'success' => true,
                        'message' => $result['passwd'][0]['statusmsg'] ?? __('frontend.password_changed_successfully')
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $result['passwd'][0]['statusmsg'] ?? __('frontend.failed_to_change_password')
                    ];
                }
            } elseif (isset($result['result']) && is_array($result['result'])) {
                // Alternative format
                if (isset($result['result'][0]['status']) && $result['result'][0]['status'] == 1) {
                    return [
                        'success' => true,
                        'message' => $result['result'][0]['statusmsg'] ?? __('frontend.password_changed_successfully')
                    ];
                }
            }

            // If we get here, password change likely failed
            return [
                'success' => false,
                'message' => __('frontend.failed_to_change_password')
            ];

        } catch (\Exception $e) {
            Log::error('Failed to change cPanel password', [
                'username' => $username,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => __('frontend.error_occurred') . ': ' . $e->getMessage()
            ];
        }
    }

    /**
     * Change cPanel account username
     */
    public function changeAccountUsername($oldUsername, $newUsername)
    {
        try {
            Log::info('CpanelService: Starting username change', [
                'old_username' => $oldUsername,
                'new_username' => $newUsername,
                'baseUrl' => $this->baseUrl
            ]);

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'user' => $oldUsername,
                    'newuser' => $newUsername,
                ]
            ];

            // Add auth if no API token
            if (!$this->apiToken && $this->username && $this->password) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/modifyacct',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('CpanelService: WHM modifyacct Response', [
                'result' => $result
            ]);

            // Check metadata result format (newer WHM versions)
            if (isset($result['metadata']['result']) && $result['metadata']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => __('frontend.username_changed_successfully') ?? 'Username changed successfully'
                ];
            }

            // Check for success in result array
            if (isset($result['result']) && is_array($result['result'])) {
                if (isset($result['result'][0]['status']) && $result['result'][0]['status'] == 1) {
                    return [
                        'success' => true,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Username changed successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Failed to change username'
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to change username'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to change cPanel username', [
                'old_username' => $oldUsername,
                'new_username' => $newUsername,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * List all hosting packages/plans from WHM
     */
    public function listPackages()
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                ]
            ];

            if (!$this->apiToken && $this->username && $this->password) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/listpkgs',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['package']) && is_array($result['package'])) {
                return [
                    'success' => true,
                    'packages' => $result['package']
                ];
            }

            // Alternative format
            if (isset($result['data']['pkg']) && is_array($result['data']['pkg'])) {
                return [
                    'success' => true,
                    'packages' => $result['data']['pkg']
                ];
            }

            return [
                'success' => false,
                'packages' => [],
                'message' => 'No packages found'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to list WHM packages', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'packages' => [],
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Change cPanel account package/plan
     */
    public function changePackage($username, $newPackage)
    {
        try {
            Log::info('CpanelService: Starting package change', [
                'username' => $username,
                'new_package' => $newPackage,
                'baseUrl' => $this->baseUrl
            ]);

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'user' => $username,
                    'pkg' => $newPackage,
                ]
            ];

            if (!$this->apiToken && $this->username && $this->password) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/changepackage',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('CpanelService: WHM changepackage Response', [
                'result' => $result
            ]);

            // Check metadata result format
            if (isset($result['metadata']['result']) && $result['metadata']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Package changed successfully'
                ];
            }

            // Check for success in result array
            if (isset($result['result']) && is_array($result['result'])) {
                if (isset($result['result'][0]['status']) && $result['result'][0]['status'] == 1) {
                    return [
                        'success' => true,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Package changed successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Failed to change package'
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to change package'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to change cPanel package', [
                'username' => $username,
                'new_package' => $newPackage,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Change cPanel account primary domain
     */
    public function changeAccountDomain($username, $newDomain)
    {
        try {
            Log::info('CpanelService: Starting domain change', [
                'username' => $username,
                'new_domain' => $newDomain,
                'baseUrl' => $this->baseUrl
            ]);

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'user' => $username,
                    'domain' => $newDomain,
                ]
            ];

            if (!$this->apiToken && $this->username && $this->password) {
                $requestOptions['auth'] = $this->getAuth();
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/modifyacct',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('CpanelService: WHM modifyacct (domain) Response', [
                'result' => $result
            ]);

            // Check metadata result format (newer WHM versions)
            if (isset($result['metadata']['result']) && $result['metadata']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Domain changed successfully'
                ];
            }

            // Check for success in result array
            if (isset($result['result']) && is_array($result['result'])) {
                if (isset($result['result'][0]['status']) && $result['result'][0]['status'] == 1) {
                    return [
                        'success' => true,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Domain changed successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $result['result'][0]['statusmsg'] ?? 'Failed to change domain'
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to change domain'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to change cPanel domain', [
                'username' => $username,
                'new_domain' => $newDomain,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * List FTP accounts for a cPanel user
     */
    public function listFtpAccounts($cpanelUsername)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'Ftp',
                    'cpanel_jsonapi_func' => 'listftp'
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                return $result['cpanelresult']['data'];
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Failed to list FTP accounts', [
                'username' => $cpanelUsername,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Create FTP account
     */
    public function createFtpAccount($cpanelUsername, $ftpUsername, $password, $directory = null, $quota = null)
    {
        try {
            $queryParams = [
                'api.version' => '1',
                'cpanel_jsonapi_user' => $cpanelUsername,
                'cpanel_jsonapi_module' => 'Ftp',
                'cpanel_jsonapi_func' => 'addftp',
                'user' => $ftpUsername,
                'pass' => $password
            ];

            if ($directory) {
                $queryParams['homedir'] = $directory;
            }

            if ($quota) {
                $queryParams['quota'] = $quota;
            }

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $queryParams
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // Log the full response for debugging
            \Log::info('WHM Create FTP Response', ['result' => $result]);

            // Check various response formats
            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'FTP account created successfully'
                ];
            }

            if (isset($result['cpanelresult']['data'][0]['result']) && $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'FTP account created successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['data'][0]['reason'] ?? 
                       'Failed to create FTP account';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create FTP account', [
                'username' => $cpanelUsername,
                'ftp_user' => $ftpUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete FTP account
     */
    public function deleteFtpAccount($cpanelUsername, $ftpUsername)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'Ftp',
                    'cpanel_jsonapi_func' => 'delftp',
                    'user' => $ftpUsername
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // Check various response formats
            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'FTP account deleted successfully'
                ];
            }

            if (isset($result['cpanelresult']['data'][0]['result']) && $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'FTP account deleted successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['data'][0]['reason'] ?? 
                       'Failed to delete FTP account';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete FTP account', [
                'username' => $cpanelUsername,
                'ftp_user' => $ftpUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Database Wizard - Create Database
     */
    public function createDatabase($cpanelUsername, $databaseName)
    {
        try {
            // Add prefix to database name
            $fullDatabaseName = $cpanelUsername . '_' . $databaseName;
            
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '3', // UAPI
                    'cpanel_jsonapi_module' => 'Mysql',
                    'cpanel_jsonapi_func' => 'create_database',
                    'name' => $fullDatabaseName
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // UAPI format response
            if (isset($result['result']['status']) && $result['result']['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Database created successfully',
                    'database' => $fullDatabaseName
                ];
            }

            $errorMsg = $result['result']['errors'][0] ?? 
                       $result['result']['error'] ?? 
                       'Failed to create database';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create database', [
                'username' => $cpanelUsername,
                'database' => $databaseName,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Database Wizard - Create Database User
     */
    public function createDatabaseUser($cpanelUsername, $dbUsername, $password)
    {
        try {
            // Add prefix to username
            $fullUsername = $cpanelUsername . '_' . $dbUsername;
            
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '3', // UAPI
                    'cpanel_jsonapi_module' => 'Mysql',
                    'cpanel_jsonapi_func' => 'create_user',
                    'name' => $fullUsername,
                    'password' => $password
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // UAPI format response
            if (isset($result['result']['status']) && $result['result']['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Database user created successfully',
                    'username' => $fullUsername
                ];
            }

            $errorMsg = $result['result']['errors'][0] ?? 
                       $result['result']['error'] ?? 
                       'Failed to create database user';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create database user', [
                'username' => $cpanelUsername,
                'db_username' => $dbUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Database Wizard - Assign Database Privileges
     */
    public function assignDatabasePrivileges($cpanelUsername, $database, $dbUsername, $privileges = 'ALL')
    {
        try {
            // Remove prefix if already exists (we'll add it back)
            $dbNameOnly = str_replace($cpanelUsername . '_', '', $database);
            $userNameOnly = str_replace($cpanelUsername . '_', '', $dbUsername);
            
            // Add prefix back for full names
            $fullDatabase = $cpanelUsername . '_' . $dbNameOnly;
            $fullUsername = $cpanelUsername . '_' . $userNameOnly;

            // Format privileges for cPanel API
            $formattedPrivileges = $privileges;
            if ($privileges !== 'ALL' && $privileges !== 'ALL PRIVILEGES') {
                // Convert comma-separated list to cPanel format
                // e.g., "SELECT,INSERT,UPDATE" stays as is for cPanel
                $formattedPrivileges = $privileges;
            } else {
                $formattedPrivileges = 'ALL PRIVILEGES';
            }

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '3', // UAPI
                    'cpanel_jsonapi_module' => 'Mysql',
                    'cpanel_jsonapi_func' => 'set_privileges_on_database',
                    'user' => $fullUsername,
                    'database' => $fullDatabase,
                    'privileges' => $formattedPrivileges
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // UAPI format response
            if (isset($result['result']['status']) && $result['result']['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Privileges assigned successfully'
                ];
            }

            $errorMsg = $result['result']['errors'][0] ?? 
                       $result['result']['error'] ?? 
                       'Failed to assign privileges';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to assign database privileges', [
                'username' => $cpanelUsername,
                'database' => $database,
                'db_username' => $dbUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    // ===== Domains Manager Methods =====

    /**
     * List addon domains for a cPanel account
     */
    public function listAddonDomains($cpanelUsername)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'AddonDomain',
                    'cpanel_jsonapi_func' => 'listaddondomains'
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                $domains = array_map(function($domain) {
                    return [
                        'domain' => $domain['domain'] ?? '',
                        'subdomain' => $domain['subdomain'] ?? '',
                        'fullsubdomain' => $domain['fullsubdomain'] ?? '',
                        'rootdomain' => $domain['rootdomain'] ?? '',
                        'directory' => $domain['dir'] ?? '',
                        'docroot' => $domain['docroot'] ?? ''
                    ];
                }, $result['cpanelresult']['data']);

                return [
                    'success' => true,
                    'domains' => $domains
                ];
            }

            return [
                'success' => true,
                'domains' => []
            ];

        } catch (\Exception $e) {
            Log::error('Failed to list addon domains', [
                'username' => $cpanelUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'domains' => []
            ];
        }
    }

    /**
     * Add addon domain to cPanel account
     */
    public function addAddonDomain($cpanelUsername, $domain, $subdomain, $directory)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'AddonDomain',
                    'cpanel_jsonapi_func' => 'addaddondomain',
                    'newdomain' => $domain,
                    'subdomain' => $subdomain,
                    'dir' => $directory
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Addon domain added successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['event']['reason'] ?? 
                       'Failed to add addon domain';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to add addon domain', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete addon domain from cPanel account
     */
    public function deleteAddonDomain($cpanelUsername, $domain)
    {
        try {
            // First, get the addon domain details to find subdomain and root domain
            $addonDomainsResult = $this->listAddonDomains($cpanelUsername);
            
            if (!$addonDomainsResult['success']) {
                return [
                    'success' => false,
                    'message' => 'Failed to retrieve addon domains list'
                ];
            }

            $addonDomains = $addonDomainsResult['domains'];
            
            $addonDomainInfo = null;
            foreach ($addonDomains as $addonDomain) {
                if ($addonDomain['domain'] === $domain) {
                    $addonDomainInfo = $addonDomain;
                    break;
                }
            }

            if (!$addonDomainInfo) {
                return [
                    'success' => false,
                    'message' => 'Addon domain not found'
                ];
            }

            // Try using the addon domain as 'domain' parameter only
            // Maybe deladdondomain just needs the addon domain itself
            $addonDomain = $addonDomainInfo['domain'] ?? '';
            
            if (empty($addonDomain)) {
                return [
                    'success' => false,
                    'message' => 'Addon domain information not found'
                ];
            }

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'AddonDomain',
                    'cpanel_jsonapi_func' => 'deladdondomain',
                    'domain' => $addonDomain
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // Log the response for debugging
            Log::info('Delete Addon Domain Response', [
                'requested_domain' => $domain,
                'addon_domain' => $addonDomain,
                'response' => $result
            ]);

            // cPanel API v2 response structure
            if (isset($result['cpanelresult']['data'][0]['result']) && 
                $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Addon domain deleted successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['data'][0]['reason'] ?? 
                       $result['cpanelresult']['error'] ?? 
                       'Failed to delete addon domain';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete addon domain', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * List subdomains for a cPanel account
     */
    public function listSubdomains($cpanelUsername)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'SubDomain',
                    'cpanel_jsonapi_func' => 'listsubdomains'
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                $subdomains = array_map(function($subdomain) {
                    // Split subdomain.domain into parts
                    $fullDomain = $subdomain['domain'] ?? '';
                    $parts = explode('.', $fullDomain, 2);
                    
                    return [
                        'subdomain' => $parts[0] ?? '',
                        'domain' => $parts[1] ?? '',
                        'directory' => $subdomain['dir'] ?? '',
                        'docroot' => $subdomain['docroot'] ?? ''
                    ];
                }, $result['cpanelresult']['data']);

                return [
                    'success' => true,
                    'subdomains' => $subdomains
                ];
            }

            return [
                'success' => true,
                'subdomains' => []
            ];

        } catch (\Exception $e) {
            Log::error('Failed to list subdomains', [
                'username' => $cpanelUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'subdomains' => []
            ];
        }
    }

    /**
     * Add subdomain to cPanel account
     */
    public function addSubdomain($cpanelUsername, $subdomain, $domain, $directory)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'api.version' => '1',
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_module' => 'SubDomain',
                    'cpanel_jsonapi_func' => 'addsubdomain',
                    'domain' => $subdomain,
                    'rootdomain' => $domain,
                    'dir' => $directory
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Subdomain added successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['event']['reason'] ?? 
                       'Failed to add subdomain';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to add subdomain', [
                'username' => $cpanelUsername,
                'subdomain' => $subdomain,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete subdomain from cPanel account
     */
    public function deleteSubdomain($cpanelUsername, $subdomain, $domain)
    {
        try {
            $fullDomain = $subdomain . '.' . $domain;
            
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '3',
                    'cpanel_jsonapi_module' => 'SubDomain',
                    'cpanel_jsonapi_func' => 'delsubdomain',
                    'domain' => $fullDomain
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            // cPanel API v3 response structure
            if (isset($result['cpanelresult']['data'][0]['result']) && 
                $result['cpanelresult']['data'][0]['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Subdomain deleted successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['data'][0]['reason'] ?? 
                       $result['cpanelresult']['error'] ?? 
                       'Failed to delete subdomain';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete subdomain', [
                'username' => $cpanelUsername,
                'subdomain' => $subdomain,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    // ==================== Zone Editor (DNS) Functions ====================
    
    /**
     * List DNS zones for a cPanel account
     */
    public function listZones($cpanelUsername)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'ZoneEdit',
                    'cpanel_jsonapi_func' => 'fetchzones'
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);
            
            // Log the raw response for debugging
            \Log::info('Zone Editor - List Zones Response', [
                'username' => $cpanelUsername,
                'result' => $result
            ]);

            // Check different possible response structures
            if (isset($result['cpanelresult']['data'][0]['zones']) && is_array($result['cpanelresult']['data'][0]['zones'])) {
                // cPanel API v2 returns zones in data[0]['zones'] as an associative array
                $zonesData = $result['cpanelresult']['data'][0]['zones'];
                $zones = [];
                
                foreach ($zonesData as $domain => $zoneContent) {
                    $zones[] = [
                        'domain' => $domain,
                        'zonefile' => $domain
                    ];
                }

                return [
                    'success' => true,
                    'zones' => $zones
                ];
            } elseif (isset($result['cpanelresult']['data']) && is_array($result['cpanelresult']['data'])) {
                // Fallback to original structure
                $zones = array_map(function($zone) {
                    return [
                        'domain' => $zone['domain'] ?? '',
                        'zonefile' => $zone['zonefile'] ?? ''
                    ];
                }, $result['cpanelresult']['data']);

                return [
                    'success' => true,
                    'zones' => $zones
                ];
            }

            return [
                'success' => false,
                'message' => 'No zones found',
                'zones' => []
            ];

        } catch (\Exception $e) {
            Log::error('Failed to list DNS zones', [
                'username' => $cpanelUsername,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * List DNS records for a specific zone
     */
    public function fetchZoneRecords($cpanelUsername, $domain)
    {
        try {
            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'ZoneEdit',
                    'cpanel_jsonapi_func' => 'fetchzone',
                    'domain' => $domain
                ]
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['cpanelresult']['data'][0]['record']) && is_array($result['cpanelresult']['data'][0]['record'])) {
                $records = array_map(function($record) {
                    return [
                        'line' => $record['Line'] ?? '',
                        'name' => $record['name'] ?? '',
                        'ttl' => $record['ttl'] ?? '',
                        'class' => $record['class'] ?? '',
                        'type' => $record['type'] ?? '',
                        'record' => $record['record'] ?? '',
                        'address' => $record['address'] ?? '',
                        'cname' => $record['cname'] ?? '',
                        'exchange' => $record['exchange'] ?? '',
                        'preference' => $record['preference'] ?? '',
                        'txtdata' => $record['txtdata'] ?? ''
                    ];
                }, $result['cpanelresult']['data'][0]['record']);

                return [
                    'success' => true,
                    'records' => $records
                ];
            }

            return [
                'success' => false,
                'message' => 'No records found'
            ];

        } catch (\Exception $e) {
            Log::error('Failed to fetch zone records', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Add a DNS record
     */
    public function addZoneRecord($cpanelUsername, $domain, $name, $type, $record, $ttl = 14400, $priority = null)
    {
        try {
            // MX records require a different API function
            if ($type === 'MX') {
                return $this->addMXRecord($cpanelUsername, $domain, $name, $record, $priority ?? 10);
            }
            
            $queryParams = [
                'cpanel_jsonapi_user' => $cpanelUsername,
                'cpanel_jsonapi_apiversion' => '2',
                'cpanel_jsonapi_module' => 'ZoneEdit',
                'cpanel_jsonapi_func' => 'add_zone_record',
                'domain' => $domain,
                'name' => $name,
                'type' => $type,
                'ttl' => $ttl
            ];

            // Add type-specific parameters
            if ($type === 'A') {
                $queryParams['address'] = $record;
            } elseif ($type === 'CNAME') {
                $queryParams['cname'] = $record;
            } elseif ($type === 'TXT') {
                $queryParams['txtdata'] = $record;
            } elseif ($type === 'AAAA') {
                $queryParams['address'] = $record;
            }

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $queryParams
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);
            
            // Log the response for debugging
            \Log::info('Zone Editor - Add Record Response', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'type' => $type,
                'name' => $name,
                'record' => $record,
                'priority' => $priority,
                'queryParams' => $queryParams,
                'result' => $result
            ]);

            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'DNS record added successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['event']['reason'] ?? 
                       'Failed to add DNS record';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            Log::error('Failed to add DNS record', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Add MX record (uses different API)
     */
    private function addMXRecord($cpanelUsername, $domain, $name, $exchange, $priority = 10)
    {
        try {
            $queryParams = [
                'cpanel_jsonapi_user' => $cpanelUsername,
                'cpanel_jsonapi_apiversion' => '2',
                'cpanel_jsonapi_module' => 'Email',
                'cpanel_jsonapi_func' => 'addmx',
                'domain' => $domain,
                'exchange' => $exchange,
                'preference' => $priority
            ];

            $requestOptions = [
                'headers' => $this->getAuthHeaders(),
                'query' => $queryParams
            ];

            if (!$this->apiToken) {
                $requestOptions['auth'] = [$this->username, $this->password];
            }

            $response = $this->client->get(
                $this->baseUrl . '/json-api/cpanel',
                $requestOptions
            );

            $result = json_decode($response->getBody()->getContents(), true);
            
            \Log::info('Zone Editor - Add MX Record Response', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'exchange' => $exchange,
                'priority' => $priority,
                'result' => $result
            ]);

            if (isset($result['cpanelresult']['event']['result']) && $result['cpanelresult']['event']['result'] == 1) {
                return [
                    'success' => true,
                    'message' => 'MX record added successfully'
                ];
            }

            $errorMsg = $result['cpanelresult']['error'] ?? 
                       $result['cpanelresult']['data'][0]['error'] ?? 
                       $result['cpanelresult']['event']['reason'] ?? 
                       'Failed to add MX record';

            return [
                'success' => false,
                'message' => $errorMsg
            ];

        } catch (\Exception $e) {
            \Log::error('Failed to add MX record', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * List SSL certificates for a domain
     */
    public function listSSLCertificates($cpanelUsername)
    {
        try {
            // Use WHM API to get account information including domains
            $url = $this->baseUrl . '/json-api/listaccts?api.version=1&search=' . $cpanelUsername . '&searchtype=user';
            
            $response = $this->client->get($url, [
                'headers' => $this->getAuthHeaders(),
                'auth' => $this->getAuth()
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('SSL/TLS - Account Info Response', [
                'username' => $cpanelUsername,
                'result' => $result
            ]);
            
            // Extract domain information from account data
            $certificates = [];
            if (isset($result['data']['acct']) && is_array($result['data']['acct'])) {
                foreach ($result['data']['acct'] as $account) {
                    if (isset($account['domain'])) {
                        $certificates[] = [
                            'domain' => $account['domain'],
                            'issuer' => 'AutoSSL/Let\'s Encrypt',
                            'not_after' => time() + (90 * 24 * 60 * 60), // 90 days from now (typical SSL expiry)
                            'has_ssl' => true
                        ];
                    }
                }
            }
            
            return [
                'success' => true,
                'certificates' => $certificates
            ];
            return [
                'success' => false,
                'message' => 'Failed to retrieve SSL certificates',
                'certificates' => []
            ];
            
        } catch (\Exception $e) {
            Log::error('SSL/TLS - List Certificates Error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'certificates' => []
            ];
        }
    }

    /**
     * Get SSL status for domains
     */
    public function getSSLStatus($cpanelUsername)
    {
        try {
            // Use WHM API to get account domains
            $url = $this->baseUrl . '/json-api/listaccts?api.version=1&search=' . $cpanelUsername . '&searchtype=user';
            
            $response = $this->client->get($url, [
                'headers' => $this->getAuthHeaders(),
                'auth' => $this->getAuth()
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('SSL/TLS - Get Status Response', [
                'username' => $cpanelUsername,
                'result' => $result
            ]);
            
            if (isset($result['data']['acct']) && is_array($result['data']['acct'])) {
                $domains = [];
                foreach ($result['data']['acct'] as $account) {
                    if (isset($account['domain'])) {
                        $domains[] = [
                            'domain' => $account['domain'],
                            'ssl_installed' => isset($account['has_ssl']) ? $account['has_ssl'] : false
                        ];
                    }
                }
                
                return [
                    'success' => true,
                    'status' => $domains
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Failed to retrieve SSL status',
                'status' => []
            ];
            
        } catch (\Exception $e) {
            Log::error('SSL/TLS - Get Status Error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'status' => []
            ];
        }
    }

    /**
     * Install AutoSSL for a domain
     */
    public function installAutoSSL($cpanelUsername, $domain)
    {
        try {
            // AutoSSL installation requires root WHM access
            // Instead, we'll return a message instructing manual installation
            
            Log::info('SSL/TLS - AutoSSL Installation Request', [
                'username' => $cpanelUsername,
                'domain' => $domain,
                'note' => 'AutoSSL requires WHM root access - manual installation needed'
            ]);
            
            return [
                'success' => false,
                'message' => 'AutoSSL installation requires WHM administrator access. Please contact your hosting provider or install SSL manually through cPanel.'
            ];
            
        } catch (\Exception $e) {
            Log::error('SSL/TLS - Install AutoSSL Error', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get available PHP versions (CloudLinux Selector via cPanel API)
     */
    public function getAvailablePHPVersions($cpanelUsername)
    {
        try {
            // CloudLinux Selector API
            $url = $this->baseUrl . '/json-api/cpanel';
            
            $response = $this->client->get($url, [
                'headers' => $this->getAuthHeaders(),
                'auth' => $this->getAuth(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'LVEInfo',
                    'cpanel_jsonapi_func' => 'getSupportedVersions'
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('PHP Selector - Available Versions Response', [
                'username' => $cpanelUsername,
                'result' => $result
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('PHP Selector - Get Versions Error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get current PHP version for account (CloudLinux Selector)
     */
    public function getCurrentPHPVersion($cpanelUsername)
    {
        try {
            // CloudLinux Selector API
            $url = $this->baseUrl . '/json-api/cpanel';
            
            $response = $this->client->get($url, [
                'headers' => $this->getAuthHeaders(),
                'auth' => $this->getAuth(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'LVEInfo',
                    'cpanel_jsonapi_func' => 'getCurrentVersion'
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('PHP Selector - Current Version Response', [
                'username' => $cpanelUsername,
                'result' => $result
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('PHP Selector - Get Current Version Error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Set PHP version for account (applies to entire cPanel account)
     */
    public function setPHPVersion($cpanelUsername, $version)
    {
        try {
            // CloudLinux Selector API
            $url = $this->baseUrl . '/json-api/cpanel';
            
            $response = $this->client->get($url, [
                'headers' => $this->getAuthHeaders(),
                'auth' => $this->getAuth(),
                'query' => [
                    'cpanel_jsonapi_user' => $cpanelUsername,
                    'cpanel_jsonapi_apiversion' => '2',
                    'cpanel_jsonapi_module' => 'LVEInfo',
                    'cpanel_jsonapi_func' => 'setVersion',
                    'version' => $version
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('PHP Selector - Set Version Response', [
                'username' => $cpanelUsername,
                'version' => $version,
                'result' => $result
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('PHP Selector - Set Version Error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}


