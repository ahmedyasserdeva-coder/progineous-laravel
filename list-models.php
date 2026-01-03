<?php

$apiKey = "AIzaSyBgNoAZIwyQjxNxA8bd_fOIXbzzbthn6_E";
$url = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    $data = json_decode($response, true);
    
    echo "📋 Available Models:\n";
    echo str_repeat("=", 80) . "\n\n";
    
    if (isset($data['models'])) {
        foreach ($data['models'] as $model) {
            $name = $model['name'] ?? 'Unknown';
            $displayName = $model['displayName'] ?? 'N/A';
            $description = $model['description'] ?? 'No description';
            
            // Extract model ID
            $modelId = str_replace('models/', '', $name);
            
            // Check if it supports generateContent
            $supportsGenerate = isset($model['supportedGenerationMethods']) && 
                               in_array('generateContent', $model['supportedGenerationMethods']);
            
            if ($supportsGenerate) {
                echo "✅ {$modelId}\n";
                echo "   Display: {$displayName}\n";
                echo "   {$description}\n\n";
            }
        }
    }
} else {
    echo "Error: HTTP {$httpCode}\n";
    echo $response;
}
