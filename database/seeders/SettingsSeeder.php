<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            // General Settings
            [
                'key' => 'company_name',
                'value' => 'WHMCS CRM',
                'type' => 'string',
                'description' => 'Company name for the platform',
            ],
            [
                'key' => 'email_address',
                'value' => 'support@example.com',
                'type' => 'string',
                'description' => 'Official company email address',
            ],
            [
                'key' => 'domain',
                'value' => 'https://example.com',
                'type' => 'string',
                'description' => 'Main website domain',
            ],
            [
                'key' => 'activity_log_limit',
                'value' => '1000',
                'type' => 'integer',
                'description' => 'Maximum number of activity log entries to retain',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable or disable maintenance mode',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'We are currently performing scheduled maintenance. Please check back soon.',
                'type' => 'string',
                'description' => 'Message displayed during maintenance mode',
            ],
            [
                'key' => 'maintenance_redirect_url',
                'value' => '',
                'type' => 'string',
                'description' => 'Redirect URL during maintenance mode',
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                ]
            );
        }

        $this->command->info('✅ Default settings seeded successfully!');
    }
}
