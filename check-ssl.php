<?php

$domain = 'progineous.org';

echo "Checking SSL for: $domain\n\n";

// Method 1: stream_socket_client
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'capture_peer_cert' => true,
    ],
]);

$socket = @stream_socket_client(
    "ssl://{$domain}:443",
    $errno,
    $errstr,
    5,
    STREAM_CLIENT_CONNECT,
    $context
);

if ($socket) {
    echo "Method 1 (stream_socket): SSL FOUND\n";
    $params = stream_context_get_params($socket);
    if (isset($params['options']['ssl']['peer_certificate'])) {
        $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
        echo "Certificate CN: " . ($cert['subject']['CN'] ?? 'N/A') . "\n";
        echo "Issuer: " . ($cert['issuer']['O'] ?? 'N/A') . "\n";
    }
    fclose($socket);
} else {
    echo "Method 1 (stream_socket): NO SSL - Error: $errstr ($errno)\n";
}

echo "\n";

// Method 2: curl
if (function_exists('curl_init')) {
    $ch = curl_init("https://{$domain}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($httpCode > 0) {
        echo "Method 2 (curl): SSL FOUND - HTTP Code: $httpCode\n";
    } else {
        echo "Method 2 (curl): NO SSL - Error: $error\n";
    }
}
