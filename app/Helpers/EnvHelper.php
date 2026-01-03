<?php

namespace App\Helpers;

class EnvHelper
{
    /**
     * Update .env file with new values
     *
     * @param array $data
     * @return bool
     */
    public static function updateEnv(array $data): bool
    {
        $envFile = base_path('.env');

        if (!file_exists($envFile)) {
            return false;
        }

        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            // Escape special characters in value
            $value = self::escapeEnvValue($value);

            // Check if key exists
            if (preg_match("/^{$key}=(.*)$/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=(.*)$/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                // Add new key at the end
                $envContent .= "\n{$key}={$value}";
            }
        }

        // Write to .env file
        file_put_contents($envFile, $envContent);

        // Clear config cache
        if (function_exists('config')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('config:clear');
            } catch (\Exception $e) {
                // Ignore if artisan command fails
            }
        }

        return true;
    }

    /**
     * Escape special characters in env value
     *
     * @param string $value
     * @return string
     */
    protected static function escapeEnvValue($value): string
    {
        if (empty($value)) {
            return '""';
        }

        // If value contains spaces or special characters, wrap in quotes
        if (preg_match('/\s|[#&|$]/', $value)) {
            $value = '"' . addslashes($value) . '"';
        }

        return $value;
    }

    /**
     * Get value from .env file
     *
     * @param string $key
     * @return string|null
     */
    public static function getEnvValue(string $key): ?string
    {
        $envFile = base_path('.env');

        if (!file_exists($envFile)) {
            return null;
        }

        $envContent = file_get_contents($envFile);

        if (preg_match("/^{$key}=(.*)$/m", $envContent, $matches)) {
            $value = trim($matches[1]);
            // Remove quotes if present
            return trim($value, '"\'');
        }

        return null;
    }
}
