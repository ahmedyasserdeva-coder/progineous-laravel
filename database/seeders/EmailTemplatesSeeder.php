<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'hosting_welcome_email',
                'subject_ar' => '🎉 مرحباً بك في عائلة Pro Gineous!',
                'subject_en' => '🎉 Welcome to the Pro Gineous Family!',
                'body_ar' => $this->loadTemplate('hosting-welcome-ar'),
                'body_en' => $this->loadTemplate('hosting-welcome-en'),
                'is_active' => true,
            ],
            [
                'name' => 'shared_hosting_welcome',
                'subject_ar' => '✅ تم تفعيل استضافتك - معلومات الدخول الخاصة بك',
                'subject_en' => '✅ Your Hosting is Active - Login Credentials',
                'body_ar' => $this->loadTemplate('shared-hosting-welcome-ar'),
                'body_en' => $this->loadTemplate('shared-hosting-welcome-en'),
                'is_active' => true,
            ],
            [
                'name' => 'cloud_hosting_welcome',
                'subject_ar' => '☁️ استضافتك السحابية جاهزة - معلومات الوصول',
                'subject_en' => '☁️ Your Cloud Hosting is Ready - Access Credentials',
                'body_ar' => $this->loadTemplate('cloud-hosting-welcome-ar'),
                'body_en' => $this->loadTemplate('cloud-hosting-welcome-en'),
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }

    /**
     * Load email template from blade file
     */
    private function loadTemplate(string $templateName): string
    {
        $templatePath = resource_path("views/emails/templates/{$templateName}.blade.php");
        
        if (file_exists($templatePath)) {
            return file_get_contents($templatePath);
        }
        
        return '';
    }
}
