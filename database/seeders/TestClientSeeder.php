<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if test client already exists
        $existingClient = Client::where('email', 'test@example.com')->first();
        
        if ($existingClient) {
            $this->command->info('Test client already exists!');
            $this->command->info('Email: test@example.com');
            $this->command->info('Password: password123');
            $this->command->info('Username: ' . $existingClient->username);
            return;
        }

        // Generate unique username
        $username = 'TEST' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        // Create test client
        $client = Client::create([
            'username' => $username,
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'company_name' => 'شركة الاختبار للتكنولوجيا',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+201234567890',
            'address1' => 'شارع الهرم، الجيزة',
            'address2' => 'الدور الثالث، شقة 12',
            'city' => 'الجيزة',
            'state' => 'الجيزة',
            'postcode' => '12345',
            'country' => 'EG',
            'tax_number' => '123456789',
            'language' => 'ar',
            'currency' => 'USD',
            'payment_method' => 'credit_card',
            'status' => 'active',
            'billing_contact' => 'أحمد محمد',
            'referral_source' => 'test',
            'email_notifications' => [
                'order_confirmation' => true,
                'invoice_created' => true,
                'payment_received' => true,
                'service_suspended' => true,
                'domain_renewal' => true,
                'newsletter' => false,
            ],
            'settings' => [
                'two_factor_enabled' => false,
                'email_notifications' => true,
                'sms_notifications' => false,
            ],
            'owner_type' => 'new',
            'existing_user_id' => null,
            'admin_notes' => 'عميل تجريبي للاختبار',
            'send_welcome_email' => false,
        ]);

        $this->command->info('✅ Test client created successfully!');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('📧 Email: test@example.com');
        $this->command->info('🔑 Password: password123');
        $this->command->info('👤 Username: ' . $username);
        $this->command->info('📱 Phone: +201234567890');
        $this->command->info('🏢 Company: شركة الاختبار للتكنولوجيا');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('يمكنك الآن تسجيل الدخول باستخدام البريد الإلكتروني أو اسم المستخدم!');
    }
}
