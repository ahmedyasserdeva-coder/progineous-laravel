<?php

namespace App\Services;

use App\Models\DomainRegistrar;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

/**
 * Dynadot API Integration Service
 * Supports both API v3 (Legacy) and RESTful API v1
 */
class DynadotService
{
    protected $registrar;
    protected $apiKey;
    protected $apiSecret;
    protected $testMode;

    const API_V3_BASE = 'https://api.dynadot.com/api3.json';
    const API_V3_SANDBOX = 'https://api-sandbox.dynadot.com/api3.json';
    const API_V1_BASE = 'https://api.dynadot.com/restful/v1';
    const API_V1_SANDBOX = 'https://api-sandbox.dynadot.com/restful/v1';

    public function __construct(?DomainRegistrar $registrar = null)
    {
        if ($registrar) {
            $this->registrar = $registrar;
            $this->apiKey = $registrar->api_key;
            $this->apiSecret = $registrar->api_secret;
            $this->testMode = $registrar->test_mode;
        }
    }

    public function setCredentials(string $apiKey, string $apiSecret, bool $testMode = false): self
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * Make RESTful API v1 request (NEW API - March 2025)
     * Documentation: https://www.dynadot.com/domain/api-document
     */
    protected function makeRestfulV1Request(string $method, string $endpoint, array $params = [], array $body = []): array
    {
        $baseUrl = 'https://api.dynadot.com/restful/v1';
        $url = $baseUrl . $endpoint;

        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $options = ['headers' => $headers];

            // Add query parameters for GET requests
            if ($method === 'GET' && !empty($params)) {
                $options['query'] = $params;
            }

            // Add body for POST/PUT requests
            if (in_array($method, ['POST', 'PUT', 'DELETE']) && !empty($body)) {
                $options['json'] = $body;
            }

            Log::info('Dynadot RESTful API v1 Request', [
                'method' => $method,
                'url' => $url,
                'params' => $params,
                'body' => $body
            ]);

            // Configure SSL certificate verification
            // On production (cPanel), PHP's default CA bundle will be used
            // On local (Laragon), use custom certificate path if available
            $http = Http::withHeaders($headers)->timeout(30);

            // Check if we're on local Laragon environment
            $laravelCertPath = base_path('../etc/ssl/cacert.pem');
            if (app()->environment('local') && file_exists($laravelCertPath)) {
                $http = $http->withOptions(['verify' => $laravelCertPath]);
            }
            // On production, let cURL use system's default CA bundle

            $response = $http->{strtolower($method)}($url, $method === 'GET' ? $params : $body);

            if (!$response->successful()) {
                throw new Exception("RESTful API v1 request failed with HTTP status: " . $response->status());
            }

            $data = $response->json();

            // Check for API errors
            if (isset($data['code']) && $data['code'] != 200) {
                $errorMsg = $data['message'] ?? 'Unknown API error';
                throw new Exception($errorMsg);
            }

            return $data;

        } catch (Exception $e) {
            Log::error('Dynadot RESTful API v1 Error', [
                'method' => $method,
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function makeV3Request(string $command, array $params = []): array
    {
        $url = $this->testMode ? self::API_V3_SANDBOX : self::API_V3_BASE;
        $params['key'] = $this->apiKey;
        $params['command'] = $command;

        try {
            // Configure SSL certificate verification
            // On production (cPanel), PHP's default CA bundle will be used
            // On local (Laragon), use custom certificate path if available
            $http = Http::timeout(30);

            // Check if we're on local Laragon environment
            $laravelCertPath = base_path('../etc/ssl/cacert.pem');
            if (app()->environment('local') && file_exists($laravelCertPath)) {
                $http = $http->withOptions(['verify' => $laravelCertPath]);
            }
            // On production, let cURL use system's default CA bundle

            $response = $http->get($url, $params);

            if (!$response->successful()) {
                throw new Exception("API v3 request failed with HTTP status: " . $response->status());
            }

            $data = $response->json();

            // Check if response is null (invalid JSON)
            if ($data === null) {
                Log::error('Dynadot API v3 Invalid Response', [
                    'command' => $command,
                    'response_body' => $response->body(),
                    'status' => $response->status(),
                ]);
                throw new Exception("Invalid JSON response from Dynadot API");
            }

            // Check for API errors in the Response object
            if (isset($data['Response']['ResponseCode']) && $data['Response']['ResponseCode'] != 0) {
                $errorMsg = $data['Response']['Error'] ?? 'Unknown API error (Code: ' . $data['Response']['ResponseCode'] . ')';

                // Log specific error for unauthorized IP
                if (stripos($errorMsg, 'unauthorized ip') !== false) {
                    Log::error('Dynadot API: Unauthorized IP Address', [
                        'error' => $errorMsg,
                        'command' => $command
                    ]);
                }

                throw new Exception($errorMsg);
            }

            // Legacy check for backward compatibility
            if (isset($data['ResponseCode']) && $data['ResponseCode'] != 0) {
                $errorMsg = $data['Error'] ?? 'Unknown API error';

                // Log specific error for unauthorized IP
                if (stripos($errorMsg, 'unauthorized ip') !== false) {
                    Log::error('Dynadot API: Unauthorized IP Address', [
                        'error' => $errorMsg,
                        'command' => $command
                    ]);
                }

                throw new Exception($errorMsg);
            }

            return $data;
        } catch (Exception $e) {
            Log::error('Dynadot API v3 Error', [
                'command' => $command,
                'error' => $e->getMessage(),
                'params' => array_diff_key($params, ['key' => '']), // Don't log API key
            ]);
            throw $e;
        }
    }

    public function testConnection(): array
    {
        try {
            $result = $this->makeV3Request('account_info');

            // Log the full response for debugging
            Log::info('Dynadot API Response', ['response' => $result]);

            // Dynadot API v3 structure for account_info command
            // Response structure: AccountInfoResponse > AccountInfo
            $accountInfo = $result['AccountInfoResponse']['AccountInfo']
                ?? $result['AccountInfo']
                ?? $result['Response']['AccountInfo']
                ?? null;

            if (!$accountInfo) {
                Log::warning('Unexpected Dynadot API structure', ['keys' => array_keys($result)]);
            }

            return [
                'success' => true,
                'message' => 'Dynadot API connection successful!',
                'account' => [
                    'username' => $accountInfo['Username'] ?? 'N/A',
                    'balance' => $accountInfo['AccountBalance'] ?? 'N/A',
                    'price_level' => $accountInfo['PriceLevel'] ?? 'N/A',
                ]
            ];
        } catch (Exception $e) {
            Log::error('Dynadot Connection Test Failed', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    public function searchDomains(array $domains, bool $showPrice = true, string $currency = 'USD'): array
    {
        $params = ['show_price' => $showPrice ? '1' : '0', 'currency' => $currency];
        foreach ($domains as $index => $domain) {
            $params["domain{$index}"] = $domain;
        }
        $result = $this->makeV3Request('search', $params);

        Log::info('Dynadot searchDomains raw result', ['result' => $result]);

        // Parse Dynadot response and normalize format
        // Dynadot returns: ResponseCode, SearchResults array
        $searchResults = $result['SearchResults'] ?? $result['SearchResponse']['SearchResults'] ?? [];
        $normalizedResults = [];

        foreach ($searchResults as $domainResult) {
            $normalizedResults[] = [
                'domain' => $domainResult['DomainName'] ?? '',
                'available' => ($domainResult['Available'] ?? 'no') === 'yes',
                'status' => $domainResult['Status'] ?? '',
                'price' => $domainResult['Price'] ?? null
            ];
        }

        Log::info('Dynadot searchDomains normalized', ['domains' => $normalizedResults]);

        return [
            'domains' => $normalizedResults,
            'raw' => $searchResults
        ];
    }

    /**
     * Register a domain with optional coupon code
     *
     * @param string $domain Domain name to register
     * @param int $duration Registration duration in years
     * @param array $options Additional options (currency, coupon, contacts, etc.)
     * @return array API response
     */
    public function registerDomain(string $domain, int $duration = 1, array $options = []): array
    {
        $params = [
            'domain' => $domain,
            'duration' => $duration,
            'currency' => $options['currency'] ?? 'USD'
        ];

        // Add coupon code if provided
        if (!empty($options['coupon'])) {
            $params['coupon'] = $options['coupon'];
        }

        // Merge additional options (contacts, premium flag, etc.)
        $params = array_merge($params, array_diff_key($options, ['currency' => '', 'coupon' => '']));

        return $this->makeV3Request('register', $params);
    }

    /**
     * Renew a domain with optional coupon code
     *
     * @param string $domain Domain name to renew
     * @param int $duration Renewal duration in years
     * @param array $options Additional options (currency, coupon, etc.)
     * @return array API response
     */
    public function renewDomain(string $domain, int $duration = 1, array $options = []): array
    {
        $params = [
            'domain' => $domain,
            'duration' => $duration,
            'currency' => $options['currency'] ?? 'USD'
        ];

        // Add coupon code if provided
        if (!empty($options['coupon'])) {
            $params['coupon'] = $options['coupon'];
        }

        // Merge additional options
        $params = array_merge($params, array_diff_key($options, ['currency' => '', 'coupon' => '']));

        return $this->makeV3Request('renew', $params);
    }

    /**
     * Transfer a domain with optional coupon code
     *
     * @param string $domain Domain name to transfer
     * @param string $authCode Authorization/EPP code
     * @param array $options Additional options (currency, coupon, contacts, etc.)
     * @return array API response
     */
    public function transferDomain(string $domain, string $authCode, array $options = []): array
    {
        $params = [
            'domain' => $domain,
            'auth' => $authCode,
            'currency' => $options['currency'] ?? 'USD'
        ];

        // Add coupon code if provided
        if (!empty($options['coupon'])) {
            $params['coupon'] = $options['coupon'];
        }

        // Merge additional options (contacts, privacy, nameservers, etc.)
        $params = array_merge($params, array_diff_key($options, ['currency' => '', 'coupon' => '']));

        Log::info('Dynadot transferDomain request', [
            'domain' => $domain,
            'has_auth_code' => !empty($authCode),
            'params_without_key' => array_diff_key($params, ['auth' => '']), // Don't log auth code
        ]);

        $result = $this->makeV3Request('transfer', $params);
        
        Log::info('Dynadot transferDomain response', [
            'domain' => $domain,
            'result' => $result,
        ]);

        return $result;
    }

    public function getDomainInfo(string $domain): array
    {
        $result = $this->makeV3Request('domain_info', ['domain' => $domain]);
        return $result['DomainInfoResponse']['DomainInfo'] ?? $result['DomainInfo'] ?? [];
    }

    /**
     * Get domain contact/WHOIS information from Dynadot
     * 
     * @param string $domain Domain name
     * @return array Contact information
     */
    public function getDomainContacts(string $domain): array
    {
        try {
            $info = $this->getDomainInfo($domain);
            
            if (empty($info)) {
                return [];
            }
            
            // Extract contact info from domain info response
            // Dynadot returns contact info within the domain info
            $contacts = [];
            
            // Get Whois info if available
            if (isset($info['Whois'])) {
                $whois = $info['Whois'];
                
                // Registrant contact - get full details using contact ID
                if (isset($whois['Registrant']['ContactId'])) {
                    $contactDetails = $this->getContactById($whois['Registrant']['ContactId']);
                    $contacts['registrant'] = $contactDetails ?: ['contact_id' => $whois['Registrant']['ContactId']];
                }
                
                // Admin contact
                if (isset($whois['Admin']['ContactId'])) {
                    $contactDetails = $this->getContactById($whois['Admin']['ContactId']);
                    $contacts['admin'] = $contactDetails ?: ['contact_id' => $whois['Admin']['ContactId']];
                }
                
                // Technical contact
                if (isset($whois['Technical']['ContactId'])) {
                    $contactDetails = $this->getContactById($whois['Technical']['ContactId']);
                    $contacts['technical'] = $contactDetails ?: ['contact_id' => $whois['Technical']['ContactId']];
                }
                
                // Billing contact
                if (isset($whois['Billing']['ContactId'])) {
                    $contactDetails = $this->getContactById($whois['Billing']['ContactId']);
                    $contacts['billing'] = $contactDetails ?: ['contact_id' => $whois['Billing']['ContactId']];
                }
            }
            
            // If no Whois section, try to get contact from ContactId
            if (empty($contacts) && isset($info['ContactId'])) {
                $contactDetails = $this->getContactById($info['ContactId']);
                $contacts['registrant'] = $contactDetails ?: ['contact_id' => $info['ContactId']];
            }
            
            return $contacts;
            
        } catch (\Exception $e) {
            Log::error('Failed to get domain contacts from Dynadot', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);
            
            return [];
        }
    }
    
    /**
     * Get contact details by contact ID
     * 
     * @param string|int $contactId Contact ID
     * @return array|null Contact details or null if not found
     */
    public function getContactById($contactId): ?array
    {
        try {
            $result = $this->makeV3Request('get_contact', ['contact_id' => $contactId]);
            
            // Parse the response
            $contact = $result['GetContactResponse']['GetContact'] 
                ?? $result['GetContact'] 
                ?? null;
            
            if ($contact) {
                return $this->parseContact($contact);
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Failed to get contact by ID from Dynadot', [
                'contact_id' => $contactId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
    
    /**
     * Parse contact information from Dynadot response
     */
    private function parseContact(array $contact): array
    {
        $fullName = $contact['Name'] ?? '';
        $nameParts = $this->splitName($fullName);
        
        // Convert country name to ISO code if needed
        $country = $contact['Country'] ?? '';
        $countryCode = $this->countryNameToCode($country);
        
        // Format phone with country code prefix
        $phoneNum = $contact['PhoneNum'] ?? '';
        $phoneCc = $contact['PhoneCc'] ?? '';
        $fullPhone = $phoneCc ? '+' . $phoneCc . $phoneNum : $phoneNum;
        
        return [
            'contact_id' => $contact['ContactId'] ?? null,
            'name' => $fullName,
            'first_name' => $nameParts['first_name'],
            'last_name' => $nameParts['last_name'],
            'organization' => $contact['Organization'] ?? '',
            'email' => $contact['Email'] ?? '',
            'phone' => $fullPhone,
            'phone_cc' => $phoneCc,
            'address1' => $contact['Address1'] ?? '',
            'address2' => $contact['Address2'] ?? '',
            'city' => $contact['City'] ?? '',
            'state' => $contact['State'] ?? '',
            'zip' => $contact['ZipCode'] ?? $contact['Zip'] ?? '',
            'postcode' => $contact['ZipCode'] ?? $contact['Zip'] ?? '',
            'country' => $countryCode,
        ];
    }
    
    /**
     * Split full name into first and last name
     */
    private function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName), 2);
        return [
            'first_name' => $parts[0] ?? '',
            'last_name' => $parts[1] ?? ''
        ];
    }
    
    /**
     * Convert country name to ISO 2-letter code
     */
    private function countryNameToCode(string $country): string
    {
        // If already a 2-letter code, return as-is
        if (strlen($country) === 2 && ctype_alpha($country)) {
            return strtoupper($country);
        }
        
        $countries = [
            'egypt' => 'EG',
            'united states' => 'US',
            'usa' => 'US',
            'united kingdom' => 'GB',
            'uk' => 'GB',
            'saudi arabia' => 'SA',
            'united arab emirates' => 'AE',
            'uae' => 'AE',
            'germany' => 'DE',
            'france' => 'FR',
            'canada' => 'CA',
            'australia' => 'AU',
            'india' => 'IN',
            'china' => 'CN',
            'japan' => 'JP',
            'south korea' => 'KR',
            'italy' => 'IT',
            'spain' => 'ES',
            'netherlands' => 'NL',
            'turkey' => 'TR',
            'jordan' => 'JO',
            'lebanon' => 'LB',
            'qatar' => 'QA',
            'bahrain' => 'BH',
            'oman' => 'OM',
            'kuwait' => 'KW',
            'iraq' => 'IQ',
            'syria' => 'SY',
            'palestine' => 'PS',
            'yemen' => 'YE',
            'algeria' => 'DZ',
            'morocco' => 'MA',
            'tunisia' => 'TN',
            'libya' => 'LY',
            'sudan' => 'SD',
        ];
        
        $key = strtolower(trim($country));
        return $countries[$key] ?? $country;
    }

    /**
     * Update domain contact/WHOIS information
     * 
     * @param string $domain Domain name
     * @param array $data Contact data with 'registrant' key
     * @return array Result with success status
     */
    public function updateDomainContacts(string $domain, array $data): array
    {
        try {
            $registrant = $data['registrant'] ?? [];
            
            // Parse phone number to separate country code and number
            $phoneData = $this->parsePhoneNumber($registrant['phone'] ?? '');
            
            // Build contact array for Dynadot
            $contact = [
                'name' => trim(($registrant['first_name'] ?? '') . ' ' . ($registrant['last_name'] ?? '')),
                'organization' => $registrant['organization'] ?? '',
                'email' => $registrant['email'] ?? '',
                'phone' => $phoneData['number'],
                'phone_cc' => $phoneData['country_code'],
                'address1' => $registrant['address1'] ?? '',
                'address2' => $registrant['address2'] ?? '',
                'city' => $registrant['city'] ?? '',
                'state' => $registrant['state'] ?? '',
                'postcode' => $registrant['zip'] ?? $registrant['postcode'] ?? '',
                'country' => $registrant['country'] ?? '',
            ];
            
            Log::info('Updating domain contacts', [
                'domain' => $domain,
                'contact' => $contact
            ]);
            
            // Use setContact which creates contact and assigns it to domain
            $result = $this->setContact($domain, $contact);
            
            Log::info('setContact result', ['result' => $result]);
            
            // Check for success - setWhois response
            if (isset($result['SetWhoisResponse']['ResponseCode']) && $result['SetWhoisResponse']['ResponseCode'] == 0) {
                return ['success' => true, 'message' => 'Contact information updated successfully'];
            }
            
            // Check for success - direct response
            if (isset($result['ResponseCode']) && $result['ResponseCode'] == 0) {
                return ['success' => true, 'message' => 'Contact information updated successfully'];
            }
            
            // Check if there was an error in createContact step
            if (isset($result['CreateContactResponse']['ResponseCode']) && $result['CreateContactResponse']['ResponseCode'] != 0) {
                $errorMessage = $result['CreateContactResponse']['Error'] ?? 'Failed to create contact';
                return ['success' => false, 'message' => $errorMessage];
            }
            
            // Return error message
            $errorMessage = $result['SetWhoisResponse']['Error'] 
                ?? $result['Error'] 
                ?? $result['CreateContactResponse']['Error'] 
                ?? 'Unknown error from Dynadot API';
            return ['success' => false, 'message' => $errorMessage];
            
        } catch (\Exception $e) {
            Log::error('Failed to update domain contacts', [
                'domain' => $domain,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Update a single contact type for a domain
     * 
     * @param string $domain Domain name
     * @param string $contactType Contact type: registrant, admin, technical, billing
     * @param array $contactData Contact information
     * @return array Result with success status
     */
    public function updateSingleContact(string $domain, string $contactType, array $contactData): array
    {
        try {
            // Parse phone number to separate country code and number
            $phoneData = $this->parsePhoneNumber($contactData['phone'] ?? '');
            
            // Build contact array for Dynadot
            $contact = [
                'name' => trim(($contactData['first_name'] ?? '') . ' ' . ($contactData['last_name'] ?? '')),
                'organization' => $contactData['organization'] ?? '',
                'email' => $contactData['email'] ?? '',
                'phone' => $phoneData['number'],
                'phone_cc' => $phoneData['country_code'],
                'address1' => $contactData['address1'] ?? '',
                'address2' => $contactData['address2'] ?? '',
                'city' => $contactData['city'] ?? '',
                'state' => $contactData['state'] ?? '',
                'postcode' => $contactData['zip'] ?? $contactData['postcode'] ?? '',
                'country' => $contactData['country'] ?? '',
            ];
            
            Log::info('Updating single domain contact', [
                'domain' => $domain,
                'contact_type' => $contactType,
                'contact' => $contact
            ]);
            
            // Get existing contacts to preserve other contact IDs
            $existingContacts = $this->getDomainContacts($domain);
            
            Log::info('Existing contacts', ['contacts' => $existingContacts]);
            
            // First, create the new contact
            $createResult = $this->createContact($contact);
            
            Log::info('createContact result', ['result' => $createResult]);
            
            // Check if contact was created successfully
            $newContactId = null;
            if (isset($createResult['CreateContactResponse']['ResponseCode']) &&
                $createResult['CreateContactResponse']['ResponseCode'] == 0) {
                $newContactId = $createResult['CreateContactResponse']['CreateContactContent']['ContactId'] ?? null;
            } elseif (isset($createResult['ResponseCode']) && $createResult['ResponseCode'] == 0) {
                $newContactId = $createResult['CreateContactContent']['ContactId'] ?? null;
            }
            
            if ($newContactId === null) {
                $errorMessage = $createResult['CreateContactResponse']['Error'] 
                    ?? $createResult['Error'] 
                    ?? 'Failed to create contact';
                return ['success' => false, 'message' => $errorMessage];
            }
            
            // Build params with all contact types
            // Use existing contact IDs for unchanged types, new ID for the updated type
            $contactTypes = ['registrant', 'admin', 'technical', 'billing'];
            $params = ['domain' => $domain];
            
            foreach ($contactTypes as $type) {
                $apiParam = $type . '_contact';
                
                if ($type === $contactType) {
                    // Use the new contact ID for the type being updated
                    $params[$apiParam] = $newContactId;
                } else {
                    // Use existing contact ID if available
                    $existingId = $existingContacts[$type]['contact_id'] ?? null;
                    if ($existingId) {
                        $params[$apiParam] = $existingId;
                    } else {
                        // If no existing contact, use the new one (first time setup)
                        $params[$apiParam] = $newContactId;
                    }
                }
            }
            
            Log::info('set_whois params', ['params' => $params]);
            
            $result = $this->makeV3Request('set_whois', $params);
            
            Log::info('set_whois result', ['result' => $result]);
            
            // Check for success
            if (isset($result['SetWhoisResponse']['ResponseCode']) && $result['SetWhoisResponse']['ResponseCode'] == 0) {
                return ['success' => true, 'message' => 'Contact updated successfully'];
            }
            
            if (isset($result['ResponseCode']) && $result['ResponseCode'] == 0) {
                return ['success' => true, 'message' => 'Contact updated successfully'];
            }
            
            // Return error message
            $errorMessage = $result['SetWhoisResponse']['Error'] 
                ?? $result['Error'] 
                ?? 'Unknown error from Dynadot API';
            return ['success' => false, 'message' => $errorMessage];
            
        } catch (\Exception $e) {
            Log::error('Failed to update single domain contact', [
                'domain' => $domain,
                'contact_type' => $contactType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Parse phone number to extract country code and number
     */
    private function parsePhoneNumber(string $phone): array
    {
        // Remove spaces, dashes, and parentheses
        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        
        // Country codes mapping (sorted by length descending to match longest first)
        $countryCodes = [
            '+971' => '971', // UAE
            '+966' => '966', // Saudi Arabia
            '+962' => '962', // Jordan
            '+961' => '961', // Lebanon
            '+974' => '974', // Qatar
            '+973' => '973', // Bahrain
            '+968' => '968', // Oman
            '+965' => '965', // Kuwait
            '+213' => '213', // Algeria
            '+216' => '216', // Tunisia
            '+212' => '212', // Morocco
            '+218' => '218', // Libya
            '+249' => '249', // Sudan
            '+964' => '964', // Iraq
            '+963' => '963', // Syria
            '+970' => '970', // Palestine
            '+967' => '967', // Yemen
            '+20' => '20',   // Egypt
            '+44' => '44',   // UK
            '+49' => '49',   // Germany
            '+33' => '33',   // France
            '+39' => '39',   // Italy
            '+34' => '34',   // Spain
            '+31' => '31',   // Netherlands
            '+90' => '90',   // Turkey
            '+91' => '91',   // India
            '+86' => '86',   // China
            '+81' => '81',   // Japan
            '+82' => '82',   // South Korea
            '+61' => '61',   // Australia
            '+1' => '1',     // USA/Canada
        ];
        
        foreach ($countryCodes as $prefix => $code) {
            if (str_starts_with($phone, $prefix)) {
                $number = substr($phone, strlen($prefix));
                return [
                    'country_code' => $code,
                    'number' => $number
                ];
            }
        }
        
        // If no country code found, assume it's the full number with default country code
        // Remove leading zeros
        $phone = ltrim($phone, '0');
        
        return [
            'country_code' => '1', // Default to USA
            'number' => $phone
        ];
    }

    /**
     * Extract country code from phone number
     */
    private function extractPhoneCountryCode(string $phone): string
    {
        // Remove non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Common country codes mapping
        $countryCodes = [
            '+20' => '20',   // Egypt
            '+1' => '1',     // USA/Canada
            '+44' => '44',   // UK
            '+971' => '971', // UAE
            '+966' => '966', // Saudi Arabia
            '+962' => '962', // Jordan
            '+961' => '961', // Lebanon
        ];
        
        foreach ($countryCodes as $prefix => $code) {
            if (str_starts_with($phone, $prefix)) {
                return $code;
            }
        }
        
        // Default to 1 (USA)
        return '1';
    }

    /**
     * Get raw domain info response for debugging
     */
    public function getDomainInfoRaw(string $domain): array
    {
        return $this->makeV3Request('domain_info', ['domain' => $domain]);
    }

    /**
     * Get domain status from Dynadot and map it to our system statuses
     *
     * Dynadot Status Values (from API docs):
     * - active: Domain is registered and working
     * - moved: Domain transferred away
     * - expired: Domain has expired
     * - grace_period: Domain is in grace period after expiry
     * - redemption_period: Domain is in redemption period
     * - pending_transfer: Domain transfer is in progress
     *
     * @param string $domain Domain name to check
     * @return array ['dynadot_status' => string, 'system_status' => string, 'info' => array]
     */
    public function getDomainStatus(string $domain): array
    {
        try {
            $info = $this->getDomainInfo($domain);

            if (empty($info)) {
                return [
                    'dynadot_status' => 'not_found',
                    'system_status' => \App\Models\Domain::STATUS_PENDING,
                    'info' => [],
                    'error' => 'Domain not found in Dynadot account'
                ];
            }

            $dynadotStatus = strtolower($info['Status'] ?? 'unknown');

            // Map Dynadot status to our system status
            $systemStatus = $this->mapDynadotStatusToSystem($dynadotStatus);

            return [
                'dynadot_status' => $dynadotStatus,
                'system_status' => $systemStatus,
                'info' => [
                    'name' => $info['Name'] ?? $domain,
                    'expiration' => isset($info['Expiration']) ? (int)$info['Expiration'] : null,
                    'registration' => isset($info['Registration']) ? (int)$info['Registration'] : null,
                    'locked' => strtolower($info['Locked'] ?? 'no') === 'yes',
                    'privacy' => $info['Privacy'] ?? 'none',
                    'auto_renew' => strtolower($info['RenewOption'] ?? '') === 'auto',
                ],
            ];

        } catch (Exception $e) {
            Log::error('Failed to get domain status from Dynadot', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);

            return [
                'dynadot_status' => 'error',
                'system_status' => \App\Models\Domain::STATUS_PENDING,
                'info' => [],
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Map Dynadot status to our system status constants
     *
     * @param string $dynadotStatus Status from Dynadot API
     * @return string System status constant
     */
    public function mapDynadotStatusToSystem(string $dynadotStatus): string
    {
        return match($dynadotStatus) {
            'active' => \App\Models\Domain::STATUS_ACTIVE,
            'grace_period', 'grace period' => \App\Models\Domain::STATUS_GRACE_PERIOD,
            'redemption_period', 'redemption period' => \App\Models\Domain::STATUS_REDEMPTION_PERIOD,
            'expired' => \App\Models\Domain::STATUS_EXPIRED,
            'moved', 'transferred_away', 'transferred away' => \App\Models\Domain::STATUS_TRANSFERRED_AWAY,
            'pending_transfer', 'pending transfer' => \App\Models\Domain::STATUS_PENDING_TRANSFER,
            'cancelled', 'deleted' => \App\Models\Domain::STATUS_CANCELLED,
            default => \App\Models\Domain::STATUS_PENDING,
        };
    }

    /**
     * Get transfer status for a domain
     *
     * @param string $domain Domain name
     * @param string $type 'in' for transfer in, 'away' for transfer out
     * @return array Transfer status information
     */
    public function getTransferStatus(string $domain, string $type = 'in'): array
    {
        try {
            $result = $this->makeV3Request('get_transfer_status', [
                'domain' => $domain,
                'transfer_type' => $type
            ]);

            return $result['TransferList'] ?? [];

        } catch (Exception $e) {
            Log::error('Failed to get transfer status', [
                'domain' => $domain,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Sync domain status from Dynadot to local database
     *
     * @param \App\Models\Domain $domain Domain model instance
     * @return bool True if status was updated
     */
    public function syncDomainStatus(\App\Models\Domain $domain): bool
    {
        try {
            $statusInfo = $this->getDomainStatus($domain->domain_name);

            if (isset($statusInfo['error'])) {
                Log::warning('Could not sync domain status', [
                    'domain_id' => $domain->id,
                    'domain_name' => $domain->domain_name,
                    'error' => $statusInfo['error'],
                ]);
                return false;
            }

            $oldStatus = $domain->status;
            $newStatus = $statusInfo['system_status'];

            // Update domain record
            $updateData = ['status' => $newStatus];

            // Update expiry date if available
            if (!empty($statusInfo['info']['expiration'])) {
                $updateData['expiry_date'] = \Carbon\Carbon::createFromTimestampMs($statusInfo['info']['expiration']);
            }

            // Update registration date if not set
            if (empty($domain->registration_date) && !empty($statusInfo['info']['registration'])) {
                $updateData['registration_date'] = \Carbon\Carbon::createFromTimestampMs($statusInfo['info']['registration']);
            }

            // Update auto_renew
            if (isset($statusInfo['info']['auto_renew'])) {
                $updateData['auto_renew'] = $statusInfo['info']['auto_renew'];
            }

            $domain->update($updateData);

            // Log status change
            if ($oldStatus !== $newStatus) {
                Log::info('Domain status synced from Dynadot', [
                    'domain_id' => $domain->id,
                    'domain_name' => $domain->domain_name,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'dynadot_status' => $statusInfo['dynadot_status'],
                ]);
            }

            return true;

        } catch (Exception $e) {
            Log::error('Failed to sync domain status', [
                'domain_id' => $domain->id,
                'domain_name' => $domain->domain_name,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function listDomains(int $page = 1, int $perPage = 100): array
    {
        $result = $this->makeV3Request('list_domain', ['page_index' => $page, 'count_per_page' => $perPage]);
        return $result['MainDomains'] ?? [];
    }

    public function setNameservers(string $domain, array $nameservers): array
    {
        $params = ['domain' => $domain];
        foreach ($nameservers as $index => $ns) {
            $params["ns{$index}"] = $ns;
        }
        return $this->makeV3Request('set_ns', $params);
    }

    /**
     * Get nameservers for a domain from Dynadot API
     */
    public function getNameservers(string $domain): array
    {
        try {
            $info = $this->getDomainInfo($domain);

            if (empty($info)) {
                return [];
            }

            $nameservers = [];

            // Check NameServerSettings first
            if (isset($info['NameServerSettings'])) {
                $nsSettings = $info['NameServerSettings'];
                $type = $nsSettings['Type'] ?? '';

                // If using Dynadot DNS (Dynadot manages DNS)
                if ($type === 'Dynadot DNS' || $type === 'Dynadot Parking' || $type === 'Dynadot Hosting') {
                    // Return Dynadot's default nameservers
                    return [
                        'ns1.dynadot.com',
                        'ns2.dynadot.com'
                    ];
                }

                // If using custom nameservers
                if ($type === 'Name Servers' && isset($nsSettings['NameServers'])) {
                    foreach ($nsSettings['NameServers'] as $ns) {
                        if (isset($ns['ServerName']) && !empty($ns['ServerName'])) {
                            $nameservers[] = $ns['ServerName'];
                        } elseif (is_string($ns) && !empty($ns)) {
                            $nameservers[] = $ns;
                        }
                    }
                }
            }

            // Check for NameServers array format at root level
            if (empty($nameservers) && isset($info['NameServers']) && is_array($info['NameServers'])) {
                foreach ($info['NameServers'] as $ns) {
                    if (isset($ns['ServerName'])) {
                        $nameservers[] = $ns['ServerName'];
                    } elseif (is_string($ns)) {
                        $nameservers[] = $ns;
                    }
                }
            }

            // Check for individual Ns0, Ns1, etc format
            if (empty($nameservers)) {
                for ($i = 0; $i <= 12; $i++) {
                    $key = "Ns{$i}";
                    if (isset($info[$key]) && !empty($info[$key])) {
                        $nameservers[] = $info[$key];
                    }
                    $key = "ns{$i}";
                    if (isset($info[$key]) && !empty($info[$key])) {
                        $nameservers[] = $info[$key];
                    }
                }
            }

            return array_values(array_unique(array_filter($nameservers)));

        } catch (\Exception $e) {
            Log::error('Failed to get nameservers from Dynadot', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    public function lockDomain(string $domain): array
    {
        return $this->makeV3Request('lock_domain', ['domain' => $domain]);
    }

    public function unlockDomain(string $domain): array
    {
        // Dynadot uses get_transfer_auth_code with unlock_domain_for_transfer=1 to unlock
        return $this->makeV3Request('get_transfer_auth_code', [
            'domain' => $domain,
            'unlock_domain_for_transfer' => '1'
        ]);
    }

    /**
     * Set domain renewal option (Auto Renew)
     * @param string $domain Domain name
     * @param string $option Renew option: 'auto', 'donot', or 'reset' (let expire)
     * @return array
     */
    public function setRenewOption(string $domain, string $option = 'auto'): array
    {
        return $this->makeV3Request('set_renew_option', [
            'domain' => $domain,
            'renew_option' => $option
        ]);
    }

    /**
     * Set domain privacy (WHOIS protection)
     * @param string $domain Domain name
     * @param string $option Privacy option: 'full', 'partial', or 'off'
     * @return array
     */
    public function setPrivacy(string $domain, string $option = 'full'): array
    {
        return $this->makeV3Request('set_privacy', [
            'domain' => $domain,
            'option' => $option
        ]);
    }

    public function getTransferAuthCode(string $domain, bool $generateNew = false): array
    {
        return $this->makeV3Request('get_transfer_auth_code', ['domain' => $domain, 'new_code' => $generateNew ? '1' : '0']);
    }

    /**
     * Delete/Cancel domain registration
     * WARNING: This action is IRREVERSIBLE and NO REFUND will be given
     * Only works during grace period (usually first 5 days after registration)
     *
     * @param string $domain Domain name to delete
     * @return array API response
     */
    public function deleteDomain(string $domain): array
    {
        return $this->makeV3Request('delete_registration', [
            'domain' => $domain
        ]);
    }

    /**
     * Create a contact in Dynadot account
     *
     * @param array $contact Contact details
     * @return array API response with ContactId
     */
    public function createContact(array $contact): array
    {
        $params = [
            'name' => $contact['name'] ?? '',
            'email' => $contact['email'] ?? '',
            'phonenum' => $contact['phone'] ?? '',
            'phonecc' => $contact['phone_cc'] ?? '1',
            'address1' => $contact['address1'] ?? '',
            'city' => $contact['city'] ?? '',
            'state' => $contact['state'] ?? '',
            'zip' => $contact['postcode'] ?? '',
            'country' => $contact['country'] ?? '',
        ];

        // Add optional fields
        if (!empty($contact['organization'])) {
            $params['organization'] = $contact['organization'];
        }
        if (!empty($contact['address2'])) {
            $params['address2'] = $contact['address2'];
        }

        // Remove empty values
        $params = array_filter($params, fn($v) => $v !== '');

        return $this->makeV3Request('create_contact', $params);
    }

    /**
     * Set WHOIS contact for a domain using contact IDs
     *
     * @param string $domain Domain name
     * @param string $contactId Contact ID for all contact types
     * @return array API response
     */
    public function setWhois(string $domain, string $contactId): array
    {
        $params = [
            'domain' => $domain,
            'registrant_contact' => $contactId,
            'admin_contact' => $contactId,
            'technical_contact' => $contactId,
            'billing_contact' => $contactId,
        ];

        return $this->makeV3Request('set_whois', $params);
    }

    /**
     * Set contact/WHOIS information for a domain
     * This creates a contact first, then assigns it to the domain
     *
     * @param string $domain Domain name
     * @param array $contact Contact information array
     * @return array API response
     */
    public function setContact(string $domain, array $contact): array
    {
        // First, create the contact
        $createResult = $this->createContact($contact);

        // Check if contact was created successfully
        if (isset($createResult['CreateContactResponse']['ResponseCode']) &&
            $createResult['CreateContactResponse']['ResponseCode'] == 0) {

            $contactId = $createResult['CreateContactResponse']['CreateContactContent']['ContactId'] ?? null;

            if ($contactId !== null) {
                // Now set the WHOIS with the contact ID
                return $this->setWhois($domain, (string)$contactId);
            }
        }

        // Check alternative response format
        if (isset($createResult['ResponseCode']) && $createResult['ResponseCode'] == 0) {
            $contactId = $createResult['CreateContactContent']['ContactId'] ?? null;

            if ($contactId !== null) {
                return $this->setWhois($domain, (string)$contactId);
            }
        }

        // Return the create result if something went wrong
        return $createResult;
    }

    /**
     * Get list of available coupons from Dynadot
     *
     * @param string $type Coupon type: 'registration', 'renewal', or 'transfer'
     * @return array List of available coupons with details
     */
    public function listCoupons(string $type = 'registration'): array
    {
        $validTypes = ['registration', 'renewal', 'transfer'];
        if (!in_array($type, $validTypes)) {
            throw new Exception("Invalid coupon type. Must be one of: " . implode(', ', $validTypes));
        }

        $result = $this->makeV3Request('list_coupons', ['coupon_type' => $type]);

        // Return the coupons array from the response
        return $result['Coupons'] ?? [];
    }

    public function getTLDPricing(string $currency = 'USD'): array
    {
        $result = $this->makeV3Request('tld_price', ['currency' => $currency]);
        Log::info('Dynadot API Raw Response for tld_price', [
            'has_TldPrice' => isset($result['TldPrice']),
            'has_TldPriceResponse' => isset($result['TldPriceResponse']),
            'keys' => array_keys($result),
            'sample' => array_slice($result, 0, 2, true)
        ]);

        // Try different response structures
        if (isset($result['TldPriceResponse']['TldPrice'])) {
            $tlds = $result['TldPriceResponse']['TldPrice'];
        } elseif (isset($result['TldPrice'])) {
            $tlds = $result['TldPrice'];
        } else {
            return [];
        }

        // Convert array of TLD objects to associative array with TLD as key
        $pricing = [];
        foreach ($tlds as $tld) {
            if (isset($tld['Tld']) && isset($tld['Price'])) {
                $tldName = ltrim($tld['Tld'], '.');
                $pricing[$tldName] = $tld['Price'];
            }
        }

        return $pricing;
    }

    public function getAccountInfo(): array
    {
        $result = $this->makeV3Request('account_info');
        return $result['AccountInfo'] ?? [];
    }

    public function getAccountBalance(): array
    {
        $result = $this->makeV3Request('get_account_balance');
        return ['balance' => $result['AccountBalance'] ?? '0.00', 'currency' => $result['Currency'] ?? 'USD'];
    }

    public function isDomainAvailable(string $domain): bool
    {
        try {
            $result = $this->searchDomains([$domain], false);
            return isset($result['SearchResults'][0]['Available']) && strtolower($result['SearchResults'][0]['Available']) === 'yes';
        } catch (Exception $e) {
            Log::error('Domain availability check failed', ['domain' => $domain, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function getDomainPrice(string $domain, string $currency = 'USD'): ?array
    {
        try {
            $result = $this->searchDomains([$domain], true, $currency);
            if (isset($result['SearchResults'][0])) {
                return [
                    'domain' => $result['SearchResults'][0]['DomainName'] ?? $domain,
                    'available' => $result['SearchResults'][0]['Available'] ?? 'no',
                    'price' => $result['SearchResults'][0]['Price'] ?? 'N/A',
                    'currency' => $currency
                ];
            }
            return null;
        } catch (Exception $e) {
            Log::error('Domain price check failed', ['domain' => $domain, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Check if domain is transferable
     * Validates:
     * 1. Domain exists and is not available
     * 2. Domain is not already in our account
     * 3. Domain is not locked
     * 4. Transfer is allowed
     *
     * @param string $domain The domain name to check
     * @param string|null $authCode The EPP/Auth code (optional for checking)
     * @return array Result with status and message
     */
    public function checkTransferEligibility(string $domain, ?string $authCode = null): array
    {
        try {
            // First, check if domain is already in our account
            $isOwnedByUs = $this->checkIfDomainInAccount($domain);

            if ($isOwnedByUs) {
                return [
                    'eligible' => false,
                    'reason' => 'domain_already_registered',
                    'message' => __('frontend.domain_already_registered_with_us'),
                ];
            }

            // Check if domain is available (if available, cannot transfer)
            $searchResult = $this->searchDomains([$domain]);

            if (!isset($searchResult['domains'][0])) {
                return [
                    'eligible' => false,
                    'reason' => 'domain_not_found',
                    'message' => __('frontend.domain_not_found'),
                ];
            }

            $domainInfo = $searchResult['domains'][0];

            // If domain is available, it means it's not registered
            if ($domainInfo['available'] === true) {
                return [
                    'eligible' => false,
                    'reason' => 'domain_available',
                    'message' => __('frontend.domain_available_cannot_transfer'),
                ];
            }

            // Domain exists and is not available, so it's registered
            // Check transfer eligibility
            $tld = $this->extractTld($domain);
            $transferPrice = $this->getTransferPrice($tld);

            return [
                'eligible' => true,
                'domain' => $domain,
                'tld' => $tld,
                'transfer_price' => $transferPrice,
                'message' => __('frontend.domain_transfer_eligible'),
                'notes' => [
                    __('frontend.transfer_note_1'),
                    __('frontend.transfer_note_2'),
                    __('frontend.transfer_note_3'),
                ]
            ];

        } catch (Exception $e) {
            Log::error('Transfer eligibility check failed', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);

            return [
                'eligible' => false,
                'reason' => 'api_error',
                'message' => __('frontend.transfer_check_failed'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Extract TLD from domain name
     */
    private function extractTld(string $domain): string
    {
        $parts = explode('.', $domain);
        return end($parts);
    }

    /**
     * Check if domain is already in our Dynadot account
     * Uses list_domain API command
     *
     * @param string $domain The domain name to check
     * @return bool True if domain is in our account, false otherwise
     */
    private function checkIfDomainInAccount(string $domain): bool
    {
        try {
            // Use list_domain API to get all domains in account
            // We'll check by searching for the specific domain
            $response = $this->makeV3Request('list_domain');

            if (!isset($response['ListDomainInfoResponse'])) {
                return false;
            }

            $responseData = $response['ListDomainInfoResponse'];

            // Check if request was successful
            if ($responseData['ResponseCode'] != 0 || $responseData['Status'] !== 'success') {
                return false;
            }

            // Check if we have domain list
            if (!isset($responseData['MainDomains']) || !is_array($responseData['MainDomains'])) {
                return false;
            }

            // Normalize domain for comparison (lowercase)
            $domainToCheck = strtolower(trim($domain));

            // Search for the domain in our account
            foreach ($responseData['MainDomains'] as $domainInfo) {
                if (isset($domainInfo['Name'])) {
                    $accountDomain = strtolower(trim($domainInfo['Name']));
                    if ($accountDomain === $domainToCheck) {
                        return true;
                    }
                }
            }

            return false;

        } catch (Exception $e) {
            Log::error('Failed to check if domain is in account', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);
            // In case of error, allow the transfer to proceed
            // (better to let Dynadot reject than block legitimate transfers)
            return false;
        }
    }

    /**
     * Get transfer price for a TLD
     */
    private function getTransferPrice(string $tld): ?float
    {
        try {
            // Get pricing from database
            $pricing = \App\Models\DomainPricing::where('tld', $tld)->first();
            if ($pricing) {
                return (float) $pricing->progineous_transfer;
            }
            return null;
        } catch (Exception $e) {
            Log::error('Failed to get transfer price', ['tld' => $tld, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Search aftermarket domains (RESTful API v1 - March 2025)
     * Uses GET /aftermarket/listings endpoint
     * Documentation: https://www.dynadot.com/domain/api-document
     */
    public function searchAftermarket(array $filters = []): array
    {
        try {
            // Dynadot RESTful API v1 parameters
            $params = [
                'currency' => $filters['currency'] ?? 'USD',
                'exclude_pending_sale' => true,
                'show_other_registrar' => false,
                'count_per_page' => $filters['per_page'] ?? 50,
                'page_index' => $filters['page'] ?? 1,
            ];

            Log::info('Dynadot Aftermarket Search (RESTful API v1)', [
                'params' => $params,
                'filters' => $filters
            ]);

            $response = $this->makeRestfulV1Request('GET', '/aftermarket/listings', $params);

            // Parse response
            if (isset($response['data']['listing_item_list'])) {
                $domains = $response['data']['listing_item_list'];

                // Apply client-side filters
                $domains = $this->filterDomains($domains, $filters);

                Log::info('Dynadot Aftermarket: Found domains', [
                    'count' => count($domains),
                    'total_before_filter' => count($response['data']['listing_item_list'])
                ]);

                return [
                    'success' => true,
                    'domains' => array_values($domains), // Re-index array
                    'total' => count($domains),
                    'page' => $params['page_index'],
                ];
            }

            Log::warning('Dynadot Aftermarket: No listing_item_list in response', [
                'response_keys' => array_keys($response)
            ]);

            return [
                'success' => true,
                'domains' => [],
                'total' => 0,
                'page' => 1,
            ];

        } catch (Exception $e) {
            Log::error('Aftermarket search failed', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'domains' => [],
                'total' => 0,
            ];
        }
    }

    /**
     * Filter domains based on user criteria
     */
    private function filterDomains(array $domains, array $filters): array
    {
        return array_filter($domains, function($domain) use ($filters) {
            // Filter by keyword/search term
            if (!empty($filters['keyword'])) {
                $keyword = strtolower(trim($filters['keyword']));
                $domainName = strtolower($domain['domain'] ?? '');
                if (strpos($domainName, $keyword) === false) {
                    return false;
                }
            }

            // Filter by minimum price
            if (!empty($filters['min_price'])) {
                $price = floatval($domain['price'] ?? 0);
                if ($price < floatval($filters['min_price'])) {
                    return false;
                }
            }

            // Filter by maximum price
            if (!empty($filters['max_price'])) {
                $price = floatval($domain['price'] ?? 0);
                if ($price > floatval($filters['max_price'])) {
                    return false;
                }
            }

            // Filter by minimum length
            if (!empty($filters['min_length'])) {
                $domainName = $domain['domain'] ?? '';
                // Remove TLD for length calculation
                $domainWithoutTld = explode('.', $domainName)[0] ?? '';
                $length = strlen($domainWithoutTld);
                if ($length < intval($filters['min_length'])) {
                    return false;
                }
            }

            // Filter by maximum length
            if (!empty($filters['max_length'])) {
                $domainName = $domain['domain'] ?? '';
                // Remove TLD for length calculation
                $domainWithoutTld = explode('.', $domainName)[0] ?? '';
                $length = strlen($domainWithoutTld);
                if ($length > intval($filters['max_length'])) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Get aftermarket domain details (RESTful API v1)
     * Uses GET /aftermarket/listings/{domain_name
     */
    public function getAftermarketDomainInfo(string $domain): array
    {
        try {
            $params = ['currency' => 'USD'];

            $response = $this->makeRestfulV1Request('GET', "/aftermarket/listings/{$domain}", $params);

            if (isset($response['data']['listing_item'])) {
                return [
                    'success' => true,
                    'domain' => $response['data']['listing_item']
                ];
            }

            return [
                'success' => false,
                'error' => 'Domain not found in aftermarket'
            ];

        } catch (Exception $e) {
            Log::error('Failed to get aftermarket domain info', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Buy domain from aftermarket (RESTful API v1)
     * Uses POST /aftermarket/listings/{domain_name}/buy_it_now
     */
    public function buyAftermarketDomain(string $domain): array
    {
        try {
            $body = ['currency' => 'USD'];

            $response = $this->makeRestfulV1Request(
                'POST',
                "/aftermarket/listings/{$domain}/buy_it_now",
                [],
                $body
            );

            return [
                'success' => true,
                'message' => 'Domain purchased successfully',
                'data' => $response,
            ];
        } catch (Exception $e) {
            Log::error('Failed to buy aftermarket domain', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get WHOIS information for a domain
     * Uses socket-based WHOIS lookup
     */
    public function getWhoisInfo(string $domain): array
    {
        try {
            Log::info('WHOIS Lookup Request', ['domain' => $domain]);

            // Perform WHOIS lookup
            $whoisData = $this->performWhoisLookup($domain);

            if (empty($whoisData)) {
                throw new Exception('No WHOIS data received');
            }

            Log::info('WHOIS Lookup Success', ['domain' => $domain, 'length' => strlen($whoisData)]);

            // Parse and format the WHOIS data
            return $this->parseWhoisData($domain, $whoisData);

        } catch (Exception $e) {
            Log::error('WHOIS lookup failed', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);

            throw new Exception('Failed to retrieve WHOIS information: ' . $e->getMessage());
        }
    }

    /**
     * Perform WHOIS lookup using socket connection
     */
    private function performWhoisLookup(string $domain): string
    {
        // Determine WHOIS server based on TLD
        $tld = strtolower(substr($domain, strrpos($domain, '.') + 1));
        $whoisServer = $this->getWhoisServer($tld);

        Log::info('WHOIS Server', ['domain' => $domain, 'tld' => $tld, 'server' => $whoisServer]);

        // Connect to WHOIS server
        $fp = @fsockopen($whoisServer, 43, $errno, $errstr, 10);

        if (!$fp) {
            throw new Exception("Cannot connect to WHOIS server: $errstr ($errno)");
        }

        // Send domain query
        fputs($fp, $domain . "\r\n");

        // Read response
        $whoisData = '';
        while (!feof($fp)) {
            $whoisData .= fgets($fp, 128);
        }

        fclose($fp);

        return $whoisData;
    }

    /**
     * Get WHOIS server for TLD
     */
    private function getWhoisServer(string $tld): string
    {
        $servers = [
            'com' => 'whois.verisign-grs.com',
            'net' => 'whois.verisign-grs.com',
            'org' => 'whois.pir.org',
            'info' => 'whois.afilias.net',
            'biz' => 'whois.biz',
            'us' => 'whois.nic.us',
            'uk' => 'whois.nic.uk',
            'ca' => 'whois.cira.ca',
            'de' => 'whois.denic.de',
            'eu' => 'whois.eu',
            'fr' => 'whois.nic.fr',
            'it' => 'whois.nic.it',
            'nl' => 'whois.domain-registry.nl',
            'be' => 'whois.dns.be',
            'au' => 'whois.auda.org.au',
            'jp' => 'whois.jprs.jp',
            'cn' => 'whois.cnnic.cn',
            'in' => 'whois.registry.in',
            'io' => 'whois.nic.io',
            'ai' => 'whois.nic.ai',
            'me' => 'whois.nic.me',
            'co' => 'whois.nic.co',
            'tv' => 'whois.nic.tv',
            'cc' => 'whois.nic.cc',
            'ws' => 'whois.website.ws',
            'mobi' => 'whois.dotmobiregistry.net',
            'name' => 'whois.nic.name',
            'asia' => 'whois.nic.asia',
            'tel' => 'whois.nic.tel',
        ];

        return $servers[$tld] ?? 'whois.iana.org';
    }

    /**
     * Parse WHOIS data into structured format
     */
    private function parseWhoisData(string $domain, string $rawData): array
    {
        // Extract common WHOIS fields using regex
        $parsed = [
            'DomainInfo' => [
                'Name' => $domain,
                'Registrar' => $this->extractWhoisValue($rawData, ['Registrar:', 'registrar:']),
                'Created' => $this->extractWhoisValue($rawData, ['Creation Date:', 'Created Date:', 'Created On:', 'created:']),
                'Expires' => $this->extractWhoisValue($rawData, ['Expiry Date:', 'Expiration Date:', 'Registry Expiry Date:', 'Registrar Registration Expiration Date:', 'expires:']),
                'Updated' => $this->extractWhoisValue($rawData, ['Updated Date:', 'Last Updated:', 'Modified Date:', 'updated:']),
                'Status' => $this->extractWhoisValue($rawData, ['Status:', 'Domain Status:', 'status:']),
                'NameServers' => $this->extractWhoisNameServers($rawData),
            ],
            'RegistrantContact' => [
                'Name' => $this->extractWhoisValue($rawData, ['Registrant Name:', 'Registrant:', 'registrant_name:']),
                'Organization' => $this->extractWhoisValue($rawData, ['Registrant Organization:', 'Registrant Org:', 'registrant_organization:']),
                'Email' => $this->extractWhoisValue($rawData, ['Registrant Email:', 'registrant_email:']),
                'Phone' => $this->extractWhoisValue($rawData, ['Registrant Phone:', 'registrant_phone:']),
                'Address1' => $this->extractWhoisValue($rawData, ['Registrant Street:', 'Registrant Address:', 'registrant_address:']),
                'City' => $this->extractWhoisValue($rawData, ['Registrant City:', 'registrant_city:']),
                'State' => $this->extractWhoisValue($rawData, ['Registrant State/Province:', 'Registrant State:', 'registrant_state:']),
                'PostalCode' => $this->extractWhoisValue($rawData, ['Registrant Postal Code:', 'registrant_postal:']),
                'Country' => $this->extractWhoisValue($rawData, ['Registrant Country:', 'registrant_country:']),
            ],
            'RawData' => $rawData, // Include raw data for debugging
        ];

        return $parsed;
    }

    /**
     * Extract WHOIS value by trying multiple possible field names
     */
    private function extractWhoisValue(string $data, array $possibleFields): ?string
    {
        foreach ($possibleFields as $field) {
            if (preg_match('/' . preg_quote($field, '/') . '\s*(.+)/i', $data, $matches)) {
                return trim($matches[1]);
            }
        }
        return null;
    }

    /**
     * Extract name servers from WHOIS data
     */
    private function extractWhoisNameServers(string $data): array
    {
        $nameServers = [];

        // Match various name server formats
        if (preg_match_all('/(?:Name Server|nameserver|nserver):\s*(.+)/i', $data, $matches)) {
            foreach ($matches[1] as $ns) {
                $ns = trim($ns);
                if (!empty($ns)) {
                    $nameServers[] = $ns;
                }
            }
        }

        return array_unique($nameServers);
    }
}



